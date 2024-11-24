@extends('admin.layouts.master')
@section('content')
	<div class="rounded-md bg-white p-8 shadow-xl">
		<div class="grid grid-cols-1 gap-3 md:grid-cols-4">
			<div class="flex items-center space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="mr-3 text-2xl font-bold text-white">Internal Clients </h1>
					<h1 class="text-3xl font-bold text-white">{{ $totalUsers }}</h1>
				</div>
				<i class="fa-solid fa-users fa-2xl text-5xl" style="color: #e3e3e3"></i>
			</div>
			<div class="flex w-fit items-center space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Active Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $activeDocuments }}</h1>
				</div>
				<i class="fa-solid fa-file-shield fa-2xl text-5xl" style="color: #e3e3e3"></i>
			</div>
			<div class="flex w-fit items-center space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Inactive Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $inactiveDocuments }}</h1>
				</div>
				<i class="fa-solid fa-file-circle-question fa-2xl text-5xl" style="color: #e3e3e3"></i>
			</div>
			<div class="flex w-fit items-center space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Disposal Documents</h1>
					<h1 class="text-3xl font-bold text-white">0</h1>
				</div>
				<i class="fa-solid fa-file-circle-xmark fa-2xl text-5xl" style="color: #e3e3e3"></i>
			</div>
		</div>
		<div class="ml-3 mt-8 grid grid-cols-1 space-y-2 sm:grid sm:grid-cols-4 sm:space-x-3 sm:space-y-0">
			<div class="space-y-3">
				<div class="flex items-center space-x-3">
					<i class="fa-solid fa-file-circle-question fa-xl" style="color: #00bd3f;"></i>
					<h1 class="font-bold">{{ $pendingDocumentsCount }}</h1>
				</div>
				<h1 class="text-2xl font-bold text-green-600">Pending</h1>
				<div class="rounded-md bg-green-600 p-1"></div>
			</div>
			<div class="space-y-3">
				<div class="flex items-center space-x-3">
					<i class="fa-solid fa-file-circle-check fa-xl" style="color: #00bd3f;"></i>
					<h1 class="font-bold">{{ $receivedDocumentsCount }}</h1>
				</div>
				<h1 class="text-2xl font-bold text-green-600">Received</h1>
				<div class="rounded-md bg-green-600 p-1"></div>
			</div>
			<div class="space-y-3">
				<div class="flex items-center space-x-3">
					<i class="fa-solid fa-file-arrow-up fa-xl" style="color: #00bd3f;"></i>
					<h1 class="font-bold">{{ $forwardedDocumentsCount }}</h1>
				</div>
				<h1 class="text-2xl font-bold text-green-600">Forwarded</h1>
				<div class="rounded-md bg-green-600 p-1"></div>
			</div>
			<div class="space-y-3">
				<div class="flex items-center space-x-3">
					<i class="fa-solid fa-file-circle-check fa-xl" style="color: #00bd3f;"></i>
					<h1>{{ $acceptedDocumentsCount }}</h1>
				</div>
				<h1 class="text-2xl font-bold text-green-600">Accepted</h1>
				<div class="rounded-md bg-green-600 p-1"></div>
			</div>
		</div>
	</div>

	<div class="mt-4 flex flex-col space-y-2 rounded-md shadow-xl sm:flex sm:flex-row sm:space-x-3 sm:space-y-0">
		<div style="" class="h-96 w-full bg-white">
			<div class="flex items-center space-x-3 p-2">
				<label for="monthFilter" class="hidden sm:block">Select Month:</label>
				<select id="monthFilter" class="p-1">
					<option value="0">All Months</option>
					@foreach (range(1, 12) as $month)
						<option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
					@endforeach
				</select>
				<label for="weekFilter" class="hidden sm:block">Select Week:</label>
				<select id="weekFilter" class="p-1">
					<option value="0">All Weeks</option>
					<option value="1">1st Week</option>
					<option value="2">2nd Week</option>
					<option value="3">3rd Week</option>
					<option value="4">4th Week</option>
					<!-- You can add more weeks if needed -->
				</select>
			</div>
			<canvas id="documentsChart"></canvas>
		</div>
		<div style="" class="flex h-96 w-full justify-center overflow-hidden bg-white">
			<canvas id="categoriesChart" style="" class=""></canvas>
		</div>
	</div>
	<script>
		var ctxDocuments = document.getElementById('documentsChart').getContext('2d');
		var myChartDocuments;

		// Event listener to update chart when month is changed
		// Default values for month and week filters
		var defaultMonth = 0; // 0 represents all months
		var defaultWeek = 0; // 0 represents all weeks

		// Set default values for filters
		document.getElementById('monthFilter').value = defaultMonth;
		document.getElementById('weekFilter').value = defaultWeek;

		// Event listener to update chart when month is changed
		document.getElementById('monthFilter').addEventListener('change', function() {
			var selectedMonth = parseInt(this.value);
			var selectedWeek = parseInt(document.getElementById('weekFilter').value);
			updateChart(selectedMonth, selectedWeek);
		});

		// Event listener to update chart when week is changed
		document.getElementById('weekFilter').addEventListener('change', function() {
			var selectedMonth = parseInt(document.getElementById('monthFilter').value);
			var selectedWeek = parseInt(this.value);
			updateChart(selectedMonth, selectedWeek);
		});

		// Function to update the chart
		function updateChart(month, week) {
			var filteredCounts = {!! json_encode($counts) !!};

			if (month !== 0) {
				filteredCounts = filteredCounts.map((count, index) => index + 1 === month ? count : 0);
			}

			if (week !== 0) {
				// Calculate start and end index for the selected week
				var startIndex = (week - 1) * 4; // Assuming 4 weeks in a month
				var endIndex = week * 4 - 1;
				filteredCounts = filteredCounts.slice(startIndex, endIndex + 1);
			}

			// Log the filtered data
			console.log("Filtered Data:", filteredCounts);

			if (myChartDocuments) {
				myChartDocuments.destroy(); // Destroy previous chart instance
			}

			myChartDocuments = new Chart(ctxDocuments, {
				type: 'line',
				data: {
					labels: {!! json_encode($months) !!},
					datasets: [{
						label: 'Number of Documents',
						data: filteredCounts,
						backgroundColor: 'rgba(0, 207, 36, 0.8)',
						borderColor: 'rgba(75, 192, 192, 1)',
						borderWidth: 1,
						fill: true // Enable fill below the line
					}]
				},
				options: {
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});
		}

		// Initially, update the chart with default values
		updateChart(defaultMonth, defaultWeek);


		var categories = @json($categories->pluck('category'));
		var counts = @json($categories->pluck('count'));

		var ctxCategories = document.getElementById('categoriesChart').getContext('2d');
		var myChartCategories = new Chart(ctxCategories, {
			type: 'pie',
			data: {
				labels: categories,
				datasets: [{
					label: 'Document Counts per Category',
					data: counts,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)',
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)'
						// Add more colors if you have more categories
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)',
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)'
						// Add more colors if you have more categories
					],
					borderWidth: 1
				}]
			},
			options: {
				scales: {
					yAxes: [{
						ticks: {
							beginAtZero: true
						}
					}]
				}
			}
		});
	</script>
@endsection
