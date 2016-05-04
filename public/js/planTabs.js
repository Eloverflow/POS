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
var circle
var canvas;
var wallToggle = false;
var canvaWall
var bntSaveWalls = $("#btnSaveWalls").click(function(){
    var tblContainers = $(".tablesContainer .tables");
    bntWall.css({backgroundColor: "#5bc0de"})
    bntWall.text('Add Walls')
    tblContainers.css({backgroundColor: "#FFFFFF", opacity: 1})
    $(window).unbind();
    var follower = $("#follower");
    follower.hide()

    /*Take all the cordinate and place them inside an input that will be serialized*/
});

var bntWall = $("#btnAddWalls").click(function () {
    var tblContainers = $(".tablesContainer .tables");

    wallToggle = !wallToggle;

    if(wallToggle){

        bntWall.css({backgroundColor: "#884444"})
        bntWall.text('Cancel Add Walls')
        tblContainers.css({backgroundColor: "rgba(0,0,0,0.5)"})

        bntSaveWalls.css({visibility: 'visible'});


        tblContainers.append('<div id="canvaShape" >Click on a wall to add junction point !</div><canvas id="canvaWalls" width="' + tblContainers.width() +'" height="' +  tblContainers.height() + '" style="border:1px solid #ccc"></canvas>')
        canvaWall  = $('#canvaWalls')


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
            var canvas = new fabric.Canvas('canvaWalls', { selection: false,  hoverCursor: 'move', defaultCursor: 'pointer' });

            /*canvas = this.__canvas = fabricCanva;*/


            fabric.Object.prototype.originX = fabric.Object.prototype.originY = 'center';

            function makeCircle(left, top, link1, link2) {
                var c = new fabric.Circle({
                    left: left,
                    top: top,
                    strokeWidth: 5,
                    radius: 12,
                    fill: '#fff',
                    stroke: '#666'
                });
                c.hasControls = c.hasBorders = false;

                c.link1 = link1;
                c.link2 = link2;

                return c;
            }

            function makeLine(coords, link1, link2) {

                var l = new fabric.Line(coords, {
                    fill: '#333',
                    stroke: '#333',
                    strokeWidth: 14,
                    selectable: false
                });

                l.link1 = link1;
                l.link2 = link2;

                l.hasControls = l.hasBorders = false;
               /* l.hoverCursor = 'pointer';*//* = 'pointer';*/


                return l;
            }


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
            );/*
            canvas.hoverCursor = 'pointer';
*/
            var timeoutHandle;
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




            /*
            this.__canvas.push(canvas);*/

          /*  canvas.on('object:moving', function(e) {
                console.log('test')
                var p = e.target;
                p.line1 && p.line1.set({ 'x2': p.left, 'y2': p.top });
                p.line2 && p.line2.set({ 'x1': p.left, 'y1': p.top });
                p.line3 && p.line3.set({ 'x1': p.left, 'y1': p.top });
                p.line4 && p.line4.set({ 'x1': p.left, 'y1': p.top });
                canvas.renderAll();
            });*/
            /*.on('object:hovering', function(e) {
           console.log('test')
        });*/

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

        $(window).click(function(e){

            if(e.pageX > tblContainers.offset().left+5 && e.pageY > tblContainers.offset().top+5)
            {

                var $info = $('#nested-tabInfo');
                var $tabItemID = $('.tabItemID', $info);
                var curTab = $("[aria-labelledby='" + $tabItemID.text() + "'] .tables");
                var offsetTab = curTab.offset();

/*
                circle.push(makeCircle(line.get('x1'), line.get('y1'), line4, line))
                canvas.add(circle[circle.length-1]);*/

                var canvaUpper = tblContainers.find('.upper-canvas');

                /*Do not add wall while moving them*/
                if(canvaUpper.css('cursor') != "move"){

                    console.log('Click event')
                    /*Inside*/

                    var junctionScore = 99999;
                    var lastBestJunction;

                    var boxX = parseInt(e.pageX-offsetTab.left);
                    var boxY = parseInt(e.pageY-offsetTab.top);

                    var currentScore;
                    for(var n = 0; n < circle.length; n++ ){

                        currentScore = Math.pow(boxX - circle[n].left,2) + Math.pow(boxY - circle[n].top,2);
/*
                        var circleLeft = circle[n].left
                        var circleTop = circle[n].top
                        console.log("circle:left:"+circleLeft+"-top:"+circleTop)*/

                        if(currentScore < junctionScore){
                            lastBestJunction = n;
                            junctionScore = currentScore;
                        }
/*
                        console.log('junctionScore')
                        console.log(junctionScore)
                        console.log('currentScore')
                        console.log(currentScore)*/


                    }/*
                    console.log('lastBestJunction');
                    console.log(lastBestJunction);
                    console.log('x:'+ boxX +'y:'+ boxY);


                    console.log(circle[lastBestJunction])
                    console.log('link1');
                    console.log(circle[lastBestJunction].link1)
                    console.log('link2');
                    console.log(circle[lastBestJunction].link2)*/

                    /*Lequel des link est le plus proche ?*/


                    console.log(circle[lastBestJunction].link1.top)
                    console.log(circle[lastBestJunction].link1.left )

                    var closestCircle = circle[lastBestJunction];


                    var linkList = [{
                        link: closestCircle.link1,
                        x: closestCircle.link1.get('x1'),
                        y: closestCircle.link1.get('y1')
                    },{
                        link: closestCircle.link1,
                        x: closestCircle.link1.get('x2'),
                        y: closestCircle.link1.get('y2')
                    },{
                        link: closestCircle.link2,
                        x: closestCircle.link2.get('x1'),
                        y: closestCircle.link2.get('y1')
                    },{
                        link: closestCircle.link2,
                        x: closestCircle.link2.get('x2'),
                        y: closestCircle.link2.get('y2')
                    }
                    ];


                    var winnerScore =99999999,lastBestScore,currentScorePos;

                    for(var k = 0; k < linkList.length; k++ ){

                        currentScorePos = Math.pow(boxX - linkList[k].x,2) + Math.pow(boxY - linkList[k].y,2);

                        if(currentScorePos < winnerScore){
                            lastBestScore = k;
                            winnerScore = currentScorePos;
                        }
                    }

                    console.log(closestCircle)
                    console.log(lastBestScore)
                    console.log(linkList[lastBestScore])


                    var closestWall = linkList[lastBestScore].link;

                    /* On Set une l'extrémité de la place à x2 et y2, au curseur*/
                    linkList[lastBestScore].link.set({x2: boxX, y2: boxY})


/*
                    var linkLowerCircle = linkList[lastBestScore].link.link1;

                    /!*Swap link*!/
                    linkLowerCircle.link1 = linkLowerCircle.link2;*/


                    /*Create a line from the second point to the cursor point*/
                    line.push(makeLine([ boxX, boxY,closestCircle.left, closestCircle.top ]))
                    var newLine = line[line.length-1]

                    /*circle at curent cursor position*/
                    circle.push(makeCircle(boxX, boxY,linkList[lastBestScore].link, newLine))
                    var newCircle = circle[circle.length-1]


                    newLine.link1 = closestCircle
                    newLine.link2 = newCircle


                    closestCircle.link1 = newLine

/*
                    /!*nearest circle new line attribution*!/
                    linkLowerCircle.link2 = newLine;*/

                    /*Adding to visual*/
                    canvas.add(line[line.length-1],circle[circle.length-1]);


                    canvas.renderAll();

                }
            }
            else{
                /*Outside the box */
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

 /*       var data = [];

        data.push({ x1 : line.get('x1'), y1 : line.get('y1'), x2 : line.get('x2'), y2 : line.get('y2') });
        data.push({ x1 : line2.get('x1'), y1 : line2.get('y1'), x2 : line2.get('x2'), y2 : line2.get('y2') });
        data.push({ x1 : line3.get('x1'), y1 : line3.get('y1'), x2 : line3.get('x2'), y2 : line3.get('y2') });
        data.push({ x1 : line4.get('x1'), y1 : line4.get('y1'), x2 : line4.get('x2'), y2 : line4.get('y2') });
/!*
        $('#canvaWalls').css({cursor: 'pointer'});*!/
/!*

        canvas.freeDrawingCursor = 'pointer'
*!/


        canvaWall.mousemove(function(e) {
            console.log('x: '+e.pageX )
            console.log('Happening3')
            for(var i = 0; i < data.length; i++) {
                console.log('Happening2')
                if (e.pageX > data[i].x1 && e.pageX < data[i].x2 && e.pageY > data[i].y1 && e.pageY < data[i].y2) {
                    /!*data[i].height = 200;*!/
                    console.log('Happening')
                }
            }
        });
        console.log(data);*/


    }
    else{
        bntWall.css({backgroundColor: "#5bc0de"})
        bntWall.text('Add Walls')
        tblContainers.css({backgroundColor: "#FFFFFF", opacity: 1})
        $(window).unbind();
        var follower = $("#follower");
        follower.hide()

        tblContainers.empty();
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
