@extends('admin.layouts.master')
@section('content')
<div class="">
    <form action="{{ url('/file/' . $file->id) }}" method="POST" class="bg-gray-100 shadow-md rounded-md p-6 flex flex-col space-y-3">
        @csrf
        @method("PATCH")
        <div class="space-y-2">
            <a href="{{ url('/admin-outgoing-documents') }}">
                <i class="fa-solid fa-circle-arrow-left fa-2xl text-4xl w-fit" style="color: #00ad62;"></i>
            </a>
            <h1 class="text-2xl font-semibold">Document Information</h1>
        </div>
        <div class="flex space-x-3">
            <div style="width: 777px; height: 666px;" class="bg-white shadow-lg p-2 rounded-md">
                <iframe src="{{ asset('storage/app/public/files/' . $file->file_name . '.pdf') }}" width="100%" height="100%"></iframe>
            </div>
            <div class="space-y-4 shadow-2xl rounded-md bg-white">
                <h1 class="text-2xl font-bold p-3">Document Transaction History</h1>
                <div class="ml-3">
                    @if($file->sendeded_date)
                        {{-- Execute code until here when sender id === 2 then execute the code below if not --}}
                        @if($file->type === 'outgoing' && $file->sender_id === 2)
                            <h1 class="font-bold text-xl mb-2 "><i class="fa-solid fa-circle mr-2" style="color: #2edc8a;"></i>{{ $file->created_at }}</h1>
                            <div class="flex space-x-3 ml-2">
                                <div class="h-14 w-1 rounded-md bg-green-500"></div>
                                <div>
                                    <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold inline-block mb-3">Sent By: <span class="font-semibold">{{ $file->sender->name }}</span></h1>
                                    <br>                           
                                </div>
                            </div>

                            @if($file->fowarded_date)
                                <h1 class="font-bold text-xl mb-2"><i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>{{ $file->fowarded_date }}</h1>
                                <div class="flex space-x-3 ml-2">
                                    <div class="w-1 rounded-md bg-green-500"></div>
                                    <div>
                                        @foreach($forwardedDocument as $document)
                                            <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-4">Sent To: <span class="font-semibold">{{ $document->forwarded->name }}</span></h1>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($forwardedDocument->isNotEmpty())
                                @foreach($forwardedDocument as $document)
                                    @if($document->accepted_date)
                                        <h1 class="font-bold text-xl mb-2">
                                            <i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>
                                            {{ $document->accepted_date }}
                                        </h1>
                                        <div class="flex space-x-3 ml-2">
                                            <div class="h-14 w-1 rounded-md bg-green-500"></div>
                                            <div>
                                                <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-6">
                                                    Received By: <span class="font-semibold">{{ $document->accepted->name }}</span>
                                                </h1>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        @else
                            <h1 class="font-bold text-xl mb-2"><i class="fa-solid fa-circle mr-2" style="color: #2edc8a;"></i>{{ $file->created_at }}</h1>
                            <div class="flex space-x-3 ml-2">
                                <div class="h-24 w-1 rounded-md bg-green-500"></div>
                                <div>
                                    <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold inline-block mb-3">Sent By: <span class="font-semibold">{{ $file->sender->name }}</span></h1>
                                    <br>
                                    <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-4 -pt-2">Sent To: <span class="font-semibold">{{ $file->recieved->name }}</span></h1>
                                    <br>
                                </div>
                            </div>

                            @if($file->recieved_date)
                                <h1 class="font-bold text-xl mb-2"><i class="fa-solid fa-circle mr-2" style="color: #2edc8a;"></i>{{ $file->recieved_date }}</h1>
                                <div class="flex space-x-3 ml-2">
                                    <div class="h-14 w-1 rounded-md bg-green-500"></div>
                                    <div>
                                        <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-6">Received By: <span class="font-semibold">{{ $file->recieved->name }}</span></h1>
                                    </div>
                                </div>
                            @endif

                            @if($file->fowarded_date && $file->type === 'incoming')
                                <h1 class="font-bold text-xl mb-2"><i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>{{ $file->fowarded_date }}</h1>
                                <div class="flex space-x-3 ml-2">
                                    <div class="w-1 rounded-md bg-green-500"></div>
                                    <div>
                                        @foreach($forwardedDocument as $document)
                                            <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-6">Forwarded To: <span class="font-semibold">{{ $document->forwarded->name }}</span></h1>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($forwardedDocument->isNotEmpty())
                                @foreach($forwardedDocument as $document)
                                    @if($document->accepted_date)
                                        <h1 class="font-bold text-xl mb-2">
                                            <i class="fa-solid fa-circle mr-2 mt-2" style="color: #2edc8a;"></i>
                                            {{ $document->accepted_date }}
                                        </h1>
                                        <div class="flex space-x-3 ml-2">
                                            <div class="h-14 w-1 rounded-md bg-green-500"></div>
                                            <div>
                                                <h1 class="bg-green-200 w-fit px-4 py-2 rounded-md text-xl font-bold mb-6">
                                                    Accepted By: <span class="font-semibold">{{ $document->accepted->name }}</span>
                                                </h1>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif

                        @endif
                    @endif
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
