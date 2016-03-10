@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
@stop

@section('patate')
    <div class="panel panel-default calendar-fix">
        <div class="panel-body">
            {!! $calendar->calendar() !!}
            {!! $calendar->script('gotoDate', new DateTime("2016-02-07")) !!}
            <script>
                $(`calendar-yk8Jet3l).fullCalendar( 'gotoDate', date )
                </script>
        </div>
    </div>
@stop
