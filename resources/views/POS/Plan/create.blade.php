@extends('master')

@section("csrfToken")
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery-ui.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery.ui.rotatable.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery.ui.rotatable.css') }}">
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery-ui.css') }}">
    <script src="{{ @URL::to('js/easyResponsiveTabs.js') }}"></script>
    <script src="{{ @URL::to('Framework/fabric.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ @URL::to('css/easy-responsive-tabs.css') }}"/>
@stop

@section('content')

<div class="row no-fade">
    <div class="panel panel-default">
        <div class="panel-body">

            <div id="displayErrors" style="display:none;" class="alert alert-danger">
                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                <ul id="errors"></ul>
            </div>
            <h3>Plan name: </h3>
            <span id="planName">{{ $ViewBag['planName'] }}</span>
            <h5>Floor Number:</h5>
            <span id="floorNumber">{{ $ViewBag['nbFloor'] }}</span>
            <a class="btn btn-success pull-right" id="btnFinish" href="#"> Create </a>
            <br/>
            <div id="rowCmd">
                <a id="btnNewTable" class="btn btn-primary" href="#"> New Table </a>
                <a id="btnNewPlace" class="btn btn-primary" href="#"> New Place </a>
                <a id="btnNewSeparation" class="btn btn-primary" href="#"> New Separation </a>
                <a class="btn btn-warning" id="btnReOrder" href="#"> Re-order </a>
                <br>
                <br>
                <a class="btn btn-info" id="btnAddWalls" href="#"> Add Walls </a>
                <a class="btn btn-info" id="btnEditWalls" href="#"> Edit Walls </a>{{--
                <a class="btn btn-danger" id="btnCancelEditWalls" href="#">Cancel Edit Walls </a>--}}
                <a class="btn btn-success" id="btnSaveWalls" href="#"> Save Walls </a>
                <a class="btn btn-danger" id="btnDeleteWalls"  href="#"> Delete Walls </a>
                <p id="wall-info"><em>Click near a wall to cut it in half or click inside the walls to add a separation(Rezisable)</em></p>
            </div>
            <br>
            <div id="follower"><span class="glyphicon glyphicon-plus"></span></div>
            <!--Horizontal Tab-->
            <div id="parentHorizontalTab">
                <ul class="resp-tabs-list hor_1">

                </ul>
                <div id="tabControl" class="resp-tabs-container hor_1">

                </div>
            </div>
            <div id="nested-tabInfo">
                Selected tab: <span class="tabName"></span>
                Selected tab ID: <span class="tabItemID"></span>
            </div>

            <div id="editModal" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- dialog body -->
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <div class="col-md-4">
                                <div class="form-group">
                                    {!! Form::label('tblNum', "Table Number" ) !!}
                                    {!! Form::text('tblNum', null, array('class' => 'form-control', 'id' => 'tblNum')) !!}
                                </div>
                            </div>
                        </div>

                        <!-- dialog buttons -->
                        <div class="modal-footer">
                            <button id="btnDelTable" type="button" class="btn btn-danger">Delete</button>
                            <button id="btnEditTable" type="button" class="btn btn-primary">Edit</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop


