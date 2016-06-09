@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment.min.js') }}"></script>
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>
    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>
@stop

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Schedules</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('schedule/create') }}"> Create New </a>
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
                            <th data-field="startDate"  data-sortable="true">Start Date</th>
                            <th data-field="endDate" data-sortable="true">End Date</th>
                            <th data-field="nbEmployees"  data-sortable="true">Employees</th>
                            <th data-field="createdAt" data-sortable="true">Created At</th>
                            <th data-field="actions" data-sortable="true"></th>
                            <th data-field="track" data-sortable="true"></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($ViewBag['schedules'] as $schedule)
                            <tr>
                                <td>{{ $schedule->idSchedule }}</td>
                                <td>{{ $schedule->name }}</td>
                                <td>{{ $schedule->startDate }}</td>
                                <td>{{ $schedule->endDate }}</td>
                                <td><a href='{{ URL::to('schedule', $schedule->idSchedule) . '/employees' }}'>View</a></td>
                                {{--<td>{{ $schedule->status }}</td>--}}
                                <td>{{ $schedule->created_at }}</td>
                                <td>
                                    <a href="{{ URL::to('schedule/details', $schedule->idSchedule) }}">Details</a>
                                    <a href="{{ URL::to('schedule/edit', $schedule->idSchedule) }}">Edit</a>
                                    <a href="{{ URL::to('schedule/delete', $schedule->idSchedule) }}">Delete</a>
                                    <a href="{{ URL::to('schedule', $schedule->idSchedule) . "/pdf" }}">Download</a></td>
                                <td>
                                    <a href="{{ URL::to('schedule/track', $schedule->idSchedule) }}">Track</a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
