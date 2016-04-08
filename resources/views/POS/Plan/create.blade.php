@extends('POS.Punch.mainLayout')

@section("csrfToken")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/jquery-ui.js') }}"></script>
    <script src="{{ @URL::to('js/jquery.ui.rotatable.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('js/jquery.ui.rotatable.css') }}">
    <link rel="stylesheet" href="{{ @URL::to('js/jquery-ui.css') }}">
    <script src="{{ @URL::to('js/easyResponsiveTabs.js') }}"></script>
    <script src="{{ @URL::to('js/planTabs.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ @URL::to('css/easy-responsive-tabs.css') }}" />
@stop

@section('content')

    <h2>Horizontal Tab with (Nested Tabs) </h2>
    <h3>Plan name: {{ $ViewBag['planName'] }}</h3>
    <span>Floor Number: {{ $ViewBag['nbFloor'] }}</span>
    <br/>
    <a id="btnNewTab" href="#">New Tab</a>
    <div id="rowCmd"><a id="btnNewTable" href="#">New Table</a> | <a id="btnNewPlace" href="#">New Place</a> | <a id="btnNewSeparation" href="#">New Separation</a></div>
    <!--Horizontal Tab-->
    <div id="parentHorizontalTab">
        <ul class="resp-tabs-list hor_1">

        </ul>
        <div id="tabControl" class="resp-tabs-container hor_1">
            <div class="tablesContainer">
                <ul class="tables">
                    <li class="draggable tbl" id="user_1">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                    <li class="draggable tbl" id="user_2">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                </ul>
            </div>
            <div class="tablesContainer">
                <ul class="tables">
                    <li class="draggable tbl" id="user_1">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                    <li class="draggable tbl" id="user_2">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                </ul>
            </div>
            <div class="tablesContainer">
                <ul class="tables">
                    <li class="draggable tbl" id="user_1">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                    <li class="draggable tbl" id="user_2">
                        <span id="posX"></span>
                        <span id="posY"></span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div id="nested-tabInfo">
        Selected tab: <span class="tabName"></span>
    </div>


@stop

@section('myjsfile')
    <script>
        var globTabNumber = 0;
        var rotateParams = {
            start: function(event, ui) {
                console.log("Rotating started");
            },
            rotate: function(event, ui) {
                console.log("Rotating");
            },
            stop: function(event, ui) {
                console.log("Rotating stopped");
            },
        };
        var dragParams = {
            containment: "parent",
            drag: function(){
                var offset = $(this).offset();
                var xPos = offset.left;
                var yPos = offset.top;
                $(this).find('#posX').text('x: ' + xPos.toFixed(0));
                $(this).find('#posY').text('y: ' + yPos.toFixed(0));
            }
        };
        $("#btnNewTab").click(function() {
            $("#parentHorizontalTab .resp-tabs-list").append("<li class=\"resp-tab-item hor_1 resp-tab-active\" aria-controls=\"hor_1_tab_item-"+ globTabNumber +"\" role=\"tab\" style=\"border-color: rgb(193, 193, 193); background-color: rgb(255, 255, 255);\">Horizontal PEN</li>");
            $("#tabControl").append("<div id=\"tablesContainer\"><ul class=\"tables\"></ul></div>");
            globTabNumber += 1;
        });
        $("#btnNewSeparation").click(function() {
            $tableGUID = guid();
            $(".tablesContainer .tables").append('<li class="draggable sep" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).resizable().rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewPlace").click(function() {
            $tableGUID = guid();
            $(".tablesContainer .tables").append('<li class="draggable plc" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewTable").click(function() {
            $tableGUID = guid();
            $(".tablesContainer .tables").append('<li class="draggable tbl" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });

        $(".tablesContainer ul li").rotatable(rotateParams);
        $(".tablesContainer ul li").draggable(dragParams);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            //Horizontal Tab
            $('#parentHorizontalTab').easyResponsiveTabs({
                type: 'default', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                tabidentify: 'hor_1', // The tab groups identifier
                activate: function(event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#nested-tabInfo');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });

            // Child Tab
            $('#ChildVerticalTab_1').easyResponsiveTabs({
                type: 'vertical',
                width: 'auto',
                fit: true,
                tabidentify: 'ver_1', // The tab groups identifier
                activetab_bg: '#fff', // background color for active tabs in this group
                inactive_bg: '#F5F5F5', // background color for inactive tabs in this group
                active_border_color: '#c1c1c1', // border color for active tabs heads in this group
                active_content_border_color: '#5AB1D0' // border color for active tabs contect in this group so that it matches the tab head border
            });

            //Vertical Tab
            $('#parentVerticalTab').easyResponsiveTabs({
                type: 'vertical', //Types: default, vertical, accordion
                width: 'auto', //auto or any width like 600px
                fit: true, // 100% fit in a container
                closed: 'accordion', // Start closed if in accordion view
                tabidentify: 'hor_1', // The tab groups identifier
                activate: function(event) { // Callback function if tab is switched
                    var $tab = $(this);
                    var $info = $('#nested-tabInfo2');
                    var $name = $('span', $info);
                    $name.text($tab.text());
                    $info.show();
                }
            });
        });
    </script>
@stop