@section('myjsfile')
    <script src="{{ @URL::to('js/planTabs.js') }}"></script>
    <script>
        var totalTables = 0;
        $("#btnFinish").click(function () {
            var tblContainers = $(".tablesContainer .tables");
            var listItems = $("#tabControl").find(tblContainers);
            var $arrayFloorTable = [],
            $arrayFloorSep = [];

            for ($i = 0; $i < listItems.length; $i++) {
                $liSubItems = $(listItems[$i]).find("li");

                for ($j = 0; $j < $liSubItems.length; $j++) {
                    //$arrayFloorTable.push()
                    $parsedliSubItem = $($liSubItems[$j]);
                    //var offset = $parsedliSubItem.offset();

                    $xPos = $parsedliSubItem.find("#posX").text();
                    $yPos = $parsedliSubItem.find("#posY").text();
                    console.log($xPos);

                    var txtRaw = $parsedliSubItem[0].style.transform;
                    var radValReg = /\((.*)\)/;
                    var radVal = 0;
                    if (txtRaw != null && txtRaw.trim() != "") {
                        if (txtRaw.match(radValReg)[1] != null) {
                            radVal = txtRaw.match(radValReg)[1];
                        }
                    } else {
                        radVal = 0;
                    }
                    var $tabNum = parseInt($parsedliSubItem.find("#tableNumber").text()),
                    $typeChr = "";
                    if ($parsedliSubItem.hasClass("tbl")) {
                        $typeChr = "tbl"
                    } else if ($parsedliSubItem.hasClass("plc")) {
                        $typeChr = "plc"
                    } else {
                        $typeChr = "sep"
                    }
                    var objTable = {
                        tblType: $typeChr,
                        tblNum: $tabNum,
                        noFloor: $i,
                        xPos: $xPos,
                        yPos: $yPos,
                        angle: radVal
                    };

                    if($typeChr == "sep")
                    {
                        var objSep = objTable;
                        objSep.w = $parsedliSubItem.css('width');
                        objSep.h = $parsedliSubItem.css('height');

                        $arrayFloorSep.push(objSep);
                    }
                    else {
                        $arrayFloorTable.push(objTable);
                    }

                }

            }

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


            var nbFloor = $("#floorNumber").text();
            var planName = $("#planName").text();
            $.ajax({
                url: '/plan/create',
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    planName: planName,
                    nbFloor: nbFloor,
                    wallPoints: getWalls(),
                    tables: JSON.stringify($arrayFloorTable),
                    separations: JSON.stringify($arrayFloorSep)
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
                        window.location.replace("/plan");
                    });
                }
            });

            console.log(JSON.stringify($arrayFloorTable))
        });
        $("#btnEditTable").click(function () {
            $tblNumEdit = $('#editModal #tblNum').val();
            $oTableNum = $(globEditTable).text($tblNumEdit);
        });
        $("#btnDelTable").click(function () {

        });

        //$(".tablesContainer ul li").rotatable(rotateParams);
        //$(".tablesContainer ul li").draggable(dragParams);
    </script>
    <script type="text/javascript">
        $(document).ready(function () {
            var TabNumber = 0;
            var intNbFloor = parseInt($("#floorNumber").text());
            if (intNbFloor >= 1) {
                for (var i = 1; i <= intNbFloor; i++) {
                    $("#parentHorizontalTab .resp-tabs-list").append("<li class=\"resp-tab-item hor_1\" aria-controls=\"hor_1_tab_item-" + TabNumber + "\" role=\"tab\" style=\"border-color: rgb(193, 193, 193); background-color: rgb(255, 255, 255);\">Floor No. " + i + "</li>");
                    $("#tabControl").append("<div class=\"tablesContainer\"><ul class=\"tables\"></ul></div>");
                }
                $('#parentHorizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true, // 100% fit in a container
                    tabidentify: 'hor_1', // The tab groups identifier
                    activate: function (event) { // Callback function if tab is switched

                        var $tab = $(this);
                        var $info = $('#nested-tabInfo');
                        var $name = $('.tabName', $info);

                        var $tabItemID = $('.tabItemID', $info);
                        $name.text($tab.text());

                        $tabItemID.text($tab.attr("aria-controls").toString())
                        $info.show();
                    }
                });
            } else {
                alert("The floor number must be greater than 0");
            }



         /*   $('.resp-tab-item').append('<li class="resp-tab-item" style="border-color: rgb(193, 193, 193); background-color: rgb(245, 245, 245);">Floor No. 2</li>')
*/

            stateHasNoWall();
        });

        $('#sidebar-collapse').delay(50).animate({width: 0}, 200);
        $('.col-sm-9.col-sm-offset-3.col-lg-10.col-lg-offset-2').delay(50).animate({width: '100%', marginLeft: 0, position: 'absolute'}, 200)

    </script>
@stop