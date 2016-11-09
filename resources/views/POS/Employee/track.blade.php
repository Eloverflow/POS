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
                    {!! Form::text('idEmployee', $ViewBag["employee"]->idEmployee, array('style' => 'display:none;visibility:hidden;', 'id' => 'idEmployee')) !!}
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
        <div class="col-lg-12 cmd-section">
            <a class="btn btn-primary pull-left" id="btnAdd" href="#"><span class="glyphicon glyphicon-plus"></span>&nbsp; Add </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toggle="table" id="tblPunches">
                        <thead>
                        <tr>
                            <th class="col-md-2" data-field="startTime">Start Time</th>
                            <th class="col-md-2" data-field="endTime">End Time</th>
                            <th data-field="actions">Options</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ViewBag['punches'] as $punch)
                            <tr>
                                <td>{{ $punch->startTime }}</td>
                                <td>{{ $punch->endTime }}</td>
                                <td><a class="editPunch" href="#" data-id="{{ $punch->id }}" data-work-title-id="{{ $punch->idWorkTitle }}">Edit</a>
                                    <a class="delPunch" href="#" data-id="{{ $punch->id }}">Delete</a></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="addModal" class="lumino modal fade">
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Work Title</h3>

                            <select id="workTitleSelect" name="workTitleSelect" class="form-control dark-border">
                                @foreach ($ViewBag['work_titles'] as $workTitle)

                                    <option value="{{ $workTitle->id }}" @if(old('workTitleSelect'))
                                        @if(old('workTitleSelect') == $workTitle->id)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $workTitle->name . "  " . $workTitle->baseSalary}}</option>
                                @endforeach
                            </select>

                        </div>
                    </div>

                </div>

                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button id="btnAddPunch" type="button" class="btn btn-primary">Add</button>
                </div>

            </div>
        </div>
    </div>

    <div id="editModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                {!! Form::text('idPunch', null, array('style' => 'display:none;visibility:hidden;', 'id' => 'idPunch')) !!}
                {!! Form::text('idWorkTitle', null, array('style' => 'display:none;visibility:hidden;', 'id' => 'idWorkTitle')) !!}
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

                    <div class="col-md-6">
                        <div class="form-group">
                            <h3>Work Title</h3>

                            <select id="workTitleSelect" name="workTitleSelect" class="form-control dark-border">
                                @foreach ($ViewBag['work_titles'] as $workTitle)

                                    <option value="{{ $workTitle->id }}" @if(old('workTitleSelect'))
                                        @if(old('workTitleSelect') == $workTitle->id)
                                            {{ "selected" }}
                                                @endif
                                            @endif >{{ $workTitle->name . "  " . $workTitle->baseSalary}}</option>
                                @endforeach
                            </select>

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

        // Table Object
        $tblPunches = $("#tblPunches");

        // Modal Object
        $addModal = $("#addModal");
        $editModal = $("#editModal");

        // Global Access Variables
        $startTimeCell = null;
        $endTimeCell = null;

        $addModal.find('#startTimePicker').datetimepicker({});
        $addModal.find('#endTimePicker').datetimepicker({});

        $editModal.find('#startTimePicker').datetimepicker({});
        $editModal.find('#endTimePicker').datetimepicker({});

        // Show the Modal
        $("#btnAdd").bind('click', function (e) {

            // On set les values
            $addModal.find("#workTitleSelect" ).val(1);

            $addModal.find('#startTimePicker').data("DateTimePicker").date(moment());
            $addModal.find('#endTimePicker').data("DateTimePicker").date(moment().add(2, 'hours'));

            $addModal.modal('show');
            e.preventDefault();
        })

        // Create the punch
        $("#btnAddPunch").bind('click', function (e) {
            $startTimeMoment = moment($addModal.find("#startTimePicker").data("DateTimePicker").date());
            $endTimeMoment = moment($addModal.find("#endTimePicker").data("DateTimePicker").date());

            $idWorkTitle = $addModal.find("#workTitleSelect option:selected" ).val();
            $idEmployee = $("#idEmployee").val();


            /*  console.log($startTimeMoment);
             console.log($endTimeMoment);
             console.log($idPunch);
             console.log($idWorkTitle);
             console.log($idEmployee);*/

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/punch/create',
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    startTime: $startTimeMoment.format(),
                    endTime: $endTimeMoment.format(),
                    idWorkTitle: $idWorkTitle,
                    idEmployee: $idEmployee
                },
                dataType: 'JSON',
                error: function (xhr, status, error) {
                    console.log(xhr);
                },
                success: function(xhr) {
                    console.log(xhr);

                    if($tblPunches.find('> tbody > tr').length === 1){

                        if($tblPunches.find("> tbody > tr:first").hasClass("no-records-found")){
                            $tblPunches.find("> tbody > tr:first").remove();
                        }
                    }
                    $tblPunches.append("<tr><td>" + $startTimeMoment.format("YYYY-MM-DD HH:mm") +
                            "</td><td>" + $endTimeMoment.format("YYYY-MM-DD HH:mm") + "</td>" +
                            "<td><a class=\"editPunch\" href=\"#\" data-id=\"" + xhr.idPunch + "\" data-work-title-id=\"" + $idWorkTitle + "\">Edit</a>&nbsp;" +
                            "<a class=\"delPunch\" href=\"#\" data-id=\"" + xhr.idPunch + "\">Delete</a></td>" +
                            "</tr>")

                    // Bind events on the options button (Edit, Delete)
                    $lastRow = $tblPunches.find("> tbody > tr:last");
                    $lastRow.find(".editPunch").bind('click', function(e) {
                        EditPunch(this);
                    })
                    $lastRow.find(".delPunch").bind('click', function(e) {
                        DeletePunch(this);
                    })
                    alert(xhr.Message);

                }
            });

            $addModal.modal('hide');
        });

        $('a.editPunch').bind('click', function(e) {

            EditPunch(this);

        });

        function EditPunch(elem){

            $idPunch = $(elem).data("id");
            $idWorkTitle = $(elem).data("work-title-id");
            $selectedRow = $(elem).parent().parent();

            // On set les values
            $editModal.find("#idPunch").val($idPunch);
            $editModal.find("#workTitleSelect" ).val($idWorkTitle);

            $startTimeCell = $selectedRow.find('td:eq(0)');
            $endTimeCell = $selectedRow.find('td:eq(1)');

            $editModal.find('#startTimePicker').data("DateTimePicker").date(moment($startTimeCell.text()));
            $editModal.find('#endTimePicker').data("DateTimePicker").date(moment($endTimeCell.text()));

            $editModal.modal('show');

        }

        $('a.delPunch').bind('click', function(e) {

            DeletePunch(this);

        });

        function DeletePunch(elem) {
            $idPunch = $(elem).data("id");

            $selectedRow = $(elem).parent().parent();

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            if(confirm("Are you sure you want to delete this punch ?")) {
                $.ajax({
                    url: '/punch/delete',
                    type: 'POST',
                    async: true,
                    data: {
                        _token: CSRF_TOKEN,
                        idPunch: $idPunch
                    },
                    dataType: 'JSON',
                    error: function (xhr, status, error) {
                        console.log(xhr);
                    },
                    success: function (xhr) {
                        $selectedRow.remove();
                        if($tblPunches.find('> tbody > tr').length === 0){
                            $tblPunches.append("<tr class=\"no-records-found\"><td colspan=\"3\">No matching records found</td></tr>")
                        }
                        alert(xhr);

                    }
                });
            }
        }

        // Les binds pour ce qui concerne les controles dans les modals.
        $("#btnEditPunch").bind('click', function(e) {


            $startTimeMoment = moment($editModal.find("#startTimePicker").data("DateTimePicker").date());
            $endTimeMoment = moment($editModal.find("#endTimePicker").data("DateTimePicker").date());

            $idPunch = $editModal.find("#idPunch").val();
            $idWorkTitle = $editModal.find("#workTitleSelect option:selected" ).val();
            $idEmployee = $("#idEmployee").val();


          /*  console.log($startTimeMoment);
            console.log($endTimeMoment);
            console.log($idPunch);
            console.log($idWorkTitle);
            console.log($idEmployee);*/

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: '/punch/edit',
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    startTime: $startTimeMoment.format(),
                    endTime: $endTimeMoment.format(),
                    idPunch: $idPunch,
                    idWorkTitle: $idWorkTitle,
                    idEmployee: $idEmployee
                },
                dataType: 'JSON',
                error: function (xhr, status, error) {
                    console.log(xhr);
                },
                success: function(xhr) {
                    $startTimeCell.text($startTimeMoment.format("YYYY-MM-DD HH:mm"));
                    $endTimeCell.text($endTimeMoment.format("YYYY-MM-DD HH:mm"));
                    alert(xhr);

                }
            });

            $editModal.modal('hide');
        })

    });
    </script>


@stop