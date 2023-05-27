@extends('layouts.app')

@section('content')
    <div class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="bg-white p-8 shadow-lg rounded-lg w-1/3">
            <h2 class="text-2xl font-semibold mb-4">Register</h2>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold">Name:</label>
                    <input type="text" id="name" name="name" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Enter name" value="{{ old('name') }}">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold">Email:</label>
                    <input type="email" id="email" name="email" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Enter email" value="{{ old('email') }}">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Enter password">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password:</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Confirm password">
                </div>

                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow hover:bg-blue-700 transition duration-300">Register</button>
            </form>
        </div>
    </div>
@endsection

