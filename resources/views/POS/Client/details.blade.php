@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop


@section('afterContent')
    @include('shared.afterContent')
@stop


@section('title', 'Extra')

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('client.detailsClient') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('clients') }}"> {{ @Lang::get('client.backToClient') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        {!! Form::open(array('url' => 'inventory/update', 'role' => 'form')) !!}


                        <div class="form-group">
                            <label for="item" >Item</label>
                            <p>{{ $clients }}</p>
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

@section("myjsfile")

@stop