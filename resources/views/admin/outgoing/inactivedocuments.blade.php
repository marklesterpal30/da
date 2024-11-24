@extends('admin.layouts.master')
@section('content')

<div class="p-12 bg-white rounded-md shadow-2xl">
    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex justify-between">
        <h1 class="text-3xl mb-3 font-semibold text-green-700">Outgoing Inactive Documents</h1>

            <form action="{{ url('/admin-outgoing-documents') }}" method="GET" class="mb-4">
                <select name="month" class="px-2 py-1 border rounded">
                    <option value="">All Months</option>
                    @foreach(range(1, 12) as $month)
                        <option value="{{ $month }}">{{ date('F', mktime(0, 0, 0, $month, 1)) }}</option>
                    @endforeach
                </select>
                <select name="type" class="px-2 py-1 border rounded">
                    <option value="">All category</option>
                    @foreach($types as $type)
                        <option value="{{ $type->purpose_name }}">{{$type->purpose_name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded ml-2">Filter</button>
            </form>
        </div>
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-green-400 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        File Name
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
                        Date
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
                    {{ $file->file}}
                    </th>
                    <td class="px-6 py-4">
                    {{ $file->category}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->sender->email}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->recieved->name}}
                    </td>
                    <td class="px-6 py-4">
                    {{ $file->created_at}}
                    </td>
                    <td class="px-6 py-4 " >
                    <span class="px-2 py-1.5 font-semibold text-white {{ $file->status == 'pending' ? 'bg-yellow-300' : (   $file->status == 'accepted' ? 'bg-gray-400 text-black shadow-md' : ($file->status == 'forwarded' ? 'bg-blue-400' : ( $file->status == 'return' ? 'bg-red-500' : ( $file->status == 'recieved' ? 'bg-green-500' : ''   ) ) ))}}">
                         {{ $file->status }}
                    </span>
                    </td>
                    <td class="px-6 py-4">
                        <a href="{{ url('/admin-outgoing-documents/' . $file->id . '/edit') }}" class="font-medium text-blue-600 dark:text-blue-500 hover:underline"><i class="fa-solid fa-eye" style="color: #2977ff;"></i></a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>



@endsection