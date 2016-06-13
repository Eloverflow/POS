@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
{{--
@section('title', $title)--}}

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Extra</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a href="{{@URL::to('/extras/create')}}"  ><button type="button" class="btn btn-primary">Create</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {{$extras}}
                    </div>

                </div>

                <!-- dialog buttons -->

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop