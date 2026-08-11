<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #eee; border-radius: 8px;">
        <h2 style="color: #0F141E; text-align: center;">Akhbar Mashriq</h2>
        <p>Hello {{ $user->first_name }},</p>
        <p>You requested to reset your password. Please use the following One-Time Password (OTP) to proceed with resetting your password:</p>
        
        <div style="text-align: center; margin: 30px 0;">
            <span style="font-size: 32px; font-weight: bold; padding: 15px 30px; background-color: #f4f4f4; border-radius: 5px; letter-spacing: 5px;">{{ $otp }}</span>
        </div>
        
        <p>This OTP will expire in 15 minutes.</p>
        <p>If you did not request a password reset, please ignore this email or contact support if you have questions.</p>
        
        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">
        <p style="font-size: 12px; color: #777; text-align: center;">
            &copy; {{ date('Y') }} Akhbar Mashriq. All rights reserved.
        </p>
    </div>
</body>
</html>
