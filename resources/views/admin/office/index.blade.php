k@extends('admin.layouts.master')
@section('content')
	<div class="h-full bg-white p-4">

		<div class="relative h-full overflow-x-auto sm:rounded-lg">
			<div class="mb-4 flex justify-between">
				<h1 class="mb-3 text-3xl font-bold text-green-700">Employee Lists</h1>
				<div x-data="{ open: false }">
					<!-- Open modal button -->
					<a x-on:click="open = true" class=""><button class="rounded-md bg-green-200 px-5 py-1 font-semibold text-black shadow-md">Create</button></a>
					<!-- Modal Overlay -->
					<div x-show="open" class="fixed inset-0 z-50 flex items-center justify-end overflow-hidden">
						<div x-show="open" x-transition:enter="transition-opacity ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="bg-opacity-25" x-transition:leave="opacity-50 ease-in duration-300" x-transition:leave-start="opacity-0" x-transition:leave-end="opacity-25"
							class="absolute inset-0 transition-opacity" style="background-color: rgba(151, 255, 140, 0.47);"></div>
						<!-- Modal Content -->
						<div x-show="open" x-transition:enter="transition-transform ease-out duration-300" x-transition:enter-start="transform translate-x-full" x-transition:enter-end="transform translate-y-0" x-transition:leave="transition-transform ease-in duration-300"
							x-transition:leave-start="transform translate-y-0" x-transition:leave-end="transform translate-x-full" class="z-50 h-full w-full max-w-md overflow-hidden rounded-md bg-white shadow-xl sm:w-96 md:w-1/2 lg:w-2/3 xl:w-1/3">
							<!-- Modal Header -->
							<div class="flex justify-between bg-green-500 px-4 py-2 text-white">
								<h2 class="text-lg font-semibold">Create Accounts</h2>
								<button x-on:click="open = false" class="rounded-md bg-red-500 px-3 py-1 text-white"> Cancel </button>
							</div>
							<!-- Modal Body -->

							<!-- Modal Footer -->
							<div class="flex justify-end space-x-3 border-t px-4 py-2">
								<form action="{{ url('/admin-employee') }}" method="POST" class="mt-10 w-full">
									@csrf
									<div class="mb-4">
										<label for="name" class="text-gray-600">Name</label>
										<input type="text" name="name" class="border-1 w-full rounded-md border-gray-200 bg-green-100" placeholder="Enter Name">
									</div>
									<div class="mb-4">
										<label for="email" class="text-gray-600">Email</label>
										<input type="text" name="email" class="border-1 w-full rounded-md border-gray-200 bg-green-100" placeholder="Enter Email">
									</div>
									<div class="mb-4">
										<label for="password" class="text-gray-600">Password</label>
										<input type="text" name="password" class="border-1 w-full rounded-md border-gray-200 bg-green-100" placeholder="Enter Password">
									</div>
									<div class="mb-4 hidden">
										<label for="role" class="text-gray-600">Employee Role</label>
										<input type="text" name="role" value="office" class="border-1 hidden w-full rounded-md border-gray-200 bg-green-100" placeholder="Select Employee Role">
									</div>
									<div class="mt-5 flex justify-end space-x-4">
										<button type="submit" class="rounded-md bg-green-500 px-3 py-1 text-white shadow-md">Submit</button>
										<button class="rounded-md border-2 border-gray-200 bg-white px-3 py-1 shadow-sm">Clear Fields</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<table class="w-full text-left text-sm text-gray-500 rtl:text-right dark:text-gray-400">
				<thead class="bg-green-300 text-xs uppercase text-gray-700 shadow-lg dark:bg-gray-700 dark:text-gray-400">
					<tr>
						<th scope="col" class="px-6 py-3">
							Name
						</th>
						<th scope="col" class="px-6 py-3">
							Office
						</th>
						<th scope="col" class="px-6 py-3">
							Designation
						</th>
						<th scope="col" class="px-6 py-3">
							Actions
						</th>

					</tr>
				</thead>
				<tbody class="">
					@foreach ($offices as $office)
						<tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-100' : 'bg-white' }} border-b dark:border-gray-700 dark:bg-gray-800">
							<th scope="row" class="flex items-center space-x-2 whitespace-nowrap px-6 py-4 font-medium text-gray-900 dark:text-white">
								<div>
									<div class="user-avatar">
										<h1 class="rounded-full bg-green-200 px-3 py-2 text-xl">{{ $office->user_avatar }}</h1>
									</div>
								</div>
								<div class="flex flex-col">
									<h1>{{ $office->name }}</h1>
									<h1>{{ $office->email }}</h1>
								</div>
							</th>
							<td class="px-6 py-4">
								{{ $office->name }}
							</td>
							<td class="px-6 py-4">
								N/A
							</td>
							<td class="space-x-3 px-6 py-4">
								<a href="{{ url('/admin-employee/' . $office->id . '/edit') }}" class="font-medium text-blue-600 hover:underline dark:text-blue-500"><i class="fa-solid fa-pen-to-square" style="color: #74C0FC;"></i></a>
								<form action="{{ url('/admin-employee', $office->id) }}" method="POST" class="inline-block">
									@csrf
									@method('DELETE')
									<button type="submit" class="font-medium text-blue-600 hover:underline dark:text-blue-500">
										<i class="fa-solid fa-trash-can" style="color: #ff2424;"></i>
									</button>
								</form>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

	</div>
@endsection
