@extends('site/index')

@section('content')

<!--{!! Breadcrumbs::render('register') !!}-->


<section id="login-page" class="bg-white margin-large-bottom padding-bottom">
    <h4 class="title-section">Регистрация</h4>
    <form role="form" method="POST" action="{{ url('register') }}" autocomplete="off" enctype="multipart/form-data">
        {{ csrf_field() }}
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label for="email">E-mail *</label>
                    <input type="email" name="email" class="form-control" id="email" placeholder="E-mail" required value="{{ old('email') }}">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                    <label for="password">Пароль *</label>
                    <input type="password" name="password" class="form-control" required placeholder="Пароль" value="{{ old('password') }}">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                    <label for="password">Повторите пароль *</label>
                    <input type="password" name="password_confirmation" class="form-control" required placeholder="Пароль" value="{{ old('password_confirmation') }}">
                    @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                    @endif
                </div>

                <hr/>
                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label for="email">Имя</label>
                    <input type="text" name="name" class="form-control" placeholder="Имя" value="{{ old('name') }}">
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    <label for="email">Фамилия</label>
                    <input type="text" name="lastname" class="form-control" placeholder="Фамилия" value="{{ old('lastname') }}">
                    @if ($errors->has('lastname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('patronymic') ? 'has-error' : '' }}">
                    <label for="email">Отчество</label>
                    <input type="text" name="patronymic" class="form-control"placeholder="Отчество" value="{{ old('patronymic') }}">
                    @if ($errors->has('patronymic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('patronymic') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label for="email">Ваш адресс</label>
                    <input type="text" name="address" class="form-control" placeholder="Ваш адресс" value="{{ old('address') }}">
                    @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label for="email">Основной телефон</label>
                    <input type="text" name="phone" class="form-control" placeholder="Основной телефон" value="{{ old('phone') }}">
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="control-label display-block">Аватарка</label>
                    <input name="image" id="profile-avatar" type="file" accept="image/png, image/jpeg, image/gif">
                    @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-orange">Регистрация</button>
                </div>
            </div>
        </div>

    </form>
</section>

@endsection