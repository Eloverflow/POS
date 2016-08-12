/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
var globStoredEvent = null;
var globRefEventId = null;

var globTimeZoneAMontreal = "America/Montreal";
moment.tz.add("America/Montreal|EST EDT EWT EPT|50 40 40 40|01010101010101010101010101010101010101010101012301010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010|-28tR0 bV0 2m30 1in0 121u 1nb0 1g10 11z0 1o0u 11zu 1o0u 11zu 3VAu Rzu 1qMu WLu 1qMu WLu 1qKu WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 4kO0 8x40 iv0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 1fz0 1cN0 1cL0 1cN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 11z0 1o10 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0");

// Events Setters Section

$('#btnAdd').click(function(e) {

    $calendarStartDate = new Date(
        globStoredCalendar.fullCalendar('getView').start.tz(globTimeZoneAMontreal)
            .format()
    );

    $stPick = $('#addModal #startTimePicker').data("DateTimePicker");
    $stPick.clear();
    $stPick.defaultDate(new Date(moment($calendarStartDate).tz(globTimeZoneAMontreal)));

    $etPick = $('#addModal #endTimePicker').data("DateTimePicker");
    $etPick.clear();
    $etPick.defaultDate(new Date(moment($calendarStartDate).add(2, 'hours').tz(globTimeZoneAMontreal)));



    $("#addModal").modal('show');
});

$( "#addModal #momentType" ).change(function() {
    var selectedValue = parseInt(this.value);
    if(selectedValue == 1)
    {
        $('#addModal #employeeSelect').prop('disabled', true);
    } else {
        $('#addModal #employeeSelect').prop('disabled', false);
    }
});

$( "#editModal #momentType" ).change(function() {
    var selectedValue = parseInt(this.value);
    if(selectedValue == 1)
    {
        $('#editModal #employeeSelect').prop('disabled', true);
    } else {
        $('#editModal #employeeSelect').prop('disabled', false);
    }
});

// End Events Setters Section

// Http Request Section

