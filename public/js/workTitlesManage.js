/**
 * Created by isaelblais on 7/21/2016.
 */
$(document).ready(function(){

    $(".viewHide").hide();

    var isCreatingNew = false;

    $("#btnCreateNew").bind('click', function () {

        if(isCreatingNew == false) {
            $("#accordion").prepend('<div id="newWorkTitle">' +
                '<div class="viewShow">' +
                '<div class="groupHeader"><h6 id="emplTitleName" class="hsize"></h6> <span id="emplTitleBaseSalary" class="secondInfo"><p class="textCase"></p><p class="hcase">h</p></span></div>' +
                '<span class="editEmplTitle pull-right glyphicon glyphicon-pencil"></span>' +
                '</div>' +
                '<div class="viewHide">' +
                '<span id="emplTitleId" class="hidden"></span>' +
                '<div class="cont-block">' +
                '<label for="emplTitleName">Title Name :</label>' +
                '<br />' +
                '<input id="inptTitleName" class="form-control inpt-bar in-Title dark-border" type="text" name="emplTitleName">' +
                '</div>&nbsp;' +
                '<div class="cont-block">' +
                '<label for="emplTitleName">Base Salary :</label>' +
                '<br />' +
                '<input id="inptBaseSalary" class="form-control inpt-bar in-BSalary dark-border" type="text" name="emplTitleBaseSalary">' +
                '</div>' +
                '<span class="btnCancel pull-right glyphicon glyphicon glyphicon-remove"></span>' +
                '<a id="btn-confirm-work-title">' +
                '<span class="btnOk pull-right glyphicon glyphicon-ok"></span>' +
                '</a>' +
                '</div>' +
                '</div>' +
                '<div id="newWorkTitleContent">' +
                '<button data-emplTitleId="0" type="button" class="btn btn-success pull-right btnAddEmployee">Add Employee</button>' +
                '<table id="tbl-0" class="table">' +
                '<thead>' +
                '<tr>' +
                '<th>#</th>' +
                '<th>Full Name</th>' +
                '<th>Hire Date</th>' +
                '<th></th>' +
                '</tr>' +
                '</thead>' +
                '<tbody>' +
                '</tbody>' +
                '</table>' +
                '</div>');

            $("#accordion").accordion("refresh");



            // The new htmlObject
            var newObj = $("#newWorkTitle");
            var viewToHide = newObj.find(".viewShow");
            var viewToShow = newObj.find(".viewHide");

            viewToHide.hide();

            var inputTitleName = viewToShow.find("#inptTitleName");
            inputTitleName.focus();

            var index = $('#accordion').find('div').index( $('#accordion').find('#newWorkTitle') );
            $("#accordion").accordion({
                active : index
            });

            newObj.find(".btnOk").bind("click", function() {
                createWorkTitle(this);
            });

            newObj.find(".btnCancel").bind("click", function() {
                if(confirm("Are you sure you want to cancel creating new work title ?")) {
                    CancelNewGroupItem();
                }
            });

            newObj.find(".editEmplTitle").bind("click", function() {
                editGroup(this);
            });

            isCreatingNew = true;
        } else {
            alert("Please finish creating the current work title !");
        }
    });

    // Les binds au depart de la plage

    $(".btnAddEmployee").bind("click", function() {
        $("#frmTitleId").val($(this).attr("data-emplTitleId"));
        $("#addModal").modal('show');
    });

    $(".delEmpl").bind("click", function() {
        delEmployee(this);
    });

    $(".editEmplTitle").bind("click", function() {
        editGroup(this);
    });

    $(".btnCancel").bind("click", function() {
        cancelEditGroup(this);
    });

    $(".btnOk").bind("click", function() {
        okEditGroup(this);
    });
    // Find des binds au depart de la page


    var CancelNewGroupItem = function(){

        var accordion = $("#accordion");

        accordion.find("#newWorkTitle").fadeOut('fast', function() {
            $(this).remove();
        });
        accordion.find("#newWorkTitleContent").fadeOut('fast', function() {
            $(this).remove();
        });

        isCreatingNew = false;

        accordion.accordion("refresh");
    };

    var createWorkTitle = function(elem){

        $viewHide = $(elem).parent().parent();

        var inptTitleName = $viewHide.find("#inptTitleName").val();

        var inptBaseSalary = parseFloat($viewHide.find("#inptBaseSalary").val());

        // vs for ViewShow
        $viewHide.hide();

        $viewShow = $viewHide.parent().find(".viewShow");

        $viewShow.find("#emplTitleName").text(inptTitleName);

        $viewShow.find("#emplTitleBaseSalary .textCase").text(inptBaseSalary.toFixed(2));

        $viewShow.show();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        $.ajax({
            url: '/work/title/create',
            type: 'POST',
            async: true,
            data: {
                _token: CSRF_TOKEN,
                emplTitleName: inptTitleName,
                emplTitleBaseSalary: inptBaseSalary
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
                    var workTitleId = xhr[key]["workTitleId"];

                    var groupContent =  $("#newWorkTitleContent");

                    $viewShow.find(".editEmplTitle").unbind();
                    $viewShow.find(".editEmplTitle").bind("click", function() {
                        editGroup(this);
                    });

                    $btnOk =  $viewShow.find(".btnOk");
                    $btnCancel = $viewShow.find(".btnCancel");

                    $btnOk.unbind();
                    $btnOk.bind("click", function(){
                        okEditGroup($(this).parent().parent());
                    });

                    $btnCancel.unbind();
                    $btnCancel.bind("click", function(){
                        cancelEditGroup(this);
                    });

                    groupContent.find(".btnAddEmployee").bind("click", function() {
                        //alert();
                        $("#frmTitleId").val($(this).attr("data-emplTitleId"));
                        $("#addModal").modal('show');
                    });


                    groupContent.find('.btnAddEmployee').attr("data-emplTitleId", workTitleId);

                    $viewShow.find("#emplTitleId").text(workTitleId);

                    groupContent.find("tbl-0").attr("id", workTitleId);

                    $viewShow.removeAttr('id');
                    groupContent.removeAttr('id');

                    $("#accordion").accordion("refresh");

                    isCreatingNew = false;
                    alert(xhr[key]["success"]);

                });
            }
        });
    };

    var okEditGroup = function(elem){

        $viewHide = $(elem).parent().parent();

        var inptTitleId = $viewHide.find("#emplTitleId").text();

        var inptTitleName = $viewHide.find("#inptTitleName").val();

        var inptBaseSalary = $viewHide.find("#inptBaseSalary").val();


        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var emplTitleId = parseInt(inptTitleId);
        var emplTitleName = inptTitleName;
        var emplTitleBaseSalary = inptBaseSalary;

        console.log(inptTitleId);
        console.log(emplTitleName);
        console.log(emplTitleBaseSalary);

        if(ValidateWorkTitleForm(elem)) {
            // vs for ViewShow
            $viewHide.hide();

            $viewShow = $viewHide.parent().find(".viewShow");

            $viewShow.find("#emplTitleName").text(inptTitleName);

            $viewShow.find(".textCase").text(inptBaseSalary);

            $viewShow.show();


            $.ajax({
                url: '/work/title/edit',
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    emplTitleId: emplTitleId,
                    emplTitleName: emplTitleName,
                    emplTitleBaseSalary: emplTitleBaseSalary
                },
                dataType: 'JSON',
                error: function (xhr, status, error) {
                    console.log(xhr);
                },
                success: function (xhr) {
                    [].forEach.call(Object.keys(xhr), function (key) {
                        alert(xhr[key]);
                    });
                }
            });
        }
    };

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


    $("#frmBtnAddEmpl").bind("click", function() {
        var emplId =  $("#employeeSelect").val();
        var emplTitleId = $("#frmTitleId").val();

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

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

    var editGroup = function(lethis) {
        var parent = $(lethis).parent().parent();


        var viewToHide = parent.find(".viewShow");

        var vsTitleName = viewToHide.find("#emplTitleName").text();
        console.log(vsTitleName);

        var vsBaseSalary = viewToHide.find("#emplTitleBaseSalary").find(".textCase").text();
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
    };


    var cancelEditGroup = function(elem) {

        $viewHide = $(elem).parent();
        $viewShow = $viewHide.parent().find(".viewShow");


        $inputTitleName = $viewHide.find("#inptTitleName");
        $inputBaseSalary = $viewHide.find("#inptBaseSalary");

        $errorContainer = $viewHide.find("#displayErrors");
        $errorsList = $errorContainer.find("#errors");

        // On nettoie les trace de la validation presente si le cas
        $inputBaseSalary.parent().removeClass('has-error');
        $inputTitleName.parent().removeClass('has-error');
        $errorsList.empty();
        $errorContainer.hide();

        /*console.log($viewShow);
        console.log("Sep -------");
        console.log($viewHide);*/
        $viewHide.hide();
        $viewShow.show();

    };


    function ValidateWorkTitleForm(elem) {

        $isValid = true;

        $viewHide = $(elem).parent().parent();
        $inputTitleName = $viewHide.find("#inptTitleName");
        $inputBaseSalary = $viewHide.find("#inptBaseSalary");

        $errorContainer = $viewHide.find("#displayErrors");
        $errorsList = $errorContainer.find("#errors");

        // On nettoie les trace de la validation presente si le cas
        $inputBaseSalary.parent().removeClass('has-error');
        $inputTitleName.parent().removeClass('has-error');
        $errorsList.empty();

        /*var inptTitleId = $viewHide.find("#emplTitleId").text();*/

        var inptTitleName = $inputTitleName.val();

        var inptBaseSalary = parseFloat($inputBaseSalary.val());



        if(!$.isNumeric(inptBaseSalary)){
            $errorsList.append("<li>The salary is required !</li>");
            $inputBaseSalary.parent().addClass('has-error');
            $isValid = false;
        } else {
            if(inptBaseSalary < 0){
                $errorsList.append("<li>The salary must be positive !</li>");
                $inputBaseSalary.parent().addClass('has-error');
                $isValid = false;
            }
        }

        if(inptTitleName == ''){
            $errorsList.append("<li>The Job title is required !</li>");
            $inputTitleName.parent().addClass('has-error');
            $isValid = false;
        }

        if($isValid){
            $errorsList.empty();
            $errorContainer.hide();
        } else {
            $errorContainer.show();
        }
        return $isValid;

    }

});
