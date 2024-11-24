<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<div style="max-width: 600px; margin: 50px auto; background-color: #cbffc5; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
		<!-- Centered text and bolded Agricultural Training Institute -->
		<p style="font-size: 16px; color: #333333;">Hello User,</p>
		<p style="font-size: 16px; color: #333333;">{{ $mailMessage }}</p>
		<p style="font-size: 16px; color: #333333;">Login to your account to see your document. Thank you!</p>
		<a href="{{ url('/login') }}" style="display: inline-block; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; font-size: 16px;">
			Login
		</a>
	</div>
</body>

</html>
