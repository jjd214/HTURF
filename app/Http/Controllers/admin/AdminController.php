<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use constGuards;
use constDefaults;
use App\Models\Admin;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use App\Models\GeneralSetting;
use App\Services\AdminDataAnalysisServices;
use Illuminate\Support\Facades\Log;

class AdminController extends Controller
{

    public function adminHome(Request $request)
    {
        $selectedSalesYear = $request->input('sales_year', now()->year); // Default to current year
        $selectedExpensesYear = $request->input('expenses_year', now()->year); // Default to current year
        $selectedRevenueYear = $request->input('revenue_year', now()->year);

        // Monthly Sales Data
        $monthlySales = DB::table('transactions')
            ->selectRaw('MONTH(created_at) as month, SUM(total_amount) as total_sales')
            ->whereYear('created_at', $selectedSalesYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $salesData = array_fill(1, 12, 0); // Initialize sales data for all 12 months
        foreach ($monthlySales as $sale) {
            $salesData[$sale->month] = $sale->total_sales;
        }

        // Monthly Expenses Data
        $monthlyExpenses = DB::table('inventories')
            ->selectRaw('MONTH(created_at) as month, SUM(qty * purchase_price) as total_expenses')
            ->whereYear('created_at', $selectedExpensesYear)
            ->groupByRaw('MONTH(created_at)')
            ->orderBy('month')
            ->get();

        $expensesData = array_fill(1, 12, 0); // Initialize expenses data for all 12 months
        foreach ($monthlyExpenses as $expense) {
            $expensesData[$expense->month] = $expense->total_expenses;
        }

        $totalRevenue = DB::table('transactions')
            ->whereYear('created_at', $selectedRevenueYear)
            ->sum('total_amount');

        $expectedRevenue = DB::table('inventories')
            ->whereYear('created_at', $selectedRevenueYear)
            ->whereNull('consignment_id')
            ->sum(DB::raw('qty * selling_price'));

        $data = [
            'pageTitle' => 'Home',
            'salesData' => $salesData,
            'expensesData' => $expensesData,
            'selectedSalesYear' => $selectedSalesYear,
            'selectedExpensesYear' => $selectedExpensesYear,
            'selectedRevenueYear' => $selectedRevenueYear,
            'totalRevenue' => $totalRevenue,
            'expectedRevenue' => $expectedRevenue
        ];

        return view('back.pages.admin.home', $data);
    }

    public function profileView(Request $request)
    {
        $admin = null;
        if (Auth::guard('admin')->check()) {
            $admin = Admin::findOrFail(auth()->id());
        }
        return view('back.pages.admin.profile', compact('admin'));
    }

    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType == 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:admins,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or username is required',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'Email do not exist',
                'password.required' => 'Password is required'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:admins,username',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or username is required',
                'login_id.exists' => 'Username do not exist',
                'password.required' => 'Password is required'
            ]);
        }
        $creds = array(
            $fieldType => $request->login_id,
            'password' => $request->password
        );

        if (Auth::guard('admin')->attempt($creds)) {
            Log::info("Logged in at " . now()->format('F j, Y g:i A'));
            Admin::findOrFail(auth('admin')->id())->update(['is_online' => true]);
            return redirect()->route('admin.home');
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('admin.login');
        }
    }

    public function logoutHandler(Request $request)
    {
        Log::info("Logged out at " . now()->format('F j, Y g:i A'));
        Admin::findOrFail(auth('admin')->id())->update(['is_online' => false]);
        Auth::guard('admin')->logout();
        session()->flash('fail', 'You are logged out');
        return redirect()->route('admin.login');
    }

    public function sendResetPasswordLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:admins,email',
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The :attribute is not exits in system'
        ]);

        // Get admin details
        $admin = Admin::where('email', $request->email)->first();

        // Generate token
        $token = base64_encode(Str::random(64));

        // check if there is an existing password token
        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
            ->first();

        if ($oldToken) {
            // Update token
            DB::table('password_reset_tokens')
                ->where(['email' => $request->email, 'guard' => constGuards::ADMIN])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            // Add new token
            DB::table('password_reset_tokens')->insert([
                'email' => $request->email,
                'guard' => constGuards::ADMIN,
                'token' => $token,
                'created_at' => Carbon::now()
            ]);
        }

        $actionLink = route('admin.reset-password', ['token' => $token, 'email' => $request->email]);
        $data = array(
            'actionLink' => $actionLink,
            'admin' => $admin
        );

        $mail_body = view('email-templates.admin-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Reset password',
            'mail_body' => $mail_body
        );

        if (sendEmail($mailConfig)) {
            session()->flash('success', 'We have e-mailed your password reset link');
            return redirect()->route('admin.forgot-password');
        } else {
            session()->flash('fail', 'Something went wrong');
            return redirect()->route('admin.forgot-password');
        }
    }

    public function resetPassword(Request $request, $token = null)
    {
        $check_token = DB::table('password_reset_tokens')
            ->where(['token' => $token, 'guard' => constGuards::ADMIN])
            ->first();

        if ($check_token) {
            // Check if token is not expired
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $check_token->created_at)->diffInMinutes(Carbon::now());

            if ($diffMins > constDefaults::tokenExpiredMinutes) {
                // If token expired
                session()->flash('fail', 'Token expired request another reset password link.');
                return redirect()->route('admin.forgot-password', ['token' => $token]);
            } else {
                return view('back.pages.admin.auth.reset-password')->with(['token' => $token]);
            }
        } else {
            session()->flash('fail', 'Invalid token!, request another reset password link');
            return redirect()->route('admin.forgot-password', ['token' => $token]);
        }
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:new_password_confirmation|same:new_password_confirmation',
            'new_password_confirmation' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
            ->where(['token' => $request->token, 'guard' => constGuards::ADMIN])
            ->first();

        // Get admin details
        $admin = Admin::where('email', $token->email)->first();

        // Update admin password
        Admin::where('email', $admin->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        // Delete token record
        DB::table('password_reset_tokens')->where([
            'email' => $admin->email,
            'token' => $request->token,
            'guard' => constGuards::ADMIN
        ])->delete();

        // Send email to notify admin
        $data = array(
            'admin' => $admin,
            'new_password' => $request->new_password
        );

        $mail_body = view('email-templates.admin-reset-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $admin->email,
            'mail_recipient_name' => $admin->name,
            'mail_subject' => 'Password change',
            'mail_body' => $mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('admin.login')->with('success', 'Done!, Your password has been changed. Use new password to login into system');
    }

    public function changeProfilePicture(Request $request)
    {
        $admin = Admin::findOrFail(auth()->id());
        $path = 'images/users/admins/';
        $file = $request->file('adminProfilePictureFile');
        $old_picture = $admin->getAttributes()['picture'];
        $file_path = $path . $old_picture;
        $filename = 'ADMIN_IMG_' . rand(2, 1000) . $admin->id . time() . uniqid() . '.jpg';

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_picture != null && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path . $old_picture));
            }
            $admin->update(['picture' => $filename]);
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }

    public function changeLogo(Request $request)
    {
        $path = 'images/site/';
        $file = $request->file('site_logo');
        $settings = new GeneralSetting();
        $old_logo = $settings->first()->site_logo;
        $filename = 'LOGO_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_logo != null && File::exists(public_path($path . $old_logo))) {
                File::delete(public_path($path . $old_logo));
            }
            $settings = $settings->first();
            $settings->site_logo = $filename;
            $settings->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Site logo has been successfully updated.',
                'type' => 'success',
                'new_logo' => $filename,  // Return the new logo filename
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong.',
                'type' => 'error',
            ]);
        }
    }

    public function changeFavicon(Request $request)
    {
        $path = 'images/site/';
        $file = $request->file('site_favicon');
        $settings = new GeneralSetting();
        $old_favicon = $settings->first()->site_favicon;
        $filename = 'FAVICON_' . uniqid() . '.' . $file->getClientOriginalExtension();

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_favicon != null && File::exists(public_path($path . $old_favicon))) {
                File::delete(public_path($path . $old_favicon));
            }
            $settings = $settings->first();
            $settings->site_favicon = $filename;
            $settings->save();

            return response()->json([
                'status' => 1,
                'msg' => 'Site favicon has been successfully updated.',
                'type' => 'success',
                'new_favicon' => $filename,  // Return the new favicon filename
            ]);
        } else {
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong.',
                'type' => 'error',
            ]);
        }
    }
}
