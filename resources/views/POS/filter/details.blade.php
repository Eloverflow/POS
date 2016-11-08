@extends('master')

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('filter.detailsFilter') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('filters') }}"> {{ @Lang::get('filter.backToFilter') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">

                        <div class="form-group">
                            <label for="item" >Item</label>
                            <p>{{ $filter }}</p>
                            <label for="item" >Item Size</label>
                        </div>


                        <div class="form-group">
                            <label for="quantity" >Quantité</label>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
@stop