function postAddSchedules() {


    var allEvents = globStoredCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {
            StartTime: allEvents[i].start.toString(),
            EndTime: allEvents[i].end.toString(),
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
function postEditSchedules() {

    var allEvents = globStoredCalendar.fullCalendar('clientEvents');

    var arr = [];

    for (var i = 0; i < allEvents.length; i++){
        var dDate  = new Date(allEvents[i].start.toString());
        var myArray = {StartTime: allEvents[i].start.toString(), EndTime: allEvents[i].end.toString(), employeeId:allEvents[i].employeeId};
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

// End Http Request Section

function addEvent() {

    $employeeId = parseInt($("#addModal #employeeSelect option:selected").val());
    $employeeName = $("#addModal #employeeSelect option:selected").text()

    $momentType = parseInt($("#addModal #momentType option:selected").val());
    switch ($momentType)
    {
        case 1:
            $color = "#0C0C50";
            $title = "Event";
            break;
        case 2:
            $color = "#b30000";
            $title = "Unavailability - " + $employeeName;
            break;
        case 3:
            $color = "#003300";
            $title = "Day Off - " + $employeeName;
            break;
    }
    /*var ValidationResult = ModalValidation("#addModal");
     //console.log(ValidationResult.errors);
     if(ValidationResult.errors.length == 0) {*/

    var momentStart = moment($('#addModal #startTimePicker').data("DateTimePicker").date());
    var momentEnd = moment($('#addModal #endTimePicker').data("DateTimePicker").date());

    var scheduleStartDate = new Date(
        globStoredCalendar.fullCalendar('getView').start.tz(globTimeZoneAMontreal)
            .format()
    );

    var a = momentStart.clone().startOf('day');
    var b = momentEnd.clone().startOf('day');
    var diffDays = b.diff(a, 'days');



    if ($('#addModal #chkOptAllWeek').is(':checked')) {

        for (var i = 1; i <= 7; i++) {


            var startDate = new Date(moment(formatDate(scheduleStartDate))
                .add(i, 'days')
                .add(momentStart.hours(), 'hours')
                .add(momentStart.minutes(), 'minutes')
                .tz(globTimeZoneAMontreal)
                .format());

            var endDateBound = 0;
            if(diffDays > 0){
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
            if($employeeColor == ""){
                $availableColors = GetAvailableColors();
                $availableColor = $availableColors[0];
            } else {
                $availableColor = $employeeColor;
            }


            var newEvent = {
                id: guid(),
                title: $title,
                isAllDay: false,
                start: startDate,
                end: endDate,
                description: '',
                employeeId: $employeeId,
                color: $color
            };

            globStoredCalendar.fullCalendar('addEventSource', [newEvent]);

        }

    } else {


        $availableColor = "";
        $employeeColor = GetEmployeeColor($employeeId);
        if($employeeColor == ""){
            $availableColors = GetAvailableColors();
            $availableColor = $availableColors[0];
        } else {
            $availableColor = $employeeColor;
        }

        var newEvent = {
            id: guid(),
            title: $title,
            color: $color,
            isAllDay: false,
            start: new Date(momentStart.tz(globTimeZoneAMontreal).format()),
            end: new Date(momentEnd.tz(globTimeZoneAMontreal).format()),
            description: '',
            employeeId: $employeeId
        };

        globStoredCalendar.fullCalendar('addEventSource', [newEvent]);

        $("#addModal #displayErrors").hide();

        $("#addModal #displaySuccesses .successMsg").empty();
        $("#addModal #displaySuccesses .successMsg").append('The moment has been added succesfully !');

        $("#addModal #displaySuccesses").show();

    }
    /*} else {

     $("#addModal #displaySuccesses").hide();
     $("#addModal #displayErrors #errors").empty();
     for(var x = 0; x < ValidationResult.errors.length; x++) {
     $("#addModal #displayErrors #errors").append('<li class="errors">' + ValidationResult.errors[x] + '</li>');
     //$("#errors").append('<li class="errors">' + arrayErrors[i] + '</li>');
     }
     $("#addModal #displayErrors").show();
     //console.log( key , erro[key] );

     }*/

}

function editEvent(){

    //var ValidationResult = ModalValidation("#editModal");
    //console.log(ValidationResult.errors);
    //if(ValidationResult.errors.length == 0) {

    $employeeId = parseInt($("#editModal #employeeSelect option:selected" ).val());
    $employeeName = $("#editModal #employeeSelect option:selected" ).text()

    var momentStart = moment($('#editModal #startTimePicker').data("DateTimePicker").date());
    var momentEnd = moment($('#editModal #endTimePicker').data("DateTimePicker").date());

    globStoredEvent.title = $employeeName;
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

    globStoredEvent.employeeId = $employeeId;

    globStoredCalendar.fullCalendar('updateEvent', globStoredEvent);

    $("#editModal #displayErrors").hide();

    $("#editModal #displaySuccesses .successMsg").empty();
    $("#editModal #displaySuccesses .successMsg").append('The moment has been edited succesfully !');

    $("#editModal #displaySuccesses").show();



    /*} else {

     $("#editModal #displaySuccesses").hide();
     $("#editModal #displayErrors #errors").empty();
     for(var x = 0; x < ValidationResult.errors.length; x++) {
     $("#editModal #displayErrors #errors").append('<li class="errors">' + ValidationResult.errors[x] + '</li>');
     //$("#errors").append('<li class="errors">' + arrayErrors[i] + '</li>');
     }
     $("#editModal #displayErrors").show();
     //console.log( key , erro[key] );

     }*/
}

function deleteEvent(){
    globStoredCalendar.fullCalendar('removeEvents', globStoredEvent.id);
}


// Calendar Functions Section
function dayClick(xDate, xEvent)
{

    $stPick = $('#addModal #startTimePicker').data("DateTimePicker");
    $stPick.clear();
    $stPick.defaultDate(new Date(moment(xDate).tz(globTimeZoneAMontreal)));

    $etPick = $('#addModal #endTimePicker').data("DateTimePicker");
    $etPick.clear();
    $etPick.defaultDate(new Date(moment(xDate).add(2, 'hours').tz(globTimeZoneAMontreal)));


    $("#addModal #displayErrors").hide();
    $("#addModal #displaySuccesses").hide();

    $("#addModal").modal('show');
}

function scheduleClick(calEvent, jsEvent, view)
{
    // Set global var so we can get it when we edit.
    globStoredEvent = calEvent;

    $stPick = $('#editModal #startTimePicker').data("DateTimePicker");
    $stPick.clear();
    $stPick.defaultDate(new Date(moment(calEvent.start).tz(globTimeZoneAMontreal)));

    $etPick = $('#editModal #endTimePicker').data("DateTimePicker");
    $etPick.clear();
    $etPick.defaultDate(new Date(moment(calEvent.end).tz(globTimeZoneAMontreal)));


    $("#editModal #displayErrors").hide();
    $("#editModal #displaySuccesses").hide();
    $("#editModal").modal('show');
}

// End Calendar Functions Section

// Custom Functions Section
function GetEmployeeColor(idEmployee)
{
    var emplColor = "";
    //console.log(globUsedColors);
    var allEvents = globStoredCalendar.fullCalendar('clientEvents');
    for(var i = 0; i < allEvents.length; i++)
    {
        //console.log(globUsedColors[i]["idEmployee"]);
        if (allEvents[i].employeeId == idEmployee) {
            emplColor = allEvents[i].color;
        }
    }

    return emplColor;
}

function GetAvailableColors()
{
    var availableColors = [];
    var allEvents = globStoredCalendar.fullCalendar('clientEvents');

    var niceColors = [
        "#6AA4C1",
        "#800000",
        "#520043",
        "#33044D",
        "#1A094F",
        "#0C0C50",
        "#00502A",
        "#256500",
        "#737300"
    ];


    if(allEvents.length == 0){
        availableColors.push(niceColors[0]);
    } else {
        for(var i = 0; i < niceColors.length; i++){

            /*var colorFound = false;
             for(var j = 0; j < globUsedColors.length; j++){
             if(niceColors[i] == globUsedColors[j]["color"]){
             colorFound = true;
             }
             }*/


            var colorFound = false;
            for (var j = 0; j < allEvents.length; j++){

                if(niceColors[i] == allEvents[j].color){
                    colorFound = true;
                }
                //console.log(allEvents[j].color);

            }

            if(colorFound == false){
                availableColors.push(niceColors[i]);
            }
        }

        if(availableColors.length == 0){
            availableColors.push(niceColors[0]) ;
        }
    }

    return availableColors;
}

// End Custom Functions Section