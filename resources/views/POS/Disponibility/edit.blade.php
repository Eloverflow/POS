@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Edit</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'disponibility/edit', 'role' => 'form')) !!}
                        {!! Form::text('idDisponibility', $ViewBag['disponibility']->idDisponibility, array('style' => 'display:none;visibility:hidden;')) !!}
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
                                        {!! Form::text('name', $ViewBag['disponibility']->name, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('employee', "Employee" ) !!}
                                    {{ old('employeeSelect') }}
                                    <select id="employeeSelect" name="employeeSelect" class="form-control">
                                        @foreach ($ViewBag['employees'] as $employee)
                                            <option value="{{ $employee->idEmployee }}" <?php if($employee->idEmployee == $ViewBag['disponibility']->idEmployee) { echo "selected"; } ?>>{{ $employee->firstName }}</option>
                                        @endforeach
                                    </select>
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
                        @if($ViewBag['weekDispos'][0] != null)
                            @foreach($ViewBag['weekDispos'][0] as $sunDispo)
                                <option selected="" value="{{ json_encode(array("StartTime" => $sunDispo->startTime, "EndTime" => $sunDispo->endTime)) }}">
                                    {{ $sunDispo->startTime . " To " . $sunDispo->endTime }}
                                </option>
                            @endforeach
                        @elseif(old('sunDispos'))
                            @foreach(old('sunDispos') as $sunDispo)
                                <option selected="" value="{{ $sunDispo }}">
                                    <?php $jsonData = json_decode($sunDispo, true);?>
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
                    Monday
                </div>
                <div class="panel-body">
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
                        @if($ViewBag['weekDispos'][1] != null)
                            @foreach($ViewBag['weekDispos'][1] as $monDispo)
                                <option selected="" value="{{ json_encode($monDispo) }}">
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
                        @if($ViewBag['weekDispos'][2] != null)
                            @foreach($ViewBag['weekDispos'][2] as $tueDispo)
                                <option selected="" value="{{ json_encode($tueDispo) }}">
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
                        @if($ViewBag['weekDispos'][3] != null)
                            @foreach($ViewBag['weekDispos'][3] as $wedDispo)
                                <option selected="" value="{{ json_encode($wedDispo) }}">
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
                        @if($ViewBag['weekDispos'][4] != null)
                            @foreach($ViewBag['weekDispos'][4] as $thuDispo)
                                <option selected="" value="{{ json_encode($thuDispo) }}">
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
                        @if($ViewBag['weekDispos'][5] != null)
                            @foreach($ViewBag['weekDispos'][5] as $friDispo)
                                <option selected="" value="{{ json_encode($friDispo) }}">
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
                        @if($ViewBag['weekDispos'][6] != null)
                            @foreach($ViewBag['weekDispos'][6] as $satDispo)
                                <option selected="" value="{{ json_encode($satDispo) }}">
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

    {!! Form::submit('Edit', array('class' => 'btn btn-primary pull-right')) !!}
    {!! Form::close() !!}


@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/disponibilityMultiSelect.js') }}"></script>
    <script>
        $('.badd').click(function (e) {
            addDisponibility($(this));
        });
        $('.bdel').click(function (e) {
            remDisponibility($(this));
        });
    </script>
@stop