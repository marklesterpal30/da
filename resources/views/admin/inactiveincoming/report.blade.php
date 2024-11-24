@php
    use Carbon\Carbon;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
    
<div class="bg-white p-24">
<h1 class="text-3xl font-bold mb-4">Active</h1>
<h1>
@php
    $currentDate = Carbon::now()->format('F j, Y');
@endphp

<h1 class="text-3xl font-bold mb-8">{{ $currentDate }}</h1>

<div>
<h2 class="mb-3 mt-4 text-3xl font-bold">Documents</h2>

<table class="min-w-full border border-gray-300 text-2xl">
    <thead>
        <tr>
            <th class="py-2 px-4 border-b border-r">Document Name</th>
            <th class="py-2 px-4 border-b border-r">Owner</th>
            <th class="py-2 px-4 border-b border-r">Update</th>
            <th class="py-2 px-4 border-b border-r">Location</th>
        </tr>
    </thead>
    <tbody>
            <tr class="hover:bg-gray-100">
                <td class="py-2 px-4 border-b border-r">{{$document->file_name}}</td>
                <td class="py-2 px-4 border-b border-r">{{$document->address_from}}</td>
                <td class="py-2 px-4 border-b border-r">{{$document->updated_at}}</td>
                <td class="py-2 px-4 border-b border-r">asa may cabinet</td>
            </tr>
    </tbody>
</table>
</div>
<div class="mt-8">
    <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded" onclick="printOrderDetails()">
        Print Order Details
    </button>
</div>
</div>
<script>
    function printOrderDetails() {
        window.print();
    }
</script>

</body>
</html>

