@extends('admin.layouts.master')
@section('content')
	<div class="h-full w-fit rounded-md bg-white p-12 shadow-2xl md:w-full">
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
		<div class="relative sm:rounded-lg">
			<a href="/admin-createdocuments" class="btn mb-3 bg-green-400 text-white hover:bg-green-500">Create Documents</a>

			<div class="flex justify-between">
				<h1 class="mb-3 text-3xl font-semibold text-green-700">Outgoing Documents</h1>

				<form action="{{ url('/admin-outgoing-documents') }}" method="GET" class="mb-4">
					<select name="type" class="rounded border px-2 py-1">
						<option value="">All category</option>
						@foreach ($types as $type)
							<option value="{{ $type->purpose_name }}">{{ $type->purpose_name }}</option>
						@endforeach
					</select>
					<button type="submit" class="ml-2 rounded bg-green-500 px-3 py-1 text-white">Filter</button>
				</form>
			</div>
			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-400 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					<tr>
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
							Date
						</th>
						<th scope="col" class="px-6 py-3">
							Status
						</th>
						<th scope="col" class="px-6 py-3">
							Action
						</th>
					</tr>
				</thead>
				<tbody>
					@if ($files->isEmpty())
						<tr>
							<td colspan="7" class="px-6 py-4 text-left text-2xl font-semibold text-gray-500 dark:text-gray-400 md:text-center">
								No outgoing documents
							</td>
						</tr>
					@else
						@foreach ($files as $file)
							<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
								<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
									{{ $file->file }}
								</th>
								<td class="px-6 py-4">
									{{ $file->category }}
								</td>
								<td class="px-6 py-4">
									{{ $file->sender->email }}
								</td>
								<td class="px-6 py-4">
									{{ $file->created_at }}
								</td>
								<td class="px-6 py-4">
									<span
										class="{{ $file->status == 'pending' ? 'bg-yellow-300' : ($file->status == 'accepted' ? 'bg-gray-400 text-black shadow-md' : ($file->status == 'forwarded' ? 'bg-blue-400' : ($file->status == 'return' ? 'bg-red-500' : ($file->status == 'recieved' ? 'bg-green-500' : '')))) }} px-2 py-1.5 font-semibold text-white">
										{{ $file->status }}
									</span>
								</td>
								<td class="px-6 py-4">
									<a href="{{ url('/admin-outgoing-documents/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
									<button id="thumbsUpButton" data-file_name="{{ $file->file_name }}" data-description="{{ $file->description }}" data-last_code="{{ $file->lastcode }}" data-id="{{ $file->id }}" data-modal-target="accept-modal" data-modal-toggle="accept-modal"
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
		<div class="max-h-3xl relative w-full max-w-2xl p-4">
			<div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
				<button type="button" class="absolute end-2.5 top-3 ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="accept-modal">
					<svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
						<path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
					</svg>
					<span class="sr-only">Close modal</span>
				</button>
				<div class="p-4 md:p-5">
					<form action={{ url('/admin-outgoing-documents') }} method="POST">
						@csrf
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
						<div class="mb-6 h-32 overflow-auto">
							<div class="">
								<label for="description" class="text-md block w-full text-left">Send to</label>
								<input type="text" id="search" placeholder="search" class="mb-2 w-full rounded-md border-2 border-gray-500 p-1" oninput="filterUsers()">
							</div>

							<div class="max-h-96 overflow-auto rounded-md border-2 border-gray-500 bg-green-50 p-3 outline-2" id="userList">
								@foreach ($users as $user)
									<div class="user-item mb-2 flex items-center">
										<input type="checkbox" name="forwardTo[]" id="user_{{ $user->id }}" value="{{ $user->id }}" class="user-checkbox mr-2">
										<label for="user_{{ $user->id }}" class="block">{{ $user->name }}</label>
									</div>
								@endforeach
							</div>
						</div>
						<input type="text" name="id" id="id" class="hidden">
						<div class="flex justify-center">
							<button data-modal-hide="accept-modal" type="submit" class="w-full rounded-lg bg-green-400 py-2.5 text-center font-medium text-white hover:bg-green-500 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800">
								Submit
							</button>
							<button data-modal-hide="accept-modal" type="button" class="ms-3 w-full rounded-md bg-red-500 py-2.5 text-sm font-medium text-white focus:outline-none">Cancel</button>
						</div>

					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
		function filterUsers() {
			const searchInput = document.getElementById('search').value.toLowerCase();
			const userItems = document.querySelectorAll('.user-item');

			userItems.forEach(item => {
				const label = item.querySelector('label').innerText.toLowerCase();
				if (label.includes(searchInput)) {
					item.style.display = ''; // Show item
				} else {
					item.style.display = 'none'; // Hide item
				}
			});
		}

		function moveCheckedToTop() {
			const userList = document.getElementById('userList');
			const userItems = Array.from(document.querySelectorAll('.user-item'));

			// Get checked and unchecked items
			const checkedItems = userItems.filter(item => item.querySelector('.user-checkbox').checked);
			const uncheckedItems = userItems.filter(item => !item.querySelector('.user-checkbox').checked);

			// Clear the list
			userList.innerHTML = '';

			// Append checked items first
			checkedItems.forEach(item => userList.appendChild(item));

			// Append unchecked items after
			uncheckedItems.forEach(item => userList.appendChild(item));
		}

		// Add event listeners for checkboxes
		document.querySelectorAll('.user-checkbox').forEach(checkbox => {
			checkbox.addEventListener('change', moveCheckedToTop);
		});


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
