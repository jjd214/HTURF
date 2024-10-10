<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\VerificationToken;

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
}
