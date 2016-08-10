/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
var globStoredEvent = null;
var globTimeZoneAMontreal = "America/Montreal";
moment.tz.add("America/Montreal|EST EDT EWT EPT|50 40 40 40|01010101010101010101010101010101010101010101012301010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010|-28tR0 bV0 2m30 1in0 121u 1nb0 1g10 11z0 1o0u 11zu 1o0u 11zu 3VAu Rzu 1qMu WLu 1qMu WLu 1qKu WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 4kO0 8x40 iv0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 1fz0 1cN0 1cL0 1cN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 11z0 1o10 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0");

function postAddDisponibilities($storedCalendar) {
    var allEvents = $storedCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {StartTime: allEvents[i].start.toString(), EndTime: allEvents[i].end.toString(), dayIndex: dDate.getDay()};
        arr.push(myArray)
    }


    var $dispoName = $('#name').val();
    var $dispoEmployee = $('#employeeSelect').val();

    //$('#frmDispoCreate').submit();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/disponibility/create',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            name: $dispoName,
            employeeSelect: $dispoEmployee,
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
                window.location.replace("/disponibility");
            });
        }
    });

}
function postEditDisponibilities($storedCalendar) {

    var allEvents = $storedCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {StartTime: allEvents[i].start.toString(), EndTime: allEvents[i].end.toString(), dayIndex: dDate.getDay()};
        arr.push(myArray)
    }

    var $dispoId = $('#dispoId').val();
    var $dispoName = $('#name').val();
    var $dispoEmployee = $('#employeeSelect').val();

    //$('#frmDispoCreate').submit();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/disponibility/edit',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            name: $dispoName,
            dispoId: $dispoId,
            employeeSelect: $dispoEmployee,
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
                window.location.replace("/disponibility");
            });
        }
    });

}

function editEvent(){

    var momentStart = moment($('#editModal #startTimePicker').data("DateTimePicker").date());
    var momentEnd = moment($('#editModal #endTimePicker').data("DateTimePicker").date());

    globStoredEvent.title = "Dispo";
    globStoredEvent.start = new Date(momentStart.tz(globTimeZoneAMontreal).format());
    globStoredEvent.end = new Date(momentEnd.tz(globTimeZoneAMontreal).format());

    // ici a voir
    if(globStoredEvent.employeeId != $employeeId){
        $availableColor = "";
        $employeeColor = GetEmployeeColor($employeeId);
        if($employeeColor == ""){
            $availableColors = GetAvailableColors();
            $availableColor = $availableColors[0];
            globStoredEvent.color = $availableColor;
        } else {
            $availableColor = $employeeColor;
            globStoredEvent.color = $availableColor;
        }
    }



    globStoredCalendar.fullCalendar('updateEvent', globStoredEvent);

    $("#editModal #displayErrors").hide();

    $("#editModal #displaySuccesses .successMsg").empty();
    $("#editModal #displaySuccesses .successMsg").append('The moment has been edited succesfully !');

    $("#editModal #displaySuccesses").show();

}

function addEvent($storedCalendar) {

    $dDayNumber = $("#addModal #dayNumber option:selected").val();

    var momentStart = moment($('#addModal #startTimePicker').data("DateTimePicker").date());
    var momentEnd = moment($('#addModal #endTimePicker').data("DateTimePicker").date());

    var scheduleStartDate = new Date($('#startDate').val());

    var a = momentStart.clone().startOf('day');
    var b = momentEnd.clone().startOf('day');
    var diffDays = b.diff(a, 'days');

    if ($dDayNumber == -1) {

        for (var i = 1; i <= 7; i++) {


            var startDate = new Date(moment(formatDate(scheduleStartDate))
                .add(i, 'days')
                .add(momentStart.hours(), 'hours')
                .add(momentStart.minutes(), 'minutes')
                .tz(globTimeZoneAMontreal)
                .format());

            var endDateBound = 0;
            if (diffDays > 0) {
                endDateBound = i + diffDays
            } else {
                endDateBound = i;
            }

            var endDate = new Date(moment(formatDate(scheduleStartDate))
                .add(endDateBound, 'days')
                .add(momentEnd.hours(), 'hours')
                .add(momentEnd.minutes(), 'minutes')
                .tz(globTimeZoneAMontreal)
                .format());

            $availableColor = "";
            $employeeColor = GetEmployeeColor($employeeId);
            if ($employeeColor == "") {
                $availableColors = GetAvailableColors();
                $availableColor = $availableColors[0];
            } else {
                $availableColor = $employeeColor;
            }


            var newEvent = {
                id: guid(),
                title: "Dispo",
                isAllDay: false,
                start: startDate,
                end: endDate,
                color: $availableColor
            };

            globStoredCalendar.fullCalendar('addEventSource', [newEvent]);

        }

    } else {


        $availableColor = "";
        $employeeColor = GetEmployeeColor($employeeId);
        if ($employeeColor == "") {
            $availableColors = GetAvailableColors();
            $availableColor = $availableColors[0];
        } else {
            $availableColor = $employeeColor;
        }

        var newEvent = {
            id: guid(),
            title: "Dispo",
            color: $availableColor,
            isAllDay: false,
            start: new Date(momentStart.tz(globTimeZoneAMontreal).format()),
            end: new Date(momentEnd.tz(globTimeZoneAMontreal).format())
        };

        globStoredCalendar.fullCalendar('addEventSource', [newEvent]);

        $("#addModal #displayErrors").hide();

        $("#addModal #displaySuccesses .successMsg").empty();
        $("#addModal #displaySuccesses .successMsg").append('The moment has been added succesfully !');

        $("#addModal #displaySuccesses").show();

    }
}

