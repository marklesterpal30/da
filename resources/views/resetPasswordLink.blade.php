<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Verify Your Email</title>
</head>

<body style="font-family: Arial, sans-serif; background-color: #f7f7f7; margin: 0; padding: 18px;">
	<div style="max-width: 600px; margin: 50px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
		<p style="font-size: 16px; color: #333333;">Hello User,</p>
		<p style="font-size: 16px; color: #333333;">Click the button to reset your password.</p>
		<a href="{{ url('/resetPasswordForm', session('email')) }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; font-size: 16px;">Verify Account</a>
	</div>
</body>

</html>
