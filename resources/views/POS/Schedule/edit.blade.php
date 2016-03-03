@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'schedule/edit', 'role' => 'form')) !!}
                        {!! Form::text('idSchedule', $ViewBag['schedule']->id, array('style' => 'display:none;visibility:hidden;')) !!}
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
                                    @if($errors->has('name'))
                                        <div class="form-group has-error">
                                            {!! Form::text('name', old('name'), array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('name', $ViewBag['schedule']->name, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('startDate', "Start Date" ) !!}
                                    @if($errors->has('startDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('startDate', old('startDate'), array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('startDate', $ViewBag['schedule']->startDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('endDate', "End Date" ) !!}
                                    @if($errors->has('endDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('endDate', old('endDate'), array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('endDate', $ViewBag['schedule']->endDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>

                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Sunday
                </div>
                <div class="panel-body">

                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="0">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="sunNestedList" class="nestedList">

                    </div>

                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="0">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="0">Add +</a>
                    <br />

                    <label>Sunday Disponibilities</label>

                    <select id="sunMultiSelect" name="sunDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][0] != null)
                            @foreach($ViewBag['weekSchedules'][0] as $sunDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $sunDispo->startTime, "EndTime" => $sunDispo->endTime)) }}">
                                    {{ $sunDispo->startTime . " To " . $sunDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('sunDispos'))
                            @foreach(old('sunDispos') as $sunDispo)
                                <option selected="" value="{{ $sunDispo }}">
                                    <?php $jsonData = json_decode($sunDispo, true);?>
                                    {{ $jsonData['EmployeeName'] . " - " . $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Monday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="1">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="monNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="1">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="1">Add +</a>
                    <br />

                    <label>Monday Disponibilities</label>

                    <select id="monMultiSelect" name="monDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][1] != null)
                            @foreach($ViewBag['weekSchedules'][1] as $monDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $monDispo->startTime, "EndTime" => $monDispo->endTime)) }}">
                                    {{ $monDispo->startTime . " To " . $monDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('monDispos'))
                            @foreach(old('monDispos') as $monDispo)
                                <option selected="" value="{{ $monDispo }}">
                                    <?php $jsonData = json_decode($monDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Tuesday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="2">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="tueNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="2">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="2">Add +</a>
                    <br />

                    <label>Tuesday Disponibilities</label>
                    <select id="tueMultiSelect" name="tueDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][2] != null)
                            @foreach($ViewBag['weekSchedules'][2] as $tueDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $tueDispo->startTime, "EndTime" => $tueDispo->endTime)) }}">
                                    {{ $tueDispo->startTime . " To " . $tueDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('tueDispos'))
                            @foreach(old('tueDispos') as $tueDispo)
                                <option selected="" value="{{ $tueDispo }}">
                                    <?php $jsonData = json_decode($tueDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Wednesday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="3">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="wedNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="3">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="3">Add +</a>
                    <br />

                    <label>Wednesday Disponibilities</label>
                    <select id="wedMultiSelect" name="wedDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][3] != null)
                            @foreach($ViewBag['weekSchedules'][3] as $wedDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $wedDispo->startTime, "EndTime" => $wedDispo->endTime)) }}">
                                    {{ $wedDispo->startTime . " To " . $wedDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('wedDispos'))
                            @foreach(old('wedDispos') as $wedDispo)
                                <option selected="" value="{{ $wedDispo }}">
                                    <?php $jsonData = json_decode($wedDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Thursday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="4">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="thuNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="4">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="4">Add +</a>
                    <br />

                    <label>Thursday Disponibilities</label>
                    <select id="thuMultiSelect" name="thuDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][4] != null)
                            @foreach($ViewBag['weekSchedules'][4] as $thuDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $thuDispo->startTime, "EndTime" => $thuDispo->endTime)) }}">
                                    {{ $thuDispo->startTime . " To " . $thuDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('thuDispos'))
                            @foreach(old('thuDispos') as $thuDispo)
                                <option selected="" value="{{ $thuDispo }}">
                                    <?php $jsonData = json_decode($thuDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Friday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="5">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="friNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="5">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="5">Add +</a>
                    <br />

                    <label>Friday Disponibilities</label>
                    <select id="friMultiSelect" name="friDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][5] != null)
                            @foreach($ViewBag['weekSchedules'][5] as $friDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $friDispo->startTime, "EndTime" => $friDispo->endTime)) }}">
                                    {{ $friDispo->startTime . " To " . $friDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('friDispos'))
                            @foreach(old('friDispos') as $friDispo)
                                <option selected="" value="{{ $friDispo }}">
                                    <?php $jsonData = json_decode($friDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    Saturday
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        {!! Form::label('employee', "Employee" ) !!}
                        <select id="employeeSelect" name="employeeSelect" class="form-control" data-Day="6">
                            <option value="-2"> - Select - </option>
                            <option value="-1">All</option>
                            @foreach ($ViewBag['employees'] as $employee)
                                <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div id="satNestedList" class="nestedList">

                    </div>
                    {!! Form::label('startTime', "Start Time" ) !!}
                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                    {!! Form::label('endTime', "End Time" ) !!}
                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                    <br />
                    <a class="bdel btn btn-default pull-right" data-Day="6">Delete -</a>
                    <a class="badd btn btn-primary pull-right" data-Day="6">Add +</a>
                    <br />

                    <label>Saturday Disponibilities</label>
                    <select id="satMultiSelect" name="satDispos[]" multiple class="form-control">
                        @if($ViewBag['weekSchedules'][6] != null)
                            @foreach($ViewBag['weekSchedules'][6] as $satDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $satDispo->startTime, "EndTime" => $satDispo->endTime)) }}">
                                    {{ $satDispo->startTime . " To " . $satDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('satDispos'))
                            @foreach(old('satDispos') as $satDispo)
                                <option selected="" value="{{ $satDispo }}">
                                    <?php $jsonData = json_decode($satDispo, true);?>
                                    {{ $jsonData['StartTime'] . " To " . $jsonData['EndTime'] }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit('Create', array('class' => 'btn btn-primary pull-right')) !!}
    {!! Form::close() !!}


@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/scheduleMultiSelect.js') }}"></script>
    <script src="{{ @URL::to('js/Disponibilities.js') }}"></script>
    <script>
        $('.badd').click(function (e) {
            addSchedule($(this));
        });
        $('.bdel').click(function (e) {
            remSchedule($(this));
        });
        $('select[id^=employeeSelect]').on('change', function (e) {

            var optionSelected = $("option:selected", this);
            var $idSelected = this.value;

            if($idSelected != -2) {
                findDisponibilities(this);
            }

        });

    </script>
@stop