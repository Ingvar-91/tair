@extends('admin/index') 

@push('css')

@endpush 

@push('scripts')
@endpush 

@section('content')

<div class="clearfix"></div>

<section id="edit-user">
    <form class="form-horizontal form-label-left" enctype="multipart/form-data" method="post" action="{{Route('admin.filter.edit', ['shop_type' => request()->shop_type])}}">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="x_panel">
            <div class="x_title">
                <h2>Назначить фильтр</h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                
                @include('alerts')
                
                @if(count($characteristicsName))
                    <div class="form-group">
                    @foreach($characteristicsName as $val)
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="characteristics_name[]" value="{{$val->id}}" @if($val->check) checked @endif /> {{$val->name}}
                            </label>
                        </div>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Сохранить</button>
                    </div>
                @else
                    <h4>Характеристики отсутствуют</h4>
                @endif
                
                
            </div>
        </div>
    </form>
</section>

@stop