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
                        {!! Form::open(array('url' => 'Disponibility/Create', 'role' => 'form')) !!}
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
                                            {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('name', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('employee', "Employee" ) !!}
                                    <select id="employeeSelect" name="employeeSelect" class="form-control">
                                        @foreach ($ViewBag['employees'] as $employee)
                                            <option value="{{ $employee->idEmployee }}">{{ $employee->firstName }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                        </fieldset>
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

                                    </select>
                                </div>
                            </div>
                        </div>

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

                                </select>
                            </div>
                        </div>
                    </div>

                            <h2>Monday</h2>
                            <div class="mfs">
                                <div class="form-group">

                                    {!! Form::label('startTime', "Start Time" ) !!}
                                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                    {!! Form::label('endTime', "End Time" ) !!}
                                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                    <br />
                                    <a class="bdel btn btn-default pull-right" data-Day="1">Delete -</a>
                                    <a class="badd btn btn-primary pull-right" data-Day="1">Add +</a>
                                    <br />

                                    <label>Sunday Disponibilities</label>
                                    <select id="monMultiSelect" name="monDispos[]" multiple class="form-control">

                                    </select>

                                </div>
                            </div>

                            <h2>Tuesday</h2>
                            <div class="mfs">
                                <div class="form-group">

                                    {!! Form::label('startTime', "Start Time" ) !!}
                                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                    {!! Form::label('endTime', "End Time" ) !!}
                                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                    <br />
                                    <a class="badd btn btn-default pull-right" data-Day="2">Delete -</a>
                                    <a class="bdel btn btn-primary pull-right" data-Day="2">Add +</a>
                                    <br />

                                    <label>Sunday Disponibilities</label>
                                    <select id="tueMultiSelect" name="tueDispos[]" multiple class="form-control">

                                    </select>

                                </div>
                            </div>

                            <h2>Wednesday</h2>
                            <div class="mfs">
                                <div class="form-group">

                                    {!! Form::label('startTime', "Start Time" ) !!}
                                    {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                    {!! Form::label('endTime', "End Time" ) !!}
                                    {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                    <br />
                                    <a class="bdel btn btn-default pull-right" data-Day="3">Delete -</a>
                                    <a class="badd btn btn-primary pull-right" data-Day="3">Add +</a>
                                    <br />

                                    <label>Sunday Disponibilities</label>
                                    <select id="wedMultiSelect" name="wedDispos[]" multiple class="form-control">

                                    </select>

                                </div>
                            </div>



                    <div class="col-md-6">
                        <h2>Thursday</h2>
                        <div class="mfs">
                            <div class="form-group">

                                {!! Form::label('startTime', "Start Time" ) !!}
                                {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                {!! Form::label('endTime', "End Time" ) !!}
                                {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                <br />
                                <a class="badd btn btn-default pull-right" data-Day="4">Delete -</a>
                                <a class="bdel btn btn-primary pull-right" data-Day="4">Add +</a>
                                <br />

                                <label>Sunday Disponibilities</label>
                                <select id="thuMultiSelect" name="thuDispos[]" multiple class="form-control">

                                </select>

                            </div>
                        </div>

                        <h2>Friday</h2>
                        <div class="mfs">
                            <div class="form-group">

                                {!! Form::label('startTime', "Start Time" ) !!}
                                {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                {!! Form::label('endTime', "End Time" ) !!}
                                {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                <br />
                                <a class="bdel btn btn-default pull-right" data-Day="5">Delete -</a>
                                <a class="badd btn btn-primary pull-right" data-Day="5">Add +</a>
                                <br />

                                <label>Sunday Disponibilities</label>
                                <select id="friMultiSelect" name="friDispos[]" multiple class="form-control">

                                </select>

                            </div>
                        </div>

                        <h2>Saturday</h2>
                        <div class="mfs">
                            <div class="form-group">

                                {!! Form::label('startTime', "Start Time" ) !!}
                                {!! Form::text('startTime', null, array('class' => 'form-control')) !!}

                                {!! Form::label('endTime', "End Time" ) !!}
                                {!! Form::text('endTime', null, array('class' => 'form-control')) !!}

                                <br />
                                <a class="bdel btn btn-default pull-right" data-Day="6">Delete -</a>
                                <a class="badd btn btn-primary pull-right" data-Day="6">Add +</a>
                                <br />

                                <label>Sunday Disponibilities</label>
                                <select id="satMultiSelect" name="satDispos[]" multiple class="form-control">

                                </select>

                            </div>
                        </div>
                    </div>
                    {!! Form::submit('Create', array('class' => 'btn btn-primary pull-right')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

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