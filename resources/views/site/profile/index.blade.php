@extends('site/index')

@section('title', 'Профиль')

@section('content')
<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('profile') !!}
</nav>

<section class="m">
    <div class="row custom-row">
        <div class="col-sm-8">
            <div>
                <div class="box p">
                    
                    <div class="m-b">
                        @include('alerts')
                    </div>

                    <form action="{{Route('profile.edit')}}" method="post" enctype="multipart/form-data" class="form-horizontal form-label-left">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">E-mail <span class="text-red">*</span></label>
                            <div class="col-md-7 col-xs-12">
                                <input type="email" name="email" value="{{Auth::user()->email}}" class="form-control" placeholder="E-mail">
                                @if ($errors->has('email'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Имя</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="name" value="{{Auth::user()->name}}" class="form-control" placeholder="Имя">
                                @if ($errors->has('name'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('lastname') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Фамилия</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="lastname" value="{{Auth::user()->lastname}}" class="form-control" placeholder="Фамилия">
                                @if ($errors->has('lastname'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('lastname') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('patronymic') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Отчество</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="patronymic" value="{{Auth::user()->patronymic}}" class="form-control" placeholder="Отчество">
                                @if ($errors->has('patronymic'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('patronymic') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('phone') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Телефон</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="phone" value="{{Auth::user()->phone}}" class="form-control" placeholder="Телефон">
                                @if ($errors->has('phone'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('street') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Улица</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="street" value="{{Auth::user()->street}}" class="form-control" placeholder="Улица">
                                @if ($errors->has('street'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('street') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('home') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Номер дома</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="home" value="{{Auth::user()->home}}" class="form-control" placeholder="Номер дома">
                                @if ($errors->has('home'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('home') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('apartment') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Квартира / офис</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="apartment" value="{{Auth::user()->apartment}}" class="form-control" placeholder="Квартира / офис">
                                @if ($errors->has('apartment'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('apartment') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('floor') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Этаж</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="floor" value="{{Auth::user()->floor}}" class="form-control" placeholder="Этаж">
                                @if ($errors->has('floor'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('floor') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('intercom') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Код домофона</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="intercom" value="{{Auth::user()->intercom}}" class="form-control" placeholder="Код домофона">
                                @if ($errors->has('intercom'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('intercom') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('building') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Корпус, строение</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="building" value="{{Auth::user()->building}}" class="form-control" placeholder="Корпус, строение">
                                @if ($errors->has('building'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('building') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('entrance') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Подъезд</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="text" name="entrance" value="{{Auth::user()->entrance}}" class="form-control" placeholder="Подъезд">
                                @if ($errors->has('entrance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('entrance') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Новый пароль</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="password" name="password" class="form-control" placeholder="Новый пароль">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Повторите пароль</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Повторите пароль"/>
                                @if ($errors->has('password_confirmation'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('image') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Аватарка</label>
                            <div class="col-md-7 col-sm-6 col-xs-12">
                                <input type="file" name="image" accept="image/png, image/jpeg, image/gif" />
                                
                                @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                            
                        </div>

                        <div class="form-group text-right">
                            <div class="col-md-7 col-xs-12 col-md-offset-3">
                                <button type="submit" class="btn btn-orange btn-medium">Сохранить</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="col-sm-4 m-t-sm">
            
            @include('site.profile-menu')
            
        </div>
    </div>
</section>

@stop