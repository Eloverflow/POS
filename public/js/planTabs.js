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
