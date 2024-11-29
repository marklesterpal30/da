@extends('user.layouts.master')
@section('content')
	<div class="p-0">
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

		<form action="{{ url('/creator-file') }}" method="POST" enctype="multipart/form-data" class="flex flex-col space-y-14 rounded-md bg-white p-4 shadow-xl sm:p-12">
			@csrf
			<!------FILE UPLOAD------>
			<div class="flex items-center justify-between">
				<!-- LABEL -->
				<div class="hidden w-1/2 sm:block">
					<h1 class="mb-4 font-sans text-4xl font-bold text-gray-700">Upload PDF File</h1>
					<p class="font-sans text-xl text-gray-600">Please ensure that uploaded files adhere to organizational policies and guidelines. This feature is designed to enhance collaboration and document management within the system.</p>
				</div>
				<!-- FORM -->
				<div class="flex w-full flex-col items-center justify-center rounded-md border-2 border-dashed border-green-400 bg-green-200 p-12 sm:w-1/2">
					<label for="file" class="mb-8 text-4xl"><i class="fa-solid fa-cloud-arrow-up fa-2xl" style="color: #355E3B	;"></i></label>
					<input type="file" name="file" class="w-60" required>
				</div>
			</div>
			<hr>

			<!-- FILE NAME, ADDRESS FROM, CATEGORY -->
			<div class="flex items-start justify-between">
				<!-- LABEL -->
				<div id="LABEL" class="hidden w-1/2 sm:block">
					<h1 class="mb-4 font-sans text-4xl font-bold text-gray-600">Additional Information</h1>
					<p class="font-sans text-xl text-gray-600">By considering these additional aspects, users can maximize the effectiveness of the file upload feature while ensuring compliance with organizational standards and best practices.</p>
				</div>
				<!-- INPUTS   -->
				<div id="INPUTS" class="flex w-full flex-col items-center justify-center rounded-md bg-green-50 p-2 sm:w-1/2">
					<div class="w-full p-2">
						<label for="file_name" class="text-xl font-semibold text-gray-600">Document name</label>
						<input type="text" name="file_name" class="block w-full rounded-sm border-2 border-green-400 bg-green-200" required>
					</div>
					<div class="w-full p-2">
						<label for="description" class="text-xl font-semibold text-gray-600">Description</label>
						<input type="text" name="description" class="block w-full rounded-sm border-2 border-green-400 bg-green-200" required>
					</div>
					<div class="w-full p-2">
						<label for="address_from" class="text-xl font-semibold text-gray-600">Address to/from</label>
						<input name="address_from" type="text" value="{{ Auth::user()->email }}" readonly class="block w-full rounded-sm border-2 border-green-400 bg-green-200" required>
					</div>
				</div>
			</div>
			<hr>

			<!-- SENDER ID, SENDER NAME -->
			<div class="hidden items-start justify-between">
				<!-- LABEL -->
				<div class="hidden w-1/2 sm:block">
					<h1 class="mb-4 font-sans text-4xl font-bold text-gray-600">Document Details</h1>
					<p class="font-sans text-xl text-gray-600">By considering these additional aspects, users can maximize the effectiveness of the file upload feature while ensuring compliance with organizational standards and best practices.</p>
				</div>
				<!-- INPUT -->
				<div class="flex w-full flex-col items-center justify-center rounded-md bg-green-50 p-2 sm:w-1/2">
					<div class="w-full p-2">
						<label for="from" class="text-xl font-semibold text-gray-600">Address to/from</label>
						<input type="text" name="from" class="block w-full rounded-sm border-2 border-green-400 bg-green-200">
					</div>
					<div class="w-full p-2">
						<label for="" class="text-xl font-semibold text-gray-600">Location</label>
						<input type="text" class="block w-full rounded-sm border-2 border-green-400 bg-green-200">
					</div>
				</div>
			</div>

			<!-- BUTTON SEND -->
			<div class="flex justify-center">
				<button type="submit" class="w-60 rounded-sm border-2 border-green-500 bg-green-400 px-3 py-1.5 text-2xl font-semibold text-white shadow-md hover:bg-green-700 hover:text-white">Send</button>
			</div>

		</form>

	</div>
@endsection
