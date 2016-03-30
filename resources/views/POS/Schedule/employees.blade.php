@extends('master')
@section('csrfToken')

    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Scheduled Employees</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Name :</label>
                        <p>{{ $ViewBag['schedule']->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>Start Date :</label>
                        <p>{{ $ViewBag['schedule']->startDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>End Date :</label>
                        <p>{{ $ViewBag['schedule']->endDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>Created At :</label>
                        <p>{{ $ViewBag['schedule']->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label>Updated At :</label>
                        <p>{{ $ViewBag['schedule']->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (!empty($success))
                        {{ $success }}
                    @endif
                    <table data-toggle="table">
                        <thead>
                        <tr>
                            <th data-field="fullName" data-sortable="true">Full Name</th>
                            <th data-field="phone"  data-sortable="true">Phone</th>
                            <th data-field="shifts" data-sortable="true">Shifts</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ViewBag['employees'] as $employee)
                                <tr>
                                    <td>{{ $employee->firstName . "-" . $employee->lastName }}</td>
                                    <td>{{ $employee->phone }}</td>
                                    <td>{{ $employee->shifts }}</td>
                                    <td><a href="{{ URL::to('schedule', $ViewBag['schedule']->id) . '/employee/'. $employee->idEmployee }}">View</a>
                                        <a href="{{ URL::to('schedule', $ViewBag['schedule']->id) . '/employee/'. $employee->idEmployee. '/pdf' }}">Download</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
