@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{ @URL::to('js/jquery/jquery-ui.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery-ui.css') }}"/>


    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Statistics</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">


                </div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script>
        $(document).ready(function(){

            $(".viewHide").hide();

            $(".btnAddEmployee").bind("click", function() {
                //alert();
                $("#frmTitleId").val($(this).attr("data-emplTitleId"));
                $("#addModal").modal('show');
            });

            var delEmployee = function(lethis) {

                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var parentParent = $(lethis).parent().parent();

                var titleEmployee = parentParent.find("td").eq(0).text();

                $.ajax({
                    url: '/work/title/del/employee',
                    type: 'DELETE',
                    async: true,
                    data: {
                        _token: CSRF_TOKEN,
                        titleEmployeeId: titleEmployee
                    },
                    dataType: 'JSON',
                    error: function (xhr, status, error) {
                        var erro = jQuery.parseJSON(xhr.responseText);
                        console.log(erro);
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
                        parentParent.remove();
                        [].forEach.call(Object.keys(xhr), function (key) {
                            alert(xhr[key]);
                        });
                    }
                });

            };

            $(".delEmpl").bind("click", function() {
                delEmployee(this);
            });


            $("#frmBtnAddEmpl").bind("click", function() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var emplId =  $("#employeeSelect").val();
                var emplTitleId = $("#frmTitleId").val();
                $.ajax({
                    url: '/work/title/add/employee',
                    type: 'POST',
                    async: true,
                    data: {
                        _token: CSRF_TOKEN,
                        emplTitleId: emplTitleId,
                        emplId: emplId
                    },
                    dataType: 'JSON',
                    error: function (xhr, status, error) {
                        var erro = jQuery.parseJSON(xhr.responseText);
                        console.log(erro);
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
                            var jsonTitleEmplObj = JSON.parse(xhr[key]["titleEmployee"]);
                            $("#tbl-" + emplTitleId).append('<tr><td>' + jsonTitleEmplObj['id'] +
                                    '</td><td>' + jsonTitleEmplObj['fullName'] +
                                    '</td><td>' + jsonTitleEmplObj['hireDate'] +
                                    '<td><a href="#" class="delEmpl pull-right glyphicon glyphicon-remove"></a></td>' +
                                    '</td></tr>');

                            $(".delEmpl").bind("click", function() {
                                delEmployee(this);
                            });

                            $("#addModal").modal('hide');
                            alert(xhr[key]["success"]);

                        });
                    }
                });
            });

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
                var emplTitleName = inptTitleName;
                var emplTitleBaseSalary = inptBaseSalary;


                $.ajax({
                    url: '/work/title/edit',
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