<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document Report</title>
	<script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
	<div class="-ml-20 -mt-12 w-full bg-white p-12">
		<div class="flex justify-center">
			<img src="{{ asset('storage/app/public/images/header.png') }}" class="ml-32" alt="">
		</div>
	</div>

	<div class="-mt-20 flex w-full justify-between p-4">
		<div class="p-4">
			<h1 class="text-xl font-bold">Division/RTC/Section/Office:
				<span class="underline">ATI-Regional Training Center MIMaRoPa</span>
			</h1>
			<h1 class="text-xl font-bold">
				Kind of Document:
				<span class="text-xl font-semibold">
					{{ $category ? $category : 'All Category' }}
				</span>
			</h1>

			@php
				use Carbon\Carbon;

				$fromMonthName = !empty($fromMonth) && is_numeric($fromMonth) ? Carbon::createFromFormat('m', $fromMonth)->format('F') : null;
				$toMonthName = !empty($toMonth) && is_numeric($toMonth) ? Carbon::createFromFormat('m', $toMonth)->format('F') : null;
			@endphp

			<h1 class="text-xl font-bold">
				Month:
				<span class="text-xl font-semibold">
					@if ($fromMonthName && $toMonthName)
						{{ $fromMonthName }} - {{ $toMonthName }}
					@elseif($fromMonthName)
						{{ $fromMonthName }}
					@elseif($toMonthName)
						{{ $toMonthName }}
					@else
						All Months
					@endif
				</span>
			</h1>
		</div>
	</div>

	<div class="-mt-12 w-full p-4">
		<table class="text-md min-w-full border border-gray-300">
			<h2 class="mt-4 border-2 px-5 text-center text-2xl font-bold">Records Matrix</h2>
			<thead>
				<tr>
					<th class="border-b border-r px-4 py-2">Reference Code</th>
					<th class="border-b border-r px-4 py-2">Address to/from</th>
					<th class="border-b border-r px-4 py-2">Description</th>
					<th class="border-b border-r px-4 py-2">Date Received</th>
					<th class="border-b border-r px-4 py-2">Active</th>
					<th class="border-b border-r px-4 py-2">Inactive</th>
					<th class="border-b border-r px-4 py-2">Location</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($files as $file)
					<tr class="hover:bg-gray-100">
						<td class="border-b border-r px-4 py-2">{{ $file->code }}</td>
						<td class="border-b border-r px-4 py-2">{{ $file->sender->name }}</td>
						<td class="border-b border-r px-4 py-2">{{ $file->description }}</td>
						<td class="border-b border-r px-4 py-2">{{ $file->recieved_date }}</td> <!-- Fixed spelling -->
						<td class="border-b border-r px-4 py-2">{{ \Carbon\Carbon::parse($file->active_years)->format('Y-m-d') }}</td>
						<td class="border-b border-r px-4 py-2">{{ $file->inactive_years }}</td>
						<td class="border-b border-r px-4 py-2">{{ $file->location }}</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>

</body>

</html>
