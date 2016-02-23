@extends('master')
@section('csrfToken')
    <meta name="schedule-id" content="{{ $ViewBag['schedule']->id }}" />
    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Schedule Details</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('disponibility/create') }}"> Create New </a>
            </div>
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

@section("myjsfile")
    <script src="{{ @URL::to('js/getScheduledEmployees.js') }}"></script>
    <script>
        $('#Schedule').on("click", "td", function(e) {
            var col = $(this).parent().children().index($(this));
            var row = $(this).parent().parent().children().index($(this).parent());

            GetScheduledEmployees(col - 1, row + 1);
        });
    </script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootbox.js') }}"></script>
@stop