@extends('layouts.master');

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        <div class="membersContainer grid grid-cols-3 gap-4">
            <div class="currentMembersContainer">
                <p class="text-3xl font-light mb-4">Members</p>
                @foreach($team->users as $user)
                    <p>{{$user->name}}</p>
                @endforeach
            </div>
        </div>
    </div>
@endsection
