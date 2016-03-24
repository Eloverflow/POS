@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>
@stop

@section('patate')
    <div class="panel panel-default calendar-fix">
        <div class="panel-body">
            {!! $calendar->calendar() !!}
            {!! $calendar->script() !!}
        </div>
    </div>
@stop
