@extends('master')
@section('csrfToken')
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
            <h1 class="page-header">Employee Titles</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('employee/title/create') }}"> Create New </a>
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
                            @foreach ($ViewBag['employeeTitles'] as $employeeTitle)
                                <div>
                                    <span class="hidden">{{ $employeeTitle->id }}</span>
                                    <span class="viewShow">
                                        <span><h6 class="hsize"><strong>{{ $employeeTitle->name }}</strong></h6> <span class="btn btn-default">{{ $employeeTitle->baseSalary . "/h"}}</span></span>
                                        <span class="delEmplTitle pull-right glyphicon glyphicon-trash"></span>
                                        <span class="editEmplTitle pull-right glyphicon glyphicon-pencil"></span>
                                    </span>
                                    <span class="viewHide">
                                        <span>{!! Form::text('employeeTitle', $employeeTitle->name, array('class' => 'form-control')) !!}
                                            {!! Form::text('employeeTitle', $employeeTitle->baseSalary, array('class' => 'form-control')) !!}</span>
                                        <span class="cancEmplTitle pull-right glyphicon glyphicon glyphicon-remove"></span>
                                        <span class="doneEmplTitle pull-right glyphicon glyphicon-ok"></span>
                                    </span>
                                </div>

                                <div>
                                    @if($employeeTitle->cntEmployees != null || count($employeeTitle->cntEmployees) > 0)
                                        <table>
                                            <tr>
                                                <th>Id</th>
                                                <th>Full Name</th>
                                                <th>Hire Date</th>
                                            </tr>
                                            @foreach($employeeTitle->cntEmployees as $employee)
                                                <tr>
                                                    <td>{{ $employeeTitle->id }}</td>
                                                    <td>{{ $employee->firstName . " " . $employee->lastName}}</td>
                                                    <td>{{ $employee->hireDate }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>

                            @endforeach
                        </div>

                </div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script>
        $(document).ready(function(){
            $(".editEmplTitle").bind("click", function() {
                var parent  = $(this).parent();
                console.log(parent);
                //alert("clicked edit");
            });


        });
    </script>
@stop