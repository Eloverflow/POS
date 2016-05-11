/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
var globStoredEvent = null;
var globRefEventId = null;

var globTimeZoneAMontreal = "America/Montreal";
moment.tz.add("America/Montreal|EST EDT EWT EPT|50 40 40 40|01010101010101010101010101010101010101010101012301010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010|-28tR0 bV0 2m30 1in0 121u 1nb0 1g10 11z0 1o0u 11zu 1o0u 11zu 3VAu Rzu 1qMu WLu 1qMu WLu 1qKu WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 4kO0 8x40 iv0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 1fz0 1cN0 1cL0 1cN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 11z0 1o10 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0");

function postAddSchedules($storedCalendar) {


    var allEvents = $storedCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {
            StartTime: allEvents[i].start.toString(),
            EndTime: allEvents[i].end.toString(),
            dayIndex: dDate.getDay(),
            employeeId:allEvents[i].employeeId
        };
        arr.push(myArray)
    }


    var $scheduleName = $('#name').val();
    var $startDate = $('#startDate').val();
    var $endDate = $('#endDate').val();

    //$('#frmDispoCreate').submit();
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/schedule/create',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            name: $scheduleName,
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
function postEditSchedules($storedCalendar) {

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

function editEvent($storedCalendar){

    $shour = parseInt($('#editModal #sHour').val());
    $smin = parseInt($('#editModal #sMin').val());

    $ehour = parseInt($('#editModal #eHour').val());
    $emin = parseInt($('#editModal #eMin').val());


    $dDayNumber = $( "#editModal #dayNumber option:selected" ).val();
    $employeeText = $( "#editModal #employeeSelect option:selected" ).text();
    $employeeId = $( "#editModal #employeeSelect option:selected" ).val();

    var sHM = ($shour < 10? '0' + $shour : $shour) + ":" + ($smin < 10? '0' + $smin : $smin);
    var eHM = ($ehour < 10? '0' + $ehour : $ehour) + ":" + ($emin < 10? '0' + $emin : $emin);

    var myDate = new Date($('#editModal #dateClicked').val());

    var dateAdd = null;
    if($ehour < $shour) {
        dateAdd = new Date(myDate.getTime() + (1 * 24 * 60 * 60 * 1000));
    } else {
        dateAdd = myDate;
    }
    console.log(formatDate(dateAdd));
    //console.log(sHM + " - " + eHM);


    console.log(sHM);
    //console.log(moment("05:00").tz(globTimeZoneAMontreal).format());
    //console.log(moment(formatDate(dateAdd) + ' ' + sHM).tz(globTimeZoneAMontreal).format());

    globStoredEvent.title = $employeeText;
    globStoredEvent.start = new Date(moment(formatDate(myDate) + ' ' + sHM).tz(globTimeZoneAMontreal).format());
    globStoredEvent.end = new Date(moment(formatDate(dateAdd) + ' ' + eHM).tz(globTimeZoneAMontreal).format());
    globStoredEvent.employeeId = $employeeId;

    $storedCalendar.fullCalendar('updateEvent', globStoredEvent)
}

function deleteEvent($storedCalendar){
    $storedCalendar.fullCalendar('removeEvents', globStoredEvent.id);
}

function addEvent($storedCalendar){

    $shour = parseInt($('#addModal #sHour').val());
    $smin = parseInt($('#addModal #sMin').val());

    $ehour = parseInt($('#addModal #eHour').val());
    $emin = parseInt($('#addModal #eMin').val());

    $dDayNumber = $("#addModal #dayNumber option:selected" ).val();
    $employeeId = $("#addModal #employeeSelect option:selected" ).val()
    $employeeName = $("#addModal #employeeSelect option:selected" ).text()

    // number verification
    $validationError = false;
    /*if(!$.isNumeric($shour) || !$.isNumeric($ehour)){
        alert("Please enter some valid numbers");
    } else {
        if($.isNumeric($smin)){
            if($smin > 59 || $smin < 0 ){
                alert("The number of minutes must be between 0 and 59")
            }
        } else {
            if($('#addModal #sMin').val() == ""){
                $smin = 0;
            }
        }
        if($.isNumeric($emin)){
            if($emin > 59 || $emin < 0 ){
                alert("The number of minutes must be between 0 and 59")
            }
        } else {
            if($('#addModal #eMin').val() == ""){
                $emin = 0;
            }
        }
    }*/

    var sHM = ($shour < 10? '0' + $shour : $shour) + ":" + ($smin < 10? '0' + $smin : $smin);
    var eHM = ($ehour < 10? '0' + $ehour : $ehour) + ":" + ($emin < 10? '0' + $emin : $emin);

    var myDate = new Date($('#addModal #dateClicked').val());

    if($dDayNumber == -1)
    {
        for(var i = 1; i <= 7; i++){
            var startDate = new Date(new Date($('#startDate').val()).getTime() + (i * 24 * 60 * 60 * 1000));

            var dateAdd = new Date();
            if($ehour < $shour) {
                dateAdd = new Date(startDate.getTime() + (1 * 24 * 60 * 60 * 1000));
            } else {
                dateAdd = startDate;
            }
            //console.log($dateClicked);

            $dateFormated = formatDate(startDate);
            var newEvent = {
                id: guid(),
                title: $employeeName,
                isAllDay: false,
                start: new Date($dateFormated + ' ' + sHM + ':00' + '-04:00'),
                end: new Date(formatDate(dateAdd) + ' ' + eHM + ':00' + '-04:00'),
                description: '',
                employeeId: $employeeId
            };

            $storedCalendar.fullCalendar('addEventSource', [newEvent]);

        }

    } else {

        var dateAdd = null;
        if($ehour < $shour) {
            dateAdd = new Date(myDate.getTime() + (1 * 24 * 60 * 60 * 1000));
        } else {
            dateAdd = myDate;
        }
        console.log(new Date(moment(formatDate(myDate) + ' ' + sHM).tz(globTimeZoneAMontreal).format()));
        console.log(new Date(moment(formatDate(dateAdd) + ' ' + eHM).tz(globTimeZoneAMontreal).format()));

        //console.log("Start: " + $dateClicked + ' ' + sHM + " End: " + formatDate(new Date(curDay.getTime() + (2 * 24 * 60 * 60 * 1000))) + ' ' + eHM);

        var newEvent = {
            id: guid(),
            title: $employeeName,
            isAllDay: false,
            start: new Date(moment(formatDate(myDate) + ' ' + sHM).add(1, 'days').tz(globTimeZoneAMontreal).format()),
            end: new Date(moment(formatDate(dateAdd) + ' ' + eHM).add(1, 'days').tz(globTimeZoneAMontreal).format()),
            description: '',
            employeeId: $employeeId
        };
        $storedCalendar.fullCalendar('addEventSource', [newEvent]);
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
    $("#addModal").modal('show');
}

function scheduleClick(xDate, xEvent)
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
    $('#editModal #employeeSelect').val(xEvent.employeeId);
    //alert(xEvent.employeeId);
    // Set global var so we can get it when we edit.
    globStoredEvent = xEvent;
    $("#editModal").modal('show');
}
