@extends('site/index')

@section('content')
<section class="box box-control">
    {!! Breadcrumbs::render('reset.password.form') !!}
</section>

<section id="login-page" class="box box-control">
    <h2 class="text-center m-sm-t m-lg-b">Назначить новый пароль</h2>
    <hr class="w-25"/>
    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
        {{ csrf_field() }}
        <input type="hidden" name="token" value="{{ $token }}">
        
        @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
        @endif
        
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="col-md-4 control-label">E-mail</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password" class="col-md-4 control-label">Новый пароль</label>

                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control" name="password" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password-confirm" class="col-md-4 control-label">Повторите пароль</label>
                    <div class="col-md-6">
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                </div>

                <div class="form-group text-right">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-orange btn-medium">Сохранить новый пароль</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
