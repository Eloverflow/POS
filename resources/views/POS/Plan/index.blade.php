@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Plans</h1>
        </div>
        <div class="col-md-6">
            <div class="col-md-6">
                <div class="vcenter">
                    <input type="text" id="planName" name="planName" class='form-control' placeholder="Plan Name">
                </div>
            </div>
            <div class="col-md-3">
                <div class="vcenter">
                    <input type="text" id="nbFloor" name="nbFloor" class='form-control' placeholder="Nb. Floor">
                </div>
            </div>
            <div class="col-md-3">
                <div class="vcenter">
                    <a id="btnNewPlan" class="btn btn-primary pull-right" href="#"> Create New </a>
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
                    <table data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <thead>
                        <tr>
                            <th data-field="id" data-checkbox="true" >Item ID</th>
                            <th data-field="planName" data-sortable="true">Plan Name</th>
                            <th data-field="nbTables"  data-sortable="true">Nb. Tables</th>
                            <th data-field="nbFloors"  data-sortable="true">Nb. Floors</th>
                            <th data-field="createdAt"  data-sortable="true">Created At</th>
                            <th data-field="actions" data-sortable="true"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($ViewBag['plans'] as $plan)
                            <tr>
                                <td>{{ $plan->idPlan }}</td>
                                <td>{{ $plan->name }}</td>
                                <td>0</td>
                                <td>{{ $plan->nbFloor }}</td>
                                <td>{{ $plan->created_at }}</td>
                                <td><a href="{{ URL::to('plan/details', $plan->idPlan) }}">Details</a>
                                    <a href="{{ URL::to('plan/edit', $plan->idPlan) }}">Edit</a>
                                    <a href="{{ URL::to('plan/delete', $plan->idPlan) }}">Delete</a></td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('myjsfile')
    <script>
        $("#btnNewPlan").click(function() {
            $planName = $("#planName").val();
            $nbFloor = $("#nbFloor").val();

            window.location.replace("/plan/create/" + $planName + "/" + $nbFloor);
        });
    </script>
@stop