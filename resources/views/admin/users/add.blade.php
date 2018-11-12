@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')
<!-- users -->
<script src="/js/admin/users.js"></script>
@endpush 

@section('content')
<div class="clearfix"></div>
{!! Breadcrumbs::render('admin.users.add.form') !!}

<section id="add-user">
    <form class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{Route('admin.users.add')}}">
        {{ csrf_field() }}
        <div class="row">
            <div class="col-md-8 col-xs-12">
                <div class="x_panel">
                    
                    @include('alerts')
                    
                    <div class="x_title">
                        <h2>Данные пользователя</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        <input name="id" type="hidden" value="@if (isset($user->id)) {{$user->id}} @endif"/>

                        <div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">E-mail <span class="text-red">*</span></label>
                            <div class="col-md-7 col-xs-12">
                                <input type="email" name="email" class="form-control" required value="{{old('email')}}" placeholder="E-mail">
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
                                <input type="text" name="name" class="form-control" value="{{old('name')}}" placeholder="Имя">
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
                                <input type="text" name="lastname" class="form-control" value="{{old('lastname')}}" placeholder="Фамилия">
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
                                <input type="text" name="patronymic" class="form-control" value="{{old('patronymic')}}" placeholder="Отчество">
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
                                <input type="text" name="phone" class="form-control" value="{{old('phone')}}" placeholder="Телефон">
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
                                <input type="text" name="street" class="form-control" value="{{old('street')}}" placeholder="Улица">
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
                                <input type="text" name="home" class="form-control" value="{{old('home')}}" placeholder="Номер дома">
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
                                <input type="text" name="apartment" class="form-control" value="{{old('apartment')}}" placeholder="Квартира / офис">
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
                                <input type="text" name="floor" class="form-control" value="{{old('floor')}}" placeholder="Этаж">
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
                                <input type="text" name="intercom" class="form-control" value="{{old('intercom')}}" placeholder="Код домофона">
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
                                <input type="text" name="building" class="form-control" value="{{old('building')}}" placeholder="Корпус, строение">
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
                                <input type="text" name="entrance" class="form-control" value="{{old('entrance')}}" placeholder="Подъезд">
                                @if ($errors->has('entrance'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('entrance') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Пароль *</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="password" name="password" class="form-control" value="{{old('password')}}" required placeholder="Новый пароль">
                                @if ($errors->has('password'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
                            <label class="control-label col-md-3 col-xs-12">Повторите пароль *</label>
                            <div class="col-md-7 col-xs-12">
                                <input type="password" name="password_confirmation" class="form-control" value="{{old('password_confirmation')}}" required placeholder="Повторите пароль">
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
                                <input name="image" id="avatar" type="file" class="form-control" accept="image/png, image/jpeg, image/gif">
                                @if ($errors->has('image'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group {{ $errors->has('role') ? ' has-error' : '' }}">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Роль пользователя *</label>
                            <div class="col-md-7 col-sm-7 col-xs-12">
                                <select required autocomplete="off" name="role" class="form-control col-md-7 col-xs-12" title="Выберите роль пользователя">
                                    <option value="1">Зарегистрированный пользователь</option>
                                    <option value="3">Арендатор</option>

                                    @if(Auth::user()->role == 6)
                                        <option value="5">Администратор</option>
                                    @endif
                                </select>
                                @if ($errors->has('role'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('role') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>

                        <div class="ln_solid"></div>
                        
                        <div class="form-group">
                            <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                <button class="btn btn-primary" type="submit">Создать</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            
            <div class="col-md-4 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Назначить магазины</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        @if(count($shops))
                            @foreach($shops as $val)
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="users_shops[]" value="{{$val->id}}"> {{$val->title}}
                                    </label>
                                </div>
                            @endforeach
                        @else
                            <h4>Магазины отсутствуют</h4>
                        @endif
                        
                    </div>
                </div>
            </div>
            
        </div>
        
    </form>
</section>

@stop