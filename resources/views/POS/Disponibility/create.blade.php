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
                            {!! Form::label('', "" ) !!}
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
    <script src="{{ @URL::to('js/disponibilitiesManage.js') }}"></script>
    <script type="text/javascript">
        // var for edit Event
        var globStoredEvent = null;
        var globStoredCalendar = $('#calendar-' + "{{$ViewBag['calendar']->getId() }}");

        $('#btnAdd').click(function(e) {
            $('#addModal #sHour').val("");
            $('#addModal #sMin').val("");

            $('#addModal #eHour').val("");
            $('#addModal #eMin').val("");

            var lastSunday = getLastSunday(new Date());
            $('#addModal #dateClicked').val(formatDate(lastSunday));
            $("#addModal").modal('show');
        });
        $('#btnFinish').click(function(e) {
            e.preventDefault();
            postAddDisponibilities(globStoredCalendar);

        });
        $("#btnDelEvent").click(function(){
            deleteEvent(globStoredCalendar);
            $("#editModal").modal('hide');
        });
        $("#btnEditEvent").click(function(){
            editEvent(globStoredCalendar);
        });
        $("#btnAddEvent").click(function() {
            addEvent(globStoredCalendar);
        });
        $( "#dayNumber" ).change(function() {
            //var nDate = new Date();
            //nDate.setDate(nDate.getFullYear() + "-" +  nDate.getMonth() + "-" + (nDate.getDate() + this.value));
            var realVal = parseInt(this.value);
            if(realVal != -1) {
                var lastSunday = getLastSunday(new Date());
                var myDate = new Date(lastSunday.getTime() + (realVal * 24 * 60 * 60 * 1000));
                $('#dateClicked').val(formatDate(myDate));
            }
        });
    </script>
@stop