@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')

@endpush 

@section('content')

<div class="clearfix"></div>

<section>
    <form autocomplete="off" method="post" action="{{Route('admin.districts.edit')}}">
        <input name="id" type="hidden" value="{{$district->id}}"/>
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        
        <div class="row">
            <div class="col-md-9 col-sm-9 col-xs-12">
                
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Редактировать район</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        @include('alerts')

                        <div class="clearfix"></div>
                        
                        <div class="form-group">
                            <label class="control-label" for="title">Заголовок</label>
                            <input required="required" name="title" class="form-control" type="text" value="{{$district->title}}"/>
                        </div>
                        
                        <div class="form-group">
                            <label class="control-label" for="title">Город</label>
                            <select class="form-control" name="city_id" required>
                                <option></option>
                                @foreach($cities as $val)
                                    <option @if($district->city_id == $val->id) selected @endif value="{{$val->id}}">{{$val->title}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                
                <br/>
                <br/>
                
                <ul class="list-unstyled">
                    <li>Пустое значение - магазин в этом регионе не работает</li>
                </ul>
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Минимальная сумма заказа для данного района</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        
                        @foreach($shops as $shop)
                            <div class="form-group">
                                <label class="control-label">Минимальная сумма "{{$shop->title}}"</label>
                                <input name="min_price[{{$shop->id}}]" class="form-control" type="number" value="@if(isset($min_price[$shop->id])){{$min_price[$shop->id]->price}}@endif"/>
                            </div>
                        @endforeach

                    </div>
                </div>
                
                <br/>
                <br/>
                
                <ul class="list-unstyled">
                    <li>Пустое значение - бесплатной доставки нет</li>
                </ul>
                <div class="row">
                    <div class="col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Бесплатная доставка от</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                @foreach($shops as $shop)
                                    <div class="form-group">
                                        <label class="control-label">Сумма для бесплатной доставки "{{$shop->title}}"</label>
                                        <input name="free_shipping[{{$shop->id}}]" class="form-control" type="number" value="@if(isset($shipping[$shop->id]->data)){{unserialize($shipping[$shop->id]->data)['free_shipping']['price']}}@endif"/>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Стоимость доставки</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                @foreach($shops as $shop)
                                    <div class="form-group">
                                        <label class="control-label">Стоимость доставки "{{$shop->title}}"</label>
                                        <input name="rate_shipping[{{$shop->id}}]" class="form-control" type="number" value="@if(isset($shipping[$shop->id]->data)){{unserialize($shipping[$shop->id]->data)['rate_shipping']['price']}}@endif"/>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Опубликовать</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-success btn-control">Сохранить</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </form>
</section>



@stop