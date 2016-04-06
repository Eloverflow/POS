@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Employee Titles</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('employee/title/create') }}"> Create New </a>
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
                            <th data-field="titleName" data-sortable="true">Title Name</th>
                            <th data-field="baseSalary"  data-sortable="true">Base Salary</th>
                            <th data-field="actions" data-sortable="true"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($ViewBag['employeeTitles'] as $employeeTitle)
                            <tr>
                                <td>{{ $employeeTitle->id }}</td>
                                <td>{{ $employeeTitle->name }}</td>
                                <td>{{ $employeeTitle->baseSalary }}</td>
                                <td><a href="{{ URL::to('employee/title/edit', $employeeTitle->id) }}">Edit</a>
                                    <a href="{{ URL::to('employee/title/delete', $employeeTitle->id) }}">Delete</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
