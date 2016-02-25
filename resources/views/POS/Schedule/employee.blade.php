@extends('master')
@section('csrfToken')

    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Employee Schedule</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Schedule Name :</label>
                        <p>{{ $ViewBag['schedule']->name }}</p>
                    </div>
                    <div class="form-group">
                        <label>First Name :</label>
                        <p>{{ $ViewBag['employee']->firstName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Last Name :</label>
                        <p>{{ $ViewBag['employee']->lastName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Phone :</label>
                        <p>{{ $ViewBag['employee']->phone }}</p>
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
                    <table id="Schedule" >
                        <thead>
                        <tr>
                            <th></th>
                            <th data-field="sunday" data-sortable="true">Sunday</th>
                            <th data-field="monday"  data-sortable="true">Monday</th>
                            <th data-field="tuesday"  data-sortable="true">Tuesday</th>
                            <th data-field="wednesday" data-sortable="true">Wednesday</th>
                            <th data-field="thursday" data-sortable="true">Thursday</th>
                            <th data-field="friday" data-sortable="true">Friday</th>
                            <th data-field="saturday" data-sortable="true">Saturday</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $rows = $ViewBag['Rows'];
                            for($i = 0; $i < count($rows); $i++)
                            {
                                echo $rows[$i];
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
