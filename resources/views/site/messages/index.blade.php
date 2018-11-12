@extends('site/index')

@section('content')

<div class="box box-control p">
    @if (session('message-success'))
    <div class="alert alert-success m-0">
        <div class="text-center">
            <span class="p-s-r">
                <i class="fa fa-check fa-2x" aria-hidden="true"></i>
            </span>
            <span class="h3">
                {!! session('message-success') !!}
            </span>
        </div>
    </div>
    @endif
    
    @if (session('message-error'))
    <div class="alert alert-danger m-0">
        <div class="text-center">
            <span class="p-s-r">
                <i class="fa fa-close fa-2x" aria-hidden="true"></i>
            </span>
            <span class="h3">
                {!! session('message-error') !!}
            </span>
        </div>
    </div>
    @endif
    
    @if (session('message-warning'))
    <div class="alert alert-warning m-0">
        <div class="text-center">
            <span class="p-s-r">
                <i class="fa fa-warning fa-2x" aria-hidden="true"></i>
            </span>
            <span class="h3">
                {!! session('message-warning') !!}
            </span>
        </div>
    </div>
    @endif
</div>

@stop