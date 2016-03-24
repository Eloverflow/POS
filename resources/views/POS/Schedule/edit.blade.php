@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Schedule Edit</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'schedule/create', 'role' => 'form')) !!}
                        {!! Form::text('scheduleId', $ViewBag['schedule']->id, array('class' => 'form-control', 'id' => 'scheduleId', 'style' => 'display:none;visibility:hidden;')) !!}
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
                            <legend>Schedule Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('name', "Name" ) !!}
                                    {!! Form::text('name', $ViewBag['schedule']->name, array('class' => 'form-control')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('startDate', "Start Date" ) !!}
                                    {!! Form::text('startDate', $ViewBag['schedule']->startDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                </div>

                                <div class="form-group">
                                    {!! Form::label('endDate', "End Date" ) !!}
                                    {!! Form::text('endDate', $ViewBag['schedule']->endDate, array('class' => ' form-control', 'data-date-format' => 'yyyy-mm-dd', 'id' => 'endDate', 'disabled ')) !!}
                                </div>

                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-primary pull-left" id="btnAdd" href="#"> Add+ </a>
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
                        {!! Form::text('dateClicked', $ViewBag['schedule']->startDate, array('class' => 'form-control', 'id' => 'dateClicked')) !!}
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
                        <div class="form-group">
                            <h3>Employee</h3>
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
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="col-md-4">
                        {!! Form::text('dateClicked', null, array('class' => 'form-control', 'id' => 'dateClicked', 'style' => 'display:none;visibility:hidden;')) !!}
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
                        <div class="form-group">
                            <h3>Employee</h3>
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
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer"><button id="btnEditEvent" type="button" class="btn btn-primary">Edit</button></div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/schedulesManage.js') }}"></script>
    <script type="text/javascript">
        // var for edit Event
        var globStoredEvent = null;
        var globStoredCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");
        $('#btnAdd').click(function(e) {

            $('#addModal #sHour').val("");
            $('#addModal #sMin').val("");

            $('#addModal #eHour').val("");
            $('#addModal #eMin').val("");
            $("#addModal").modal('show');
        });
        $('#btnAdd').click(function(e) {
            e.preventDefault();
            postEditSchedules(globStoredCalendar);

        });
        $('#btnFinish').click(function(e) {
            e.preventDefault();
            postEditSchedules(globStoredCalendar);

        });
        $("#btnEditEvent").click(function(){
            editEvent(globStoredCalendar);
        });
        $("#btnAddEvent").click(function() {
            addEvent(globStoredCalendar);
        });
        $( "#startDate" ).change(function() {

            if($( "#startDate").val()  != "") {
                globStoredCalendar.fullCalendar('gotoDate', $('#startDate').val());

                //Semaine du 2016-04-03 au 2016-04-09
                var nDate = new Date($('#startDate').val());
                nDate.setDate(nDate.getDate() + 7);
                $("#endDate").val(formatDate(nDate));

                globStoredCalendar.find('.fc-toolbar > div > h2').empty().append(
                        "Semaine du " + $('#startDate').val() + " au " +
                        formatDate(nDate)
                );
            }
            //$( "#endDate").val(nDate.getFullYear() + "-" + (nDate.getMonth() + 1) + "-" + nDate.getDate());
            //var $startDate = $('#startDate').val();
        });
    </script>
@stop