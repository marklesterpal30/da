@extends('office/layouts.master')
@section('content')
	<div class="h-full w-fit bg-white p-2 md:w-full md:p-12">
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
		<div class="relative h-full sm:rounded-lg">
			<h1 class="mb-3 text-3xl font-bold text-green-700">Incoming Documents</h1>
			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-300 text-xs uppercase text-gray-700 shadow-lg dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">
							Reference Code
						</th>
						<th scope="col" class="px-6 py-3">
							Document Name
						</th>
						<th scope="col" class="px-6 py-3">
							From
						</th>
						<th scope="col" class="px-6 py-3">
							Status
						</th>
						<th scope="col" class="px-6 py-3">
							Action
						</th>
					</tr>
				</thead>
				<tbody class="">
					@if ($files->isEmpty())
						<tr>
							<td colspan="7" class="px-6 py-4 text-left text-2xl font-semibold text-gray-500 dark:text-gray-400 md:text-center">
								No incoming documents
							</td>
						</tr>
					@else
						@foreach ($files as $file)
							<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
								<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
									{{ $file->file->code }}
								</th>
								<td class="px-6 py-4">
									{{ $file->file->file_name }}
								</td>
								<td class="px-6 py-4">
									{{ $file->file->sender->email }}
								</td>
								<td class="px-6 py-4">
									<span class="rounded-sm bg-blue-400 px-2 py-2 font-semibold text-white">
										Forwarded
									</span>
								</td>
								<td class="flex space-x-3 px-6 py-4">
									<a href="{{ url('/office-incoming/' . $file->file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
									<button id="thumbsUpButton" data-id="{{ $file->file->id }}" data-modal-target="accept-modal" data-modal-toggle="accept-modal" class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
										<i class="fa-solid fa-thumbs-up" style="color: #00b37d;"></i>
									</button>
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<div id="accept-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
			<div class="relative max-h-full w-full max-w-md p-4">
				<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
					<button type="button" class="absolute end-2.5 left-1 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-red-400 hover:bg-gray-200 hover:text-gray-900" data-modal-hide="accept-modal">
						<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
						</svg>
						<span class="sr-only">Close modal</span>
					</button>
					<div class="p-4 text-center md:p-5">
						<svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
						</svg>
						<h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to received this document?</h3>
						<form action="{{ url('/accept-documents') }}" method="POST">
							@csrf
							<input type="text" name="id" id="id" class="hidden">
							<button data-modal-hide="popup-modal" type="submit" class="ocus:ring-4 inline-flex items-center rounded-lg bg-green-400 px-10 py-2.5 text-center text-sm font-medium text-white hover:bg-green-500 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800">
								Yes
							</button>
							<button data-modal-hide="accept-modal" type="button" class="ms-3 rounded-md bg-red-500 px-10 py-2.5 text-sm font-medium text-white">No</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		const modalTriggers = document.querySelectorAll('[data-modal-toggle="accept-modal"]');
		const inputId = document.getElementById('id');

		modalTriggers.forEach(trigger => {
			trigger.addEventListener('click', () => {
				const id = trigger.getAttribute('data-id');

				// Update modal content with task information
				inputId.value = id;
			});
		});
	</script>
@endsection
