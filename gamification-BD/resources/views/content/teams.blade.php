@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">These are your teams:</h1>
        @can('create teams')
        <button class="btn btn-white mt-4"><a href="{{route('newteam')}}">Create new team</a></button>
        @endcan
        <div class="grid grid-cols-3 gap-4 mt-4">
            @foreach($teamlist as $team)
                <div class="teamTile mt-8 rounded-xl p-6 border-solid border-gray-400 shadow flex flex-col place-content-between">
                    <div>
                        <h2 class="text-2xl font-light uppercase">{{$team->name}}</h2>
                        <p class="text-sm mt-4">{{$team->description}}</p>
                    </div>
                    <div class="flex flex-col">
                        <p class="text-sm mt-2">Teached by: {{$team->docent}}</p>
                        <button class="self-end"><a href="{{route('team',[$team->id])}}" class="uppercase font-extralight">See team</a></button>
                    </div>
                </div>
            @endforeach
        </div>

    </div>
@endsection
