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
                        {!! Form::open(array('url' => 'employee/edit', 'role' => 'form')) !!}
                        {!! Form::text('idUser', $ViewBag['employee']->idUser, array('style' => 'display:none;visibility:hidden;')) !!}
                        {!! Form::text('idEmployee', $ViewBag['employee']->idEmployee, array('style' => 'display:none;visibility:hidden;')) !!}
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
                            <legend>Contact Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('firstName', "First Name" ) !!}
                                    @if($errors->has('firstName'))
                                        <div class="form-group has-error">
                                            {!! Form::text('firstName', $ViewBag['employee']->firstName, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('firstName', $ViewBag['employee']->firstName, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('lastName', "Last Name" ) !!}
                                    @if($errors->has('lastName'))
                                        <div class="form-group has-error">
                                            {!! Form::text('lastName', $ViewBag['employee']->lastName, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('lastName', $ViewBag['employee']->lastName, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('nast', "NAS" ) !!}
                                    @if($errors->has('nas'))
                                        <div class="form-group has-error">
                                            {!! Form::text('nas', $ViewBag['employee']->nas, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('nas', $ViewBag['employee']->nas, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('streetAddress', "Street Address" ) !!}
                                    @if($errors->has('streetAddress'))
                                        <div class="form-group has-error">
                                            {!! Form::text('streetAddress', $ViewBag['employee']->streetAddress, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('streetAddress', $ViewBag['employee']->streetAddress, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('phone', "Phone Number" ) !!}
                                    @if($errors->has('phone'))
                                        <div class="form-group has-error">
                                            {!! Form::text('phone', $ViewBag['employee']->phone, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('phone', $ViewBag['employee']->phone, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('city', "City" ) !!}
                                    @if($errors->has('city'))
                                        <div class="form-group has-error">
                                            {!! Form::text('city', $ViewBag['employee']->city, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('city', $ViewBag['employee']->city, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('state', "State" ) !!}
                                    @if($errors->has('state'))
                                        <div class="form-group has-error">
                                            {!! Form::text('state', $ViewBag['employee']->state, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('state', $ViewBag['employee']->state, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('pc', "Postal Code" ) !!}
                                    @if($errors->has('pc'))
                                        <div class="form-group has-error">
                                            {!! Form::text('pc', $ViewBag['employee']->pc, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('pc', $ViewBag['employee']->pc, array('class' => 'form-control')) !!}
                                    @endif
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>Employee Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    <p class="text-warning">* Press ctrl and/or shift while selecting for multiple select.</p>
                                    {!! Form::label('title', "Employee Titles" ) !!}
                                    <select multiple name="employeeTitles[]" class="form-control">
                                        <?php $found = false;
                                        foreach ($ViewBag['employeeTitles'] as $employeeTitle){
                                            $found = false;
                                            for($i = 0; $i < count($ViewBag['employeeTitlesInUse']); $i++){
                                                if($employeeTitle->id == $ViewBag['employeeTitlesInUse'][$i]->idEmployeeTitles){
                                                $found = true;
                                                    ?>
                                                        <option value="{{ $employeeTitle->id }}" selected>{{ $employeeTitle->name }}</option>
                                                    <?php
                                                }
                                            }
                                            if($found == false){ ?>
                                                <option value="{{ $employeeTitle->id }}">{{ $employeeTitle->name }}</option>
                                            <?php }
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="form-group">
                                    {!! Form::label('bonusSalary', "Bonus Salary" ) !!}
                                    @if($errors->has('bonusSalary'))
                                        <div class="form-group has-error">
                                            {!! Form::text('bonusSalary', $ViewBag['employee']->bonusSalary, array('class' => 'form-control')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('bonusSalary', $ViewBag['employee']->bonusSalary, array('class' => 'form-control')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('birthDate', "birthDate" ) !!}
                                    @if($errors->has('birthDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('birthDate', $ViewBag['employee']->birthDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('birthDate', $ViewBag['employee']->birthDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>

                                <div class="form-group">
                                    {!! Form::label('hireDate', "Hire Date" ) !!}
                                    @if($errors->has('hireDate'))
                                        <div class="form-group has-error">
                                            {!! Form::text('hireDate', $ViewBag['employee']->hireDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                        </div>
                                    @else
                                        {!! Form::text('hireDate', $ViewBag['employee']->hireDate, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd')) !!}
                                    @endif
                                </div>
                            </div>
                        {!! Form::submit('Edit', array('class' => 'btn btn-primary', 'id' => 'btn-edit-employee')) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop