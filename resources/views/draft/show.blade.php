@extends('layout')

@section('content')
    <draft config="{{ $config }}" playerdata="{{ $player }}"></draft>
@endsection

