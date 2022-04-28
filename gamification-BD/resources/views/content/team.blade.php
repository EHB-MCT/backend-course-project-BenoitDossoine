@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-5xl">{{$team->name}}</h2>
        <button class="btn btn-blue"><a href="{{route('newquest',[$team->id])}}">Add quest</a></button>
        <div class="questContainer grid-cols-3">
            @foreach($quests as $quest)
                <div class="questTile mt-8 rounded-xl p-6 border-solid border-gray-400 shadow">
                    <h2 class="text-xl mb-4">{{$quest->name}}</h2>
                    <p>{{$quest->description}}</p>
                    <p>{{$quest->experience}}</p>
                    <button class="btn btn-green mt-6">Mark as completed</button>
                </div>
            @endforeach
        </div>
    </div>
@endsection
