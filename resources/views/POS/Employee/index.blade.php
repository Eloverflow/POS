@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Employees</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('employee/create') }}"> Create New </a>
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
                    <table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="id" data-checkbox="true" >Item ID</th>
                            <th data-field="firstName" data-sortable="true">First Name</th>
                            <th data-field="lastName"  data-sortable="true">Last Name</th>
                            <th data-field="email" data-sortable="true">Email</th>
                            <th data-field="hireDate" data-sortable="true">Hire Date</th>
                            <th data-field="isWorking" data-sortable="true">Status</th>
                            <th data-field="actions" data-sortable="true"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->idEmployee }}</td>
                                <td>{{ $employee->firstName }}</td>
                                <td>{{ $employee->lastName }}</td>
                                <td>{{ $employee->email }}</td>
                                <td>{{ $employee->hireDate }}</td>
                                <td><?php if($employee->isWorking == 1){ echo "Working" ; }elseif($employee->isWorking == ""){ echo "Never worked"; }else { echo "Off"; } ?></td>
                                <td><a href="{{ URL::to('employee/track', $employee->idEmployee) }}">Track</a>
                                    <a href="{{ URL::to('employee/details', $employee->idEmployee) }}">Details</a>
                                    <a href="{{ URL::to('employee/edit', $employee->idEmployee) }}">Edit</a>
                                    <a href="{{ URL::to('employee/delete', $employee->idEmployee) }}">Delete</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
