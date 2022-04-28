@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">Create a new team</h1>
        <form method="POST" action="{{route('teamcreate')}}">
            <label for="name">Your team's name</label>
            <input type="text" name="name" id="name">

            <label for="description">What is it about?</label>
            <input type="textarea" name="description" id="description">

            @csrf
            <input type="submit">
        </form>

    </div>
@endsection
