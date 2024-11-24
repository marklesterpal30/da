@extends('office/layouts.master')
@section('content')
<div class="p-12 bg-white rounded-md shadow-2xl">
	<div class="mb-1">
		<h1 class="text-3xl mb-12 font-semibold text-green-700">All Documents</h1>
	</div>
	<div class="relative overflow-x-auto">
		<h1 class="text-3xl mb-3 font-semibold text-green-700">Outgoing Documents</h1>
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
			<thead class="text-xs text-gray-700 uppercase bg-green-400 dark:bg-gray-700 dark:text-gray-400">
				<tr>
					<th scope="col" class="px-6 py-3">
						Code
					</th>
					<th scope="col" class="px-6 py-3">
						From
					</th>
					<th scope="col" class="px-6 py-3">
						Document Name
					</th>
					<th scope="col" class="px-6 py-3">
						Category
					</th>
					<th scope="col" class="px-6 py-3">
						action
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($outgoingDocuments as $file)
				<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:bg-gray-800 dark:border-gray-700">
					<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						{{$file->code}}
					</th>
					<td class="px-6 py-4">
						{{$file->sender->email}}
					</td>
					<td class="px-6 py-4">
						{{$file->file_name}}
					</td>
					<td class="px-6 py-4">
						{{$file->category}}
					</td>
					<td class="px-6 py-4">
						<a href="{{ url('/office-alldocuments/' . $file->id . '/edit') }}"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $outgoingDocuments->links() }}
	</div>

	<div class="relative overflow-x-auto mt-24">
		<h1 class="text-3xl mb-3 font-semibold text-green-700">Incoming Documents</h1>
		<table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
			<thead class="text-xs text-gray-700 uppercase bg-green-400 dark:bg-gray-700 dark:text-gray-400">
				<tr>
					<th scope="col" class="px-6 py-3">
						Code
					</th>
					<th scope="col" class="px-6 py-3">
						From
					</th>
					<th scope="col" class="px-6 py-3">
						Document Name
					</th>
					<th scope="col" class="px-6 py-3">
						Category
					</th>
					<th scope="col" class="px-6 py-3">
						action
					</th>
				</tr>
			</thead>
			<tbody>
				@foreach($incomingDocuments as $file)
				<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:bg-gray-800 dark:border-gray-700">
					<th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
						{{$file->code}}
					</th>
					<td class="px-6 py-4">
						{{$file->sender->email}}
					</td>
					<td class="px-6 py-4">
						{{$file->file_name}}
					</td>
					<td class="px-6 py-4">
						{{$file->category}}
						{{$file->id}}
					</td>
					<td class="px-6 py-4">
						<a href="{{ url('/office-alldocuments/' . $file->id . '/edit') }}"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		{{ $incomingDocuments->links() }}

	</div>
</div>
@endsection