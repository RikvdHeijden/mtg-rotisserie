@extends('layout')

@section('content')
    <div class="container">
        <h1>Join draft</h1>

        <form action="{{ url('/draft/join') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="code">Draft ID</label>
                <input type="text" name="code" id="code" value="{{ $draft_code }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <button class="btn btn-dark">Join</button>
        </form>
    </div>
@endsection

