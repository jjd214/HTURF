<p>Dear {{ $admin->name }}</p>
<br>
<p>
    Your password on hypearhive system was changed successfully.
    Here is your new login credentials.
    <br>
        <b>Login ID</b>{{ $admin->username }} or {{ $admin->email }}
        <br>
        <b>Password</b>{{ $new_password }}
</p>
Please, keep your credentials confidential. Your username and password are your own credentials and you should never share them with anybody else.
<p>
    Hype Archive will not be liable for any misuse of your username or password.
</p>
---------------------------------------------
<p>
    This email was automatically sent by hype archive system devs. Do not reply.
</p>
