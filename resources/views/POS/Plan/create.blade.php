@extends('workerLayout')

@section("csrfToken")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery-ui.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery.ui.rotatable.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery.ui.rotatable.css') }}">
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery-ui.css') }}">
    <script src="{{ @URL::to('js/easyResponsiveTabs.js') }}"></script>
    <script src="{{ @URL::to('js/planTabs.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ @URL::to('css/easy-responsive-tabs.css') }}" />
@stop

@section('content')
    <h3>Plan name: </h3>
    <span id="planName">{{ $ViewBag['planName'] }}</span>
    <h5>Floor Number:</h5>
    <span id="floorNumber">{{ $ViewBag['nbFloor'] }}</span>
    <a class="btn btn-success pull-right" id="btnFinish" href="#"> Create </a>
    <br/>
    <div id="rowCmd"><a id="btnNewTable" href="#">New Table</a> | <a id="btnNewPlace" href="#">New Place</a> | <a id="btnNewSeparation" href="#">New Separation</a></div>
    <!--Horizontal Tab-->
    <div id="parentHorizontalTab">
        <ul class="resp-tabs-list hor_1">

        </ul>
        <div id="tabControl" class="resp-tabs-container hor_1">

        </div>
    </div>
    <div id="nested-tabInfo">
        Selected tab:       <span class="tabName"></span>
        Selected tab ID:    <span class="tabItemID"></span>
    </div>

@stop

@section('myjsfile')
    <script>
        var globTabNumber = 1;
        $('#target2').rotatable(); $('#draggable2').draggable();
        var rotateParams = {
            start: function(event, ui) {
                console.log("Rotating started");
            },
            rotate: function(event, ui) {
                console.log("Rotating");
            },
            stop: function(event, ui) {
                console.log("Rotating stopped");
            }
        };
        var dragParams = {
            containment: "parent",
            drag: function(){
                // Find the parent
                var tablesContainer = $(this).parent();
                var tablesContainerPos = tablesContainer.offset();

                var tblContainerXPos = tablesContainerPos.left;
                var tblContainerYPos = tablesContainerPos.top;
                //console.log("X: " + tblContainerXPos + " Y: " + tblContainerYPos);

                var offset = $(this).position();
                var xPos = offset.left;
                var yPos = offset.top;
                $(this).find('#posX').text('x: ' + xPos.toFixed(0));
                $(this).find('#posY').text('y: ' + yPos.toFixed(0));
            }
        };
        $("#btnNewSeparation").click(function() {
            $tableGUID = guid();
            var $info = $('#nested-tabInfo');
            var $tabItemID = $('.tabItemID', $info);
            var $tabControl = $("#tabControl");

            $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable sep" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');

            $('#' + $tableGUID).resizable().rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewPlace").click(function() {
            $tableGUID = guid();
            var $info = $('#nested-tabInfo');
            var $tabItemID = $('.tabItemID', $info);
            var $tabControl = $("#tabControl");

            $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable plc" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');

            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewTable").click(function() {
            $tableGUID = guid();
            var $info = $('#nested-tabInfo');
            var $tabItemID = $('.tabItemID', $info);
            var $tabControl = $("#tabControl");
            /*style="position:absolute; top: ' + 0 +'px; left: ' + 120 + 'px;"*/
            $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable tbl" ' + 'id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            //$(".tablesContainer .tables").append('<li class="draggable tbl" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });

        $(".tablesContainer ul li").rotatable(rotateParams);
        $(".tablesContainer ul li").draggable(dragParams);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {

            var intNbFloor = parseInt($("#floorNumber").text());
            if(intNbFloor >= 1){
                for(var i = 1; i <= intNbFloor; i++){
                    $("#parentHorizontalTab .resp-tabs-list").append("<li class=\"resp-tab-item hor_1\" aria-controls=\"hor_1_tab_item-"+ globTabNumber +"\" role=\"tab\" style=\"border-color: rgb(193, 193, 193); background-color: rgb(255, 255, 255);\">Floor No. " + i + "</li>");
                    $("#tabControl").append("<div class=\"tablesContainer\"><ul class=\"tables\"></ul></div>");
                }
                $('#parentHorizontalTab').easyResponsiveTabs({
                    type: 'default', //Types: default, vertical, accordion
                    width: 'auto', //auto or any width like 600px
                    fit: true, // 100% fit in a container
                    tabidentify: 'hor_1', // The tab groups identifier
                    activate: function(event) { // Callback function if tab is switched

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

        });
    </script>
@stop