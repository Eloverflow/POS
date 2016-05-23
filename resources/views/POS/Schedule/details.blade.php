@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Schedule Details</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('schedule/create') }}"> Create New </a>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Name :</label>
                        <p>{{ $ViewBag['schedule']->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>Start Date :</label>
                        <p>{{ $ViewBag['schedule']->startDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>End Date :</label>
                        <p>{{ $ViewBag['schedule']->endDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>Created At :</label>
                        <p>{{ $ViewBag['schedule']->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label>Updated At :</label>
                        <p>{{ $ViewBag['schedule']->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('calendar')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default calendar-fix">
                <div class="panel-body">
                    {!! $ViewBag['calendar']->calendar() !!}
                    {!! $ViewBag['calendar']->script() !!}
                </div>
            </div>
        </div>
    </div>
@stop
