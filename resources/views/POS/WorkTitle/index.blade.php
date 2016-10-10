@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ @URL::to('js/jquery/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery-ui.css') }}"/>
    <link rel="stylesheet" href="{{ @URL::to('css/employeeTitles.css') }}"/>
    <script>
        $(function() {
            $( "#accordion" ).accordion();
        });
    </script>
    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Work Titles</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a id="btnCreateNew" class="btn btn-primary pull-right" href="#"> Create New </a>
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
                        <div id="accordion">
                            @foreach ($ViewBag['workTitles'] as $workTitle)
                                <div>

                                    <div class="viewShow">
                                        <div class="groupHeader"><h6 id="emplTitleName" class="hsize">{{ $workTitle->name }}</h6> <span id="emplTitleBaseSalary" class="secondInfo"><p class="textCase">{{ $workTitle->baseSalary}}</p><p class="hcase">h</p> </span></div>
                                        <span class="editEmplTitle pull-right glyphicon glyphicon-pencil"></span>
                                    </div>
                                    <div class="viewHide">
                                           <span id="emplTitleId" class="hidden">{{ $workTitle->emplTitleId }}</span>
                                           <div class="cont-block">
                                                <label for="emplTitleName">Title Name :</label>
                                                <br />
                                                <input id="inptTitleName" class="form-control inpt-bar in-Title" type="text" name="emplTitleName">
                                           </div>

                                           <div class="cont-block">
                                                <label for="emplTitleName">Base Salary :</label>
                                                <br />
                                                <input id="inptBaseSalary" class="form-control inpt-bar in-BSalary" type="text" name="emplTitleBaseSalary">
                                           </div>


                                        <span class="btnCancel pull-right glyphicon glyphicon glyphicon-remove"></span>
                                        <a id="btn-confirm-work-title"><span class="btnOk pull-right glyphicon glyphicon-ok"></span></a>

                                    </div>
                                </div>

                                <div>
                                    <a id="btn-add-employee" data-emplTitleId="{{ $workTitle->emplTitleId }}" type="button" class="btn btn-success pull-right btnAddEmployee">Add Employee</a>
                                        <table id="tbl-{{ $workTitle->emplTitleId }}" class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Hire Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if($workTitle->cntEmployees != null || count($workTitle->cntEmployees) > 0)
                                                @foreach($workTitle->cntEmployees as $employee)
                                                    <tr>
                                                        <td>{{ $employee->idTitleEmployee }}</td>
                                                        <td>{{ $employee->firstName . " " . $employee->lastName}}</td>
                                                        <td>{{ $employee->hireDate }}</td>
                                                        <td><a href="#" class="delEmpl pull-right glyphicon glyphicon-remove"></a></td>
                                                    </tr>
                                                @endforeach
                                            @endif
                                            </tbody>
                                        </table>
                                </div>

                            @endforeach
                        </div>

                </div>
            </div>
        </div>
    </div>

    <div id="addModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                {!! Form::text('frmTitleId', null, array('class' => 'form-control', 'id' => 'frmTitleId', 'style' => 'display:none;visibility:hidden;')) !!}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Select Employee</h4>
                </div>

                <div class="row">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <h3></h3>
                            <select id="employeeSelect" name="employeeSelect" class="form-control">
                                @foreach ($ViewBag['employees'] as $employee)
                                    <option value="{{ $employee->idEmployee }}">{{ $employee->firstName . " " . $employee->lastName }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                <!-- dialog buttons -->
                <div class="modal-footer"><a id="frmBtnAddEmpl" type="button" class="btn btn-primary">Add</a></div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/workTitlesManage.js') }}"></script>
@stop