<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and other head content here -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/6c0a20b496.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="">
    <div class="h-screen w-screen flex "> 
        <!-- SIDE BAR LEFT -->
        <div class="sidebar bg-green-200 w-fit p-4  shadow-md rounded-sm">
        <div class="bg-red-300 w-full px-28"></div>
        <!-- TOGGLE BAR -->
        <button id="toggleSidebar" class="bg-green-700 text-white px-3 py-1 mt-2 rounded-md mb-6"><i class="fa-solid fa-bars text-lg"></i></button>
        <!-----LOGO ----->
        <div class="flex justify-center mb-14 ">
          <img src="{{ asset('storage/images/dalogo.png') }}" class="h-28 text-center">
        </div>
        <!-- SIDE BAR CONTENT -->
        <ul class="text-left gitna">
            <li class="{{ request()->is('office-incoming') ? 'bg-green-800' : 'bg-green-600' }} bg-green-600 mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white"><a href="/office-incoming"><i class="fa-solid fa-file mr-2" style="color: #6eff6b;"></i><span class="menu-text">Incoming <span class="bg-white text-green-600 px-3 py-0.5 ml-2 rounded-lg"></span></span></a></li>
            <li class=" {{ request()->is('office-dashboard') ? 'bg-green-800' : 'bg-green-600' }} mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white shadow-xl"><a href="{{ url('/office-dashboard') }}"><i class="fa-solid fa-gauge mr-2" style="color: #FFFF00;"></i><span class="menu-text">Dashboard</span></a></li>
            <li class="{{ request()->is('office-alldocuments') ? 'bg-green-800' : 'bg-green-600' }}  text-white mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500"><a href="{{ url('/office-alldocuments') }}"><i class="fa-solid fa-file-lines mr-2" style="color: #6eff6b;"></i><span class="menu-text">All Docuemnts</span></a></li>
            <li class="{{ request()->is('record') ? 'bg-green-800' : 'bg-green-600' }} bg-green-600 text-white mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500"><a href="/record"><i class="fa-solid fa-address-book mr-2" style="color: #358500;"></i><span class="menu-text">Records</span></a></li>
            <li id="dropdownDefaultButton" data-dropdown-toggle="dropdown" data-dropdown-offset-skidding="30" class="{{ request()->is('office-outgoing') ? 'bg-green-400' : 'bg-green-600' }}  text-white mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 " type="button"><i class="fa-solid fa-file-arrow-down mr-1"></i> <span class="menu-text">Outgoing</span> 
            </li>

                <!-- Dropdown menu -->
                <div id="dropdown" class="z-10 hidden bg-green-500 divide-y ml-12 divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class=" text-white  text-sm hover:text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                    <li><a href="{{ url('/office-outgoing')}}" class="hover:text-gray-700 text-white block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Outgoing</a></li>
                    <li><a href="{{ url('/office-outgoing-documents') }}" class="hover:text-gray-700 block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Documents</a></li>
                    <li><a href="#" class="hover:text-gray-700 text-white block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Earnings</a></li>
                    <li><a href="#" class="hover:text-gray-700 text-white block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Sign out</a></li></ul>
                </div>

            <form action="{{ url('/logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit" class="bg-green-600 text-white  mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500"><i class="fa-solid fa-right-from-bracket mr-2" style="color: #fb3a18;"></i>Logout</button>
            </form>
        </ul>
        </div>
        <!-- SIDE BAR RIGHT SIDE -->
        <div class="flex flex-col w-full  overflow-hidden">
            <!-- NAVIGATION BAR -->
            <div class="w-full bg-green-400  h-20 flex items-center justify-between shadow-xl">
                <img src="{{ asset('storage/images/header.png') }}" class="w-96  ml-20 ">
                <h1 class="mr-20 font-bold font-sans text-green-600 bg-white rounded-md px-2 py-1">{{ Auth::user()->name }} <i class="fa-solid fa-angle-down font-bold"></i></h1>
            </div>
            <!-- CONTENT SIDE -->
            <div class="content bg-green-200 w-full {{ request()->is('dashboard') ? 'p-0' : 'p-6' }} m-4 shadow-lg rounded-md h-screen overflow-y-auto">
                @yield('content') 
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        
     

   document.addEventListener('DOMContentLoaded', function () {
    const toggleButton = document.getElementById('toggleSidebar');
    const sidebar = document.querySelector('.sidebar');
    const redDiv = document.querySelector('.bg-red-300');
    const gitna = document.querySelector('.gitna');

    // Check if the sidebar state is stored in local storage
    const isSidebarSmall = localStorage.getItem('isSidebarSmall') === 'true';

    // Set the initial state based on local storage or default state
    setSidebarState(isSidebarSmall);

    toggleButton.addEventListener('click', () => {
        sidebar.classList.toggle('small-sidebar');
        redDiv.classList.toggle('px-8');
        gitna.classList.toggle('text-center');

        // Toggle a class for hiding text elements
        toggleTextVisibility(!sidebar.classList.contains('small-sidebar'));

        // Store the state in local storage
        localStorage.setItem('isSidebarSmall', sidebar.classList.contains('small-sidebar'));
    });

    function setSidebarState(isSmall) {
        if (isSmall) {
            sidebar.classList.add('small-sidebar');
            redDiv.classList.add('px-8');
            gitna.classList.add('text-center');
        }
        // Always toggle the text visibility based on the current state
        toggleTextVisibility(!isSmall);
    }

    function toggleTextVisibility(showText) {
        // Toggle a class on the span elements to control text visibility
        document.querySelectorAll('.menu-text').forEach((item) => {
            if (showText) {
                item.classList.remove('hidden');
            } else {
                item.classList.add('hidden');
            }
        });
    }

    // Feed Product Dropdown
    const dropdownButton = document.getElementById('feedProductDropdown');
    const dropdownContent = document.getElementById('feedProductDropdownContent');

    dropdownButton.addEventListener('click', () => {
        dropdownContent.classList.toggle('hidden');
    });

    // Hide dropdown when clicking outside
    window.addEventListener('click', (event) => {
        if (!dropdownButton.contains(event.target) && !dropdownContent.contains(event.target)) {
            dropdownContent.classList.add('hidden');
        }
    });

    const vdropdownButton = document.getElementById('vitaminProductDropdown');
    const vdropdownContent = document.getElementById('vitaminProductDropdownContent');

    vdropdownButton.addEventListener('click', () => {
        vdropdownContent.classList.toggle('hidden');
    });

    // Hide dropdown when clicking outside
    window.addEventListener('click', (event) => {
        if (!vdropdownButton.contains(event.target) && !vdropdownContent.contains(event.target)) {
            vdropdownContent.classList.add('hidden');
        }
    });

});




  // Function to automatically close the alert after a specified time
  function closeAlert(alert) {
        setTimeout(function () {
            alert.style.display = 'none';
        }, 3000);
    }

    // Find and close the alerts after 3 seconds
    document.addEventListener('DOMContentLoaded', function () {
        var errorAlert = document.querySelector('.error-alert');
        var successAlert = document.querySelector('.success-alert');

        if (errorAlert) {
            closeAlert(errorAlert);
        }

        if (successAlert) {
            closeAlert(successAlert);
        }
    });
</script>
</body>
</html>

