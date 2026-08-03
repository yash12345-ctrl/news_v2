<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ env('APP_NAME') }}</title>
</head>
<body>
	<p>Hi {{ $user->fullName() }},</p>
	<p>
		Your email address verification code is <strong>{{ $email_verification_code }}</strong>.
	</p>
</body>
</html>