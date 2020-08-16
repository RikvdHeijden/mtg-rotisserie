@extends('layout')

@section('content')
    <div class="container">
        <h1>Join draft</h1>

        <form action="{{ url('/draft/join') }}" method="POST">
            @csrf
            <label for="code">Draft ID</label>
            <input type="text" name="code" id="code">

            <label for="password">Draft password</label>
            <input type="password" name="password" id="password">

            <label for="name">Name</label>
            <input type="text" name="name" id="name">

            <button>Join</button>
        </form>
    </div>
@endsection

