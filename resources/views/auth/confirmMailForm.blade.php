@extends('site/index')

@section('content')
<section id="login-page" class="bg-white margin-large-bottom padding-bottom">
    <h4 class="title-section">Подтверждение аккаунта</h4>
    <form class="form-horizontal" role="form" method="POST" action="{{ Route('sendMailConfirm') }}">
        {{ csrf_field() }}
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                <div class="form-group">
                    <div>{!!captcha_img()!!}</div>
                </div>
                <div class="form-group{{ $errors->has('captcha') ? ' has-error' : '' }}">
                    <label for="captcha" class="control-label">Введите указанные симолы </label>
                    <input id="captcha" type="text" class="form-control" name="captcha" value="{{ old('captcha') }}" required autofocus>
                    @if ($errors->has('captcha'))
                    <span class="help-block">
                        <strong>{{ $errors->first('captcha') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-orange">
                        Отправить письмо
                    </button>
                </div>
            </div>
        </div>

    </form>
</section>
@endsection
