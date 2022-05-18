@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        @can('create quests')
            <button class="btn btn-white mb-8"><a href="{{route('newquest',[$team->id])}}">Add quest</a></button>
        @endcan
        @can('add students to teams')
            <button class="btn btn-white mb-8"><a href="{{route('teammembers',[$team->id])}}">Add members</a></button>
        @endcan
        @can('verify achievements')
            <button class="btn btn-white mb-8"><a href="{{route('teamprogress',[$team->id])}}">Check progress</a></button>
        @endcan
        <div class="teamContainer grid grid-cols-3 gap-4">
            <div class="questContainer col-span-2">
                <p class="text-3xl font-light mb-4">Quests</p>
                @for($i=1; $i<=$maxModule;$i++)
                    <p class="text-2xl font-light mb-2 mt-4">Module {{$i}}</p>
                    @if(count($team->quests->where('module',$i)) > 0)
                    @foreach($team->quests->where('module',$i) as $quest)
                        <div class=" relative questTile mb-8 rounded-xl p-6 border-solid border-gray-400 shadow mx-4">
                            <h2 class="text-xl mb-4">{{$quest->name}}</h2>
                            @can('edit team')
                                <div class="absolute top-10 right-10">
                                    <button>
                                        <a href="{{route('editQuestForm',[$team->id,$quest->id])}}">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-green-500 h-5 w-5" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                                <path d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z"/>
                                            </svg>
                                        </a>
                                    </button>
                                    <button onclick="event.preventDefault();
                                        document.getElementById('quest{{$quest->id}}DeleteForm').submit();">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                    <form id="quest{{$quest->id}}DeleteForm" action="deleteQuest" method="POST">
                                        <input type="number" value="{{$quest->id}}" class="hidden" name="questId">
                                        @csrf
                                    </form>
                                </div>
                            @endcan
                            <p>{{$quest->description}}</p>
                            <p>{{$quest->experience}} XP</p>
                            @can('achieve quest')
                            @if($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'not completed')
                                <button class="btn btn-white mt-6 hover:text-red-800 hover:border-red-800 active:fill-red-800" onclick="
                                    event.preventDefault();
                                    document.getElementById('questBtn{{$quest->id}}').submit();">Mark as completed</button>
                                <form method="POST" action="{{route('markStudentQuestPending')}}" id="questBtn{{$quest->id}}" class="hidden">
                                    <input type="number" name="questId" value="{{$quest->id}}">
                                    <input type="number" name="userId" value="{{auth()->user()->id}}">
                                    @csrf
                                </form>
                            @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'pending')
                                <button class="btn btn-white mt-6 disabled hover:text-orange-500 hover:border-orange-500">Pending</button>
                            @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'completed')
                                <button class="btn btn-white completedBtn mt-6 disabled hover:text-green-500 hover:border-green-500">Completed</button>
                            @endif
                            @endcan
                        </div>
                    @endforeach
                    @else
                        <p class="mx-4">No quests for this module yet!</p>
                    @endif
                @endfor
                <p class="text-2xl font-light mb-2 mt-4">Quests without module</p>
                @foreach($team->quests->whereNull('module') as $quest)
                    <div class=" relative questTile mb-8 rounded-xl p-6 border-solid border-gray-400 shadow mx-4">
                        <h2 class="text-xl mb-4">{{$quest->name}}</h2>
                        @can('edit team')
                            <div class="absolute top-10 right-10">
                                <button>
                                    <a href="{{route('editQuestForm',[$team->id,$quest->id])}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-green-500 h-5 w-5" viewBox="0 0 512 512"><!--! Font Awesome Pro 6.1.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2022 Fonticons, Inc. -->
                                            <path d="M362.7 19.32C387.7-5.678 428.3-5.678 453.3 19.32L492.7 58.75C517.7 83.74 517.7 124.3 492.7 149.3L444.3 197.7L314.3 67.72L362.7 19.32zM421.7 220.3L188.5 453.4C178.1 463.8 165.2 471.5 151.1 475.6L30.77 511C22.35 513.5 13.24 511.2 7.03 504.1C.8198 498.8-1.502 489.7 .976 481.2L36.37 360.9C40.53 346.8 48.16 333.9 58.57 323.5L291.7 90.34L421.7 220.3z"/>
                                        </svg>
                                    </a>
                                </button>


                                <button onclick="event.preventDefault();
                                    document.getElementById('quest{{$quest->id}}DeleteForm').submit();">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="fill-black hover:fill-red-500 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <form id="quest{{$quest->id}}DeleteForm" action="deleteQuest" method="POST">
                                    <input type="number" value="{{$quest->id}}" class="hidden" name="questId">
                                    @csrf
                                </form>
                            </div>
                        @endcan
                        <p>{{$quest->description}}</p>
                        <p>{{$quest->experience}} XP</p>
                        @can('achieve quest')
                            @if($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'not completed')
                                <button class="btn btn-white mt-6 hover:text-red-800 hover:border-red-800 active:fill-red-800 active:text-white" onclick="
                                    event.preventDefault();
                                    document.getElementById('questBtn{{$quest->id}}').submit();">Mark as completed</button>
                                <form method="POST" action="{{route('markStudentQuestPending')}}" id="questBtn{{$quest->id}}" class="hidden">
                                    <input type="number" name="questId" value="{{$quest->id}}">
                                    <input type="number" name="userId" value="{{auth()->user()->id}}">
                                    @csrf
                                </form>
                            @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'pending')
                                <button class="btn btn-white mt-6 disabled hover:text-orange-500 hover:border-orange-500">Pending</button>
                            @elseif($quest->achievements->where('user_id',auth()->user()->id)->first()->status == 'completed')
                                <button class="btn btn-white completedBtn mt-6 disabled hover:text-green-500 hover:border-green-500">Completed</button>
                            @endif
                        @endcan
                    </div>
                @endforeach
            </div>
            <div class="membersContainer">
                <p class="text-3xl font-light mb-4">Team leaderboard</p>
                @foreach($team->users->sortByDesc('experience') as $user)
                        @if(!is_null($user->experience))
                        <div class="mb-4 mx-2 rounded flex justify-between">
                            <p>{{$user->name}}</p>
                            <p>{{$user->experience}} XP</p>
                        </div>
                        @endif
                @endforeach
            </div>
        </div>

    </div>
@endsection
