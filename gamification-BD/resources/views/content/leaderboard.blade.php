@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">Hall of Fame</h2>
        <div class="container grid grid-cols-3 gap-4">
            <div class="leaderboardContainer col-span-2">
                <h2 class="text-3xl subtitle mb-4">Leaderboard</h2>
                <div class="grid grid-cols-1 gap-y-5 grid-flow-row-dense">
                @foreach($users as $user)
                    @if(!is_null($user->experience))
                            <div class="grid grid-cols-4 width-100 justify-between px-6 py-2 mx-4 bg-white rounded h-12 items-center">
                                <p class="col-span-2">{{$user->name}}</p>
                                <p class="text-right">{{$user->achievements->where('status','completed')->count()}} quests</p>
                                <p class="text-right">{{$user->experience}} points</p>
                            </div>
                    @endif
                @endforeach
                </div>
            </div>
            <div class="col-span-1">
                <h2 class="text-3xl subtitle mb-4">Your statistics</h2>
                <div class="grid grid-cols-1 gap-y-5 grid-flow-row-dense">
                    <div class="grid grid-cols-2 width-100 justify-between px-6 mx-4 py-2 bg-white rounded h-12 items-center">
                        <p class="">Number of teams</p>
                        <p class="text-right">{{\Illuminate\Support\Facades\Auth::user()->teams->count()}}</p>
                    </div>
                    @if(Auth::user()->hasRole('member'))
                    <div class="grid grid-cols-2 width-100 justify-between px-6 mx-4 bg-white rounded h-12 items-center">
                        <p class="">Quests achieved</p>
                        <p class="text-right">{{\Illuminate\Support\Facades\Auth::user()->achievements->where('status','completed')->count()}}</p>
                    </div>
                    <div class="grid grid-cols-2 width-100 justify-between px-6 mx-4 bg-white rounded h-12 items-center">
                        <p class="">Quests pending</p>
                        <p class="text-right">{{\Illuminate\Support\Facades\Auth::user()->achievements->where('status','pending')->count()}}</p>
                    </div>
                    <div class="grid grid-cols-2 width-100 justify-between px-6 mx-4 bg-white rounded h-12 items-center">
                        <p class="">Quests to complete</p>
                        <p class="text-right">{{\Illuminate\Support\Facades\Auth::user()->achievements->where('status','not completed')->count()}}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
