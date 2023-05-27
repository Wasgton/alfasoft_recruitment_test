@extends('layouts.app')
@section('content')
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
                                           class="">Edit</a>
                                    </div>
                                    <form action="{{route('contacts.destroy',['contact'=>$contact->id])}}"
                                          method="POST">
                                        @method('DELETE') @csrf
                                        <button type="submit">
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
