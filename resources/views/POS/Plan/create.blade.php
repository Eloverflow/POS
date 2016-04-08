@extends('POS.Punch.mainLayout')

@section("csrfToken")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/jquery-ui.js') }}"></script>
    <script src="{{ @URL::to('js/jquery.ui.rotatable.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('js/jquery.ui.rotatable.css') }}">
    <link rel="stylesheet" href="{{ @URL::to('js/jquery-ui.css') }}">
@stop

@section('content')
    <div id="rowCmd"><a id="btnNewTable" href="#">New Table</a> | <a id="btnNewPlace" href="#">New Place</a> | <a id="btnNewSeparation" href="#">New Separation</a></div>
    <div id="tablesContainer">

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
@stop

@section('myjsfile')
    <script>
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
        $("#btnNewSeparation").click(function() {
            $tableGUID = guid();
            $("#tablesContainer .tables").append('<li class="draggable sep" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).resizable().rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewPlace").click(function() {
            $tableGUID = guid();
            $("#tablesContainer .tables").append('<li class="draggable plc" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });
        $("#btnNewTable").click(function() {
            $tableGUID = guid();
            $("#tablesContainer .tables").append('<li class="draggable tbl" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
            $('#' + $tableGUID).rotatable(rotateParams);
            $('#' + $tableGUID).draggable(dragParams);
        });

        $("li").rotatable(rotateParams);
        $("li").draggable(dragParams);
    </script>
@stop