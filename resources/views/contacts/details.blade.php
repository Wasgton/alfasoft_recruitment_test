@extends('layout.blade')

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div>
            {{$contact->name}}
        </div>
        <div>
            {{$contact->contact}}
        </div>
        <div>
            {{$contact->email}}
        </div>
    </div>
@endsection
