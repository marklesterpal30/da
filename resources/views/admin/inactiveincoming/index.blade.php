@extends('admin/layouts.master')
@section('content')
	<div class="h-fit w-fit rounded-md bg-white p-4 shadow-xl md:w-full">
		<h1 class="mb-4 text-2xl font-bold text-gray-600">Inactive Document Lists</h1>

		<input type="text" id="codeFilter" class="mb-2 w-full rounded-lg border bg-green-200 px-4 py-2 focus:border-blue-500 focus:outline-none dark:border-gray-600 dark:bg-gray-700 dark:text-white" placeholder="Search ">

		@php
			$documentCategories = [
			    'atiSpecialOrders' => 'ATI Special Orders',
			    'atiMemorandumOrders' => 'ATI Memorandum Orders',
			    'letters' => 'Letters',
			    'others' => 'Others',
			    'daMemorandumOrders' => 'DA Memorandum Orders',
			    'daSpecialOrders' => 'DA Special Orders',
			    'travelOrders' => 'Travel Orders',
			    'ob' => 'OB',
			    'letter' => 'Letter',
			    'requestToWork' => 'Request to Work',
			    'trainingDesign' => 'Training Design',
			    'contract' => 'Contract',
			    'officeOrders' => 'Office Orders',
			];
		@endphp

		@foreach ($documentCategories as $category => $title)
			<h2 class="mb-4 mt-6 text-xl font-bold text-gray-600">{{ $title }}</h2>
			<table id="documentTable_{{ $category }}" class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-300 text-xs uppercase text-gray-700 shadow-lg dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">Reference No.</th>
						<th scope="col" class="px-6 py-3">Date Recieved</th>
						<th scope="col" class="px-6 py-3">Address To/From</th>
						<th scope="col" class="px-6 py-3">Subject/Title/Description</th>
						<th scope="col" class="px-6 py-3">Active</th>
						<th scope="col" class="px-6 py-3">Inactive</th>
						<th scope="col" class="px-6 py-3">Location</th>
						<th scope="col" class="px-6 py-3">Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach ($$category as $document)
						<tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
							<th scope="row" class="whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
								{{ $document->code }}
							</th>
							<td class="px-6 py-4">{{ $document->recieved_date }}</td>
							<td class="px-6 py-4">{{ $document->address_from }}</td>
							<td class="px-6 py-4">{{ $document->file_name }}</td>
							<td class="px-6 py-4">2 years</td>
							<td class="px-6 py-4">3 years</td>
							<td class="px-6 py-4">{{ $document->location }}</td>
							<td class="flex space-x-2 px-6 py-4">
								<a href="{{ url('/admin-inactiveincoming/' . $document->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		@endforeach
	</div>

	<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>

	<script>
		document.addEventListener("DOMContentLoaded", function() {
			const codeFilterInput = document.getElementById("codeFilter");
			const allRows = document.querySelectorAll("tbody tr");

			codeFilterInput.addEventListener("input", function() {
				const filterValue = this.value.trim().toLowerCase();

				allRows.forEach(row => {
					const codeCell = row.querySelector("th");
					if (codeCell) {
						const codeText = codeCell.textContent.trim().toLowerCase();
						if (codeText.includes(filterValue)) {
							row.style.display = "";
						} else {
							row.style.display = "none";
						}
					}
				});
			});
		});
	</script>
@endsection
