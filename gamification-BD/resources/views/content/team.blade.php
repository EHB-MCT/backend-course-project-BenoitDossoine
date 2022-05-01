@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h2 class="text-center uppercase text-6xl font-extralight">{{$team->name}}</h2>
        @can('create quests')
        <button class="btn btn-blue mb-4"><a href="{{route('newquest',[$team->id])}}">Add quest</a></button>
        @endcan
        @can('add students to teams')
        <button class="btn btn-blue mb-4"><a href="">Add members</a></button>
        @endcan
        <div class="teamContainer grid grid-cols-3 gap-4">
            <div class="questContainer col-span-2">
                <p class="text-3xl font-light mb-4">Quests</p>
                @foreach($team->quests as $quest)
                    <div class="questTile mb-8 rounded-xl p-6 border-solid border-gray-400 shadow">
                        <h2 class="text-xl mb-4">{{$quest->name}}</h2>
                        <p>{{$quest->description}}</p>
                        <p>{{$quest->experience}}</p>
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
                        @endif
                        @endcan
                    </div>
                @endforeach
            </div>
            <div class="membersContainer">
                <p class="text-3xl font-light mb-4">Members</p>
                @foreach($team->users as $user)
                        <div class="mb-4 rounded">
                            <p>{{$user->name}}</p>
                        </div>

                @endforeach
            </div>
        </div>

    </div>
@endsection
