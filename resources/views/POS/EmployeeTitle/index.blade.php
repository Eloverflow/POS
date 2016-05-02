@extends('master')
@section('csrfToken')
    <link rel="stylesheet" href="{{ @URL::to('css/employeeTitles.css') }}"/>
    <script>

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
                    <table id="employeeTitles" class="table">
                        <thead>
                        <tr>
                            <th class="hidden" >Item ID</th>
                            <th style="width:40px"></th>
                            <th>Title Name</th>
                            <th>Base Salary</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>

                        @foreach ($ViewBag['employeeTitles'] as $employeeTitle)
                            <tr>
                                <td class="hidden">{{ $employeeTitle->id }}</td>
                                <td data-shown="false" class="rowExp"><svg style="width:30px;height:30px;" class="glyph stroked eye"><use xlink:href="#stroked-eye"/></svg></td>
                                <td>{{ $employeeTitle->name }}</td>
                                <td>{{ $employeeTitle->baseSalary }}</td>
                                <td><a href="{{ URL::to('employee/title/edit', $employeeTitle->id) }}">Edit</a>
                                    <a href="{{ URL::to('employee/title/delete', $employeeTitle->id) }}">Delete</a></td>
                            </tr>
                            <tr >
                                <td colspan="5">
                                    <h2>This is title</h2>
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

@section("myjsfile")
    <script>
        $(document).ready(function(){

            var element = $("#employeeTitles");
            $(element).find("tr:odd").addClass("odd");
            /*$(element).find("tr:not(.odd)").hide();*/
            //$(element).find("tr:not(.odd)").css({"height": "0px"});
            //$(element).find("tr:not(.odd) td").css({"height": "0px"});
            $(element).find("tr:not(.odd) td").children().hide();
            $(element).find("tr:not(.odd) td").css({"padding": "0px"});


            $(element).find("tr:first-child").show();

            $(".rowExp").bind("click", function() {

                $dataShownValue = $(this).attr("data-shown");
                $parentRowButton = $(this).parent();
                $nextRowOdd = $parentRowButton.closest('tr').next('tr')

                if($dataShownValue == "true"){
                    $nextRowOdd.animate(
                            {"height": "0px"},
                            "fast");
                    $nextRowOdd.find("td").children().hide();

                    $(this).attr("data-shown","false");
                } else if($dataShownValue == "false") {
                    $nextRowOdd.find("td").children().show();
                    /*
                     $nextRowOdd.slideUp(0);*/
                    $nextRowOdd.animate(
                            {"height": "auto"},
                            "slow");

                    $(this).attr("data-shown","true");
                }

                //$("#employeeTitles").next("tr").toggle();
            });
        });
    </script>
@stop