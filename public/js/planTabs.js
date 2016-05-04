/**
 * Created by isaelblais on 4/8/2016.
 */
var totalTables = 0;

var globEditTable = null;
var rotateParams = {
    /*start: function (event, ui) {
        console.log("Rotating started");
    },
    rotate: function (event, ui) {
        console.log("Rotating");
    },
    stop: function (event, ui) {
        console.log("Rotating stopped");
    }*/
};

var dragParams = {
    containment: "parent",
    /* start:*/
    drag: function () {
        // Find the parent
        var tablesContainer = $(this).parent();
        var tablesContainerPos = tablesContainer.offset();

        var width = $(this).width();
        var height = $(this).height();

        var offset = $(this).position();
        var xPos = offset.left;
        var yPos = offset.top;

        //console.log(xPos);
        //console.log(yPos);

        $(this).find('#posX').text(xPos.toFixed(0));
        $(this).find('#posY').text(yPos.toFixed(0));


        $(this).css({top: yPos.toFixed(0), left: xPos.toFixed(0)});
    }
};
$("#btnNewSeparation").click(function () {
    $tableGUID = guid();
    var $info = $('#nested-tabInfo');
    var $tabItemID = $('.tabItemID', $info);
    var $tabControl = $("#tabControl");

    $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable sep" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');

    $('#' + $tableGUID).resizable().rotatable(rotateParams);
    $('#' + $tableGUID).draggable(dragParams);
});
$("#btnNewPlace").click(function () {
    totalTables += 1;
    $tableGUID = guid();
    var $info = $('#nested-tabInfo');
    var $tabItemID = $('.tabItemID', $info);
    var $tabControl = $("#tabControl");

    $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable plc" id="' + $tableGUID + '">' +
        '<span id="tableNumber">' + totalTables + '</span>' +
        '<span id="posX">0</span>' +
        '<span id="posY">0</span>' +
        '</li>');

    $('#' + $tableGUID + ' #tableNumber').bind("click", function () {
        globEditTable = this;
        $('#editModal #tblNum').val($(this).text());
        $("#editModal").modal('show');
    });
    $('#' + $tableGUID).rotatable(rotateParams);
    $('#' + $tableGUID).bind("mousewheel", function() {
        return false;
    });

    $('#' + $tableGUID).draggable(dragParams);
    $('#' + $tableGUID).css({top: 0, left: 0, position: 'absolute'});
});
$("#btnNewTable").click(function () {
    totalTables += 1;
    $tableGUID = guid();
    var $info = $('#nested-tabInfo');
    var $tabItemID = $('.tabItemID', $info);
    var $tabControl = $("#tabControl");

    $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable tbl" ' + 'id="' + $tableGUID + '">' +
        '<div id="tableNumber">' + totalTables + '</div>' +
        '<span id="posX">0</span>' +
        '<span id="posY">0</span>' +
        '</li>');
    //$(".tablesContainer .tables").append('<li class="draggable tbl" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
    $('#' + $tableGUID + ' #tableNumber').bind("click", function () {
        globEditTable = this;
        $('#editModal #tblNum').val($(this).text());
        $("#editModal").modal('show');
    });

    $('#' + $tableGUID).rotatable(rotateParams);
    $('#' + $tableGUID).draggable(dragParams);

    var width = $(this).width();
    var height = $(this).height();

    var top = width / 2;
    var left = height / 2;

    $('#' + $tableGUID).css({top: 0, left: 0, position: 'relative'});

    var curTab = $("[aria-labelledby='" + $tabItemID.text() + "'] .tables");
    var offsetTab = curTab.offset();

    $('#' + $tableGUID).offset({top: offsetTab.top})


    $('#' + $tableGUID).unbind("mousewheel");
});


