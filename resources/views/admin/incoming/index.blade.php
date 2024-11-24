@extends('admin/layouts.master')
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
	<div class="h-full w-fit bg-white p-4 md:w-full">
		<div class="relative sm:rounded-lg">
			<h1 class="mb-3 text-3xl font-bold text-green-700">Form External Clients</h1>
			<form action="{{ url('/admin-incoming') }}" method="GET" class="mb-2 flex justify-end space-x-1">
				<select name="status" id="" class="p-2">
					<option value="pending" {{ $selectedStatus == 'pending' ? 'selected' : '' }}>Pending</option>
					<option value="received" {{ $selectedStatus == 'received' ? 'selected' : '' }}>Received</option>
				</select>
				<button type="submit" class="rounded-sm bg-green-500 px-6 py-2 text-white">filter</button>
			</form>
			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-300 text-xs uppercase text-gray-700 shadow-lg dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">
							Reference Code
						</th>
						<th scope="col" class="px-6 py-3">
							Documnt Name
						</th>
						<th scope="col" class="px-6 py-3">
							Document Category
						</th>
						<th scope="col" class="px-6 py-3">
							From
						</th>
						<th scope="col" class="px-6 py-3">
							Date Sent
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
					@if ($incomingExternal->isEmpty())
						<tr>
							<td colspan="7" class="px-6 py-4 text-left text-2xl font-semibold text-gray-500 dark:text-gray-400 md:text-center">
								No incoming documents
							</td>
						</tr>
					@else
						@foreach ($incomingExternal as $file)
							<tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
								<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
									{{ $file->code }}
								</th>
								<td scope="row" class="px-6 py-4">
									{{ $file->file_name }}
								</td>
								<td class="px-6 py-4">
									{{ $file->category }}
								</td>
								<td class="px-6 py-4">
									{{ $file->address_from }}
								</td>
								<td class="px-6 py-4">
									{{ $file->created_at }}
								</td>
								<td class="px-6 py-4">
									<h1 class="{{ $file->status == 'pending' ? 'bg-yellow-400' : 'bg-green-500' }} px-2 py-1 text-center text-white">
										{{ $file->status }}
									</h1>
								</td>
								<td class="flex space-x-3 px-6 py-4">
									<a href="{{ url('/admin-incoming/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
									@if ($file->status === 'pending')
										<button id="thumbsUpButton" data-file_name="{{ $file->file_name }}" data-description="{{ $file->description }}" data-last_code="{{ $file->lastcode }}" data-id="{{ $file->id }}" data-modal-target="accept-modal" data-modal-toggle="accept-modal"
											class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
											<i class="fa-solid fa-thumbs-up" style="color: #00b37d;"></i>
										</button>
									@endif
									@if (auth()->user()->role == 'admin')
										@if ($file->status == 'received')
											@if ($file->type == 'incoming')
												<button id="forward" data-forward-id="{{ $file->id }}" data-modal-target="forward-modal" data-modal-toggle="forward-modal" class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
													<i class="fa-solid fa-forward" style="color: #00b37d;"></i>
												</button>
											@endif
										@endif
									@endif
								</td>

							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
			{{ $incomingExternal->links() }}
		</div>
		<div class="relative mt-16 sm:rounded-lg">
			<h1 class="mb-3 text-3xl font-bold text-green-700">From Internal Clients</h1>
			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-300 text-xs uppercase text-gray-700 shadow-lg dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">
							Reference Code
						</th>
						<th scope="col" class="px-6 py-3">
							Documnt Name
						</th>
						<th scope="col" class="px-6 py-3">
							Document Category
						</th>
						<th scope="col" class="px-6 py-3">
							From
						</th>
						<th scope="col" class="px-6 py-3">
							Date Sent
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
					@if ($incomingInternal->isEmpty())
						<tr>
							<td colspan="7" class="px-6 py-4 text-left text-2xl font-semibold text-gray-500 dark:text-gray-400 md:text-center">
								No incoming documents
							</td>
						</tr>
					@else
						@foreach ($incomingInternal as $file)
							<tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
								<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
									{{ $file->code }}
								</th>
								<td scope="row" class="px-6 py-4">
									{{ $file->file_name }}
								</td>
								<td class="px-6 py-4">
									{{ $file->category }}
								</td>
								<td class="px-6 py-4">
									{{ $file->address_from }}
								</td>
								<td class="px-6 py-4">
									{{ $file->created_at }}
								</td>
								<td class="px-6 py-4">
									<h1 class="{{ $file->status == 'pending' ? 'bg-yellow-400' : 'bg-green-500' }} px-2 py-1 text-center text-white">
										{{ $file->status }}
									</h1>
								</td>
								<td class="flex space-x-3 px-6 py-4">
									@if ($file->status === 'pending')
										<button id="thumbsUpButton" data-file_name="{{ $file->file_name }}" data-description="{{ $file->description }}" data-last_code="{{ $file->lastcode }}" data-id="{{ $file->id }}" data-modal-target="accept-modal" data-modal-toggle="accept-modal"
											class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
											<i class="fa-solid fa-thumbs-up" style="color: #00b37d;"></i>
										</button>
									@endif
									@if ($file->status === 'received')
										<button id="outgoing-forward" data-outgoing-forward-id="{{ $file->id }}" data-modal-target="outgoing-forward-modal" data-modal-toggle="outgoing-forward-modal" class="font-extra bold text-blue-600 hover:underline dark:text-blue-500">
											<i class="fa-solid fa-forward" style="color: #00b37d;"></i>
										</button>
									@endif
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>

			</table>
			{{ $incomingInternal->links() }}
		</div>
		<div id="accept-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
			<div class="max-h-xl relative w-full max-w-xl p-4">
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
						<form action="{{ route('approveddocuments') }}" method="POST">
							@csrf
							@method('PATCH')
							<input type="text" name="file_name" id="file_name" class="hidden">
							<div class="mb-5 flex w-full space-x-1">
								<div class="w-1/2">
									<label for="reference_code" class="block w-full text-left">Enter Reference Code</label>
									<input type="text" name="reference_code" id="reference_code" placeholder="" class="block w-full rounded-md bg-green-50">
								</div>
								<div class="w-1/2">
									<label for="category" class="block w-full text-left">Category</label>
									<input type="text" name="category" id="category" placeholder="" class="block w-full rounded-md bg-green-50">
								</div>
							</div>

							<div class="mb-3">
								<label for="description" class="block w-full text-left">Description</label>
								<input type="text" name="description" id="description" placeholder="" class="block w-full rounded-md bg-green-50">
							</div>
							<div class="mb-3">
								<label for="location" class="block w-full text-left">Location</label>
								<input type="text" name="location" id="location" placeholder="" class="block w-full rounded-md bg-green-50">
							</div>

							<label for="" class="block w-full text-left">Retention Period</label>
							<div class="mb-5 flex w-full space-x-1">
								<div class="w-1/2">
									<input type="number" name="active_years" class="w-full rounded-md bg-green-50" placeholder="active">
								</div>
								<div class="w-1/2">
									<input type="number" name="inactive_years" class="w-full rounded-md bg-green-50" placeholder="inactive">
								</div>
							</div>
							<input type="text" name="id" id="id" class="hidden">
							<div class="flex">
								<button data-modal-hide="accept-modal" type="submit" class="ocus:ring-4 w-full rounded-lg bg-green-400 py-2.5 text-center text-sm font-medium text-white hover:bg-green-500 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800">
									Yes
								</button>
								<button data-modal-hide="accept-modal" type="button" class="ms-3 w-full rounded-md bg-red-500 py-2.5 text-sm font-medium text-white focus:outline-none">No</button>
							</div>

						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="forward-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
			<div class="max-h-xl relative w-full max-w-xl p-4">
				<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
					<button type="button" class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="forward-modal">
						<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
						</svg>
						<span class="sr-only">Close modal</span>
					</button>
					<div class="p-4 md:p-5">
						<svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
						</svg>
						<h3 class="mb-5 text-center text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to forward this document?</h3>
						<form action="{{ url('/forward-documents') }}" method="POST">
							@csrf
							<input type="text" name="id" id="forwardId" class="hidden">
							<h1 for="forward_to" class="text-center text-lg font-semibold">Select Office you want to forward</h1>
							<div class="ml-6 mt-2 grid grid-cols-2">
								@foreach ($offices as $office)
									<div class="text-md mt-1">
										<input type="checkbox" name="forwardTo[]" id="office_{{ $office->id }}" value="{{ $office->id }}" class="mr-2">
										<label for="office_{{ $office->id }}">{{ $office->name }}</label>
									</div>
								@endforeach
							</div>
							<div class="mt-4 flex justify-center">
								<button data-modal-hide="forward-modal" type="submit" class="w-full rounded-lg bg-green-400 py-2.5 text-center text-sm font-medium text-white hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
									Yes
								</button>
								<button data-modal-hide="forward-modal" type="button" class="ms-3 w-full rounded-md bg-red-500 py-2.5 text-sm font-medium text-white">No</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div id="outgoing-forward-modal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-y-auto overflow-x-hidden md:inset-0">
			<div class="relative max-h-full w-full max-w-md p-4">
				<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
					<button type="button" class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="outgoing-forward-modal">
						<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
						</svg>
						<span class="sr-only">Close modal</span>
					</button>
					<div class="p-4 text-center md:p-5">
						<svg class="mx-auto mb-4 h-12 w-12 text-gray-400 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
							<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
						</svg>
						<h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to forward this document?</h3>
						<form action="{{ url('/forward-documents') }}" method="POST">
							@csrf
							<input type="text" name="id" id="outgoing-forwardId" class="hidden">
							<div class="flex justify-center">
								<button data-modal-hide="forward-modal" type="submit" class="inline-flex items-center rounded-lg bg-green-400 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-green-300 dark:focus:ring-green-800">
									Yes, I'm sure
								</button>
								<button data-modal-hide="outgoing-forward-modal" type="button" class="ms-3 rounded-md bg-red-500 px-5 py-2.5 text-sm font-medium text-white">No, cancel</button>
							</div>
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
		const inputDescription = document.getElementById('description');

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
				inputDescription.value = description; // Assigning value to inputfilename
			});
		});


		document.addEventListener('DOMContentLoaded', function() {
			const forwardTriggers = document.querySelectorAll('[data-modal-toggle="forward-modal"]');
			const inputId = document.getElementById('forwardId');

			forwardTriggers.forEach(trigger => {
				trigger.addEventListener('click', () => {
					const id = trigger.getAttribute('data-forward-id');
					// Update the form input with the task ID
					inputId.value = id;
				});
			});
		});


		document.addEventListener('DOMContentLoaded', function() {
			const forwardTriggers = document.querySelectorAll('[data-modal-toggle="outgoing-forward-modal"]');
			const inputId = document.getElementById('outgoing-forwardId');

			forwardTriggers.forEach(trigger => {
				trigger.addEventListener('click', () => {
					const id = trigger.getAttribute('data-outgoing-forward-id');
					// Update the form input with the task ID
					inputId.value = id;
				});
			});
		});
	</script>
@endsection
