@extends('master')

@section('title', $title)

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
        <h1 class="page-header">{{ @Lang::get('client.updateToClient') }}</h1>
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
                    <?php $path = dirname(Request::path());?>
                    <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
                    <div class="panel-body">

                        {!! Form::open(array('url' => @URL::to(Request::path()),'files' => true)) !!}
                            <div class="form-group">
                                @foreach($tableColumns as $column)
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    @if($column != 'rfid_card_code')
                                        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableRow->$column }}">
                                    @else
                                        <p>{{ $tableRow->$column }}</p>
                                    @endif
                                    @endforeach

                                    @if(Session::has('error'))
                                        <p class="errors">{!! Session::get('error') !!}</p>
                                    @endif
                                    <div id="success"> </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            </div>
                            <button type="submit" id="btn-edit-client" class="btn btn-default">Update</button>
                        </form>
                        <br>

                        @include('partials.alerts.errors')

                        @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                                {{ Session::get('flash_message') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
