<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body class="bg-gray-100">
        <div class="flex justify-between bg-blue-500 p-4">
            <a href="{{ route('home') }}"
               class="bg-white text-blue-500 font-semibold py-2 px-4 border border-blue-500 rounded shadow">
                Home
            </a>
            @guest
                <div class="py-2 px-4 border border-blue-500 rounded shadow">
                    <a href="{{ route('login') }}"
                       class="bg-white text-blue-500 font-semibold py-2 px-4 border border-blue-500 rounded shadow">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="bg-white text-blue-500 font-semibold py-2 px-4 border border-blue-500 rounded shadow">
                        Register
                    </a>
                </div>
            @endguest
            @auth
                <div>
                    <form action="{{route('logout')}}" method="post">
                        @method('post') @csrf
                        <button type="submit" class="bg-white text-blue-500 font-semibold py-2 px-4 border border-blue-500 rounded shadow">
                            Log out
                        </button>
                    </form>
                </div>
            @endauth
        </div>
        <main class="flex justify-center mt-8">
            <div class="w-2/3">

                    @if($errors->any())
                    <div>
                        <div class="bg-red-100 text-red-700 mb-4 p-4 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    @endif
                @yield('content')
            </div>
        </main>
    </body>
</html>
