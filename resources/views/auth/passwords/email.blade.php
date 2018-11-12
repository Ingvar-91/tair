@extends('site/index')

<!-- Main Content -->
@section('content')
<section class="box box-control">
    {!! Breadcrumbs::render('reset.email.form') !!}
</section>

<section id="login-page" class="box box-control">
    <h2 class="text-center m-sm-t m-lg-b">Восстановление пароля</h2>
    <hr class="w-25"/>
    <form class="form-horizontal" role="form" method="POST" action="{{ Route('password.reset') }}">
        {{ csrf_field() }}
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                    <label for="email" class="control-label">E-Mail</label>

                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>

                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>

                <div class="form-group text-right">
                    <button type="submit" class="btn btn-orange btn-medium">Отправить инструкцию на почту</button>
                </div>
            </div>
        </div>
    </form>
</section>


@endsection
