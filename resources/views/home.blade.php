@extends('layouts.app')
@section('content')
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
            @auth <a href="{{route('contacts.create')}}">Create Contact</a> @endauth
            <table class="hover:table-fixed">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        @auth <th>Action</th> @endauth
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                        <tr>
                            <td></td>
                            <td>{{$contact->name}}</td>
                            @auth
                                <td>
                                    <div>
                                        <a href="{{route('contacts.show',['contact'=>$contact->id])}}">
                                            Details
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{route('contacts.edit',['contact'=>$contact->id])}}"
                                           class="btn-icon mdi mdi-square-edit-outline"></a>
                                    </div>
                                    <form action="{{route('contacts.destroy',['contact'=>$contact->id])}}"
                                          method="POST">
                                        @method('DELETE') @csrf
                                        <button type="button" class="btn-icon btSubmitDeleteItem">
                                            Delete Contact
                                        </button>
                                    </form>
                                </td>
                            @endauth
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
@endsection
