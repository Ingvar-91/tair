@extends('site/index')

@push('css')
@endpush 

@push('scripts')
@endpush

@section('title', 'Профиль пользователя')

@section('content')
<div class="row">
    <div class="col-3">
        @include('/site/account-menu')
    </div>
    <div class="col-9">
        
        
    <div class="padding-left padding-right">
        @include('alerts')
    </div>

    <form action="{{Route('profile.edit')}}" method="post" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row padding-top">
            <div class="col-md-6 col-md-offset-3">
                
                
                <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                    <label>E-mail</label>
                    <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" placeholder="E-mail">
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                    <label class="control-label">Имя</label>
                    <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control" placeholder="Имя">
                    @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                    <label class="control-label">Фамилия</label>
                    <input type="text" name="lastname" value="{{Auth::user()->lastname}}" class="form-control" placeholder="Фамилия">
                    @if ($errors->has('lastname'))
                    <span class="help-block">
                        <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('patronymic') ? 'has-error' : '' }}">
                    <label class="control-label">Отчество</label>
                    <input type="text" name="patronymic" value="{{Auth::user()->patronymic}}" class="form-control" placeholder="Отчество">
                    @if ($errors->has('patronymic'))
                    <span class="help-block">
                        <strong>{{ $errors->first('patronymic') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                    <label class="control-label">Телефон</label>
                    <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control" placeholder="Телефон">
                    @if ($errors->has('phone'))
                    <span class="help-block">
                        <strong>{{ $errors->first('phone') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('address') ? 'has-error' : '' }}">
                    <label class="control-label">Адрес</label>
                    <input type="text" name="address" value="{{Auth::user()->address}}" class="form-control" placeholder="Адрес">
                    @if ($errors->has('address'))
                    <span class="help-block">
                        <strong>{{ $errors->first('address') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <label class="control-label">Новый пароль</label>
                    <input type="password" name="password" class="form-control" placeholder="Новый пароль">
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('confirm_password') ? 'has-error' : '' }}">
                    <label class="control-label">Повторите пароль</label>
                    <input type="password" name="confirm_password" class="form-control" placeholder="Повторите пароль">
                    @if ($errors->has('confirm_password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('confirm_password') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group {{ $errors->has('image') ? 'has-error' : '' }}">
                    <label class="control-label display-block">Аватарка</label>
                    <input name="image" id="profile-avatar" type="file" accept="image/png, image/jpeg, image/gif">
                    @if(Helper::getImg(Auth::user()->image, 'avatars'))
                    <div class="img">
                        <img src="{{Helper::getImg(Auth::user()->image, 'avatars')}}" alt="" class="img-thumbnail" style="max-width: 200px;"/>
                    </div>
                    @else
                    <div class="icon-avatar">
                        <img src="/img/no-image-1x1.jpg" alt="" class="img-thumbnail" style="max-width: 200px;"/>
                    </div>
                    @endif
                    
                    @if ($errors->has('image'))
                    <span class="help-block">
                        <strong>{{ $errors->first('image') }}</strong>
                    </span>
                    @endif
                </div>
                
                <div class="form-group text-right">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </div>
        </div>

    </form>
        
    </div>
</div>
@stop