@extends('layouts.app')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <form action="{{route('contacts.update', ['contact'=>$contact->id])}}" method="post">
            @method('put') @csrf
            <div>
                <div class=" p-4 mb-4">
                    <label>
                        Name
                        <input name="name" type="text" value="{{$contact->name}}">
                    </label>
                </div>
            </div>
            <div>
                <div class=" p-4 mb-4">
                    <label>
                        Contact
                        <input name="contact" type="text" value="{{$contact->contact}}">
                    </label>
                </div>
            </div>
            <div>
                <div class=" p-4 mb-4">
                    <label>
                        Email
                        <input name="email" type="text" value="{{$contact->email}}">
                    </label>
                </div>
            </div>
            <button type="submit">Update Contact</button>
        </form>
    </div>
@endsection
