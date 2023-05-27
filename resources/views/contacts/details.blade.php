@extends('layouts.app')

@section('content')

    <div class="flex justify-center mt-8">
        <div class="w-2/3">
            <h2 class="text-2xl font-semibold">Contact Details</h2>

            <div class="bg-white rounded shadow p-8">
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold">Name:</label>
                    <p id="name" class="text-gray-900">{{$contact->name}}</p>
                </div>
                <div class="mb-4">
                    <label for="contact" class="block text-gray-700 font-semibold">Contact:</label>
                    <p id="contact" class="text-gray-900"> {{$contact->contact}}</p>
                </div>
                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                    <p id="email" class="text-gray-900">{{$contact->email}}</p>
                </div>
                <div class="flex justify-end">
                    <a class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow"
                       href="{{route('contacts.edit', ['contact'=>$contact->id])}}"
                    >
                        Edit
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
