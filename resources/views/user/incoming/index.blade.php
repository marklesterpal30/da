@extends('user.layouts.master')
@section('content')

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
	<div class="h-full w-fit rounded-md bg-white p-2 shadow-2xl sm:p-12 md:h-fit md:w-full">
		<div class="relative w-full sm:rounded-lg">

			<div class="flex w-full justify-between">
				<h1 class="mb-3 text-3xl font-semibold text-green-700">Incoming Documents</h1>
			</div>

			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-400 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">
							Ref. Code
						</th>
						<th scope="col" class="px-6 py-3">
							File Name
						</th>
						<th scope="col" class="px-6 py-3">
							Category
						</th>
						<th scope="col" class="px-6 py-3">
							From
						</th>
						<th scope="col" class="px-6 py-3">
							Date Sent
						</th>
						<th scope="col" class="px-6 py-3">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
					@if ($files->isEmpty())
						<tr class="">
							<td colspan="6" class="px-6 py-4 text-center text-3xl font-semibold text-gray-500">
								<h1 class="mt-20">
									No incoming documents available.
								</h1>
							</td>
						</tr>
					@else
						@foreach ($files as $file)
							<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
								<td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
									{{ $file->document->code }}
								</td>
								<th scope="row" class="px-6 py-4">
									{{ $file->document->file_name }}
								</th>
								<td class="px-6 py-4">
									{{ $file->document->category }}

								</td>
								<td class="px-6 py-4">
									{{ $file->document->sender->name }}

								</td>
								<td class="px-6 py-4">
									{{ $file->document->fowarded_date }}

								</td>
								<td class="space-x-2 px-6 py-4">
									<a href="{{ url('/user-incoming/' . $file->document_id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
										<i class="fa-solid fa-eye" style="color: #2977ff;"></i>
									</a>
									<button id="thumbsUpButton" data-file_name="{{ $file->document->file_name }}" data-description="{{ $file->description }}" data-last_code="{{ $file->lastcode }}" data-id="{{ $file->document_id }}" data-modal-target="accept-modal" data-modal-toggle="accept-modal"
										class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
										<i class="fa-solid fa-thumbs-up" style="color: #00b37d;"></i>
									</button>
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>

	<div id="accept-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
		<div class="relative max-h-full w-full max-w-md p-4">
			<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
				<button type="button" class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="accept-modal">
					<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
				<div class="p-4 text-center md:p-5">
					<svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
					</svg>
					<h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to receive this document?</h3>
					<div class="mt-4 flex justify-center">
						<form action="{{ url('/user-incoming-received') }}" method="POST" class="flex w-full justify-center">
							@csrf
							<button type="submit" class="w-full rounded-lg bg-green-500 py-2.5 text-center text-sm font-medium text-white focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
								Yes
							</button>
							<button data-modal-hide="accept-modal" type="button"
								class="ms-3 w-full rounded-lg bg-red-500 py-2.5 text-sm font-medium text-white focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-100 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white dark:focus:ring-gray-700">No</button>
							<input type="text" name="id" id="id" class="hidden">
						</form>
					</div>

				</div>
			</div>
		</div>
	</div>

	<script>
		const modalTriggers = document.querySelectorAll('[data-modal-toggle="accept-modal"]');
		const inputId = document.getElementById('id');
		const inputfilename = document.getElementById('file_name');
		const inputReferencecode = document.getElementById('reference_code'); // Corrected typo here

		modalTriggers.forEach(trigger => {
			trigger.addEventListener('click', () => {
				const id = trigger.getAttribute('data-id');
				const code = trigger.getAttribute('data-last_code');
				const filename = trigger.getAttribute('data-file_name');
				const description = trigger.getAttribute('data-description');
				// Adding filename attribute

				console.log(code);
				// Update modal content with task information
				inputId.value = id;
				inputReferencecode.placeholder = code;
				inputfilename.value = filename;
			});
		});
	</script>

@endsection