/*Jean added*/
var canvas;
var wallToggle = false;
var bntWall = $("#btnAddWalls").click(function () {
    var tblContainers = $(".tablesContainer .tables");

    wallToggle = !wallToggle;

    if(wallToggle){

        bntWall.css({backgroundColor: "#884444"})
        bntWall.text('Cancel Add Walls')
        tblContainers.css({backgroundColor: "rgba(0,0,0,0.5)"})


        tblContainers.append('<div id="canvaShape" >Click on a wall to add junction point !</div><canvas id="canvaWalls" width="' + tblContainers.width() +'" height="' +  tblContainers.height() + '" style="border:1px solid #ccc"></canvas>')
        var canvaWall  = $('#canvaWalls')

      /*  var mouseX = 0, mouseY = 0, limitX = 150-15, limitY = 150-15;
        $(window).mousemove(function(e){
            mouseX = Math.min(e.pageX, limitX);
            mouseY = Math.min(e.pageY, limitY);
        });

        // cache the selector
        var follower = $("#tabControl");
        var xp = 0, yp = 0;
        var loop = setInterval(function(){
            // change 12 to alter damping higher is slower
            xp += (mouseX - xp) / 12;
            yp += (mouseY - yp) / 12;
            follower.css({left:xp, top:yp});

        }, 30);*/

/*        var canvas = new fabric.Canvas('canvaWalls', { selection: false });

        var line, isDown;

        canvas.on('mouse:down', function(o){
            isDown = true;
            var pointer = canvas.getPointer(o.e);
            var points = [ pointer.x, pointer.y, pointer.x, pointer.y ];
            line = new fabric.Line(points, {
                strokeWidth: 8,
                fill: 'brown',
                stroke: 'brown',
                originX: 'center',
                originY: 'center'
            });
            canvas.add(line);
        });

        canvas.on('mouse:move', function(o){
            if (!isDown) return;
            var pointer = canvas.getPointer(o.e);
            line.set({ x2: pointer.x, y2: pointer.y });
            canvas.renderAll();
        });

        canvas.on('mouse:up', function(o){
            isDown = false;
        });*/

            canvas = this.__canvas = new fabric.Canvas('canvaWalls', { selection: false,  CURSOR: 'crosshair' });
            fabric.Object.prototype.originX = fabric.Object.prototype.originY = 'center';

            function makeCircle(left, top, line1, line2, line3, line4) {
                var c = new fabric.Circle({
                    left: left,
                    top: top,
                    strokeWidth: 5,
                    radius: 12,
                    fill: '#fff',
                    stroke: '#666'
                });
                c.hasControls = c.hasBorders = false;

                c.line1 = line1;
                c.line2 = line2;
                c.line3 = line3;
                c.line4 = line4;

                return c;
            }

            function makeLine(coords) {

                var l = new fabric.Line(coords, {
                    fill: '#333',
                    stroke: '#333',
                    strokeWidth: 14,
                    selectable: false
                });

                l.hasControls = l.hasBorders = false;
                l.hoverCursor = 'crosshair';/* = 'pointer';*/


                return l;
            }

            var line = makeLine([ 0, 0, 0, 400 ]),
                line2 =  makeLine([ 0, 400, 400,400  ]),
                line3 = makeLine([ 400, 400, 400, 0 ]),
                line4 = makeLine([ 400, 0, 0, 0 ]);


            canvas.add(line, line2, line3, line4);

            canvas.add(
                makeCircle(line.get('x1'), line.get('y1'), line4, line),
                makeCircle(line2.get('x1'), line2.get('y1'), line, line2),
                makeCircle(line3.get('x1'), line3.get('y1'), line2, line3),
                makeCircle(line4.get('x1'), line.get('y1'), line3, line4)
            );

            canvas.on('object:moving', function(e) {
                var p = e.target;
                p.line1 && p.line1.set({ 'x2': p.left, 'y2': p.top });
                p.line2 && p.line2.set({ 'x1': p.left, 'y1': p.top });
                p.line3 && p.line3.set({ 'x1': p.left, 'y1': p.top });
                p.line4 && p.line4.set({ 'x1': p.left, 'y1': p.top });
                canvas.renderAll();
            });

        var mouseX = 0, mouseY = 0, limitX = 2000, limitY = 4000;

        var follower = $("#follower");


        $(window).mousemove(function(e){

            if(e.pageX > tblContainers.offset().left+5 && e.pageY > tblContainers.offset().top+5)
            {
                follower.offset({
                    left: e.pageX-20,
                    top: e.pageY-20
                });
                follower.show(200);
            }
            else{
                follower.hide(300);
            }



        /*
            mouseX = Math.min(e.pageX, limitX);
            mouseY = Math.min(e.pageY, limitY);*/
        });

        // cache the selector
        /*var xp = 0, yp = 0*/;/*
        var loop = setInterval(function(){
            // change 12 to alter damping higher is slower
            xp += (mouseX - xp) / 12;
            yp += (mouseY - yp) / 12;
            follower.css({left:xp, top:yp});

        }, 30);*/

        /*
        var context = $("#canvaWalls").get(0).getContext("2d");
*/

        var data = [];

        data.push({ x1 : line.get('x1'), y1 : line.get('y1'), x2 : line.get('x2'), y2 : line.get('y2') });
        data.push({ x1 : line2.get('x1'), y1 : line2.get('y1'), x2 : line2.get('x2'), y2 : line2.get('y2') });
        data.push({ x1 : line3.get('x1'), y1 : line3.get('y1'), x2 : line3.get('x2'), y2 : line3.get('y2') });
        data.push({ x1 : line4.get('x1'), y1 : line4.get('y1'), x2 : line4.get('x2'), y2 : line4.get('y2') });

        $('#canvaWalls').css({cursor: 'pointer'});


        canvaWall.mousemove(function(e) {
            console.log('x: '+e.pageX )
            console.log('Happening3')
            for(var i = 0; i < data.length; i++) {
                console.log('Happening2')
                if (e.pageX > data[i].x1 && e.pageX < data[i].x2 && e.pageY > data[i].y1 && e.pageY < data[i].y2) {
                    /*data[i].height = 200;*/
                    console.log('Happening')
                }
            }
        });
        console.log(data);


    }
    else{
        bntWall.css({backgroundColor: "#5bc0de"})
        bntWall.text('Add Walls')
        tblContainers.css({backgroundColor: "#FFFFFF", opacity: 1})
        $(window).unbind();
        var follower = $("#follower");
        follower.hide()
    }






    var listItems = $("#tabControl").find(tblContainers);
    $arrayFloorWall = [];

   /* for ($i = 0; $i < listItems.length; $i++) {
        $liSubItems = $(listItems[$i]).find("div.wall");

        for ($j = 0; $j < $liSubItems.length; $j++) {
            //$arrayFloorTable.push()
            $parsedliSubItem = $($liSubItems[$j]);
            //var offset = $parsedliSubItem.offset();

            $xPos = parseInt($parsedliSubItem.find("#posX").text());
            $yPos = parseInt($parsedliSubItem.find("#posY").text());
            $sGuid = $parsedliSubItem.attr('id');
        }
    }*/
});



