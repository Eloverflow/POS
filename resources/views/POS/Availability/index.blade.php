@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Availability</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('availability/create') }}"> Create New </a>
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
                            <th data-field="name" data-sortable="true">Name</th>
                            <th data-field="employee" data-sortable="true">Employee</th>
                            <th data-field="createdAt"  data-sortable="true">Created At</th>
                            <th data-field="lastUpdated"  data-sortable="true">Last Updated</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($ViewBag['availability'] as $availability)
                            <tr>
                                <td>{{ $availability->idDisponibility }}</td>
                                <td>{{ $availability->name }}</td>
                                <td>{{ $availability->firstName . " - " . $availability->lastName }}</td>
                                <td>{{ $availability->created_at }}</td>
                                <td>{{ $availability->updated_at }}</td>
                                <td><a href="{{ URL::to('availability/details', $availability->idDisponibility) }}">Details</a>
                                    <a href="{{ URL::to('availability/edit', $availability->idDisponibility) }}">Edit</a>
                                    <a href="{{ URL::to('availability/delete', $availability->idDisponibility) }}">Delete</a>
                                    <a href="{{ URL::to('availability/download', $availability->idDisponibility) }}">Download</a></td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
