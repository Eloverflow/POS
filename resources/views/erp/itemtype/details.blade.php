@extends('master')

@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('itemtype.detailsItemtype') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('itemtypes') }}"> {{ @Lang::get('itemtype.backToItemtype') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">


                        <div class="form-group">
                            <label for="item" >Type</label>
                            <p>{{ $itemtypes->type }}</p>
                            <label for="item" >Field names</label>
                            <p>{{ $itemtypes->field_names }}</p>
                            <label for="quantity" >Size names</label>
                            <p>{{ $itemtypes->size_names }}</p>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop