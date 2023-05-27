@extends('layouts.app')
@section('content')
        <div class="flex justify-between mb-4">
            <h2 class="text-2xl font-semibold">Contacts</h2>
            @auth
                <a class="bg-blue-500 text-white font-semibold py-2 px-4 rounded shadow" href="{{route('contacts.create')}}">
                    Create Contact
                </a>
            @endauth
        </div>
        <table class="w-full bg-white rounded shadow">
            <thead>
                <tr class="h-16">
                    <th class="py-2 px-4 bg-blue-500 text-white font-semibold">#</th>
                    <th class="py-2 px-4 bg-blue-500 text-white font-semibold">Name</th>
                    @auth <th class="py-2 px-4 bg-blue-500 text-white font-semibold">Action</th> @endauth
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                    <tr class="h-16">
                        <td class="py-2 px-4">{{$contact->id}}</td>
                        <td class="py-2 px-4">{{$contact->name}}</td>
                        @auth
                            <td>
                                <div class="flex items-center space-x-2">
                                    <div>
                                        <a class="bg-blue-500 text-white font-semibold py-1 px-2 rounded shadow hover:bg-blue-700 transition duration-300"
                                            href="{{route('contacts.show',['contact'=>$contact->id])}}">
                                            Details
                                        </a>
                                    </div>
                                    <div>
                                        <a href="{{route('contacts.edit',['contact'=>$contact->id])}}"
                                           class="bg-yellow-500 text-white font-semibold py-1 px-2 rounded shadow hover:bg-yellow-700 transition duration-300">Edit</a>
                                    </div>
                                    <form action="{{route('contacts.destroy',['contact'=>$contact->id])}}"
                                          method="POST">
                                        @method('DELETE') @csrf
                                        <button
                                            class="bg-red-500 text-white font-semibold py-1 px-2 rounded shadow hover:bg-red-700 transition duration-300"
                                            type="submit">
                                            Delete Contact
                                        </button>
                                    </form>
                                </div>
                            </td>
                        @endauth
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mb-6">
            {{$contacts->links()}}
        </div>

@endsection
