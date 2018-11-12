@extends('site/index')

@section('content')

<nav class="box box-control m-b-0">
    {!! Breadcrumbs::render('current-orders') !!}
</nav>

<section id="orders">
    <div class="row custom-row">
        <div class="col-md-8">
            <div>
                <div class="box-control m-r-0">

                    <div class="panel panel-default box">
                        <div class="panel-heading">Заказ	№	495823	от	25.03.2017 14:01:13, 1	товар	на сумму <b>10 009 Тг</b></div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="w-100 table">
                                    <thead>
                                        <tr>
                                            <td>Наименование</td>
                                            <td>Количество</td>
                                            <td>Цена</td>
                                            <td>Сумма</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <a href="#" class="link">Товар</a>
                                            </td>
                                            <td>10 шт</td>
                                            <td>840 ₸</td>
                                            <td>8 400 ₸</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="link">Товар</a>
                                            </td>
                                            <td>10 шт</td>
                                            <td>840 ₸</td>
                                            <td>8 400 ₸</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <a href="#" class="link">Товар</a>
                                            </td>
                                            <td>10 шт</td>
                                            <td>840 ₸</td>
                                            <td>8 400 ₸</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="row">
                                <div class="col-md-6 col-xs-12">
                                    <a href="{{Route('current-order')}}" class="btn btn-orange btn-medium">Детали заказа</a>
                                </div>
                                <div class="col-md-6 col-xs-12">
                                    <div class="text-right m-sm-t">
                                        <span class="text-yellow">Ожидает доставки</span> - 26.03.2017 12:02:27
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    

                </div>
            </div>
        </div>
        <div class="col-md-4">

            @include('site.profile-menu')

        </div>
    </div>
</section>

@stop