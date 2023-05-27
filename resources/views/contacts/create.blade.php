@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <form class="mt-8" action="{{route('contacts.store')}}" method="post">
            @method('post') @csrf
            <div class="mb-4">
                <label>
                    Name
                    <input
                        name="name"
                        value="{{old('name')}}"
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
                        name="contact" value="{{old('contact')}}">
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
                           value="{{old('email')}}">
                </label>
            </div>
            <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow">
                Create Contact
            </button>
        </form>
    </div>
@endsection
