@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">Create a new quest</h1>
        <form method="POST" action="{{route('questcreate')}}" class="flex flex-col w-1/2 mx-auto">
            <label for="name" class="mb-2">Quest name</label>
            <input type="text" name="name" id="questName" class="mb-4">

            <label for="description" class="mb-2">Goal</label>
            <input type="textarea" name="description" id="questDescription" class="h-52 mb-4">

            <label for="experience" class="mb-2">Experience points</label>
            <input type="number" name="experience" id="number" class="mb-4">

            <input type="number" name="teamId" value="{{$teamId}}" class="hidden">
            @csrf
            <input type="submit">
        </form>

    </div>
@endsection
