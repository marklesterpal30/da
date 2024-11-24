@extends('office.layouts.master')
@section('content')
	<div class="rounded-md bg-white p-2 shadow-md sm:p-12">
		<script>
			@if (Session::has('success'))
				toastr.success('{{ Session::get('success') }}');
			@endif

			@if (Session::has('error'))
				toastr.error('{{ Session::get('error') }}');
			@endif

			// Function to validate password fields
			function validatePasswords(event) {
				const newPassword = document.querySelector('input[name="newPassword"]').value;
				const confirmPassword = document.querySelector('input[name="confirmPassword"]');
				const originalPlaceholder = 'Confirm Password'; // Default placeholder text

				// Reset the placeholder on each submission
				confirmPassword.placeholder = originalPlaceholder;

				// Check if passwords match
				if (newPassword !== confirmPassword.value) {
					event.preventDefault(); // Prevent form submission
					confirmPassword.value = ''; // Clear the confirm password field
					confirmPassword.placeholder = 'Passwords do not match'; // Show error message in placeholder
					confirmPassword.classList.add('border-red-500'); // Optional: add red border for visual cue
				} else {
					confirmPassword.classList.remove('border-red-500'); // Remove red border if they match
				}
			}
		</script>

		<div class="flex sm:space-x-12">
			<div class="hidden w-96 sm:block">
				<h1 class="mb-2 text-4xl font-semibold text-gray-700">Profile Information</h1>
				<h1 class="text-lg font-medium italic text-gray-900">Update your account Profile Information and email address</h1>
			</div>
			<form action="{{ url('/office-profile') }}" method="POST" class="w-full space-y-3 bg-green-50 sm:w-1/2">
				@csrf
				<input type="text" name="userId" value="{{ $userId }}" class="hidden">
				<div class="px-4 pt-5">
					<label for="name" class="text-xl font-bold text-gray-800">Name</label>
					<input type="text" name="name" class="border-1 block w-full rounded-sm border-2 border-green-400 bg-green-100 sm:w-96" value="{{ Auth::user()->name }}">
				</div>
				<div class="px-4">
					<label for="email" class="text-xl font-bold text-gray-800">Email</label>
					<input type="text" name="email" class="border-1 block w-full rounded-sm border-2 border-green-400 bg-green-100 sm:w-96" value="{{ Auth::user()->email }}">
				</div>
				<div class="flex justify-end bg-green-300 py-2">
					<button class="mr-5 rounded-sm bg-green-600 px-5 py-1 text-xl font-semibold text-white">Save</button>
				</div>
			</form>
		</div>
		<hr class="mt-4 bg-gray-600">

		<!-------- PASSWORD ----->

		<div class="mt-8 flex sm:space-x-12">
			<div class="hidden w-96 sm:block">
				<h1 class="mb-2 text-4xl font-semibold text-gray-700">Update Your Password</h1>
				<h1 class="text-lg font-medium italic text-gray-900">Ensure your account is using a long and random password</h1>
			</div>
			<div class="w-full space-y-3 bg-green-50 sm:w-1/2">
				<form action="{{ url('/office-profile') }}" method="POST" onsubmit="validatePasswords(event)">
					@csrf
					<input type="text" name="userId" class="hidden" value="{{ $userId }}">
					<div class="px-4 pt-5">
						<label for="name" class="text-xl font-bold text-gray-800">Current Password</label>
						<input type="text" name="currentPassword" class="border-1 block w-full rounded-sm border-2 border-green-400 bg-green-100 sm:w-96">
					</div>
					<div class="px-4">
						<label for="newPassword" class="text-xl font-bold text-gray-800">New Password</label>
						<input type="text" name="newPassword" class="border-1 block w-full rounded-sm border-2 border-green-400 bg-green-100 sm:w-96">
					</div>
					<div class="px-4">
						<label for="confirmPassword" class="text-xl font-bold text-gray-800">Confirm Password</label>
						<input type="text" name="confirmPassword" class="border-1 block w-full rounded-sm border-2 border-green-400 bg-green-100 sm:w-96" placeholder="Confirm Password">
					</div>
					<div class="mt-2 flex justify-end bg-green-300 py-2">
						<button type="submit" class="mr-5 rounded-sm bg-green-600 px-5 py-1 text-xl font-semibold text-white">Save</button>
					</div>
				</form>
			</div>
		</div>

	</div>
@endsection
