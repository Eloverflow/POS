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
            <h1 class="page-header">Track Employee</h1>
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
                            <th class="col-md-1" data-field="inout">In/Out</th>
                            <th data-field="time">Time</th>
                            <th data-field="date">Date</th>
                            <th data-field="actions"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ViewBag['punches'] as $punch)
                            <tr>
                                <?php  if($punch->inout == "in") {
                                    echo "<td class=\"tagin\">IN</td>"; } else {
                                    echo "<td class=\"tagout\">OUT</td>";
                                }
                                        ?>
                                <td>{{ $punch->time }}</td>
                                <td>{{ $punch->date }}</td>
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

    <div id="addModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>

                </div>
                <div class="modal-content">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div id="displaySuccesses" style="display:none;" class="alert alert-success">
                        <strong>Success!</strong><div class="successMsg"></div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-group">
                            <h3>IN / OUT</h3>
                            <select id="isInSelect" name="isIn" class="form-control">
                                <option value="0">IN</option>
                                <option value="1">OUT</option>
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Time</h3>
                            <div class="col-md-6">
                                <div class='input-group date' id='punchTimePicker'>
                                    <input type='text' class="form-control" />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Date</h3>
                            <div class="col-md-6">
                                <div class='input-group date' id='punchDatePicker'>
                                    {!! Form::text('punchDate', null, array('class' => 'datepickerInput form-control', 'data-date-format' => 'yyyy-mm-dd', 'id' => 'punchDate')) !!}
                                    {{--<input type='text' class="form-control" />--}}
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-time"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        {!! Form::label('startDate', "Start Date" ) !!}

                    </div>

                </div>
                <!-- dialog buttons -->
                <div class="modal-footer"><button id="btnAddPunch" type="button" class="btn btn-primary">Add</button></div>
            </div>
        </div>
    </div>
    <div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div id="displaySuccesses" style="display:none;" class="alert alert-success">
                        <strong>Success!</strong><div class="successMsg"></div>
                    </div>
                    <div class="col-md-4">

                        <div class="form-group">
                            <h3>Start Time</h3>
                            <div class="col-md-6">

                            </div>
                            <div class="col-md-6">

                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <h3>IN / OUT</h3>
                            <select id="isInSelect" name="isIn" class="form-control">
                                <option value="0">IN</option>
                                <option value="1">OUT</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button id="btnDelPunch" type="button" class="btn btn-danger">Delete</button>
                    <button id="btnEditPunch" type="button" class="btn btn-primary">Edit</button>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>{{--
    <script src="{{ @URL::to('js/schedulesManage.js') }}"></script>--}}
    <script src="{{ @URL::to('js/moment/moment-timezone-with-data.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function (e) {

         $('a.editPunch').bind('click', function(e) {
         /*$('#addModal #sHour').val("");
         $('#addModal #sMin').val("");*/

         $("#addModal").modal('show');
         e.preventDefault();
         });
         $('a.delPunch').bind('click', function(e) {
         /*e.preventDefault();*/

         $("#editPunch").modal('show');
         e.preventDefault();
         });/*
         $('#punchTimePicker').datetimepicker({
         format: 'LT'
         });*/
         });

    </script>


@stop