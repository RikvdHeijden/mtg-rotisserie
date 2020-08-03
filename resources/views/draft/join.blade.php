@extends('layout')

@section('content')
    <div class="container">
        <h1>Join draft</h1>

        <form action="{{ url('/draft/join') }}" method="POST">
            @csrf
            <label for="code">Draft ID</label>
            <input type="text" name="code" id="code">

            <label for="name">Name</label>
            <input type="text" name="name" id="name">

            <label for="set">Set</label>
            <select name="set" id="set">
                <option value="">I'm joining an existing draft</option>
                @foreach($sets as $set)
                    <option value="{{ $set->id }}">{{ $set->name }}</option>
                @endforeach
            </select>

            <button>Join</button>
        </form>
    </div>
@endsection

