@extends('layouts.master');

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        <div class="membersContainer grid grid-cols-3 gap-4">
            <div class="currentMembersContainer  col-span-2">
                <p class="text-3xl font-light mb-4">Members</p>
                @foreach($team->users as $user)
                    <div class="currentMemberContainer grid grid-cols-3">
                        <p>{{$user->name}}</p>
                        <p>9/15 quests completed</p>
                        <p>Joined 15/9/2022</p>
                    </div>
                @endforeach
            </div>
            <div class="newMembersContainer col-span-1">
                <p class="text-3xl font-light mb-4">Add members</p>
                <form method="POST" action="addTeamMembers" class="flex flex-col">
                    @include('partials.error')
                    @csrf
                    @foreach($allUsers->diff($team->users) as $user)
                        <div>
                            <input type="checkbox" id="addUser{{$user->id}}" name="newUsers[]" value="{{$user->id}}"> {{$user->name}} <br>
                        </div>
                    @endforeach
                    <input type="number" class="hidden" name="teamId" value="{{$team->id}}">
                    <input type="submit" class="w-1/4 mt-6 btn btn-white self-end">
                </form>
            </div>
        </div>
    </div>
@endsection
