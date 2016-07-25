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
            <h1 class="page-header">Edit Calendar</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary pull-left" id="btnAdd" href="#"> Add+ </a>
            <a class="btn btn-success pull-right" id="btnFinish" href="#"> Finish </a>
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
                                <input type='text' id="startTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Employee</h3>
                            <select id="employeeSelect" name="employeeSelect" class="form-control">
                                @foreach ($ViewBag['employees'] as $employee)

                                    <option value="{{ $employee->idEmployee }}" @if(old('employeeSelect'))
                                        @if(old('employeeSelect') == $employee->idEmployee)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $employee->firstName . " " . $employee->lastName}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Options</h3>
                                {!! Form::checkbox('name', 1, null, ['id' => 'chkOptAllWeek']) !!}
                                {!! Form::label('lblOptAllWeek', "All this week") !!}
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
                                <input type='text' id="startTime" class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Employee</h3>
                            <select id="employeeSelect" name="employeeSelect" class="form-control">
                                @foreach ($ViewBag['employees'] as $employee)

                                    <option value="{{ $employee->idEmployee }}" @if(old('employeeSelect'))
                                        @if(old('employeeSelect') == $employee->idEmployee)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $employee->firstName . " " . $employee->lastName}}</option>
                                @endforeach
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
    <script src="{{ @URL::to('js/schedulesManage.js') }}"></script>

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
            //postAddSchedules();

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
            var startDate = globStoredCalendar.fullCalendar('getDate');
            console.log(startDate);
            var nDate = new Date($('#startDate').val());
            nDate.setDate(nDate.getDate() + 7);



        }

        $( "#startDate" ).change(function() {
            if($( "#startDate").val()  != ""){
                globStoredCalendar.fullCalendar('gotoDate', $('#startDate').val());

                var nDate = new Date($('#startDate').val());
                nDate.setDate(nDate.getDate() + 7);
                $( "#endDate").val(formatDate(nDate));

                globStoredCalendar.find('.fc-toolbar > div > h2').empty().append(
                        "Semaine du "+ $('#startDate').val() + " au "+
                        formatDate(nDate)
                );
            }
            //$( "#endDate").val(nDate.getFullYear() + "-" + (nDate.getMonth() + 1) + "-" + nDate.getDate());
            //var $startDate = $('#startDate').val();
        });

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