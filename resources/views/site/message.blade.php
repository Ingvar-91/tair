@extends('site/index')

@section('content')
@if (session('message-error'))
    <div class="alert alert-danger">
        {{ session('message-error') }}
    </div>
@endif

@if (session('message-success'))
    <div class="alert alert-success">
        {{ session('message-success') }}
    </div>
@endif

@if (session('message-warning'))
    <div class="alert alert-warning">
        {{ session('message-warning') }}
    </div>
@endif
@stop