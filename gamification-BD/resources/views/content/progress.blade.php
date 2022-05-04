@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        <div class="progressContainer grid grid-cols-3 gap-4">
            <div class="questsProgressContainer col-span-2">
                <p class="text-3xl font-light mb-4">Quest progress</p>
                @foreach($team->quests as $quest)
                    <div class="questProgressContainer rounded-xl mb-4">
                        <h2 class="text-xl mb-2">{{$quest->name}}</h2>
                        @foreach($quest->achievements as $achievement)
                            @if($achievement->status == 'pending')
                                <div class="userProgressContainer flex flex-row justify-between px-4">
                                    <p>{{$achievement->user->name}}</p>
                                    <div>
                                        <button class="border border-black rounded p-2 hover:stroke-green-700"
                                        onclick="event.preventDefault();
                                        document.getElementById('achievement{{$achievement->id}}StatusInput').value='completed';
                                        document.getElementById('achievement{{$achievement->id}}Form').submit();">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                        <button class="border border-black rounded p-2 hover:stroke-red-700"
                                                onclick="event.preventDefault();
                                                    document.getElementById('achievement{{$achievement->id}}StatusInput').value='not completed';
                                                    document.getElementById('achievement{{$achievement->id}}Form').submit();">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                        </button>
                                    </div>
                                    <form action="updateAchievement" class="hidden" method="POST" id="achievement{{$achievement->id}}Form">
                                        @csrf
                                        <input type="number" name="achievementId" value="{{$achievement->id}}">
                                        <input type="text" id="achievement{{$achievement->id}}StatusInput" name="achievementStatus" value="pending">
                                    </form>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="statisticsContainer col-span-1">
                <p class="text-3xl font-light mb-4">Quest statistics</p>
            </div>
        </div>
    </div>
@endsection