/*Jean added end*/


$("#btnReOrder").click(function () {
    var tblContainers = $(".tablesContainer .tables");
    var listItems = $("#tabControl").find(tblContainers);
    $arrayFloorTable = [];

    for ($i = 0; $i < listItems.length; $i++) {
        $liSubItems = $(listItems[$i]).find("li");

        for ($j = 0; $j < $liSubItems.length; $j++) {
            //$arrayFloorTable.push()
            $parsedliSubItem = $($liSubItems[$j]);
            //var offset = $parsedliSubItem.offset();

            $xPos = parseInt($parsedliSubItem.find("#posX").text());
            $yPos = parseInt($parsedliSubItem.find("#posY").text());
            $sGuid = $parsedliSubItem.attr('id');

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
                guid: $sGuid,
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


    $arrayFloorTable.sort(function(a,b) {return (a.xPos > b.xPos) ? 1 : ((b.xPos > a.xPos) ? -1 : 0);} );
    $arrayFloorTable.sort(function(a,b) {return (a.yPos > b.yPos) ? 1 : ((b.yPos > a.yPos) ? -1 : 0);} );


    var Incr = 1;
    for($i = 0; $i < $arrayFloorTable.length; $i ++){
        var tblLiObj = $("#tabControl").find("#" + $arrayFloorTable[$i].guid);
        var tblNumObj = tblLiObj.find("#tableNumber");
        //console.log(tblNumObj);
        tblNumObj.text(Incr.toString());
        Incr += 1;
    }


});
