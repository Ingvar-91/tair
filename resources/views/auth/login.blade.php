@extends('site/index')

@push('css')
@endpush 

@push('scripts')
@endpush

@section('title', 'Форма входа')

@section('content')
<section class="box box-control">
    {!! Breadcrumbs::render('login') !!}
</section>

<section id="login-page" class="box box-control p">
    <form role="form" method="POST" action="{{ url('login') }}">
        {{ csrf_field() }}
        <h2 class="text-center m-sm-t m-lg-b">Форма входа</h2>
        <hr class="w-25"/>
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email">E-mail *</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Пароль *</label>
                    <input type="password" name="password" class="form-control" id="password" placeholder="Пароль">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <div class="checkbox">
                        <label><input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить? </label>
                        <a class="float-right link" href="{{ url('/password/reset') }}">Забыли пароль?</a>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-orange btn-medium">Войти</button>
                </div>
            </div>
        </div>

    </form>
</section>
@endsection
