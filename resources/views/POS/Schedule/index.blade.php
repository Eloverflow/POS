@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Schedules</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('Schedule/Create') }}"> Create New </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">


        </div>
    </div>
@stop
