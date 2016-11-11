@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>

    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>

    {{--<script src="{{ @URL::to('js/fr-ca.js') }}"></script>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit Calendar</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 cmd-section">
            <a class="btn btn-primary pull-left" id="btnAdd" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add</a>
            <a class="btn btn-success pull-right" id="btnFinish" href="#"><span class="glyphicon glyphicon-ok"></span>&nbsp; Finish </a>
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Type</h3>
                            <select id="momentType" name="momentType" class="form-control">
                                @foreach ($ViewBag['momentTypes'] as $momentType)
                                    <option value="{{ $momentType->id }}">
                                        {{ $momentType->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group employee-select" style="display: none;">
                            <h3>Employee</h3>
                            <select id="employeeSelect" name="employeeSelect" class="form-control" disabled>
                                @foreach ($ViewBag['employees'] as $employee)

                                    <option value="{{ $employee->idEmployee }}" @if(old('employeeSelect'))
                                        @if(old('employeeSelect') == $employee->idEmployee)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $employee->firstName . " " . $employee->lastName}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group event-name">
                            <h3>Event Name</h3>
                            {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'eventName')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <div class="form-group">
                            <h3>Options</h3>
                            <div>
                                {!! Form::checkbox('name', 1, null, ['id' => 'chkOptAllWeek']) !!}
                                {!! Form::label('lblOptAllWeek', "All week") !!}
                            </div>
                            <div>
                                {!! Form::checkbox('name', 1, null, ['id' => 'chkOptAllDay']) !!}
                                {!! Form::label('lblOptAllDay', "All day") !!}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer"><button id="btnAddEvent" type="button" class="btn btn-primary">Add</button></div>
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
                                <input type='text' id="endTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Type</h3>
                            <select id="momentType" name="momentType" class="form-control">
                                @foreach ($ViewBag['momentTypes'] as $momentType)
                                    <option value="{{ $momentType->id }}">
                                        {{ $momentType->name}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group employee-select" style="display: none;">
                            <h3>Employee</h3>
                            <select id="employeeSelect" name="employeeSelect" class="form-control" disabled>
                                @foreach ($ViewBag['employees'] as $employee)

                                    <option value="{{ $employee->idEmployee }}" @if(old('employeeSelect'))
                                        @if(old('employeeSelect') == $employee->idEmployee)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $employee->firstName . " " . $employee->lastName}}</option>
                                @endforeach
                            </select>
                            <div class="form-group event-name">
                                <h3>Event Name</h3>
                                {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'eventName')) !!}
                            </div>
                        </div>
                        <div class="form-group event-name">
                            <h3>Event Name</h3>
                            {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'eventName')) !!}
                        </div>
                    </div>
                    <div class="col-md-6 pull-right">
                        <div class="form-group">
                            <h3>Options</h3>
                            <div>
                                {!! Form::checkbox('name', 1, null, ['id' => 'chkOptAllWeek']) !!}
                                {!! Form::label('lblOptAllWeek', "All week") !!}
                            </div>
                            <div>
                                {!! Form::checkbox('name', 1, null, ['id' => 'chkOptAllDay']) !!}
                                {!! Form::label('lblOptAllDay', "All day") !!}
                            </div>
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
    <script src="{{ @URL::to('js/calendarManage.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone-with-data-packed.js') }}"></script>
    <script type="text/javascript">
        // var for edit Event
        var globStoredEvent = null;
        var globStoredCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");


        $('#btnFinish').click(function(e) {
            e.preventDefault();
            //postAddSchedules();
            postCalendarMoments();
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

        function calendarViewRender (xView, xElement) {

            if(xView.type === "agendaWeek"){
                window.setTimeout(function(){
                    globStoredCalendar.find('.fc-toolbar > div > h2').empty().append(
                            "Semaine du " + xView.start.format('YYYY-MM-DD')+ "  au " +
                            xView.end.format('YYYY-MM-DD')
                    );
                },0);
            }else if(xView.type === "month"){
                window.setTimeout(function(){
                    globStoredCalendar.find('.fc-toolbar > div > h2').empty().append(
                            xView.start.format('YYYY-MM-DD')+ "  au " +
                            xView.end.format('YYYY-MM-DD')
                    );
                },0);
            } else if(xView.type === "agendaDay"){
                window.setTimeout(function(){
                    globStoredCalendar.find('.fc-toolbar > div > h2').empty().append(
                            xView.start.format('YYYY-MM-DD')
                    );
                },0);
            }

        }

        $('#addModal #startTimePicker').datetimepicker();
        $('#addModal #endTimePicker').datetimepicker();

        $('#editModal #startTimePicker').datetimepicker();
        $('#editModal #endTimePicker').datetimepicker();


        /*$("#startTimePicker").on("dp.change", function (e) {
         $('#endTimePicker').data("DateTimePicker").minDate(e.date);
         });
         $("#endTimePicker").on("dp.change", function (e) {
         $('#startTimePicker').data("DateTimePicker").maxDate(e.date);
         });*/
    </script>
@stop