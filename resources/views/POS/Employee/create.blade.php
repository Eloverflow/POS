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
                        {!! Form::open(array('url' => 'employee/create', 'role' => 'form')) !!}
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
                            <legend>User Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('email', "Email" ) !!}
                                    @if($errors->has('email'))
                                        <div class="form-group has-error">
                                            {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('email', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('password', "Password" ) !!}
                                    @if($errors->has('password'))
                                        <div class="form-group has-error">
                                            {!! Form::text('password', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('password', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('confirmPassword', "Confirm Password" ) !!}
                                    @if($errors->has('confirmPassword'))
                                        <div class="form-group has-error">
                                            {!! Form::text('confirmPassword', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('confirmPassword', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Contact Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('firstName', "First Name" ) !!}
                                    @if($errors->has('firstName'))
                                        <div class="form-group has-error">
                                            {!! Form::text('firstName', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('firstName', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('lastName', "Last Name" ) !!}
                                    @if($errors->has('lastName'))
                                        <div class="form-group has-error">
                                            {!! Form::text('lastName', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('lastName', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('nas', "NAS" ) !!}
                                    @if($errors->has('nas'))
                                        <div class="form-group has-error">
                                            {!! Form::text('nas', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('nas', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('streetAddress', "Street Address" ) !!}
                                    @if($errors->has('streetAddress'))
                                        <div class="form-group has-error">
                                            {!! Form::text('streetAddress', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('streetAddress', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('phone', "Phone Number" ) !!}
                                    @if($errors->has('phone'))
                                        <div class="form-group has-error">
                                            {!! Form::text('phone', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('phone', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('city', "City" ) !!}
                                    @if($errors->has('city'))
                                        <div class="form-group has-error">
                                            {!! Form::text('city', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('city', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('state', "State" ) !!}
                                    @if($errors->has('state'))
                                        <div class="form-group has-error">
                                            {!! Form::text('state', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('state', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('pc', "Postal Code" ) !!}
                                    @if($errors->has('pc'))
                                        <div class="form-group has-error">
                                            {!! Form::text('pc', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('pc', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Employee Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Job Title" ) !!}
                                    <select name="employeeTitle" class="form-control">
                                        @foreach ($employeeTitles as $employeeTitle)
                                            <option value="{{ $employeeTitle->id }}">{{ $employeeTitle->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('salary', "Salary" ) !!}
                                    @if($errors->has('salary'))
                                        <div class="form-group has-error">
                                            {!! Form::text('salary', null, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('salary', null, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('birthDate', "birthDate" ) !!}
                                    @if($errors->has('birthDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('birthDate', null, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('birthDate', null, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('hireDate', "Hire Date" ) !!}
                                    @if($errors->has('hireDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('hireDate', null, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('hireDate', null, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>
                            </div>
                        {!! Form::submit('Create', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop