@extends('layouts.master')

@section('content')
    <div class="relative py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">Admin panel</h2>
        <div class="container grid grid-cols-4 gap-4">
            <div class="membersContainer col-span-2">
                <h2 class="text-3xl subtitle mb-4">Members</h2>
                @foreach($users as $user)
                    <div class="grid grid-cols-3 w-100 justify-between align-center mb-4 mx-2 bg-white rounded-xl px-6 py-2">
                        <p class="self-center col-span-1">{{$user->name}}</p>
                        <div class="col-span-2 flex justify-evenly">
                            <form action="changeMemberRole" method="POST" id="user{{$user->id}}Form">
                                @csrf
                                <label for="role">User role:</label>
                                @if($user->hasRole('admin'))
                                    <select class="rounded" name="role" id="roleSelect">
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                        <option value="member">Member</option>
                                    </select>
                                @elseif($user->hasRole('manager'))
                                    <select class="rounded" name="role" id="roleSelect">
                                        <option value="manager">Manager</option>
                                        <option value="admin">Admin</option>
                                        <option value="member">Member</option>
                                    </select>
                                @elseif($user->hasRole('member'))
                                    <select class="rounded" name="role" id="roleSelect">
                                        <option value="member">Member</option>
                                        <option value="admin">Admin</option>
                                        <option value="manager">Manager</option>
                                    </select>
                                @endif
                                <input type="number" value="{{$user->id}}" class="hidden" name="userId">
                                <input type="submit" class="hidden">
                            </form>

                            @if(!($admincount==1 && $user->hasRole('admin')))
                            <button  onclick="event.preventDefault();
                                document.getElementById('user{{$user->id}}Form').submit();">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-green-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </button>
                            @endif

                            @if(!$user->hasRole('admin'))
                            <button onclick="event.preventDefault();
                                    document.getElementById('user{{$user->id}}DeleteForm').submit();
">                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <form id="user{{$user->id}}DeleteForm" action="deleteUser" method="POST">
                                <input type="number" value="{{$user->id}}" class="hidden" name="userId">
                                @csrf
                            </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-span-2">
                <h2 class="text-3xl subtitle mb-4">Teams</h2>
                @foreach($teams as $team)
                    <div class="bg-white rounded-xl w-100 mx-2 mb-4 px-6 py-2">
                        <div class="flex justify-between">
                            <p class="text-2xl">{{$team->name}}</p>
                            <p class="">{{$team->docent}}</p>
                        </div>
                        <p>{{$team->users->count()}} members</p>
                        <p>{{$team->quests->count()}} quests</p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
