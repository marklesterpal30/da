@extends('admin.layouts.master')
@section('content')

<div class="bg-white p-6  shadow-2xl   text-gray-600">
   <div class="flex ">
    <div class="hidden sm:block sm:w-1/2 mr-8">
        <h1 class="text-3xl font-semibold mb-2">Options</h1>
        <p class="text-xl">Every availble choice when configuring a product</p>
    </div>
    <div class="w-full p-8 bg-green-50">
        <form action="{{ url('/admin-purpose') }}" method="POST">
            @csrf
            <div class="space-y-3">
                <label for="purpose" class="text-2xl">Document Purpose</label>
                <input type="text" name="purpose_name" class="w-full text-lg bg-green-100 py-2 border-2 border-green-400 rounded-sm" placeholder="Enter Document Purpose">
                <select name="purpose_type" id="" class="w-full text-lg px-3 text-gray-400 bg-green-100 py-2 border-2 border-green-400 rounded-sm" placeholder="Enter Document Type">
                    <option value="incoming" class="text-gray-700">Incoming</option>
                    <option value="outgoing" class="text-gray-700">Outgoing</option>
                </select>
            </div>
            <div class="lists grid grid-cols-2 sm:grid sm:grid-cols-4 my-4 gap-2">
                @foreach($purposes as $purpose)
                <div class="relative px-3 py-1.5 bg-green-300 line-clamp-2">
                    <h1 class="text-lg font-semibold p-1.5 line-clamp-2">{{ $purpose->purpose_name }}</h1>
                    <div data-modal-target="deletepurpose" data-modal-toggle="deletepurpose" data-purpose-name="{{ $purpose->purpose_name }}" class="delete-purpose-btn absolute top-0 right-0 ">
                        <i class="fa-regular fa-circle-xmark" style="color: #cd0a0a;"></i>
                    </div>
                </div>
                @endforeach
            </div>
            <div>
                <button type="submit" class="px-4 py-2 rounded-md text-xl font-semibold bg-green-400 text-white">Add Action</button>
            </div>
        </form>
    </div>
   </div>
</div>

<div id="deletepurpose" tabindex="-1" data-modal-placement="top-center"  class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-md max-h-full">
        <div class="relative bg-green-50 rounded-lg shadow dark:bg-gray-700">
            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="deletepurpose">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close modal</span>
            </button>
            <div class="p-4 md:p-5 text-center">
                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this product?</h3>
                <form action="{{ url('/admin-delete-purpose') }}" method="POST">
                    @csrf
                    <input type="text" name="purpose_name" class="hidden" value="" id="purpose_name_input">
                    <div class="flex justify-center space-x-3">
                        <button  type="sumbmit" class="text-white bg-green-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            Yes, I'm sure
                        </button>
                        <button data-modal-hide="deletepurpose" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No, cancel</button>
                    </div>
                  

                </form>
            </div>
        </div>
    </div>
</div>
<script>
    // Get all delete purpose buttons
    const deletePurposeButtons = document.querySelectorAll('.delete-purpose-btn');

    // Add click event listener to each button
    deletePurposeButtons.forEach(button => {
        button.addEventListener('click', function() {
            // Get the purpose name from the data attribute
            const purposeName = this.dataset.purposeName;
            
            // Set the value of the hidden input field
            document.getElementById('purpose_name_input').value = purposeName;

        });
    });
</script>

@endsection