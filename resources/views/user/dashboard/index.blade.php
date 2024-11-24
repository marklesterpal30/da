@extends('user.layouts.master')
@section('content')
	<div class="flex w-full flex-col items-start space-x-2 bg-white p-4 shadow-lg">

		<div id="STATUS COUNT" class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-4">

			<div id="PENDING DOCUMENTS" class="flex w-fit items-center justify-between space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Pending Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $pendingsCount }}</h1>
				</div>
				<div>
					<i class="fa-solid fa-file-circle-question fa-2xl text-5xl" style="color: #1a6035;"></i>
				</div>
			</div>

			<div id="RECIEVED DOCUMENTS" class="flex w-fit items-center justify-between space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Received Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $receivedCounts }}</h1>
				</div>
				<div>
					<i class="fa-solid fa-file-circle-check fa-2xl pr-3 text-5xl" style="color: #1a6035;"></i>
				</div>
			</div>

			<div id="FORWARDED DOCUMENTS" class="flex w-fit items-center justify-between space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Forwarded Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $forwardedCounts }}</h1>
				</div>
				<div>
					<i class="fa-solid fa-file-arrow-up fa-2xl text-5xl" style="color: #1a6035;"></i>
				</div>
			</div>

			<div id="ACCEPTED DOCUMENTS" class="flex w-fit items-center justify-between space-x-2 rounded-md border-l-8 border-green-700 bg-green-500 p-4 shadow-md">
				<div class="flex flex-col justify-between">
					<h1 class="text-2xl font-bold text-white">Accepted Documents</h1>
					<h1 class="text-3xl font-bold text-white">{{ $acceptedCounts }}</h1>
				</div>
				<div>
					<i class="fa-solid fa-file-circle-check fa-2xl pr-3 text-5xl" style="color: #1a6035"></i>
				</div>
			</div>

		</div>
		<div class="mt-6 grid grid-cols-1 md:grid-cols-2">
			<div style="" class="mt-12 flex h-60 w-full justify-center overflow-hidden bg-white md:h-96">
				<canvas id="documentsChart" style="" class=""></canvas>
			</div>

			<div style="" class="flex h-96 w-full justify-center overflow-hidden bg-white">
				<canvas id="documentsPieChart" style="" class=""></canvas>
			</div>

		</div>

	</div>

	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

	<script>
		const ctxBar = document.getElementById('documentsChart').getContext('2d');
		const months = @json($months); // Convert PHP array to JavaScript array
		const counts = @json($counts); // Convert PHP array to JavaScript array
		const documentsChart = new Chart(ctxBar, {
			type: 'line',
			data: {
				labels: months,
				datasets: [{
					label: 'Documents Count',
					data: counts,
					backgroundColor: 'rgba(75, 192, 192, 0.2)', // Color below the line
					borderColor: 'rgba(75, 192, 192, 1)', // Line color
					borderWidth: 1,
					fill: true // Enable fill below the line
				}]
			},
			options: {
				scales: {
					y: {
						beginAtZero: true
					}
				},
				plugins: {
					legend: {
						labels: {
							font: {
								size: 20 // Adjust label font size here for the bar chart
							}
						}
					}
				}
			}
		});



		const ctxPie = document.getElementById('documentsPieChart').getContext('2d');
		const categories = @json($categories); // Convert PHP array to JavaScript array
		const countsCategories = @json($countscategories); // Convert PHP array to JavaScript array

		const documentsPieChart = new Chart(ctxPie, {
			type: 'pie',
			data: {
				labels: categories,
				datasets: [{
					label: 'Documents Count by Category',
					data: countsCategories,
					backgroundColor: [
						'rgba(255, 99, 132, 0.2)',
						'rgba(54, 162, 235, 0.2)',
						'rgba(255, 206, 86, 0.2)',
						'rgba(75, 192, 192, 0.2)',
						'rgba(153, 102, 255, 0.2)',
						'rgba(255, 159, 64, 0.2)',
					],
					borderColor: [
						'rgba(255, 99, 132, 1)',
						'rgba(54, 162, 235, 1)',
						'rgba(255, 206, 86, 1)',
						'rgba(75, 192, 192, 1)',
						'rgba(153, 102, 255, 1)',
						'rgba(255, 159, 64, 1)',
					],
					borderWidth: 1
				}]
			},
			options: {
				responsive: true,
				plugins: {
					legend: {
						labels: {
							font: {
								size: 16 // Adjust label font size here for the pie chart
							}
						}
					},
					title: {
						display: true,
						text: 'Documents Count by Category',
						font: {
							size: 20 // Adjust title font size here
						}
					}
				}
			}
		});
	</script>
@endsection
