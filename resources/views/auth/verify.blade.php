<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bungee+Shade&family=Paytone+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900&display=swap" rel="stylesheet">
	<style>
		.poppins-medium {
			font-family: "Poppins", sans-serif;
			font-weight: 500;
			font-style: normal;
		}
	</style>
</head>

<body>
	@if (Session::has('error'))
		<script>
			toastr.error("{{ Session::get('error') }}");
		</script>
	@endif
	@if (Session::has('success'))
		<script>
			toastr.success("{{ Session::get('success') }}");
		</script>
	@endif
	<div style="background-image: url('{{ asset('storage/app/public/images/loginbg.jpg') }}');" class="relative h-screen w-screen overflow-hidden bg-cover">
		<div class="absolute z-10 flex h-screen w-screen items-center justify-center bg-green-900 opacity-75"></div>
		<div class="mx-auto flex h-screen w-screen flex-row-reverse items-center justify-center px-6 py-8 lg:py-0">
			<div class="z-50 w-full rounded-lg bg-white opacity-95 shadow dark:border dark:border-gray-700 dark:bg-gray-800 sm:w-1/3 xl:p-0">
				<div class="space-y-4 p-6 sm:p-8 md:space-y-6">
					<div class="flex justify-center p-0">
						<img src="{{ asset('storage/app/public/images/atilogo.png') }}" class="h-36 text-center">
					</div>
					<form id="verifyForm" class="space-y-4 md:space-y-6" action="{{ url('/sendVerification') }}" method="POST" autocomplete="off">
						@csrf
						<div>
							<label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your email</label>
							<input type="email" name="email" id="email"
								class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-100 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
								placeholder="name@company.com" autocomplete="off" required="">
						</div>
						<button type="submit" id="submitBtn"
							class="hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white opacity-95 focus:outline-none focus:ring-4">Send Verification</button>
						<p class="text-sm font-light text-gray-500 dark:text-gray-400">
							Already have an account? <a href="/login" class="text-primary-600 dark:text-primary-500 font-medium hover:underline">Login</a>
						</p>
					</form>
				</div>
			</div>
		</div>
	</div>
</body>
<script>
	document.getElementById('verifyForm').addEventListener('submit', function(e) {
		var submitBtn = document.getElementById('submitBtn');

		// Change button text and disable it
		submitBtn.textContent = 'Loading...';
		submitBtn.disabled = true;
	});
</script>

</html>
