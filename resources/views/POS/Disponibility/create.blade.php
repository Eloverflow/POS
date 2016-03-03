@extends('master')

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
                        {!! Form::open(array('url' => 'disponibility/create', 'role' => 'form')) !!}
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
                        @if(old('sunDispos'))
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
                        @if(old('monDispos'))
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
                        @if(old('tueDispos'))
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
                        @if(old('wedDispos'))
                            @foreach(old('wedDispos') as $wedDispos)
                                <option selected="" value="{{ $wedDispos }}">
                                    <?php $jsonData = json_decode($wedDispos, true);?>
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
                        @if(old('thuDispos'))
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
                        @if(old('friDispos'))
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
                        @if(old('satDispos'))
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