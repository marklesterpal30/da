@extends('office.layouts.master')
@section('content')

<div class="p-12 bg-white rounded-md shadow-2xl">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex justify-between">
        <h1 class="text-3xl mb-3 font-semibold text-green-700">My Documents</h1>

            <form action="{{ url('/office-outgoing-documents') }}" method="GET" class="mb-4">
                <label for="status" class="mr-2">Filter by Status:</label>
                <select name="status" id="status" class="px-2 py-1 border rounded">
                        <option value="">All</option>
                        <option value="pending">Pending</option>
                        <option value="recieved">Recieved</option>
                        <option value="forwarded">Forwarded</option>
                </select>
                <select name="month" class="px-2 py-1 border rounded">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}" {{$selectedMonth == $month ? 'selected': ''}}>{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded ml-2">Filter</button>
            </form>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-green-400 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        Document Code
                    </th>
                    <th scope="col" class="px-6 py-3">
                         Document Name
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Category
                    </th>
                    <th scope="col" class="px-6 py-3">
                         From
                    </th>
                 
                    <th scope="col" class="px-6 py-3">
                        To
                    </th>
                    <th scope="col" class="px-6 py-3">
                    Status
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Action
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($files as $file)
                <tr class="{{ $loop->iteration % 2 == 0 ? 'bg-green-200' : 'bg-white' }} border-b dark:bg-gray-800 dark:border-gray-700">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{ $file->code}}
                    </th>
                    <td class="px-6 py-4">
                    {{ $file->file_name}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->category}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->sender->email}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->recieved->name}}
                    </td>
                    <td class="px-6 py-4 " >
                    <span class="px-2 py-1.5 font-semibold text-white {{ $file->status == 'pending' ? 'bg-yellow-300' : (   $file->status == 'accepted' ? 'bg-gray-400 text-black shadow-md' : ($file->status == 'forwarded' ? 'bg-blue-400' : ( $file->status == 'return' ? 'bg-red-500' : ( $file->status == 'received' ? 'bg-green-500' : ''   ) ) ))}}">
                         {{ $file->status }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ url('/office-outgoing-documents/' . $file->id . '/edit') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection