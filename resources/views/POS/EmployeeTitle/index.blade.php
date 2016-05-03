@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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

                                    <div class="viewShow">
                                        <span><h6 id="emplTitleName" class="hsize">{{ $employeeTitle->name }}</h6> <span id="emplTitleBaseSalary">{{ $employeeTitle->baseSalary}}</span>{{ "/h" }}</span>
                                        <span class="editEmplTitle pull-right glyphicon glyphicon-pencil"></span>
                                    </div>
                                    <div class="viewHide">
                                           <span id="emplTitleId" class="hidden">{{ $employeeTitle->id }}</span>
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


                                        <span class="cancEmplTitle pull-right glyphicon glyphicon glyphicon-remove"></span>
                                        <span class="doneEmplTitle pull-right glyphicon glyphicon-ok"></span>

                                    </div>
                                </div>

                                <div>
                                    <button type="button" class="btn btn-success pull-right">Add Employee</button>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Full Name</th>
                                                    <th>Hire Date</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @if($employeeTitle->cntEmployees != null || count($employeeTitle->cntEmployees) > 0)
                                                @foreach($employeeTitle->cntEmployees as $employee)
                                                    <tr>
                                                        <td>{{ $employeeTitle->id }}</td>
                                                        <td>{{ $employee->firstName . " " . $employee->lastName}}</td>
                                                        <td>{{ $employee->hireDate }}</td>
                                                        <td><a href="#" class="delEmpl pull-right glyphicon glyphicon-trash"></a></td>
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
@stop

@section("myjsfile")
    <script>
        $(document).ready(function(){

            $(".viewHide").hide();


            $(".editEmplTitle").bind("click", function() {
                var parent  = $(this).parent().parent();


                var viewToHide = parent.find(".viewShow");

                var vsTitleName = viewToHide.find("#emplTitleName").text();
                console.log(vsTitleName);

                var vsBaseSalary = viewToHide.find("#emplTitleBaseSalary").text();
                console.log(vsBaseSalary);

                viewToHide.hide();

                var viewToShow = parent.find(".viewHide");

                var inptTitleName = viewToShow.find("#inptTitleName");
                //console.log(inptTitleName);
                inptTitleName.val(vsTitleName);

                var inptBaseSalary = viewToShow.find("#inptBaseSalary");
                inptBaseSalary.val(vsBaseSalary);

                // vs for ViewShow
                viewToShow.show();

            });

            $(".cancEmplTitle").bind("click", function() {
                var parent  = $(this).parent().parent();
                var viewToShow = parent.find(".viewHide");
                viewToShow.hide();

                var viewToHide = parent.find(".viewShow");
                viewToHide.show();

                //console.log(parent);
                //alert("clicked edit");
            });

            $(".doneEmplTitle").bind("click", function() {
                var parent  = $(this).parent().parent();

                var viewToShow = parent.find(".viewHide");

                var inptTitleId = viewToShow.find("#emplTitleId").text();

                var inptTitleName = viewToShow.find("#inptTitleName").val();

                var inptBaseSalary = viewToShow.find("#inptBaseSalary").val();

                // vs for ViewShow
                viewToShow.hide();

                var viewToHide = parent.find(".viewShow");

                viewToHide.find("#emplTitleName").text(inptTitleName);

                viewToHide.find("#emplTitleBaseSalary").text(inptBaseSalary);

                viewToHide.show();


                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var emplTitleId = parseInt(inptTitleId);
                var emplTitleName = inptTitleName
                var emplTitleBaseSalary = inptBaseSalary
                $.ajax({
                    url: '/employee/title/edit',
                    type: 'POST',
                    async: true,
                    data: {
                        _token: CSRF_TOKEN,
                        emplTitleId: emplTitleId,
                        emplTitleName: emplTitleName,
                        emplTitleBaseSalary: emplTitleBaseSalary,
                    },
                    dataType: 'JSON',
                    error: function (xhr, status, error) {
                        var erro = jQuery.parseJSON(xhr.responseText);
                        $("#errors").empty();
                        //$("##errors").append('<ul id="errorsul">');
                        [].forEach.call(Object.keys(erro), function (key) {
                            [].forEach.call(Object.keys(erro[key]), function (keyy) {
                                $("#errors").append('<li class="errors">' + erro[key][keyy][0] + '</li>');
                            });
                            //console.log( key , erro[key] );
                        });
                        //$("#displayErrors").append('</ul>');
                        $("#displayErrors").show();
                    },
                    success: function (xhr) {
                        [].forEach.call(Object.keys(xhr), function (key) {
                            alert(xhr[key]);
                        });
                    }
                });
            });

            $(".delEmplTitle").bind("click", function() {
                var parent  = $(this).parent().parent();
                var viewToShow = parent.find(".viewHide");
                viewToShow.hide();

                var viewToHide = parent.find(".viewShow");
                viewToHide.show();

                //console.log(parent);
                //alert("clicked edit");
            });
        });
    </script>
@stop