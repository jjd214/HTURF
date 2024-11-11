<?php

namespace App\Http\Controllers\user;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VerificationToken;
use Illuminate\Support\Facades\DB;
use constGuards;
use constDefaults;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $data = [
            'pageTitle' => 'Consignor login'
        ];
        return view('back.pages.user.auth.login', $data);
    }

    public function register(Request $request)
    {
        $data = [
            'pageTitle' => 'Register'
        ];
        return view('back.pages.user.auth.register', $data);
    }

    public function home(Request $request)
    {
        $data = [
            'pageTitle' => 'Consignor Dashboard'
        ];
        return view('back.pages.user.home', $data);
    }

    public function createConsignor(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'min:5|required_with:confirm_password|same:confirm_password',
            'confirm_password' => 'min:5'
        ]);

        $consignor = new User();
        $consignor->name = $request->name;
        $consignor->email = $request->email;
        $consignor->password = Hash::make($request->password);
        $saved = $consignor->save();

        if ($saved) {
            //Generate token
            $token = base64_encode(Str::random(64));

            VerificationToken::create([
                'user_type' => 'user',
                'email' => $request->email,
                'token' => $token
            ]);

            $actionLink = route('consignor.verify', ['token' => $token]);
            $data['action_link'] = $actionLink;
            $data['consignor_name'] = $request->name;
            $data['consignor_email'] = $request->email;

            //Send activation link to this email
            $mail_body = view('email-templates.user-verify-template', $data)->render();

            $mailConfig = array(
                'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
                'mail_from_name' => env('EMAIL_FROM_NAME'),
                'mail_recipient_email' => $request->email,
                'mail_recipient_name' => $request->name,
                'mail_subject' => 'Verify consignor account',
                'mail_body' => $mail_body
            );

            if (sendEmail($mailConfig)) {
                return redirect()->route('consignor.register-success');
            } else {
                return redirect()->route('consignor.register')->with('fail', 'Something went wrong while sending verification link.');
            }
        } else {
            return redirect()->route('consignor.register')->with('fail', 'Something went wrong.');
        }
    }

    public function verifyAccount(Request $request, $token)
    {
        $verifyToken = VerificationToken::where('token', $token)->first();

        if (!is_null($verifyToken)) {
            $consignor = User::where('email', $verifyToken->email)->first();

            if (!$consignor->verified) {
                $consignor->verified = 1;
                $consignor->email_verified_at = Carbon::now();
                $consignor->save();

                return redirect()->route('consignor.login')->with('success', 'Good! Your e-mail is verified. Login with your credentials and complete setup your consignor account.');
            } else {
                return redirect()->route('consignor.login')->with('info', 'Your e-mail is already verified. You can now login');
            }
        } else {
            return redirect()->route('consignor.register')->with('fail', 'Invalid token.');
        }
    }

    public function registerSuccess(Request $request)
    {
        return view('back.pages.user.register-success');
    }

    public function loginHandler(Request $request)
    {
        $fieldType = filter_var($request->login_id, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        if ($fieldType === 'email') {
            $request->validate([
                'login_id' => 'required|email|exists:users,email',
                'password' => 'required|min:5|max:45'
            ], [
                'login_id.required' => 'Email or username is required',
                'login_id.email' => 'Invalid email address',
                'login_id.exists' => 'Email do not exist',
                'password.required' => 'Password is required'
            ]);
        } else {
            $request->validate([
                'login_id' => 'required|exists:users,username',
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

        if (Auth::guard('user')->attempt($creds)) {
            if (!auth('user')->user()->verified) {
                auth('user')->logout();
                return redirect()->route('consignor.login')->with('fail', 'Your account is not yet verified. Check your email and click the link we had sent in order to verify your email for consignor account.');
            } else {
                return redirect()->route('consignor.home');
            }
        } else {
            session()->flash('fail', 'Incorrect credentials');
            return redirect()->route('consignor.login');
        }
    }

    public function logoutHandler(Request $request)
    {
        Auth::guard('user')->logout();
        return redirect()->route('consignor.login')->with('fail', 'You are logged out!');
    }

    public function forgotPassword(Request $request)
    {
        $data = [
            'pageTitle' => 'Forgot password'
        ];
        return view('back.pages.user.auth.forgot', $data);
    }

    public function sendPasswordResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.required' => 'The :attribute is required',
            'email.email' => 'Invalid email address',
            'email.exists' => 'The :attribute is not exists in our system'
        ]);

        $consignor = User::where('email', $request->email)->first();

        $token = base64_encode(Str::random(64));

        $oldToken = DB::table('password_reset_tokens')
            ->where(['email' => $consignor->email, 'guard' => constGuards::USER])
            ->first();

        if ($oldToken) {
            DB::table('password_reset_tokens')
                ->where(['email' => $consignor->email, 'guard' => constGuards::USER])
                ->update([
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        } else {
            DB::table('password_reset_tokens')
                ->insert([
                    'email' => $consignor->email,
                    'guard' => constGuards::USER,
                    'token' => $token,
                    'created_at' => Carbon::now()
                ]);
        }

        $actionLink = route('consignor.reset-password', ['token' => $token, 'email' => urlencode($consignor->email)]);

        $data['actionLink'] = $actionLink;
        $data['consignor'] = $consignor;
        $mail_body = view('email-templates.user-forgot-email-template', $data)->render();

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $consignor->email,
            'mail_recipient_name' => $consignor->name,
            'mail_subject' => 'Reset password',
            'mail_body' => $mail_body
        );

        if (sendEmail($mailConfig)) {
            return redirect()->route('consignor.forgot-password')->with('success', 'We have e-mailed your password reset link.');
        } else {
            return redirect()->route('consignor.forgot-password')->with('error', 'Something went wrong.');
        }
    }

    public function showResetForm(Request $request, $token = null)
    {
        $get_token = DB::table('password_reset_tokens')
            ->where(['token' => $token, 'guard' => constGuards::USER])
            ->first();

        if ($get_token) {
            $diffMins = Carbon::createFromFormat('Y-m-d H:i:s', $get_token->created_at)
                ->diffInMinutes(Carbon::now());

            if ($diffMins > constDefaults::tokenExpiredMinutes) {
                return redirect()->route('consignor.forgot-password', ['token' => $token])->with('fail', 'Token expired!, Request another reset password link.');
            } else {
                return view('back.pages.user.auth.reset')->with(['token' => $token]);
            }
        } else {
            return redirect()->route('consignor.forgot-password', ['token' => $token])->with('fail', 'Invalid token!, request another reset password link.');
        }
    }

    public function resetPasswordHandler(Request $request)
    {
        $request->validate([
            'new_password' => 'required|min:5|max:45|required_with:confirm_new_password|same:confirm_new_password',
            'confirm_new_password' => 'required'
        ]);

        $token = DB::table('password_reset_tokens')
            ->where(['token' => $request->token, 'guard' => constGuards::USER])
            ->first();

        $consignor = User::where('email', $token->email)->first();

        User::where('email', $consignor->email)->update([
            'password' => Hash::make($request->new_password)
        ]);

        DB::table('password_reset_tokens')->where([
            'email' => $consignor->email,
            'token' => $request->token,
            'guard' => constGuards::USER
        ])->delete();

        $data['consignor'] = $consignor;
        $data['new_password'] = $request->new_password;

        $mail_body = view('email-templates.user-reset-email-template', $data);

        $mailConfig = array(
            'mail_from_email' => env('EMAIL_FROM_ADDRESS'),
            'mail_from_name' => env('EMAIL_FROM_NAME'),
            'mail_recipient_email' => $consignor->email,
            'mail_recipient_name' => $consignor->name,
            'mail_subject' => 'Password changed',
            'mail_body' => $mail_body
        );

        sendEmail($mailConfig);
        return redirect()->route('consignor.login')->with('success', 'Done!, Your password has been changed. Use new password to login into system.');
    }

    public function profileView(Request $request)
    {
        return view('back.pages.user.profile');
    }

    public function changeProfilePicture(Request $request)
    {
        $consignor = User::findOrFail(auth('user')->id());
        $path = 'images/users/consignors/';
        $file = $request->file('userProfilePictureFile');
        $old_picture = $consignor->getAttributes()['picture'];
        $file_path = $path . $old_picture;
        $filename = 'USER_IMG_' . rand(2, 1000) . $consignor->id . time() . uniqid() . '.jpg';

        $upload = $file->move(public_path($path), $filename);

        if ($upload) {
            if ($old_picture != null && File::exists(public_path($path . $old_picture))) {
                File::delete(public_path($path . $old_picture));
            }
            $consignor->update(['picture' => $filename]);
            return response()->json(['status' => 1]);
        } else {
            return response()->json(['status' => 0]);
        }
    }
}
