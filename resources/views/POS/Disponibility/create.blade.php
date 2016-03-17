@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
@stop

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Disponibility Create</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(array('url' => 'disponibility/create', 'role' => 'form', 'id' => 'frmDispoCreate')) !!}
                    @if (count($errors) > 0)
                        <div class="alert alert-danger">
                            <strong>Whoops!</strong> There were some problems with your input.<br><br>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <fieldset>
                        <legend>Disponibility Informations</legend>
                        <div class="mfs">
                            <div class="form-group">
                                {!! Form::label('name', "Name" ) !!}
                                @if($errors->has('name'))
                                    <div class="form-group has-error">
                                        {!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
                                    </div>
                                @else
                                    {!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
                                @endif
                            </div>

                            <div class="form-group">
                                {!! Form::label('employee', "Employee" ) !!}
                                <select id="employeeSelect" name="employeeSelect" class="form-control">
                                    @foreach ($ViewBag['employees'] as $employee)

                                        <option value="{{ $employee->idEmployee }}" @if(old('employeeSelect'))
                                            @if(old('employeeSelect') == $employee->idEmployee)
                                                {{ "selected" }}
                                                    @endif
                                                @endif >{{ $employee->firstName }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                    </fieldset>
                    {!! Form::textarea('disponibilities', null, array('id' => 'disposArea')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-3">
                        <div class="form-group">
                            <h3>Start Time</h3>
                            <div class="col-md-6">
                                {!! Form::label('sHour', "Hour" ) !!}
                                {!! Form::text('sHour', old('sHour'), array('class' => 'form-control', 'id' => 'sHour')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('sMin', "Min" ) !!}
                                {!! Form::text('sMin', old('sMin'), array('class' => 'form-control', 'id' => 'sMin')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <h3>End Time</h3>
                            <div class="col-md-6">
                                {!! Form::label('eHour', "Hour" ) !!}
                                {!! Form::text('eHour', old('eHour'), array('class' => 'form-control', 'id' => 'eHour')) !!}
                            </div>
                            <div class="col-md-6">
                                {!! Form::label('eMin', "Min" ) !!}
                                {!! Form::text('eMin', old('eMin'), array('class' => 'form-control', 'id' => 'eMin')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <h3>Day</h3>
                            {!! Form::label('', "" ) !!}
                            <select id="dayNumber" class="form-control">
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Saturday</option>
                                <option value="6">Friday</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <h3>#</h3>
                            <a class="btn btn-primary" id="btnAddEvent" href="#"> Add Dispo </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">

            <a class="btn btn-success pull-right" href="#"> Finish </a>

        </div>
    </div>
@stop

@section('patate')
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
    <script>
        $("#btnAddEvent").click(function(){

            $shour = $('#sHour').val();
            $smin = $('#sMin').val();

            $ehour = $('#eHour').val();
            $emin = $('#eMin').val();

            $dDayNumber = $( "#dayNumber option:selected" ).val();
            //alert($dDayNumber);

            var date = new Date();
            var day = date.getDate();
            var dayNum = date.getDay();
            var monthIndex = date.getMonth();
            var year = date.getFullYear();

            var dayToSubstract = day - (dayNum - $dDayNumber)
            monthIndex = monthIndex + 1;

            var ymd = year +  "-" + monthIndex + "-" + dayToSubstract;
            var sHM = $shour + ":" + $smin;
            var eHM = $ehour + ":" + $emin;

            console.log(ymd);
            var newEvent = {
                title: sHM + "-" + eHM,
                isAllDay: false,
                start: new Date(ymd + ' ' + sHM + ':00'),
                end: new Date(ymd + ' ' + eHM + ':00'),
                description: 'This is a cool event'
            };


            $storedCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
            $storedCalendar.fullCalendar('addEventSource', [newEvent]);
        });

        function dispoClick(xEvent)
        {
            /*alert(xEvent.start._d);
            alert(xEvent.end._d);*/
            console.log(xEvent.start.toString());
            console.log(xEvent.end.toString());
            //console.log(xEvent);
            //console.log(xEvent.start);
            //console.log(xEvent.end);
        }
        function writeAllEvents()
        {

            $storedCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
            console.log($storedCalendar.fullCalendar('getResourceEvents'));
            $('#disposArea').val($storedCalendar.fullCalendar('getResourceEvents'));
        }

    </script>
@stop