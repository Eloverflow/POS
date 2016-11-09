@extends('master')

@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('item.detailsItem') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('items') }}"> {{ @Lang::get('item.backToItem') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="item" >Name</label>
                            <p>{{ $items->name }}</p>
                            <label for="item" >Description</label>
                            <p>{{ $items->description }}</p>

                            <label for="item" >Custom Fields</label>
                            <?php $fields = json_decode($items->custom_fields_array); $field_names = explode(',',$items->itemtype->field_names)?>
                            @for($i = 0; $i < count($field_names); $i++)
                                <p>{{ $field_names[$i] }} : {{ $fields[$i] }}</p>
                            @endfor

                            <label for="item" >Size prices</label>
                            <?php $sizes_price = json_decode($items->size_prices_array); $size_names = explode(',',$items->itemtype->size_names)?>
                            @for($i = 0; $i < count($size_names); $i++)
                                <p>{{ $size_names[$i] }} : {{ $sizes_price[$i] }}</p>
                            @endfor

                            @if(!empty($items->img_id))
                                <label for="item" >Image</label>
                                <div class="">
                                    <img id="img_display" src="{{ @URL::to('img/item/' . $items->img_id) }}" alt=""  width="300">
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop