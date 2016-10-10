@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>

    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>

    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')

    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Availability Create</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                    {!! Form::open(array('url' => 'availability/create', 'role' => 'form', 'id' => 'frmDispoCreate')) !!}

                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul id="errors"></ul>
                    </div>

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
    </div>
    <div class="row">
        <div class="col-lg-12 cmd-section">
                <a class="btn btn-primary pull-left" id="btnAdd" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add</a>
                <a class="btn btn-success pull-right" id="btnFinish" href="#"><span class="glyphicon glyphicon-ok"></span>&nbsp; Create </a>
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
    <div id="addModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Add Moment</h4>
                </div>
                <div class="row">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div id="displaySuccesses" style="display:none;" class="alert alert-success">
                        <strong>Success!</strong><div class="successMsg"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Start Time</h3>
                            <div class='input-group date' id="startTimePicker">
                                <input type='text' id="startTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>End Time</h3>
                            <div class='input-group date' id="endTimePicker">
                                <input type='text' id="endTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <div class="form-group">
                            <h3>Day</h3>
                            <select id="dayNumber" class="form-control">
                                <option value="-1">All Week</option>
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
                <div class="modal-footer"><a id="btnAddEvent" type="button" class="btn btn-primary">Add</a></div>
            </div>
        </div>
    </div>
    <div id="editModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Moment</h4>
                </div>
                <div class="row">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div id="displaySuccesses" style="display:none;" class="alert alert-success">
                        <strong>Success!</strong><div class="successMsg"></div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Start Time</h3>
                            <div class='input-group date' id="startTimePicker">
                                <input type='text' id="startTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>End Time</h3>
                            <div class='input-group date' id="endTimePicker">
                                <input type='text' id="startTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <div class="form-group">
                            <h3>Day</h3>
                            <select id="dayNumber" class="form-control">
                                <option value="-1">All Week</option>
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
                <div class="modal-footer">
                    <button id="btnDelEvent" type="button" class="btn btn-danger">Delete</button>
                    <button id="btnEditEvent" type="button" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/availabilityManage.js') }}"></script>

    <script src="{{ @URL::to('js/moment/moment-timezone-with-data-packed.js') }}"></script>
    <script type="text/javascript">
        // var for edit Event
        var globStoredEvent = null;
        var globStoredCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
        $('#btnAdd').click(function(e) {

            $("#addModal").modal('show');
        });
        $('#btnFinish').click(function(e) {
            e.preventDefault();
            postAddDisponibilities();

        });
        $("#btnDelEvent").click(function(){
            deleteEvent();
            $("#editModal").modal('hide');
        });
        $("#btnEditEvent").click(function(){
            editEvent();
        });
        $("#btnAddEvent").click(function() {
            addEvent();
        });

        $('#addModal #startTimePicker').datetimepicker({
            format: 'LT',
            timeZone: null
        });
        $('#addModal #endTimePicker').datetimepicker({
            format: 'LT',
            timeZone: null
        });

        $('#editModal #startTimePicker').datetimepicker({
            format: 'LT',
            timeZone: null
        });
        $('#editModal #endTimePicker').datetimepicker({
            format: 'LT',
            timeZone: null
        });

        $( "#addModal #dayNumber" ).change(function() {
            var selectedValue = parseInt(this.value);
            if( selectedValue != -1) {

                var stDtPicker = $('#addModal #startTimePicker').data("DateTimePicker");
                var edDtPicker = $('#addModal #endTimePicker').data("DateTimePicker");

                var momentStart = moment(stDtPicker.date());
                var momentEnd = moment(edDtPicker.date());

                var calStartDate = new Date(
                        globStoredCalendar.fullCalendar('getView').start.tz(globTimeZoneAMontreal)
                                .format()
                );

                momentStart = new Date(moment(formatDate(calStartDate))
                        .add(selectedValue + 1, 'days')
                        .add(momentStart.hours(), 'hours')
                        .add(momentStart.minutes(), 'minutes')
                        .tz(globTimeZoneAMontreal)
                        .format());

                momentEnd = new Date(moment(formatDate(calStartDate))
                        .add(selectedValue + 1, 'days')
                        .add(momentEnd.hours(), 'hours')
                        .add(momentEnd.minutes(), 'minutes')
                        .tz(globTimeZoneAMontreal)
                        .format());

                stDtPicker.clear();
                stDtPicker.defaultDate(momentStart);

                edDtPicker.clear();
                edDtPicker.defaultDate(momentEnd);


            }
        });

        $( "#editModal #dayNumber" ).change(function() {
            var selectedValue = parseInt(this.value);
            if(selectedValue != -1) {

                var stDtPicker = $('#editModal #startTimePicker').data("DateTimePicker");
                var edDtPicker = $('#editModal #endTimePicker').data("DateTimePicker");

                var momentStart = moment(stDtPicker.date());
                var momentEnd = moment(edDtPicker.date());

                var calStartDate = new Date(
                        globStoredCalendar.fullCalendar('getView').start.tz(globTimeZoneAMontreal)
                                .format()
                );

                momentStart = new Date(moment(formatDate(calStartDate))
                        .add(selectedValue + 1, 'days')
                        .add(momentStart.hours(), 'hours')
                        .add(momentStart.minutes(), 'minutes')
                        .tz(globTimeZoneAMontreal)
                        .format());

                momentEnd = new Date(moment(formatDate(calStartDate))
                        .add(selectedValue + 1, 'days')
                        .add(momentEnd.hours(), 'hours')
                        .add(momentEnd.minutes(), 'minutes')
                        .tz(globTimeZoneAMontreal)
                        .format());


                stDtPicker.clear();
                stDtPicker.defaultDate(momentStart);


                edDtPicker.clear();
                edDtPicker.defaultDate(momentEnd);

            }
        });
    </script>
@stop