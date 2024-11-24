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

		.text-red-500 {
			color: #f56565;
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
						<h1 class="text-3xl font-semibold">Create Your Account</h1>
					</div>
					<form id="signupForm" class="space-y-4 md:space-y-3" action="{{ url('/signup') }}" method="POST" autocomplete="off">
						@csrf
						<div>
							<label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your name</label>
							<input type="text" name="name" id="name"
								class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-100 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
								placeholder="denver marquez" autocomplete="off" required="">
						</div>
						<div>
							<label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Your email</label>
							<input type="email" name="email" id="email"
								class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-100 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
								placeholder="name@company.com" autocomplete="off" required="">
						</div>
						<div>
							<label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Password</label>
							<div class="relative">
								<input type="password" name="password" id="password" placeholder="••••••••"
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-100 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
									autocomplete="new-password" required="">
								<button type="button" id="togglePassword" class="absolute right-2 top-2 text-sm text-gray-600">Show</button>
							</div>
						</div>
						<div>
							<div class="flex justify-between">
								<label for="confirmpassword" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
								<span id="errorText" class="hidden text-xs text-red-500">Passwords do not match</span>
							</div>
							<div class="relative">
								<input type="password" name="confirmpassword" id="confirmpassword" placeholder="••••••••"
									class="focus:ring-primary-600 focus:border-primary-600 block w-full rounded-lg border border-gray-300 bg-green-100 p-2.5 text-gray-900 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500 sm:text-sm"
									autocomplete="new-password" required="">
								<button type="button" id="toggleConfirmPassword" class="absolute right-2 top-2 text-sm text-gray-600">Show</button>
							</div>
						</div>
						<input type="text" name="role" value="user" class="hidden">
						<button type="submit" id="submitBtn"
							class="hover:bg-primary-700 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 w-full rounded-lg bg-green-600 px-5 py-2.5 text-center text-sm font-medium text-white opacity-95 focus:outline-none focus:ring-4">Sign in</button>
						<div class="flex justify-between">
							<p class="text-sm font-light text-gray-500 dark:text-gray-400">
								Already have an account? <a href="/login" class="text-primary-600 dark:text-primary-500 font-medium hover:underline">Login</a>
							</p>
							<p class="text-sm font-light text-gray-500 dark:text-gray-400">
								<a href="/verifyForm" class="text-primary-600 dark:text-primary-500 font-medium hover:underline">Verify Account</a>
							</p>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>

	<script>
		// Clear form fields on load
		window.addEventListener('load', function() {
			document.querySelector('#name').value = '';
			document.querySelector('#email').value = '';
			document.querySelector('#password').value = '';
			document.querySelector('#confirmpassword').value = '';
		});

		// Show/Hide password
		const togglePassword = document.querySelector("#togglePassword");
		const toggleConfirmPassword = document.querySelector("#toggleConfirmPassword");
		const password = document.querySelector("#password");
		const confirmPassword = document.querySelector("#confirmpassword");
		const errorText = document.querySelector("#errorText");

		// Function to toggle password visibility
		function toggleVisibility(input, toggleButton) {
			const type = input.getAttribute("type") === "password" ? "text" : "password";
			input.setAttribute("type", type);
			toggleButton.textContent = type === "password" ? "Show" : "Hide";
		}

		// Event listeners for both password and confirm password toggle
		togglePassword.addEventListener("click", function() {
			toggleVisibility(password, togglePassword);
		});

		toggleConfirmPassword.addEventListener("click", function() {
			toggleVisibility(confirmPassword, toggleConfirmPassword);

		});

		// Check password match on form submit
		const form = document.querySelector('#signupForm');
		form.addEventListener('submit', function(e) {
			if (password.value !== confirmPassword.value) {
				e.preventDefault(); // Prevent form submission
				errorText.classList.remove('hidden'); // Show error message
			} else {
				errorText.classList.add('hidden'); // Hide error message
			}
		});
	</script>
</body>
