<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha/css/bootstrap.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Anton+SC&family=Bungee+Shade&family=Paytone+One&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<style>
		.poppins-medium {
			font-family: "Poppins", sans-serif;
			font-weight: 500;
			font-style: normal;
		}
	</style>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

	<div style="background-image: url('{{ asset('storage/app/public/images/loginbg.jpg') }}');" class="relative h-screen w-full overflow-hidden bg-cover">
		<div class="absolute z-10 flex h-screen w-screen items-center justify-center bg-green-900 opacity-75"> </div>
		<div class="flex justify-center bg-pink-400">
			<h1 class="absolute z-50 mt-24 text-center text-6xl font-bold text-yellow-300 opacity-100 sm:mt-8 sm:text-7xl md:mt-12">DocuTrack</h1>
		</div>
		<div class="mx-auto mt-4 flex h-screen w-screen items-center justify-center px-6 py-8 sm:mt-6 lg:py-0">
			<div class="z-50 w-full rounded-lg bg-white opacity-95 shadow dark:border sm:w-1/3 xl:p-0">
				<div class="space-y-4 p-6 sm:p-8 md:space-y-6">
					<div class="flex justify-center p-0">
						<img src="{{ asset('storage/app/public/images/dalogo.png') }}" class="h-36 text-center">
					</div>
					<form id="loginForm" class="space-y-4 md:space-y-6" action="{{ url('/login') }}" method="POST" autocomplete="off">
						@csrf
						<div>
							<label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your email</label>
							<input type="email" name="email" id="email"
								class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-200 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
								placeholder="name@company.com" autocomplete="off" required="">
						</div>
						<div class="relative">
							<label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Password</label>
							<input type="password" name="password" id="password" placeholder="••••••••"
								class="focus:ring-primary-600 focus:border-primary-600 block h-10 w-full rounded-lg border border-gray-300 bg-green-200 p-2.5 pr-10 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
								autocomplete="new-password" required="">

							<!-- Toggle password visibility -->
							<span class="absolute right-0 top-4 flex h-full cursor-pointer items-center pr-3" id="togglePassword">
								<i class="fa-solid fa-eye" id="toggleIcon"></i>
							</span>
						</div>

						<div class="flex items-center justify-between">
							<div class="flex items-start">
								<div class="flex h-5 items-center">
									<input id="remember" aria-describedby="remember" type="checkbox" class="focus:ring-3 focus:ring-primary-300 dark:focus:ring-primary-600 h-4 w-4 rounded border border-gray-300 bg-gray-50 dark:border-gray-600 dark:bg-gray-700 dark:ring-offset-gray-800" autocomplete="off">
								</div>
								<div class="ml-3 text-sm">
									<label for="remember" class="text-gray-500 dark:text-gray-300">Remember me</label>
								</div>
							</div>
							<a href="/forgotpassword" class="text-primary-600 dark:text-primary-500 text-sm font-medium hover:underline">Forgot password?</a>
						</div>
						<button id="submitBtn" type="submit" class="hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white opacity-95 focus:outline-none focus:ring-4">
							Sign in
						</button>
						<p class="text-sm font-light text-gray-500 dark:text-gray-400">
							Don’t have an account yet? <a href="/signupForm" class="text-primary-600 dark:text-primary-500 font-medium hover:underline">Sign up</a>
						</p>
					</form>
				</div>
			</div>
			<div class="z-50 hidden p-6 text-white shadow-xl dark:border dark:border-gray-700 dark:bg-gray-800 sm:w-1/3 md:block md:w-1/3">
				<div class="mb-2">
					<h1 class="poppins-medium text-4xl font-bold text-yellow-300">AGRICULTURAL TRAINING INSTITUTE</h1>
					<p class="poppins-medium text-xl font-semibold">REGIONAL TRAINING CENTER (MIMAROPA)</p>
				</div>
				<p class="text-justify text-lg">Agricultural Training Institute is the capacity builder, knowledge bank, and catalyst of the Philippine Agriculture and Fisheries extension system.</p>
				<hr class="mt-2 bg-white">
				<h1 class="poppins-medium mt-4 text-2xl font-bold text-yellow-300">ADDRESS</h1>
				<p class="text-lg">Barcenaga, Naujan, Oriental Mindoro</p>
				<h1 class="mt-4 font-sans text-2xl font-bold text-yellow-300">CONTACT</h1>
				<p class="text-lg">Telephone: (02) 3591967</p>
				<p class="text-lg">Email: director@ati.da.gov.ph</p>
				<p class="mb-3 text-lg text-white hover:text-white">Website: <a class="hover:text-yellow-300" href="https://ati2.da.gov.ph/ati-4b/content/">https://ati2.da.gov.ph/ati-4b/</a></p>
				<div class="space-y-2">
					<div>
						<h1 class="mt-4 font-sans text-2xl font-bold text-yellow-300">CONNECT WITH US</h1>
					</div>
					<div class="flex space-x-4 text-4xl">
						<a href="https://www.facebook.com/atimimaropa4b">
							<i class="fa-brands fa-facebook hover:text-yellow-300"></i>
						</a>
						<a href="https://www.instagram.com/atiinteractive/">
							<i class="fa-brands fa-x-twitter hover:text-yellow-300"></i>
						</a>
						<a href="https://www.instagram.com/atiinteractive/">
							<i class="fa-brands fa-square-instagram hover:text-yellow-300"></i>
						</a>
						<i class="fa-brands fa-tiktok hover:text-yellow-300"></i>
						<a href="https://www.youtube.com/@ATICentralOffice">
							<i class="fa-brands fa-youtube hover:text-yellow-300"></i>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- JavaScript to handle the loading state on form submit -->
	<script>
		// Get the form and button elements
		const loginForm = document.getElementById('loginForm');
		const submitBtn = document.getElementById('submitBtn');

		// Add an event listener for form submission
		loginForm.addEventListener('submit', function(event) {
			// Prevent multiple form submissions
			submitBtn.disabled = true;

			// Change the button text to show loading state
			submitBtn.innerHTML = `<i class="fa fa-spinner fa-spin"></i> Loading...`;

			// Allow the form to submit after changing the button state
			// Uncomment the line below if you're handling form submission via AJAX
			// loginForm.submit();
		});

		// Toggle password visibility
		const togglePassword = document.getElementById('togglePassword');
		const passwordField = document.getElementById('password');
		const toggleIcon = document.getElementById('toggleIcon');

		togglePassword.addEventListener('click', function() {
			// Toggle password visibility
			const isPasswordVisible = passwordField.type === 'password';
			passwordField.type = isPasswordVisible ? 'text' : 'password';

			// Change the icon
			toggleIcon.classList.toggle('fa-eye');
			toggleIcon.classList.toggle('fa-eye-slash');
		});
	</script>
</body>

</html>
