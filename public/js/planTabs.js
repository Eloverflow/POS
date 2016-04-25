/**
 * Created by isaelblais on 4/8/2016.
 */
var globEditTable = null;
var rotateParams = {
    start: function (event, ui) {
        console.log("Rotating started");
    },
    rotate: function (event, ui) {
        console.log("Rotating");
    },
    stop: function (event, ui) {
        console.log("Rotating stopped");
    }
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
    $tableGUID = guid();
    var $info = $('#nested-tabInfo');
    var $tabItemID = $('.tabItemID', $info);
    var $tabControl = $("#tabControl");

    $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable plc" id="' + $tableGUID + '">' +
        '<span id="tableNumber">0</span>' +
        '<span id="posX"></span>' +
        '<span id="posY"></span>' +
        '</li>');

    $('#' + $tableGUID + ' #tableNumber').bind("click", function () {
        globEditTable = this;
        $('#editModal #tblNum').val($(this).text());
        $("#editModal").modal('show');
    });
    $('#' + $tableGUID).rotatable(rotateParams);
    $('#' + $tableGUID).draggable(dragParams);
    $('#' + $tableGUID).css({top: 0, left: 0, position: 'absolute'});
});
$("#btnNewTable").click(function () {
    $tableGUID = guid();
    var $info = $('#nested-tabInfo');
    var $tabItemID = $('.tabItemID', $info);
    var $tabControl = $("#tabControl");

    $("[aria-labelledby='" + $tabItemID.text() + "'] .tables").append('<li class="draggable tbl" ' + 'id="' + $tableGUID + '">' +
        '<div id="tableNumber">0</div>' +
        '<span id="posX">0</span>' +
        '<span id="posY">0</span>' +
        '</li>');
    //$(".tablesContainer .tables").append('<li class="draggable tbl" id="' + $tableGUID + '"><span id="posX"></span><span id="posY"></span></li>');
    $('#' + $tableGUID + ' #tableNumber').bind("click", function () {
        globEditTable = this;
        $('#editModal #tblNum').val($(this).text());
        $("#editModal").modal('show');
    });

    $('#' + $tableGUID).draggable(dragParams);
    $('#' + $tableGUID).rotatable(rotateParams);


    var width = $(this).width();
    var height = $(this).height();

    var top = width / 2;
    var left = height / 2;

    $('#' + $tableGUID).css({top: 0, left: 0, position: 'relative'});

    var curTab = $("[aria-labelledby='" + $tabItemID.text() + "'] .tables");
    var offsetTab = curTab.offset();
    console.log(offsetTab);
    $('#' + $tableGUID).offset({top: offsetTab.top})


});