function dayClick(xDate, xEvent)
{
    var datet = new Date(xDate);
    // Clean form control
    $('#addModal #sHour').val("");
    $('#addModal #sMin').val("");

    $('#addModal #eHour').val("");
    $('#addModal #eMin').val("");

    // Week beginning sunday: 0
    if(datet.getDay() == 6)
    {
        $('#addModal #dayNumber').val(0);
    } else {
        // Week beginning sunday: 0
        $gDay = datet.getDay();
        $('#addModal #dayNumber').val($gDay);
    }


    var ymd = formatDate(datet);
    $('#addModal #dateClicked').val(ymd);

    $("#addModal #displayErrors").hide();
    $("#addModal #displaySuccesses").hide();

    $("#addModal").modal('show');
}

function dispoClick(xDate, xEvent)
{

    //console.log(xEvent.start.toString());
    var sDate = new Date(xEvent.start.toString());
    var eDate = new Date(xEvent.end.toString());

    $('#editModal #dateClicked').val(sDate.getFullYear() +"-" + (sDate.getMonth() +1) + "-" + sDate.getDate()) ;
    //console.log(sDate);
    $('#editModal #sHour').val(sDate.getHours());
    $('#editModal #sMin').val(sDate.getMinutes());

    $('#editModal #eHour').val(eDate.getHours());
    $('#editModal #eMin').val(eDate.getMinutes());

    // Week beginning sunday: 0
    $('#editModal #dayNumber').val(sDate.getDay());
    //alert(xEvent.employeeId);
    // Set global var so we can get it when we edit.
    globStoredEvent = xEvent;

    $("#editModal #displayErrors").hide();
    $("#editModal #displaySuccesses").hide();
    $("#editModal").modal('show');
}
function deleteEvent($storedCalendar){
    $storedCalendar.fullCalendar('removeEvents', globStoredEvent.id);
}

function ModalValidation(modal){

    $shour = parseInt($(modal + ' #sHour').val());
    $smin = parseInt($(modal + ' #sMin').val());

    $ehour = parseInt($(modal + ' #eHour').val());
    $emin = parseInt($(modal + ' #eMin').val());

    var arrayErrors = [];
    if(!$.isNumeric($shour) || !$.isNumeric($ehour)){
        arrayErrors.push("Please enter some valid numbers");
    } else {
        if($shour >= 0 && $shour <= 24 && $ehour >= 0 && $ehour <= 24) {
            if ($.isNumeric($smin)) {
                if ($smin > 59 || $smin < 0) {
                    arrayErrors.push("The number of minutes must be between 0 and 59")
                }
            } else {
                if ($(modal + ' #sMin').val() == "") {
                    $smin = 0;
                } else {
                    arrayErrors.push("The number of minutes for start is not valid")
                }
            }
            if ($.isNumeric($emin)) {
                if ($emin > 59 || $emin < 0) {
                    arrayErrors.push("The number of minutes must be between 0 and 59")
                }
            } else {
                if ($(modal + ' #eMin').val() == "") {
                    $emin = 0;
                } else {
                    arrayErrors.push("The number of minutes for end is not valid")
                }
            }
        } else {
            arrayErrors.push("Please select hours between 0 and 24")
        }
    }

    var timeObj = {
        shour: $shour,
        smin: $smin,
        ehour: $ehour,
        emin: $emin
    };
    var ValidationResult = {time:timeObj, errors:arrayErrors};
    return ValidationResult;
}