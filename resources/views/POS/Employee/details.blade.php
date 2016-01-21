@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Details</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label>Email :</label>
                        <p>{{ $employee->email }}</p>
                    </div>

                    <div class="form-group">
                        <label>First Name :</label>
                        <p>{{ $employee->firstName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Last Name :</label>
                        <p>{{ $employee->lastName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Address :</label>
                        <p>{{ $employee->streetAddress }}</p>
                    </div>
                    <div class="form-group">
                        <label>City :</label>
                        <p>{{ $employee->city }}</p>
                    </div>
                    <div class="form-group">
                        <label>State :</label>
                        <p>{{ $employee->state }}</p>
                    </div>
                    <div class="form-group">
                        <label>Phone Number :</label>
                        <p>{{ $employee->phone }}</p>
                    </div>
                    <div class="form-group">
                        <label>Postal Code :</label>
                        <p>{{ $employee->pc }}</p>
                    </div>
                    <div class="form-group">
                        <label>NAS :</label>
                        <p>{{ $employee->nas }}</p>
                    </div>

                    <div class="form-group">
                        <label>Employee Title :</label>
                        <p>{{ $employee->employeeTitle }}</p>
                    </div>
                    <div class="form-group">
                        <label>Salary :</label>
                        <p>{{ $employee->salary }}</p>
                    </div>
                    <div class="form-group">
                        <label>Birth Date :</label>
                        <p>{{ $employee->birthDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>Hire Date :</label>
                        <p>{{ $employee->hireDate }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop