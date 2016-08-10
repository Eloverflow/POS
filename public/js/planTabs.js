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


/*Jean added from here*/
var circle;
var canvas;
var wallToggle = false;
var canvaWall;
var follower;
var end;
var lastCircle;
var line = [];
var btnDeleteWalls = $("#btnDeleteWalls");
var bntEditWalls = $("#btnEditWalls");
var bntCancelEditWalls = $("#btnCancelEditWalls");
var bntAddWalls = $("#btnAddWalls");
var tabControlContainers;
var follower = $("#follower");


var stateEditingWall = function () {

    bntAddWalls.hide();
    bntEditWalls.hide();
    bntCancelEditWalls.show();
    bntSaveWalls.show();
    btnDeleteWalls.show();

    follower.css('visibility', 'visible')

    var tabControlContainers = $("#tabControl");
    tabControlContainers.css({backgroundColor: "rgba(0,0,0,0.5)"})

}

var stateDisableEditingWall = function () {

    $(window).unbind();
    bntEditWalls.show();
    bntCancelEditWalls.hide();
    bntSaveWalls.hide();
    btnDeleteWalls.hide();

    follower.css('visibility', 'hidden')

    var tabControlContainers = $("#tabControl");
    tabControlContainers.css({backgroundColor: "#FFFFFF", opacity: 1})
}

var stateHasNoWall = function () {
    bntEditWalls.hide();
    bntCancelEditWalls.hide();
    bntSaveWalls.hide();
    btnDeleteWalls.hide();
    bntAddWalls.show();

}

var stateHasWall = function () {
    bntAddWalls.hide();
    bntEditWalls.show();
};

$(document).ready(function () {
    stateDisableEditingWall();
})

function deleteWall() {
    line = []
    circle = []
    canvas = new fabric.Canvas('canvaWalls', {selection: false, hoverCursor: 'move', defaultCursor: 'pointer'});
}

var bntSaveWalls = $("#btnSaveWalls").click(function(){
    stateDisableEditingWall();
    stateHasWall()
});

btnDeleteWalls.click(function(){
    deleteWall();
    stateDisableEditingWall();
    stateHasNoWall();
});

bntEditWalls.click(function(){
    customizeWall();
    stateEditingWall();
});


bntCancelEditWalls.click(function () {
    stateDisableEditingWall();
});


bntAddWalls.click(function () {
    stateEditingWall();
    tabControlContainers = $("#tabControl");

    var tableContainers = $(".tablesContainer .tables");

        /*For old wall*/
        $('.canvas-container').remove();
        tabControlContainers.prepend('<canvas id="canvaWalls" width="' + tableContainers.width() + '" height="' + tableContainers.height() + '" style="border:1px solid #ccc"></canvas>')
        canvaWall = $('#canvaWalls')


        canvas = new fabric.Canvas('canvaWalls', {selection: false, hoverCursor: 'move', defaultCursor: 'pointer',  position:'absolute'});

        $('.canvas-container').css({position:'absolute'})

        fabric.Object.prototype.originX = fabric.Object.prototype.originY = 'center';

        /*Base wall and circle starting*/
        var line1 = makeLine([5, 5, 5, 400]),
            line2 = makeLine([5, 400, 400, 400]),
            line3 = makeLine([400, 400, 400, 5]),
            line4 = makeLine([400, 5, 5, 5]);
        line = [line1, line2, line3, line4]
        canvas.add(line[0], line[1], line[2], line[3]);
        circle = [
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
        );
        /*Base wall and circle ending*/

        /*Base wall and circle starting*/
        observeCanvas();
        /*By looking into Git history we could plug back the listener to had a junction remover inside the canva*/

        customizeWall();
});

/*Make a circle inside a canva with "link1" been the source line and "link2" been the destination line */
/*Link is only an abstract logic it may differ*/
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

/*Make a line inside a canva with "link1" been the source circle and "link2" been the destination circle */
/*Link is only an abstract logic it may differ*/
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
    return l;
}




