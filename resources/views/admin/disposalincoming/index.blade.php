@extends('admin/layouts.master')
@section('content')
	<div class="h-full w-fit rounded-md bg-white p-8 shadow-2xl md:w-full">
		<div class="relative h-full overflow-x-auto shadow-md sm:rounded-lg">
			<div class="mb-2 flex items-center">
				<form id="filterForm" action="{{ url('/admin-records') }}" method="GET" class="flex items-center space-y-2">
					<div>
						<label for="category" class="mr-2 hidden sm:inline-flex">Filter by Category:</label>
						<select name="category" id="category" class="rounded px-2 py-1">
							<option value="">All Category</option>
							<option value="ATI SPECIAL ORDER" {{ $selectedCategory == 'ATI SPECIAL ORDER' ? 'selected' : '' }}>ATI SPECIAL ORDER</option>
							<option value="ATI MEMORANDUM ORDER" {{ $selectedCategory == 'ATI MEMORANDUM ORDER' ? 'selected' : '' }}>ATI MEMORANDUM ORDER</option>
							<option value="LETTER" {{ $selectedCategory == 'LETTER' ? 'selected' : '' }}>LETTER</option>
							<option value="DA SPECIAL ORDER" {{ $selectedCategory == 'DA SPECIAL ORDER' ? 'selected' : '' }}>DA SPECIAL ORDER</option>
							<option value="DA MEMORANDUM ORDER" {{ $selectedCategory == 'DA MEMORANDUM ORDER' ? 'selected' : '' }}>DA MEMORANDUM ORDER</option>
						</select>
					</div>
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
							To
						</th>
						<th scope="col" class="px-6 py-3">
							Received Date
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
								No documents for disposal
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
									{{ $file->recieved->name }}
								</td>
								<td class="px-6 py-4">
									{{ $file->created_at }}
								</td>
								<td class="px-6 py-4">
									<span class="{{ $file->status == 'received' ? 'bg-green-400' : ($file->status == 'accepted' ? 'bg-green-700' : ($file->status == 'forwarded' ? 'bg-blue-300' : '')) }} px-2 py-1.5 font-semibold text-white">
										{{ $file->status }}
									</span>
								</td>
								<td class="px-6 py-4">
									<a href="{{ url('/admin-records/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
									<form action="{{ url('/admin-disposalincoming/' . $file->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<button type="submit">Delete</button>
									</form>
								</td>
							</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
	</div>
	<script>
		document.addEventListener('DOMContentLoaded', function() {
			var category = document.getElementById('category').value;
			var month = document.getElementById('months').value;
			var week = document.getElementById('weeks').value;

			// Set initial values of hidden inputs
			document.getElementById('reportForm').querySelector('input[name="reportcategory"]').value = category;
			document.getElementById('reportForm').querySelector('input[name="reportmonth"]').value = month;
			document.getElementById('reportForm').querySelector('input[name="reportweek"]').value = week;

			// Update hidden inputs in the second form when there's a change in the first form
			document.getElementById('filterForm').addEventListener('change', function() {
				var category = document.getElementById('category').value;
				var month = document.getElementById('months').value;
				var week = document.getElementById('weeks').value;

				// Update hidden inputs in the second form
				document.getElementById('reportForm').querySelector('input[name="reportcategory"]').value = category;
				document.getElementById('reportForm').querySelector('input[name="reportmonth"]').value = month;
				document.getElementById('reportForm').querySelector('input[name="reportweek"]').value = week;
			});
		}); // JavaScript to handle form submission and updating hidden inputs
		document.getElementById('filterForm').addEventListener('change', function() {
			var category = document.getElementById('category').value;
			var month = document.getElementById('months').value;
			var week = document.getElementById('weeks').value;

			// Update hidden inputs in the second form
			document.getElementById('reportForm').querySelector('input[name="reportcategory"]').value = category;
			document.getElementById('reportForm').querySelector('input[name="reportmonth"]').value = month;
			document.getElementById('reportForm').querySelector('input[name="reportweek"]').value = week;
		});
	</script>
@endsection
