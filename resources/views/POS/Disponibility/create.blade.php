@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                                        {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'name')) !!}
                                    </div>
                                @else
                                    {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'name')) !!}
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

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row" id="calendarCtrls">
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
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
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
    </div>--}}
    <div class="row">
        <div class="col-lg-12">

            <a class="btn btn-success pull-right" id="btnFinish" href="#"> Finish </a>

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
    <div id="addModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="col-md-4">
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
                    <div class="col-md-4">
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
                    <div class="col-md-4">
                        <div class="form-group">
                            <h3>Day</h3>
                            {!! Form::label('', "" ) !!}
                            <select id="dayNumber" class="form-control">
                                <option value="0">Sunday</option>
                                <option value="1">Monday</option>
                                <option value="2">Tuesday</option>
                                <option value="3">Wednesday</option>
                                <option value="4">Thursday</option>
                                <option value="5">Friday</option>
                                <option value="6">Saturday</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer"><button id="btnAddEvent" type="button" class="btn btn-primary">Add</button></div>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    Edit Modal!
                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"><button type="button" class="btn btn-primary">OK</button></div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script>
        $("#myModal").on("show", function() {    // wire up the OK button to dismiss the modal when shown
            $("#myModal a.btn").on("click", function(e) {
                console.log("button pressed");   // just as an example...
                $("#myModal").modal('hide');     // dismiss the dialog
            });
        });
        $("#myModal").on("hide", function() {    // remove the event listeners when the dialog is dismissed
            $("#myModal a.btn").off("click");
        });

        $("#myModal").on("hidden", function() {  // remove the actual elements from the DOM when fully hidden
            $("#myModal").remove();
        });

        $("#myModal").modal({                    // wire up the actual modal functionality and show the dialog
            "backdrop"  : "static",
            "keyboard"  : true,
            "show"      : true                     // ensure the modal is shown immediately
        });
    </script>
    <script>

        $('#btnFinish').click(function(e) {
            e.preventDefault();
            $storedCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
            var allEvents = $storedCalendar.fullCalendar('clientEvents');

            var arr = [];

            for (var i = 0; i < allEvents.length; i++){
                var dDate  = new Date(allEvents[i].start.toString());
                var myArray = {StartTime: allEvents[i].start.toString(), EndTime: allEvents[i].end.toString(), dayIndex: dDate.getDay()};
                arr.push(myArray)
            }

            var $dispoName = $('#name').val();
            var $dispoEmployee = $('#employeeSelect').val();

            //$('#frmDispoCreate').submit();
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/disponibility/create',
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    name: $dispoName,
                    employeeSelect: $dispoEmployee,
                    events: JSON.stringify(arr)

                },
                dataType: 'JSON',
                success: function (data) {
                    console.log(data);
                }
            });

        });
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
                description: 'This is a cool event',
                resourceId: 4,
            };


            $storedCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
            $storedCalendar.fullCalendar('addEventSource', [newEvent]);
        });

        function dayClick(xDate, xEvent)
        {
            var datet = new Date(xDate);
            alert(datet.getDay());
            $("#addModal").modal('show');
        }

        function dispoClick(xDate, xEvent)
        {
            /*alert(xEvent.start._d);
            alert(xEvent.end._d);*/
            //console.log(xEvent.start.toString());
            //console.log(xEvent.end.toString());

            var sDate = new Date(xEvent.start.toString());
            var eDate = new Date(xEvent.end.toString());
            $("#editModal").modal('show');
            //console.log(sDate.getDay());


            $('#sHour').val(sDate.getHours());
            $smin = $('#sMin').val();

            $ehour = $('#eHour').val();
            $emin = $('#eMin').val();

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