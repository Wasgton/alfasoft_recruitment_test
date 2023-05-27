@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <form action="{{route('contacts.update', ['contact'=>$contact->id])}}" method="post">
            @method('put') @csrf

            <div class="mb-4">
                <label>
                    Name
                    <input
                        name="name"
                        value="{{$contact->name}}"
                        type="text"
                        id="name"
                        class="w-full px-4 py-2 border border-gray-300 rounded shadow"
                        placeholder="Enter name">
                </label>
            </div>
            <div class="mb-4">
                <label>
                    Contact
                    <input
                        type="text"
                        id="contact"
                        class="w-full px-4 py-2 border border-gray-300 rounded shadow"
                        placeholder="Enter contact"
                        name="contact" value="{{$contact->contact}}">
                </label>
            </div>
            <div class="mb-4">
                <label>
                    Email
                    <input type="email"
                           id="email"
                           class="w-full px-4 py-2 border border-gray-300 rounded shadow"
                           placeholder="Enter email"
                           name="email"
                           value="{{$contact->email}}">
                </label>
            </div>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow">
                Update Contact
            </button>
        </form>
    </div>
@endsection
