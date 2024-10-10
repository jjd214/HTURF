<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <p>Dear {{ $admin->name }},</p>

    <p>We received a request to reset the password for your hypearchive account associated with {{ $admin->email }}.</p>

    <p>You can reset your password by clicking the button below:</p>

    <a href="{{ $actionLink }}" style="display: inline-block; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Reset Password</a>

    <p><b>NB:</b> This link will be valid for 15 minutes.</p>

    <p>If you did not request a password reset, please ignore this email.</p>
</body>
</html>
