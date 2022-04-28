@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">Create a new quest</h1>
        <form method="POST" action="{{route('questcreate')}}">
            <label for="name">Quest name</label>
            <input type="text" name="name" id="questName">

            <label for="description">Goal</label>
            <input type="textarea" name="description" id="questDescription">

            <label for="experience">Experience points</label>
            <input type="number" name="experience" id="number">

            <input type="number" name="teamId" value="{{$teamId}}" class="hidden">
            @csrf
            <input type="submit">
        </form>

    </div>
@endsection