function customizeWall(){
    tabControlContainers = $("#tabControl");
    follower = $("#follower");

    /*Make a follower behind canva to show an action is possible*/
    $(window).mousemove(function(e){
        if(e.pageX > tabControlContainers.offset().left+5 && e.pageY > tabControlContainers.offset().top+5)
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
    });

    function getClosestCircle(x, y, getNext) {
        var junctionScore = 99999999;
        var lastBestJunction;

        var boxX = x;
        var boxY = y;

        var currentScore;
        for(var n = 0; n < circle.length; n++ ){

            currentScore = Math.pow(boxX - circle[n].left,2) + Math.pow(boxY - circle[n].top,2);

            if(currentScore < junctionScore){
                lastBestJunction = n;
                junctionScore = currentScore;
            }

        }

        if(getNext){
            if(n < circle.length)
                lastBestJunction++;
            else
                lastBestJunction--;
        }

        console.log('Top & Left')
        console.log(circle[lastBestJunction].link1.top)
        console.log(circle[lastBestJunction].link1.left)
        console.log('')

        return circle[lastBestJunction];
    }

    function getClosestWall(x, y) {
        var junctionScore = 99999999;
        var lastBestWall;

        var boxX = x;
        var boxY = y;

        var link;
        var currentScore;
        for(var n = 0; n < circle.length; n++ ){
            if(typeof circle[n].link1 != 'undefined' && circle[n].link1 != null){
                link = circle[n].link1
            }
            else {
                link = circle[n].link2
            }

            var x1 = link.get('x1'),
            y1 = link.get('y1'),
            x2 = link.get('x2'),
            y2 = link.get('y2');


            currentScore = Math.pow(boxX - x1,2) + Math.pow(boxY - y1,2) +  Math.pow(boxX - x2,2) + Math.pow(boxY - y2,2);

            if(currentScore < junctionScore){
                lastBestWall = link;
                junctionScore = currentScore;
            }

        }

        return lastBestWall;
    }

    function getLinkList(closestCircle) {

        return [{
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
    }
    function getLastBestScore(boxX, boxY, linkList) {
        var winnerScore =99999999,lastBestScore,currentScorePos;

        for(var k = 0; k < linkList.length; k++ ){
            currentScorePos = Math.pow(boxX - linkList[k].x,2) + Math.pow(boxY - linkList[k].y,2);

            if(currentScorePos < winnerScore){
                lastBestScore = k;
                winnerScore = currentScorePos;
            }
        }


        return lastBestScore;
    }

    /*Find the best place to cut between the wall and cut*/
    $(window).click(function(e){

        if(e.pageX > tabControlContainers.offset().left+5 && e.pageY > tabControlContainers.offset().top+5)
        {

            var $info = $('#nested-tabInfo');
            var $tabItemID = $('.tabItemID', $info);
            var curTab = $("[aria-labelledby='" + $tabItemID.text() + "'] .tables");
            var offsetTab = curTab.offset();

            var canvaUpper = tabControlContainers.find('.upper-canvas');

            /*Do not add wall while moving them*/
            if(canvaUpper.css('cursor') != "move"){

                //console.log('Click event')
                /*Inside*/
                var boxX = parseInt(e.pageX-offsetTab.left);
                var boxY = parseInt(e.pageY-offsetTab.top);


                /*Parcourir les point pour former les murs*/
                var closestWall = getClosestWall(boxX, boxY);
                console.log('closestWall');
                console.log(closestWall);

                /*Faire afficher un message si pas sur un mur*/


                var closestCircle = getClosestCircle(boxX, boxY);
                //var linkList = getLinkList(closestCircle);
                //var lastBestScore = getLastBestScore(boxX, boxY, linkList);


                /*if(closestCircle.top < boxY > linkList[lastBestScore].y && closestCircle.left < boxX > linkList[lastBestScore].x ){
                    closestCircle =  getClosestCircle(boxX, boxY, true);
                    linkList = getLinkList(closestCircle);
                    lastBestScore = getLastBestScore(boxX, boxY, linkList);
                }*/

                //console.log(closestCircle)
                //console.log(lastBestScore)
                //console.log(linkList[lastBestScore])

                /* On Set une l'extrémité de la place à x2 et y2, au curseur*/
                /*linkList[lastBestScore].link.set({x2: boxX, y2: boxY})

                /!*Create a line from the second point to the cursor point*!/
                line.push(makeLine([ boxX, boxY,closestCircle.left, closestCircle.top ]))
                var newLine = line[line.length-1]

                /!*circle at curent cursor position*!/
                circle.push(makeCircle(boxX, boxY,linkList[lastBestScore].link, newLine))
                var newCircle = circle[circle.length-1]*/

                    var x2Dest = closestWall.get('x2'),
                    y2Dest = closestWall.get('y2');
                 closestWall.set({x2: boxX, y2: boxY})

                 line.push(makeLine([ boxX, boxY,x2Dest, y2Dest ]))
                 var newLine = line[line.length-1]

                 /*circle at curent cursor position*/
                 circle.push(makeCircle(boxX, boxY,closestWall, newLine))
                 var newCircle = circle[circle.length-1]


                newLine.link1 = closestCircle
                newLine.link2 = newCircle

                closestCircle.link1 = newLine

                /*Adding to visual*/
                canvas.add(line[line.length-1],circle[circle.length-1]);

                canvas.sendToBack(line[line.length-1]);
                canvas.bringToFront(circle[circle.length-1]);
                canvas.renderAll();
                observeCanvas();
            }
        }
        else{
            /*Outside the box */
        }
    });
}

/*Watching bondairies and circle movement to addapt line*/
function observeCanvas(){
    var tabControlContainers = $("#tabControl");
    canvas.observe("object:moving", function(e){
        var obj = e.target;
        if(obj.top < 0){
            obj.top = Math.max(obj.top, 5);
        }
        else if(obj.top > tabControlContainers.height()){
            obj.top = Math.min(obj.top, tabControlContainers.height()-5  );
        }

        if(obj.left < 0){
            obj.left = Math.max(obj.left , 5)
        }
        else if(obj.left > tabControlContainers.width() ){
            obj.left = Math.min(obj.left, tabControlContainers.width()-5 )
        }

        obj.link1 && obj.link1.set({'x2': obj.left, 'y2': obj.top});
        obj.link2 && obj.link2.set({'x1': obj.left, 'y1': obj.top});
        canvas.renderAll();

    });
}

/*Get good link to next circle*/
function getGoodLink(link){
    //console.log('\nlinkIs')
    //console.log(link)

    var goodLink = link.link1.link1;

    if(!goodLink){
        goodLink = link.link2.link2;
    }
    //console.log('\nGoodlinkIs')
    //console.log(goodLink)

    var compare;
    compare = link.link1.link1;

    if(link.top == compare.top && link.left  == compare.left){
        goodLink = link.link1.link2;
        end = false;
        //console.log('trying another one 1')
        //console.log(goodLink)

        if(goodLink.top != lastCircle.top && goodLink.left  != lastCircle.left){

            end = true;
        }
    }
    else
    {
        end = true;
        //console.log('last was the good one')
        //console.log(goodLink)
    }

    if(!end){
        goodLink = getGoodLink(goodLink)
    }
    return goodLink;
}


/*Get the list of wall stored by tokenized arraw x1,y1:x2,y2:x3 ...*/
function getWalls(){
    var wallPoints = "";
    var noEnd = true;
    lastCircle = circle[0];

    while(noEnd){
        if(typeof lastCircle != "undefined") {
            if (wallPoints != "") {
                wallPoints += ","
            }
            wallPoints += lastCircle.left + ":" + lastCircle.top
            lastCircle = getGoodLink(lastCircle)

            if (typeof lastCircle != "undefined" && lastCircle.top == circle[0].top && lastCircle.left == circle[0].left) {
                noEnd = false;
                console.log('normalEnd')
            }
        }
        else
            noEnd = false;

        /*console.log('\nChoose')
         console.log(lastCircle)
         console.log('\n')
         console.log('wallPoints')
         console.log(wallPoints)
         console.log('\n')*/
    }
    return wallPoints;
}
/*Jean added End*/