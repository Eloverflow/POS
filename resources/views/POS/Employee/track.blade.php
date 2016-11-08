@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/fullcalendar.min.css') }}"/>
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>{{--
    <script src="{{ @URL::to('js/fullcalendar.min.js') }}"></script>--}}{{--
    <script src="{{ @URL::to('js/fr-ca.js') }}"></script>--}}
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Employee Tracking</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label>First Name :</label>
                        <p>{{ $ViewBag["employee"]->firstName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Last Name :</label>
                        <p>{{ $ViewBag["employee"]->lastName }}</p>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toggle="table" >
                        <thead>
                        <tr>
                            <th class="col-md-2" data-field="startTime">Start Time</th>
                            <th class="col-md-2" data-field="endTime">End Time</th>
                            <th data-field="date">Date</th>
                            <th data-field="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ViewBag['punches'] as $punch)
                            <tr>
                                <td>{{ $punch->startTime }}</td>
                                <td>{{ $punch->endTime }}</td>
                                <td><a class="editPunch" href="#" data-id="{{ $punch->id }}">Edit</a>
                                    <a class="delPunch" href="#" data-id="{{ $punch->id }}">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="editModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Punch</h4>
                </div>
                <div class="row">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div id="displaySuccesses" style="display:none;" class="alert alert-success">
                        <strong>Success!</strong><div class="successMsg"></div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Start Time</h3>

                            <div class='input-group date' id="startTimePicker">
                                <input type='text' class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>End Time</h3>

                                <div class='input-group date' id="endTimePicker">
                                    <input type='text' class="form-control dark-border" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>

                        </div>
                    </div>

                </div>

                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button id="btnDelPunch" type="button" class="btn btn-danger">Delete</button>
                    <button id="btnEditPunch" type="button" class="btn btn-primary">Edit</button>
                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>{{--
    <script src="{{ @URL::to('js/schedulesManage.js') }}"></script>--}}
    <script src="{{ @URL::to('js/moment/moment-timezone-with-data.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone-with-data-packed.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {

         $('a.editPunch').bind('click', function(e) {
         /*$('#addModal #sHour').val("");
         $('#addModal #sMin').val("");*/

             $startTimeMoment =  moment("2016-06-06 19:00:00");
             $('#startTimePicker').datetimepicker({
                 defaultDate: $startTimeMoment
             });
             $("#editModal").modal('show');
             e.preventDefault();
         });
         $('a.delPunch').bind('click', function(e) {
             /*e.preventDefault();*/

         });

        // Les binds pour ce qui concerne les controles dans les modals.

        $('#endTimePicker').datetimepicker({
            // Pass parameters here.
        });

        $('#punchDatePicker').datetimepicker({
            format: 'DD/MM/YYYY'
        });

        });
    </script>


@stop