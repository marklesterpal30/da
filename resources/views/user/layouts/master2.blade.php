<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Include your CSS and other head content here -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.x.x/dist/alpine.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.css" rel="stylesheet" />
    <script src="https://kit.fontawesome.com/6c0a20b496.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="">

    <div class="h-screen w-screen flex "> 
        <!-- LEFT SIDE BAR -->
        <div class="sidebar bg-green-200 w-fit p-4 shadow-md rounded-sm">
            <div class="bg-red-300 w-full px-28"></div>
            <!---- HIDE AND SHOW ----->
            <button id="toggleSidebar" class="bg-green-700 text-white px-3 py-1 mt-2 rounded-md mb-6"><i class="fa-solid fa-bars text-lg"></i></button>
            <!------ LOGO ------------>
            <div class="flex justify-center mb-14 ">
                <img src="{{ asset('storage/images/dalogo.png') }}" class="h-28 text-center">
            </div>
            <!-- SIDE BAR CONTENT  -->
            <ul class="text-left gitna">
                <li class=" {{ request()->is('dashboard') ? 'bg-green-600' : 'bg-green-600' }} mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white shadow-xl"><a href="/user-dashboard"><i class="fa-solid fa-gauge mr-2" style="color: #FFFF00;"></i><span class="menu-text">Dashboard</span></a></li>
                <li class="bg-green-600 mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white"><a href="/user-outgoing"><i class="fa-solid fa-file-import -ml-1 mr-2" style="color: #6eff6b"></i><span class="menu-text">Outgoing</span></a></li>
                <li class="bg-green-600 mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white"><a href="/user-mydocuments"><i class="fa-solid fa-file mr-2" style="color: #6eff6b;"></i><span class="menu-text">My Documents</span></a></li>
                <li class="bg-green-600 mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500 text-white"><a href="/user-profile"><i class="fa-solid fa-user mr-2" style="color: #ffffff;"></i><span class="menu-text">Your Profile</span></a></li>
                <form action="{{ url('/logout') }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="bg-green-600 text-white  mb-4 p-2 text-xl font-semibold rounded-md hover:bg-green-500"><i class="fa-solid fa-right-from-bracket mr-2" style="color: #fb3a18;"></i>Logout</button>
                </form>
            </ul>
        </div>

        <!-------RIGHT SDIDE BAR ----->
        <div class="flex flex-col w-full  overflow-hidden">
            <!-- HEADER -->
            <div class="w-full bg-green-400  h-20 flex items-center justify-between shadow-lg">
                <img src="{{ asset('storage/images/header.png') }}" class="w-96  ml-20 ">
                <h1 class="mr-20 font-bold font-sans bg-white text-green-400 px-2 py-1 rounded-md">{{ Auth::user()->name }} <i class="fa-solid fa-angle-down font-bold"></i></h1>
            </div>
            <!-- CONTENT -->
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

