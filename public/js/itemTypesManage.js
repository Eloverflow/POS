/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
function postAddItemsType() {

    var $itemTypeName = $('#typeName').val();

    var fieldRows = $('#tbl-fields-name').find('> tbody > tr');
    var sizeRows = $('#tbl-sizes-name').find('> tbody > tr');

    var $fieldNames = "";
    var $sizeNames = "";

    for (var i = 0; i < fieldRows.length; i++){
        if((fieldRows.length - 1) == i) {
            $fieldNames += $(fieldRows[i]).find('td:first').text().trim()
        } else {
            $fieldNames += $(fieldRows[i]).find('td:first').text().trim() + ",";
        }
    }

    for (var j = 0; j < sizeRows.length; j++){
        if((sizeRows.length - 1) == i) {
            $sizeNames += $(sizeRows[i]).find('td:first').text().trim()
        } else {
            $sizeNames += $(sizeRows[j]).find('td:first').text().trim() + ",";
        }
    }

    alert($fieldNames);
    alert($sizeNames);
    //$('#frmDispoCreate').submit();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/item/type/create',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            typeName: $itemTypeName,
            fieldNames: $fieldNames,
            sizeNames: $sizeNames

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
            });
        }
    });

}
function postEditItemsType() {

    var allEvents = $storedCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {StartTime: allEvents[i].start.toString(), EndTime: allEvents[i].end.toString(), dayIndex: dDate.getDay(), employeeId:allEvents[i].employeeId};
        arr.push(myArray)
    }

    var $scheduleId = $('#scheduleId').val();
    var $scheduleName = $('#name').val();
    var $startDate  = $('#startDate').val();
    var $endDate  = $('#endDate').val();

    //$('#frmDispoCreate').submit();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/schedule/edit',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            name: $scheduleName,
            scheduleId: $scheduleId,
            startDate: $startDate,
            endDate: $endDate,
            events: JSON.stringify(arr)

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
                window.location.replace("/schedule");
            });
        }
    });

}

function addItemToFieldTable(){


    var fieldName = $("#addModal #fieldName").val();
    $("#tbl-fields-name").append('<tr><td>' + fieldName +
        '</td>' +
        '<td><a href="#" class="delFieldName pull-right glyphicon glyphicon-remove"></a></td>' +
        '</tr>');

    $(".delFieldName").bind("click", function() {
        delItemToFieldTable(this);
    });
}

function addItemToSizeTable(){


    var sizeName = $("#addModal #sizeName").val();
    $("#tbl-sizes-name").append('<tr><td>' + sizeName +
        '</td>' +
        '<td><a href="#" class="delSizeName pull-right glyphicon glyphicon-remove"></a></td>' +
        '</tr>');

    $(".delSizeName").bind("click", function() {
        delItemToSizeTable(this);
    });
}

var delItemToFieldTable = function(lethis) {

    var parentParent = $(lethis).parent().parent();

    parentParent.remove();

};

var delItemToSizeTable = function(lethis) {

    var parentParent = $(lethis).parent().parent();

    parentParent.remove();

};