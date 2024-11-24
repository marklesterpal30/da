@extends('user/layouts.master')
@section('content')
	<div class="w-fit rounded-md bg-white p-2 shadow-2xl sm:p-12 md:w-full">
		<div class="relative sm:rounded-lg">
			<div class="mb-2 flex items-center justify-between">
				<h1 class="mb-3 hidden text-3xl font-semibold text-green-700 sm:block">Outgoing Documents</h1>
				<div>
					<label for="" class="text-lg">Filter by status:</label>
					<select id="outgoingStatusSelect" class="text-md rounded-md p-2" onchange="filterOutgoingTable()">
						<option value="">All</option>
						<option value="pending">Pending</option>
						<option value="received">Received</option>
						<option value="forwarded">Forwarded</option>
						<option value="accepted">Accepted</option>
					</select>
				</div>

			</div>
			<table id="outgoingDocumentsTable" class="z-0 w-full px-12 text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm">
				<thead class="bg-green-400 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">Reference Code</th>
						<th scope="col" class="px-6 py-3">Document Name</th>
						<th scope="col" class="px-6 py-3">Category</th>
						<th scope="col" class="px-6 py-3">From</th>
						<th scope="col" class="px-6 py-3">To</th>
						<th scope="col" class="px-6 py-3">Date Sent</th>
						<th scope="col" class="px-6 py-3">Status</th>
						<th scope="col" class="px-6 py-3">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($outgoingFiles as $file)
						<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
							<td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $file->code }}</td>
							<td class="px-6 py-4">{{ $file->file_name }}</td>
							<td class="px-6 py-4">{{ $file->category }}</td>
							<td class="px-6 py-4">{{ $file->sender->email }}</td>
							<td class="px-6 py-4">{{ $file->recieved->name }}</td>
							<td class="px-6 py-4">{{ $file->created_at }}</td>
							<td class="px-6 py-4">
								<span
									class="{{ $file->status == 'pending' ? 'bg-yellow-300' : ($file->status == 'accepted' ? 'bg-gray-400 text-black shadow-md' : ($file->status == 'forwarded' ? 'bg-blue-400' : ($file->status == 'return' ? 'bg-red-500' : ($file->status == 'received' ? 'bg-green-500' : '')))) }} px-2 py-1.5 font-semibold text-white">
									@if ($file->status == 'accepted')
										{{ $file->status }}:{{ $file->accepted_count }}/{{ $file->forwarded_count }}
									@else
										{{ $file->status }}
									@endif
								</span>
							</td>
							<td class="px-6 py-4">
								<a href="{{ url('/user-mydocuments/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
									<i class="fa-solid fa-eye" style="color: #2977ff;"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
			<div class="mb-12 mt-4">
				{{ $outgoingFiles->links() }}
			</div>

			<div class="mb-2 flex items-center justify-between">
				<h1 class="mb-3 hidden text-3xl font-semibold text-green-700 sm:block">Incoming Documents</h1>
				<div>
					<label for="" class="text-lg">Filter by status:</label>
					<select id="incomingStatusSelect" class="text-md rounded-md p-2" onchange="filterIncomingTable()">
						<option value="">All</option>
						<option value="pending">Pending</option>
						<option value="received">Received</option>
						<option value="forwarded">Forwarded</option>
						<option value="accepted">Accepted</option>
					</select>
				</div>

			</div>

			<table id="incomingDocumentsTable" class="z-0 w-full text-left text-xs text-gray-500 rtl:text-right dark:text-gray-400 sm:text-sm">
				<thead class="bg-green-400 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">Reference Code</th>
						<th scope="col" class="px-6 py-3">Document Name</th>
						<th scope="col" class="px-6 py-3">Category</th>
						<th scope="col" class="px-6 py-3">From</th>
						<th scope="col" class="px-6 py-3">Date Received</th>
						<th scope="col" class="px-6 py-3">Status</th>
						<th scope="col" class="px-6 py-3">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($incomingFiles as $file)
						<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
							<td class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">{{ $file->code }}</td>
							<td class="px-6 py-4">{{ $file->file_name }}</td>
							<td class="px-6 py-4">{{ $file->category }}</td>
							<td class="px-6 py-4">{{ $file->sender->email }}</td>
							<td class="px-6 py-4">{{ $file->fowarded_date }}</td>
							<td class="px-6 py-4">
								<span
									class="{{ $file->status == 'pending' ? 'bg-yellow-300' : ($file->status == 'accepted' ? 'bg-gray-400 text-black shadow-md' : ($file->status == 'forwarded' ? 'bg-blue-400' : ($file->status == 'return' ? 'bg-red-500' : ($file->status == 'received' ? 'bg-green-500' : '')))) }} px-2 py-1.5 font-semibold text-white">
									@if ($file->status == 'accepted')
										{{ $file->status }}:{{ $file->accepted_count }}/{{ $file->forwarded_count }}
									@else
										{{ $file->status }}
									@endif
								</span>
							</td>
							<td class="px-6 py-4">
								<a href="{{ url('/user-mydocuments/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
									<i class="fa-solid fa-eye" style="color: #2977ff;"></i>
								</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<script>
		// Filter function for outgoing documents table by status
		function filterOutgoingTable() {
			var selectedStatus = document.getElementById('outgoingStatusSelect').value.trim().toUpperCase();
			var table = document.getElementById('outgoingDocumentsTable');
			var tr = table.getElementsByTagName('tr');

			for (var i = 1; i < tr.length; i++) {
				var statusField = tr[i].getElementsByTagName('td')[6]; // Status is in the 7th column (index 6)
				if (statusField) {
					var statusText = statusField.textContent || statusField.innerText;
					statusText = statusText.trim().toUpperCase();
					if (selectedStatus === "" || statusText === selectedStatus) {
						tr[i].style.display = '';
					} else {
						tr[i].style.display = 'none';
					}
				}
			}
		}

		// Filter function for incoming documents table by status
		function filterIncomingTable() {
			var selectedStatus = document.getElementById('incomingStatusSelect').value.trim().toUpperCase();
			var table = document.getElementById('incomingDocumentsTable');
			var tr = table.getElementsByTagName('tr');

			for (var i = 1; i < tr.length; i++) {
				var statusField = tr[i].getElementsByTagName('td')[5]; // Status is in the 6th column (index 5)
				if (statusField) {
					var statusText = statusField.textContent || statusField.innerText;
					statusText = statusText.trim().toUpperCase();
					if (selectedStatus === "" || statusText === selectedStatus) {
						tr[i].style.display = '';
					} else {
						tr[i].style.display = 'none';
					}
				}
			}
		}
	</script>
@endsection
