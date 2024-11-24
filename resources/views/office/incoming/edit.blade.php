@extends('office.layouts.master')
@section('content')
	<div class="">
		<form action="{{ url('/file/' . $file->id) }}" method="POST" class="flex flex-col space-y-3 rounded-md bg-gray-100 p-6 shadow-md">
			@csrf
			@method('PATCH')
			<div class="space-y-2">
				<a href="{{ url('/office-incoming') }}"><i class="fa-solid fa-circle-arrow-left fa-2xl w-fit text-4xl" style="color: #00ad62;"> </i></a>
				<h1 class="text-2xl font-semibold">Document Information</h1>
			</div>
			<div class="flex space-x-3">
				<div style="width: 777px; height: 666px;" class="rounded-md bg-white p-2 shadow-lg">
					<iframe src="{{ asset('storage/app/public/files/' . $file->file_name . '.pdf') }}" width="100%" height="100%"></iframe>
				</div>
				<div class="space-y-4 rounded-md bg-white shadow-2xl">
					<h1 class="p-3 text-2xl font-bold">Document Transaction History</h1>
					<!-- <h1 class="text-2xl font-semibold text-black">From : <span class="font-semibold">{{ $file->sender->name }}</span></h1>
						<h1 class="text-2xl font-semibold text-black">File Name: <span class="font-semibold">{{ $file->file_name }}</span></h1>
						<h1 class="text-2xl font-semibold text-black">Description: <span class="font-semibold">{{ $file->description }}</span></h1> -->
					<div class="ml-3">
						@if ($file->created_at)
							<h1 class="mb-2 text-xl font-bold"><i class="fa-solid fa-circle mr-2" style="color: #2edc8a;"></i>{{ $file->created_at }}</h1>
							<div class="ml-2 flex space-x-3">
								<div class="h-28 w-1 rounded-md bg-green-500">
								</div>
								<div>
									<h1 class="mb-3 inline-block w-fit rounded-md bg-green-200 px-4 py-2 text-xl font-bold">Send By: <span class="font-semibold">{{ $file->sender->name }}</span></h1>
									<br>
									<h1 class="-pt-2 mb-4 w-fit rounded-md bg-green-200 px-4 py-2 text-xl font-bold">Sent To: <span class="font-semibold">{{ $file->recieved->name }}</span></h1>
									<br>
								</div>
							</div>
						@endif
						@if ($file->recieved_date)
							<h1 class="mb-2 text-xl font-bold"><i class="fa-solid fa-circle mr-2" style="color: #2edc8a;"></i>{{ $file->recieved_date }}</h1>
							<div class="ml-2 flex space-x-3">
								<div class="h-14 w-1 rounded-md bg-green-500">
								</div>
								<div>
									<h1 class="mb-6 w-fit rounded-md bg-green-200 px-4 py-2 text-xl font-bold">Received By: <span class="font-semibold">{{ $file->recieved->name }}</span></h1>
								</div>
							</div>
						@endif
						@if ($file->fowarded_date)
							<h1 class="mb-2 text-xl font-bold"><i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>{{ $file->fowarded_date }}</h1>
							<div class="ml-2 flex space-x-3">
								<div class="w-1 rounded-md bg-green-500">
								</div>
								<div>
									@foreach ($forwardedDocument as $document)
										<h1 class="mb-6 w-fit rounded-md bg-green-200 px-4 py-2 text-xl font-bold">Forwarded To: <span class="font-semibold">{{ $document->forwarded->name }}</span></h1>
									@endforeach
								</div>
							</div>
						@endif
						@if ($forwardedDocument->isNotEmpty())
							@foreach ($forwardedDocument as $document)
								@if ($document->accepted_date)
									<h1 class="mb-2 text-xl font-bold">
										<i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>
										{{ $document->accepted_date }}
									</h1>
									<div class="ml-2 flex space-x-3">
										<div class="h-14 w-1 rounded-md bg-green-500"></div>
										<div>
											<h1 class="mb-6 w-fit rounded-md bg-green-200 px-4 py-2 text-xl font-bold">
												Accepted By: <span class="font-semibold">{{ $document->accepted->name }}</span>
											</h1>
										</div>
									</div>
								@endif
							@endforeach
						@endif
						@if ($file->return_date)
							<h1 class="mb-2 text-xl font-bold"><i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>{{ $file->return_date }}</h1>
							<div class="ml-2 flex space-x-3">
								<div class="h-14 w-1 rounded-md bg-green-500"></div>
								<div>
									<h1 class="w-fit rounded-md bg-indigo-400 px-4 py-2 text-xl font-bold">Return By: <span class="font-semibold">{{ $file->return->name }}</span></h1>
								</div>
							</div>
						@endif
					</div>
				</div>
			</div>
		</form>
	</div>
@endsection
