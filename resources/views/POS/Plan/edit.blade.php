@extends('workerLayout')

@section("csrfToken")
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery-ui.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery.ui.rotatable.js') }}"></script>
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery.ui.rotatable.css') }}">
    <link rel="stylesheet" href="{{ @URL::to('css/jquery/jquery-ui.css') }}">
    <script src="{{ @URL::to('js/easyResponsiveTabs.js') }}"></script>
    <script src="{{ @URL::to('Framework/fabric.js') }}"></script>
    <script src="{{ @URL::to('js/planTabs.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ @URL::to('css/easy-responsive-tabs.css') }}" />
@stop

@section('content')
    <div id="displayErrors" style="display:none;" class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul id="errors"></ul>
    </div>
    <h3>Plan name: </h3>
    <span id="planName">{{ $ViewBag['plan']->name }}</span>
    <h5>Floor Number:</h5>
    <span id="floorNumber">{{ $ViewBag['plan']->nbFloor }}</span>
    <span style="visibility: hidden" id="wallPoints">{{ $ViewBag['plan']->wallPoints }}</span>
    <br/>
    {!! Form::text('jsonTables', $ViewBag['tables'], array('class' => 'form-control', 'id' => 'jsonTables', 'style' => 'display:none;visibility:hidden;')) !!}
    <div id="rowCmd">
        <a id="btnNewTable" class="btn btn-primary" href="#"> New Table </a>
        <a id="btnNewPlace" class="btn btn-primary" href="#"> New Place </a>
        <a id="btnNewSeparation" class="btn btn-primary" href="#"> New Separation </a>
        <a class="btn btn-warning" id="btnReOrder" href="#"> Re-order </a>
        <a class="btn btn-info" id="btnEditWalls" href="#"> Edit Walls </a>
        <a class="btn btn-success" id="btnSaveWalls" style="visibility: hidden" href="#"> Save Walls </a>

        <a class="btn btn-success pull-right" id="btnFinish" href="#"> Update </a>
    </div>
    <div hidden id="follower"><span class="glyphicon glyphicon-plus"></span></div>

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
@stop

