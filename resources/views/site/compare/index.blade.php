@extends('site/index')

@push('css')

@endpush 

@push('scripts')
<script src="/js/site/products.js"></script>
@endpush

@section('content')

<nav class="box box-control">
    {!! Breadcrumbs::render('compare') !!}
</nav>

<section id="compare" class="bg-white margin-large-bottom">
    <h4 class="title-section">Сравнение товаров</h4>
    <div class="padding-left padding-right padding-bottom padding-small-top">
        <!-- Nav tabs -->
        <div class="nav-tabs-scroll">
            <ul class="nav nav-tabs" role="tablist">
                
                @if(empty($products) == false)
                    @foreach($products as $key => $val)
                        <li role="presentation" class="@if($loop->first) active @endif">
                            <a href="#tab-{{$key}}" aria-controls="#tab-{{$key}}" role="tab" data-toggle="tab">{{$val['category_name']}}</a>
                        </li>
                    @endforeach
                @endif
                
            </ul>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">
            
            @if(empty($products) == false)
                @foreach($products as $key => $val)
                
                    <div role="tabpanel" class="tab-pane @if($loop->first) active @endif" id="tab-{{$key}}">
                        <div class="table-responsive">
                            <table class="table-compare table-striped">
                                <tbody>
                                    @if(empty($val['info']) == false)
                                        <tr>
                                            <td>Изображение</td>
                                            @foreach($val['info'] as $info)
                                                <td class="char">
                                                    <div class="img-product">
                                                        @if($info['images'])
                                                            <img src="{{Helper::getFirstImg($info['images'])}}" alt="" class="img-responsive"/>
                                                        @else
                                                            <img src="/img/no-image-1x1.jpg" alt="" class="img-responsive"/>
                                                        @endif
                                                    </div>
                                                    <div class="icon-remove remove-compare" data-id="{{$info['product_id']}}">
                                                        <i class="fa fa-times" aria-hidden="true"></i>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    
                                    @if(empty($val['info']) == false)
                                        <tr>
                                            <td>Наименование</td>
                                            @foreach($val['info'] as $info)
                                                <td class="char">
                                                    <div class="name-product">
                                                        <a href="{{Route('product', ['product_id' => $info['product_id'], 'category_id' => $info['category_id']])}}">{{$info['title']}}</a>
                                                    </div>
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    
                                    @if(empty($val['price']) == false)
                                        <tr>
                                            <td>Цена</td>
                                            @foreach($val['price'] as $price)
                                                <td class="char">
                                                    @if($price['discount'])
                                                        <strike class="price">{{number_format($price['price'], 0, '', ' ')}} руб.</strike>
                                                        <span class="sale">{{number_format($price['discount'], 0, '', ' ')}} руб.</span>
                                                    @else
                                                        @if($price['price'])
                                                            <span class="price">{{number_format($price['price'], 0, '', ' ')}} руб.</span>
                                                        @endif
                                                    @endif
                                                </td>
                                            @endforeach
                                        </tr>
                                    @endif
                                    
                                    
                                    @if(empty($val['chars']) == false)
                                        @foreach($val['chars'] as $char)
                                        <tr>  
                                            <td>{{$char['name_char']}}</td>
                                            @foreach($char['value_chars'] as $valChar) 
                                            <td class="char">{{$valChar}}</td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            @else
            <h3 class="text-center">Нет товаров для сравнения</h3>
            @endif
            
        </div>
    </div>
</section>
@stop