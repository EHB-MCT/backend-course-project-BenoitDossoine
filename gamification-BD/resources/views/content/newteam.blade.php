@extends('layouts.master')

@section('content')
    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h1 class="text-xl">Create a new team</h1>
        <form method="POST" action="{{route('teamcreate')}}" class="flex flex-col w-1/2 mx-auto">
            <label for="name" class="mt-4">Your team's name</label>
            <input type="text" name="name" id="name">

            <label for="description" class="mt-4">What is it about?</label>
            <input type="textarea" name="description" id="description" class="h-52">

            @csrf
            <input type="submit" class="w-1/4 mt-6 btn btn-green self-end">
        </form>

    </div>
@endsection
