@extends('master')

@section('afterContent')
@include('shared.afterContent')
@stop


@section('titleSection')
@include('shared.titleSection')
@stop


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('client.create') }}</h1>
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
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'clients/create', 'role' => 'form')) !!}

                        @foreach($tableColumns as $column)
                            <div class="form-group">
                                <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                            </div>
                        @endforeach

                        @if(isset($tableChildColumns))
                            @foreach($tableChildColumns as $column)
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                </div>
                            @endforeach
                        @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <button id="btn-create-client" type="submit" class="btn btn-primary pull-right">Create</button>

                    </div>
                </div>
            </div>
        </div>
    </div>

@stop

@section("myjsfile")

@stop