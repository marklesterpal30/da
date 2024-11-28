<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<script src="https://cdn.tailwindcss.com"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
	<script src="https://kit.fontawesome.com/6c0a20b496.js" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>

<body>
	<div>
		<nav class="fixed left-0 top-0 z-50 flex w-screen items-center justify-between bg-green-300 py-2 md:py-4">
			<button data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar" aria-controls="default-sidebar" type="button"
				class="ms-3 mt-2 inline-flex items-center rounded-lg p-2 text-sm text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600 sm:hidden">
				<span class="sr-only">Open sidebar</span>
				<svg class="h-6 w-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
					<path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
				</svg>
			</button>
			<h1 class="hidden text-2xl font-bold text-white md:ml-9 md:flex">ATI MIMAROPA</h1>
			<h1 class="mr-4 rounded-md bg-white px-2 py-1 font-sans font-bold text-green-400 sm:mr-20">{{ Auth::user()->name }} <i class="fa-solid fa-angle-down font-bold"></i></h1>
		</nav>
	</div>

	<aside id="default-sidebar" class="fixed left-0 top-14 z-40 h-screen w-64 -translate-x-full transition-transform sm:top-16 sm:translate-x-0" aria-label="Sidebar">
		<div class="h-full overflow-y-auto bg-white px-3 py-4 dark:bg-gray-800">
			<ul class="space-y-2 font-medium">
				<li class="flex justify-center">
					<img src="{{ asset('storage/app/public/images/dalogo.png') }}" class="h-28 text-center">
				</li>
				<li class="{{ request()->is('office-dashboard') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="{{ url('/office-dashboard') }}" class="flex h-full w-full items-center">
						<i class="fa-solid fa-gauge mr-2" style="color: #FFFF00;"></i>
						<span class="menu-text">Dashboard</span>
					</a>
				</li>

				<li class="{{ request()->is('office-incoming') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="/office-incoming" class="flex h-full w-full items-center">
						<i class="fa-solid fa-file-arrow-up mr-2 text-white"></i>
						<span class="menu-text">Incoming <span class="ml-2 rounded-lg bg-white px-3 py-0.5 text-green-600">{{ $officeIncomingCount }}</span></span>
					</a>
				</li>

				<li class="{{ request()->is('office-outgoing') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="/office-outgoing" class="flex h-full w-full items-center">
						<i class="fa-solid fa-file-arrow-up mr-2 text-white"></i>
						<span class="menu-text">Outgoing </span>
					</a>
				</li>

				<li class="{{ request()->is('office-alldocuments') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="{{ url('/office-alldocuments') }}" class="flex h-full w-full items-center">
						<i class="fa-solid fa-file-lines mr-2 text-white"></i>
						<span class="menu-text">All Documents</span>
					</a>
				</li>

				{{-- <li class="{{ request()->is('record') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="/record" class="flex h-full w-full items-center">
						<i class="fa-solid fa-print mr-2 text-white"></i>
						<span class="menu-text">Reports</span>
					</a>
				</li> --}}

				<li class="{{ request()->is('office-profile') ? 'bg-green-800' : 'bg-green-600' }} mb-4 rounded-md p-2 text-xl font-semibold text-white hover:bg-green-500">
					<a href="/office-profile" class="flex h-full w-full items-center">
						<i class="fa-solid fa-gear mr-2 text-white"></i>
						<span class="menu-text">Your Profile</span>
					</a>
				</li>

				<form action="{{ url('/logout') }}" method="POST" class="w-full">
					@csrf
					<button type="submit" class="mb-4 w-full rounded-md bg-green-600 p-2 text-left text-xl font-semibold text-white hover:bg-green-500">
						<i class="fa-solid fa-right-from-bracket mr-2" style="color: #fb3a18;"></i>Logout
					</button>
				</form>
			</ul>
		</div>
	</aside>

	<div class="mt-16 sm:ml-64">
		<!-- CONTENT -->
		<div class="content {{ request()->is('dashboard') ? 'p-0' : 'p-6' }} h-screen w-full overflow-y-auto rounded-md bg-green-200 shadow-lg">
			@yield('content')
		</div>
	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</body>

</html>
