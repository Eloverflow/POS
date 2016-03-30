/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
var globStoredEvent = null;

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
        success: function (data) {
            console.log(data);
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
        success: function (data) {
            console.log(data);
        }
    });

}

function editEvent($storedCalendar){

    $shour = $('#editModal #sHour').val();
    $smin = $('#editModal #sMin').val();

    $ehour = $('#editModal #eHour').val();
    $emin = $('#editModal #eMin').val();


    $dDayNumber = $( "#editModal #dayNumber option:selected" ).val();
    $employeeText = $( "#editModal #employeeSelect option:selected" ).text();
    $employeeId = $( "#editModal #employeeSelect option:selected" ).val();

    $dateClicked = $('#editModal #dateClicked').val();

    var sHM = $shour + ":" + $smin;
    var eHM = $ehour + ":" + $emin;

    globStoredEvent.title = $employeeText;
    globStoredEvent.start = new Date($dateClicked + ' ' + sHM + ':00'+ '-04:00');
    globStoredEvent.end = new Date($dateClicked + ' ' + eHM + ':00'+ '-04:00');
    globStoredEvent.employeeId = $employeeId;

    $storedCalendar.fullCalendar('updateEvent', globStoredEvent)
}
function addEvent($storedCalendar){

    $shour = $('#addModal #sHour').val();
    $smin = $('#addModal #sMin').val();

    $ehour = $('#addModal #eHour').val();
    $emin = $('#addModal #eMin').val();
    $dateClicked = $('#addModal #dateClicked').val();

    $dDayNumber = $("#addModal #dayNumber option:selected" ).val();
    $employeeId = $("#addModal #employeeSelect option:selected" ).val()
    $employeeName = $("#addModal #employeeSelect option:selected" ).text()

    var sHM = $shour + ":" + $smin;
    var eHM = $ehour + ":" + $emin;

    if($dDayNumber == -1)
    {
        for(var i = 1; i <= 7; i++){
            var myDate = new Date(new Date($('#startDate').val()).getTime() + (i * 24 * 60 * 60 * 1000));

            $dateFormated = formatDate(myDate);
            var newEvent = {
                title: $employeeName,
                isAllDay: false,
                start: new Date($dateFormated + ' ' + sHM + ':00' + '-04:00'),
                end: new Date($dateFormated + ' ' + eHM + ':00' + '-04:00'),
                description: '',
                resourceId: 4,
                employeeId: $employeeId
            };
            $storedCalendar.fullCalendar('addEventSource', [newEvent]);

        }

    } else {
        var newEvent = {
            title: $employeeName,
            isAllDay: false,
            start: new Date($dateClicked + ' ' + sHM + ':00' + '-04:00'),
            end: new Date($dateClicked + ' ' + eHM + ':00' + '-04:00'),
            description: '',
            resourceId: 4,
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


    var day = datet.getDate();
    var dayNum = datet.getDay();
    var monthIndex = datet.getMonth() + 1;
    var year = datet.getFullYear();


    var ymd = year +  "-" + monthIndex + "-" + day;
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
