@extends('site/index')

@section('title', 'Регистрация')

@section('content')
<section class="box box-control">
    {!! Breadcrumbs::render('register') !!}
</section>

<section id="register-page" class="box box-control p">
    <h2 class="text-center m-sm-t m-lg-b">Регистрация</h2>
    <hr class="w-25"/>
    <form role="form" method="POST" action="{{ url('register') }}" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-mail <span class="color-red">*</span></label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required value="{{ old('email') }}">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Пароль <span class="color-red">*</span></label>
                    <input type="password" name="password" class="form-control" required placeholder="Пароль" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password">Повторите пароль <span class="color-red">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Пароль" value="{{ old('password_confirmation') }}">
                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group text-right m-lg-t">
                    <button type="submit" class="btn btn-orange btn-medium">Регистрация</button>
                </div>
            </div>
        </div>

    </form>
</section>

@endsection