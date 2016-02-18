@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Disponibilities</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('Disponibility/Create') }}"> Create New </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="panel panel-red">
                <div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Calendar</div>
                <div class="panel-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
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
                        @foreach ($ViewBag['disponibilities'] as $disponibility)
                            <tr>
                                <td>{{ $disponibility->idDisponibility }}</td>
                                <td>{{ $disponibility->name }}</td>
                                <td>{{ $disponibility->firstName . " - " . $disponibility->lastName }}</td>
                                <td>{{ $disponibility->created_at }}</td>
                                <td>{{ $disponibility->updated_at }}</td>
                                <td><a href="{{ URL::to('disponibility/view', $disponibility->idDisponibility) }}">View</a>
                                    <a href="{{ URL::to('disponibility/edit', $disponibility->idDisponibility) }}">Edit</a>
                                    <a href="{{ URL::to('disponibility/delete', $disponibility->idDisponibility) }}">Delete</a></td>
                            </tr>
                        @endforeach


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
