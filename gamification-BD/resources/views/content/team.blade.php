@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        @can('create quests')
            <button class="btn btn-white mb-4"><a href="{{route('newquest',[$team->id])}}">Add quest</a></button>
        @endcan
        @can('add students to teams')
            <button class="btn btn-white mb-4"><a href="{{route('teammembers',[$team->id])}}">Add members</a></button>
        @endcan
        @can('verify achievements')
            <button class="btn btn-white mb-4"><a href="{{route('teamprogress',[$team->id])}}">Check progress</a></button>
        @endcan
        <div class="teamContainer grid grid-cols-3 gap-4">
            <div class="questContainer col-span-2">
                <p class="text-3xl font-light mb-4">Quests</p>
                @foreach($team->quests as $quest)
                    <div class=" relative questTile mb-8 rounded-xl p-6 border-solid border-gray-400 shadow">
                        <h2 class="text-xl mb-4">{{$quest->name}}</h2>
                        @can('edit team')
                            <button onclick="event.preventDefault();
                                document.getElementById('quest{{$quest->id}}DeleteForm').submit();"
                            class="absolute top-10 right-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <form id="quest{{$quest->id}}DeleteForm" action="deleteQuest" method="POST">
                                <input type="number" value="{{$quest->id}}" class="hidden" name="questId">
                                @csrf
                            </form>
                        @endcan
                        <p>{{$quest->description}}</p>
                        <p>{{$quest->experience}} XP</p>
                        @can('achieve quest')
                        @if($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'not completed')
                            <button class="btn btn-green mt-6" onclick="
                                event.preventDefault();
                                document.getElementById('questBtn{{$quest->id}}').submit();">Mark as completed</button>
                            <form method="POST" action="{{route('markStudentQuestPending')}}" id="questBtn{{$quest->id}}" class="hidden">
                                <input type="number" name="questId" value="{{$quest->id}}">
                                <input type="number" name="userId" value="{{auth()->user()->id}}">
                                @csrf
                            </form>
                        @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'pending')
                            <button class="btn btn-orange mt-6 disabled">Pending</button>
                        @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'completed')
                            <button class="btn btn-white completedBtn mt-6 disabled">Completed</button>
                        @endif
                        @endcan
                    </div>
                @endforeach
            </div>
            <div class="membersContainer">
                <p class="text-3xl font-light mb-4">Team leaderboard</p>
                @foreach($team->users->sortByDesc('experience') as $user)
                        <div class="mb-4 rounded flex justify-between">
                            <p>{{$user->name}}</p>
                            <p>{{$user->experience}} XP</p>
                        </div>
                @endforeach
            </div>
        </div>

    </div>
@endsection
