@extends('layouts.app')
@section('content')
    <div class="bg-gray-100 flex items-center justify-center h-screen">
        <div class="bg-white p-8 shadow-lg rounded-lg w-1/3">
            <h2 class="text-2xl font-semibold mb-4">Login</h2>
            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email"  class="block text-gray-700 font-semibold">Email:</label>
                    <input type="email" name="email" id="email" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Enter email">
                </div>
                <div class="mb-6">
                    <label for="password" class="block text-gray-700 font-semibold">Password:</label>
                    <input type="password" name="password" id="password" class="w-full px-4 py-2 border border-gray-300 rounded shadow" placeholder="Enter password">
                </div>
                <button type="submit" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow hover:bg-blue-700 transition duration-300">Login</button>
            </form>
        </div>
    </div>
@endsection
