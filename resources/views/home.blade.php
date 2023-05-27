@extends('layouts.app')
@section('content')
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center py-4 sm:pt-0">
        <div class="fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Home</a>
            @else
                <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                @endif
            @endauth
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <table class="hover:table-fixed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Contato</th>
                        <th>Email</th>
                        @auth <th>Ações</th> @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td></td>
                            <td>{{$contact->name}}</td>
                            <td>{{$contact->contact}}</td>
                            <td>{{$contact->email}}</td>
                            @auth
                                <td>

                                </td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

@endsection
