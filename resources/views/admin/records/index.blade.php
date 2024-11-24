@extends('admin/layouts.master')

@section('content')
	<div class="h-full w-fit rounded-md bg-white p-2 shadow-2xl md:w-full">
		<div class="relative h-full overflow-x-auto shadow-md sm:rounded-lg">
			<div class="flex items-center justify-start">
				<form id="filterForm" class="mb-4 space-y-2">
					<label for="category" class="mr-2 hidden sm:inline-block">Filter by Category:</label>
					<select name="category" id="category" class="rounded border px-2 py-1 sm:w-fit">
						<option value="">All Category</option>
						<option value="ATI SPECIAL ORDER">ATI SPECIAL ORDER</option>
						<option value="ATI MEMORANDUM ORDER">ATI MEMORANDUM ORDER</option>
						<option value="LETTER">LETTER</option>
						<option value="DA SPECIAL ORDER">DA SPECIAL ORDER</option>
						<option value="DA MEMORANDUM ORDER">DA MEMORANDUM ORDER</option>
						<option value="OTHERS">OTHERS</option>
					</select>
					<label for="fromMonth" class="mr-2 hidden sm:inline-block">From Month:</label>
					<select name="fromMonth" id="fromMonth" class="rounded border px-2 py-1 sm:w-fit">
						<option value="">Select Month</option>
						@foreach (range(1, 12) as $month)
							<option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
						@endforeach
					</select>
					<label for="toMonth" class="mr-2 hidden sm:inline-block">To Month:</label>
					<select name="toMonth" id="toMonth" class="rounded border px-2 py-1 sm:w-fit">
						<option value="">Select Month</option>
						@foreach (range(1, 12) as $month)
							<option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
						@endforeach
					</select>
					<button type="button" id="clearFilters" class="ml-2 rounded bg-green-500 px-3 py-1 text-white">Clear Filters</button>
				</form>

				<!-- Report generation form -->
				<form id="reportForm" action="{{ url('/admin-generateReport') }}" method="GET" class="mb-2">
					<input type="text" id="reportCategory" name="category" class="hidden">
					<input type="text" id="reportFromMonth" name="fromMonth" class="hidden">
					<input type="text" id="reportToMonth" name="toMonth" class="hidden">
					<button type="submit" class="ml-2 rounded bg-blue-500 px-3 py-1 text-white">Generate Report</button>
				</form>
			</div>

			<table id="dataTable" class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-400 text-xs uppercase text-gray-700 dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">File Name</th>
						<th scope="col" class="px-6 py-3">Category</th>
						<th scope="col" class="px-6 py-3">From</th>
						<th scope="col" class="px-6 py-3">To</th>
						<th scope="col" class="px-6 py-3">Received Date</th>
						<th scope="col" class="px-6 py-3">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($files as $file)
						<tr class="file-row">
							<td class="px-6 py-4">{{ $file->file }}</td>
							<td class="category px-6 py-4">{{ $file->category }}</td>
							<td class="px-6 py-4">{{ $file->sender->email }}</td>
							<td class="px-6 py-4">{{ $file->recieved->name }}</td>
							<td class="months px-6 py-4">{{ $file->created_at->format('F') }}</td> <!-- Use month name -->
							<td class="px-6 py-4">
								<a href="{{ url('/admin-records/' . $file->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
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
		document.addEventListener('DOMContentLoaded', function() {
			const filterForm = document.getElementById('filterForm');
			const categoryFilter = document.getElementById('category');
			const fromMonthFilter = document.getElementById('fromMonth');
			const toMonthFilter = document.getElementById('toMonth');
			const clearFiltersBtn = document.getElementById('clearFilters');
			const rows = document.querySelectorAll('.file-row');

			const reportCategoryInput = document.getElementById('reportCategory');
			const reportFromMonthInput = document.getElementById('reportFromMonth');
			const reportToMonthInput = document.getElementById('reportToMonth');
			const reportForm = document.getElementById('reportForm');

			// Create a month mapping for easy comparison
			const monthMapping = {
				"January": 1,
				"February": 2,
				"March": 3,
				"April": 4,
				"May": 5,
				"June": 6,
				"July": 7,
				"August": 8,
				"September": 9,
				"October": 10,
				"November": 11,
				"December": 12
			};

			function filterTable() {
				const selectedCategory = categoryFilter.value.toLowerCase();
				const selectedFromMonth = parseInt(fromMonthFilter.value);
				const selectedToMonth = parseInt(toMonthFilter.value);

				rows.forEach(row => {
					const rowCategory = row.querySelector('.category').textContent.toLowerCase();
					const rowMonthText = row.querySelector('.months').textContent; // Get month name
					const rowMonth = monthMapping[rowMonthText]; // Convert to month number

					// Category matching
					const matchesCategory = !selectedCategory || rowCategory.includes(selectedCategory);

					// Month range matching
					const matchesMonthRange = (!selectedFromMonth || rowMonth >= selectedFromMonth) &&
						(!selectedToMonth || rowMonth <= selectedToMonth);

					if (matchesCategory && matchesMonthRange) {
						row.style.display = '';
					} else {
						row.style.display = 'none';
					}
				});
			}

			// Listen for changes on filters
			[categoryFilter, fromMonthFilter, toMonthFilter].forEach(filter => {
				filter.addEventListener('change', filterTable);
			});

			// Clear filters
			clearFiltersBtn.addEventListener('click', () => {
				[categoryFilter, fromMonthFilter, toMonthFilter].forEach(filter => filter.value = '');
				filterTable();
			});

			// Pass filter values to hidden inputs before submitting the report form
			reportForm.addEventListener('submit', (e) => {
				reportCategoryInput.value = categoryFilter.value;
				reportFromMonthInput.value = fromMonthFilter.value;
				reportToMonthInput.value = toMonthFilter.value;
			});

			filterTable(); // Initialize table with filters
		});
	</script>
@endsection
