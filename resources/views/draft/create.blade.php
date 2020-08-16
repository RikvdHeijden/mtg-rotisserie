@extends('layout')

@section('content')
    <div class="container">
        <h1>Join draft</h1>

        <form action="{{ url('/draft/store') }}" method="POST">
            @csrf
            <label for="password">Draft password</label>
            <input type="password" name="password" id="password">

            <label for="name">Name</label>
            <input type="text" name="name" id="name">

            <label for="set">Set</label>
            <select name="set" id="set">
                @foreach($sets as $set)
                    <option value="{{ $set->id }}">{{ $set->name }}</option>
                @endforeach
            </select>

            <button>Create</button>
        </form>
    </div>
@endsection

