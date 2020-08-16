@extends('layout')

@section('content')
    <div class="container">
        <h1>Create a new draft</h1>

        <form action="{{ url('/draft/store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="set">Set to draft</label>
                <select name="set" id="set" class="form-control">
                    @foreach($sets as $set)
                        <option value="{{ $set->id }}">{{ $set->name }}</option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-dark">Create</button>
        </form>
    </div>
@endsection