@section('myjsfile')
    <script src="{{ @URL::to('js/planTabs.js') }}"></script>
    <script>
        $("#btnFinish").click(function() {
            var tblContainers = $( ".tablesContainer .tables" );
            var listItems = $( "#tabControl" ).find( tblContainers );
            $arrayFloorTable = [];
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
                    $tabId = parseInt($parsedliSubItem.find("#id").text());
                    $tabNum = parseInt($parsedliSubItem.find("#tableNumber").text());
                    $typeChr = "";
                    if ($parsedliSubItem.hasClass("tbl")) {
                        $typeChr = "tbl"
                    } else if ($parsedliSubItem.hasClass("plc")) {
                        $typeChr = "plc"
                    } else {
                        $typeChr = "sep"
                    }
                    var objTable = {
                        id: $tabId,
                        tblType: $typeChr,
                        tblNum: $tabNum,
                        noFloor: $i,
                        xPos: $xPos,
                        yPos: $yPos,
                        angle: radVal
                    };
                    $arrayFloorTable.push(objTable);
                }

            }

            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            var wallPoints = getWalls()
            console.log('circle')
            console.log(circle)

            var nbFloor = $("#floorNumber").text();
            var planName = $("#planName").text();
            $.ajax({
                url: '/plan/edit/{{ Request::segment(3)}}' ,
                type: 'POST',
                async: true,
                data: {
                    _token: CSRF_TOKEN,
                    planName: planName,
                    wallPoints:wallPoints,
                    nbFloor: nbFloor,
                    tables: JSON.stringify($arrayFloorTable)

                },
                dataType: 'JSON',
                error: function (xhr, status, error) {
                    var erro = jQuery.parseJSON(xhr.responseText);
                    $("#errors").empty();
                    //$("##errors").append('<ul id="errorsul">');
                    [].forEach.call( Object.keys( erro ), function( key ){
                        [].forEach.call( Object.keys( erro[key] ), function( keyy ) {
                            $("#errors").append('<li class="errors">' + erro[key][keyy][0] + '</li>');
                        });
                        //console.log( key , erro[key] );
                    });
                    //$("#displayErrors").append('</ul>');
                    $("#displayErrors").show();
                },
                success: function(xhr) {
                    [].forEach.call( Object.keys( xhr ), function( key ) {
                        alert(xhr[key]);
                        window.location.replace("/plan");
                    });
                }
            });

            console.log(JSON.stringify($arrayFloorTable))
        });
        $("#btnEditTable").click(function() {
            $tblNumEdit = $('#editModal #tblNum').val();
            $oTableNum = $(globEditTable).text($tblNumEdit);
        });
        $("#btnDelTable").click(function() {

        });
        //$(".tablesContainer ul li").rotatable(rotateParams);
        //$(".tablesContainer ul li").draggable(dragParams);
    </script>
    <script type="text/javascript">
        $(document).ready(function() {




            var TabNumber = 0;
            var intNbFloor = parseInt($("#floorNumber").text());
            if(intNbFloor >= 1){
                for(var i = 1; i <= intNbFloor; i++){
                    $("#parentHorizontalTab .resp-tabs-list").append("<li class=\"resp-tab-item hor_1\" aria-controls=\"hor_1_tab_item-"+ TabNumber +"\" role=\"tab\" style=\"border-color: rgb(193, 193, 193); background-color: rgb(255, 255, 255);\">Floor No. " + i + "</li>");


                    var liList = "";

                    var $tableArray = [];

                    $jsonTableArray = JSON.parse($("#jsonTables").val());
                    for(var j = 0; j < $jsonTableArray.length; j++){
                        if($jsonTableArray[j]['noFloor'] == ( i - 1 )) {

                            var currentguid = guid();

                            $tableArray.push(currentguid);

                            liList = liList + '<li class="draggable ' +  $jsonTableArray[j]['type'] + '" ' +
                                    'id="' + currentguid + '" ' +
                                    'style="position: relative; left: ' + $jsonTableArray[j]['xPos'] + 'px; top: ' + $jsonTableArray[j]['yPos'] + 'px; transform: rotate(' + $jsonTableArray[j]['angle'] + ');"><div id="tableNumber">' + $jsonTableArray[j]['tblNumber'] + '</div><span id="posX">' + $jsonTableArray[j]['xPos'] + '</span><span id="posY">' + $jsonTableArray[j]['yPos'] + '</span><span id="id">' + $jsonTableArray[j]['id'] + '</span></li>'





                        }
                    }



                    $("#tabControl").append("<div class=\"tablesContainer\"><ul class=\"tables\">" + liList + "</ul></div>");
                    $('#parentHorizontalTab li.draggable').rotatable(rotateParams);
                    $('#parentHorizontalTab li.draggable').draggable(dragParams);


                    tabOffset = $('.tablesContainer').last().offset();
                    for(var l = 0; l < $tableArray.length; l++){

                        var currentTable = $('#' + $tableArray[l]);
                        var curentTablePosition = currentTable.position();

                        var top = tabOffset.top + parseInt(currentTable.find('#posY').text());
                        var left = tabOffset.left + parseInt(currentTable.find('#posX').text());

                        currentTable.offset({top: top, left: left});

                        currentTable.find('#tableNumber').bind("click", function () {
                                    globEditTable = this;
                                    $('#editModal #tblNum').val($(this).text());
                                    $("#editModal").modal('show');
                                }
                            );

                        console.log(currentTable.offset())

                    }





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




            var tblContainers = $( ".tablesContainer .tables" );
            var listItems = $( "#tabControl" ).find( tblContainers );

            tblContainers.prepend('<canvas id="canvaWalls" width="' + tblContainers.width() +'" height="' +  tblContainers.height() + '"<!-- style="position:absolute;"-->></canvas>')

            var wallPoints = $("#wallPoints").text();

            var onePoint = wallPoints.split(",");

            canvas = new fabric.Canvas('canvaWalls', { selection: false,  hoverCursor: 'move', defaultCursor: 'pointer',position:'absolute' });

            fabric.Object.prototype.originX = fabric.Object.prototype.originY = 'center';

/*
            var line1 = makeLine([ 0, 0, 0, 400 ]),
                    line2 =  makeLine([ 0, 400, 400,400  ]),
                    line3 = makeLine([ 400, 400, 400, 0 ]),
                    line4 = makeLine([ 400, 0, 0, 0 ]);


            var line = [line1,line2,line3,line4]


            canvas.add(line[0], line[1], line[2], line[3]);

            circle =[
                makeCircle(line[0].get('x1'), line[0].get('y1'), line[3], line[0]),
                makeCircle(line[1].get('x1'), line[1].get('y1'), line[0], line[1]),
                makeCircle(line[2].get('x1'), line[2].get('y1'), line[1], line[2]),
                makeCircle(line[3].get('x1'), line[3].get('y1'), line[2], line[3])

            ];

            line[0].link1 = circle[0]
            line[0].link2 = circle[1]
            line[1].link1 = circle[1]
            line[1].link2 = circle[2]
            line[2].link1 = circle[2]
            line[2].link2 = circle[3]
            line[3].link1 = circle[3]
            line[3].link2 = circle[0]



            canvas.add(
                    circle[0],
                    circle[1],
                    circle[2],
                    circle[3]
            );*/

            var lastCircle;
            var firstCircle;
            var lastLine;

            line = [];
            circle = [];

            for(var m = 0; m < onePoint.length; m++){
                var coordonate = onePoint[m].split(":");

                var x1 = parseInt(coordonate[0]);
                var y1 = parseInt(coordonate[1]);



                if(m > 0){



                    line.push(lastLine = makeLine([lastCircle.left,lastCircle.top,x1,y1]));
                    lastLine.link1 = lastCircle;

                    if( m > 1){
                        lastCircle.link2 = line[line.length-1];
                    }


                    circle.push(lastCircle = makeCircle(x1, y1));
                    lastCircle.link1 = line[line.length-1];
                    lastLine.link2 = lastCircle;


/*
                    lastCircle.link1 = line[line.length-1]*/

                    canvas.add(lastCircle, lastLine)
                }
                else{
                    circle.push(lastCircle = makeCircle(x1, y1));
                    firstCircle = lastCircle;
                    canvas.add(lastCircle)
                }


                if(m == onePoint.length-1){
                    line.push(lastLine = makeLine([x1,y1,firstCircle.left,firstCircle.top]));
                    /*lastCircle.link1 = line[line.length-1];*/

                    lastCircle.link2 = line[line.length-1];
                    firstCircle.link2 = line[0];
                    firstCircle.link1 = line[line.length-1];
                    console.log( line[0])
                    canvas.add(lastLine)
                }


                canvas.sendToBack(lastLine);
                canvas.bringToFront(lastCircle);



            }



                /*
                console.log( coordonate)
                var curentCircle = new fabric.Circle({
                    left: parseInt(coordonate[0]),
                    top: parseInt(coordonate[1]),
                    strokeWidth: 5,
                    radius: 12,
                    fill: '#fff',
                    stroke: '#666'
                })

                var line;
                if(m == 0){
                    firstCircle = curentCircle;
                }
                else
                {
                    if(m == onePoint.length-1)
                    {
                        line = new fabric.Line([curentCircle.left,curentCircle.top,lastCircle.left,lastCircle.top], {
                            fill: '#333',
                            stroke: '#333',
                            strokeWidth: 14,
                            selectable: false
                        });

                        line.link1 = curentCircle;
                        line.link2 = lastCircle;

                        line.hasControls = line.hasBorders = false;
                        canvas.add(line);

                         var line2 = new fabric.Line([curentCircle.left,curentCircle.top,firstCircle.left,firstCircle.top], {
                         fill: '#333',
                         stroke: '#333',
                         strokeWidth: 14,
                         selectable: false
                         });

                         line2.link1 = curentCircle;
                         line2.link2 = firstCircle;

                         line2.hasControls = line2.hasBorders = false;
                         canvas.add(line2);

                    }
                    else{
                        line = new fabric.Line([lastCircle.left,lastCircle.top,curentCircle.left,curentCircle.top], {
                            fill: '#333',
                            stroke: '#333',
                            strokeWidth: 14,
                            selectable: false
                        });

                        line.link1 = curentCircle;
                        line.link2 = lastCircle;

                        line.hasControls = line.hasBorders = false;
                        canvas.add(line);



                    }
                }


                /!* l.hoverCursor = 'pointer';*!//!* = 'pointer';*!/

                if(m == 1){
                    firstLine = line;
                }

                if(m > 1){

                    curentCircle.link1 = line
                    curentCircle.link2 = lastLine
                }


                lastCircle = curentCircle;

                lastLine = line;
                canvas.add(curentCircle)
            }
*/


            canvas.renderAll();

            var updateOnListener = function(){
                canvas.on({
                    'mouse:down': function(e) {
                        if (e.target) {
                            e.target.opacity = 0.5;

                            /*We cut wall*//*
                             follower.css('z-index', 1);

                             $('#canvaShape').fadeOut(150);

                             */


                            canvas.renderAll();
                        }
                    },
                    'mouse:up': function(e) {
                        if (e.target) {
                            e.target.opacity = 1;/*
                             follower.css('z-index', 0);*/
                            canvas.renderAll();
                        }
                    },
                    'object:moved': function(e) {
                        e.target.opacity = 0.5;
                    },
                    'object:modified': function(e) {
                        e.target.opacity = 1;
                    },
                    'object:moving': function(e){
                        var p = e.target;
                        p.link1 && p.link1.set({ 'x2': p.left, 'y2': p.top });
                        p.link2 && p.link2.set({ 'x1': p.left, 'y1': p.top });
                        canvas.renderAll();

                        /*// in your click function, call clearTimeout
                         window.clearTimeout(timeoutHandle);

                         // then call setTimeout again to reset the timer
                         timeoutHandle = window.setTimeout(function() {

                         /!* canvas.add(
                         makeCircle(line.get('x1'), line.get('y1')),
                         makeCircle(line2.get('x1'), line2.get('y1')),
                         makeCircle(line3.get('x1'), line3.get('y1')),
                         makeCircle(line4.get('x1'), line.get('y1'))
                         );*!/
                         /!*
                         canvas.removeListeners();*!/
                         /!* canvas.removeListener();
                         setTimeout(function() {

                         updateOnListener();
                         }, 100);
                         console.log('DelayedUpdateLaunched');*!/
                         }, 100);*/

                    },
                    'object:hover': function(e){
                        console.log('testHover')
                    }
                });
                console.log('updateListener');
            }

            updateOnListener();

            var canvasContainer = tblContainers.find('.canvas-container')
            canvasContainer.css({position: 'absolute'})


        });



    </script>
@stop