@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">These are your teams:</h1>
        @can('create teams')
        <button class="btn btn-green mt-4"><a href="{{route('newteam')}}">Create new team</a></button>
        @endcan
        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach($teamlist as $team)
                <div class="teamTile border-solid border-2 border-sky-500 p-4 rounded-xl">
                    <h2 class="text-lg">{{$team->name}}</h2>
                    <p class="text-sm mt-4">{{$team->description}}</p>
                    <p class="text-sm mt-2">Teached by: {{$team->docent}}</p>
                    <button><a href="{{route('team',[$team->id])}}">See team</a></button>
                </div>
            @endforeach
        </div>

    </div>
@endsection
