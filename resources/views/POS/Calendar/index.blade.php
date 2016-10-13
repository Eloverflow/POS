@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>

    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Calendar</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 cmd-section">
            <a class="btn btn-warning pull-right" id="btnEdit" href="{{ @URL::to('calendar/edit') }}"><span class="glyphicon glyphicon-pencil"></span>&nbsp; Edit </a>
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

@section("myjsfile")

@stop