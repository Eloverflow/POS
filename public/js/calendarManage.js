/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
var globStoredEvent = null;
var globRefEventId = null;

var globTimeZoneAMontreal = "America/Montreal";
moment.tz.add("America/Montreal|EST EDT EWT EPT|50 40 40 40|01010101010101010101010101010101010101010101012301010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010|-28tR0 bV0 2m30 1in0 121u 1nb0 1g10 11z0 1o0u 11zu 1o0u 11zu 3VAu Rzu 1qMu WLu 1qMu WLu 1qKu WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 WL0 1qN0 4kO0 8x40 iv0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 1fz0 1cN0 1cL0 1cN0 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1o10 11z0 1qN0 11z0 1o10 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 1cN0 1fz0 1a10 1fz0 1cN0 1cL0 1cN0 1cL0 1cN0 1cL0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 14p0 1lb0 14p0 1lb0 14p0 1nX0 11B0 1nX0 11B0 1nX0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Rd0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0 Op0 1zb0");

// Events Setters Section

$addModal = $("#addModal");
$editModal = $('#editModal');

var oldEvents = null;
var onceLoaded = false;
function eventAfterAllRender() {
    if(!onceLoaded){
        oldEvents = NormalizeCalendarMomentsArray(globStoredCalendar.fullCalendar('clientEvents'));
        console.log(oldEvents);
        onceLoaded = true;
    }
}
//The event that is stored directly on dragging start
var evBeforeDragIsAllDay = null;
function eventDragStart(oEvent) {
    evBeforeDragIsAllDay = oEvent.allDay;
}

function eventDragStop(oEvent) {

}

function eventDrop(oEvent) {


    if(evBeforeDragIsAllDay == true){

        /*var eventEndTime = moment(oEvent.start).tz(globTimeZoneAMontreal);

        /!*eventEndTime.add(2, 'hours');*!/
        oEvent.end = moment(eventEndTime);

        console.log(eventEndTime);
        console.log(oEvent);*/
        /*var startTimeCopy = jQuery.extend(true, {}, oEvent.start);*/
        /*oEvent.end = oEvent.start;

        globStoredCalendar.fullCalendar('updateEvent', oEvent);
        console.log('all day');*/

        /*strEndTime = oEvent.start.format();
        oEndTime = moment(strEndTime).add(2, 'hours');

        oEvent.end = oEndTime;
        globStoredCalendar.fullCalendar('updateEvent', oEvent);*/
    }
}

$('#btnAdd').click(function(e) {

    $calendarStartDate = new Date(
        globStoredCalendar.fullCalendar('getView').start.tz(globTimeZoneAMontreal)
            .format()
    );

    $stPick = $('#addModal #startTimePicker').data("DateTimePicker");
    $stPick.clear();
    $stPick.defaultDate(new Date(moment($calendarStartDate).hours(8).add(1, 'days').tz(globTimeZoneAMontreal)));

    $etPick = $('#addModal #endTimePicker').data("DateTimePicker");
    $etPick.clear();
    $etPick.defaultDate(new Date(moment($calendarStartDate).hours(8).add(1, 'days').add(2, 'hours').tz(globTimeZoneAMontreal)));



    $("#addModal").modal('show');
});

$( "#addModal #momentType" ).change(function() {
    SelectMomentType(parseInt(this.value), $('#addModal'));
});

$( "#editModal #momentType" ).change(function() {
    SelectMomentType(parseInt(this.value), $('#editModal'));
});

$addModal.find("#chkOptAllDay").change(function() {
    if(this.checked) {
        $addModal.find('#startTime').prop('disabled', true);
        $addModal.find('#endTime').prop('disabled', true);
    } else {
        $addModal.find('#startTime').prop('disabled', false);
        $addModal.find('#endTime').prop('disabled', false);
    }
});

$editModal.find("#chkOptAllDay").change(function() {
    if(this.checked) {
        $editModal.find('#startTime').prop('disabled', true);
        $editModal.find('#endTime').prop('disabled', true);
    } else {
        $editModal.find('#startTime').prop('disabled', false);
        $editModal.find('#endTime').prop('disabled', false);
    }
});

// End Events Setters Section

// Http Request Section

function postCalendarMoments() {


    var allEvents = NormalizeCalendarMomentsArray(globStoredCalendar.fullCalendar('clientEvents'));

    console.log(GetUpdateAndDeleteEventsCompare(oldEvents, allEvents));

    //console.log(normEvents, oldEvents);

    //$('#frmDispoCreate').submit();
    /*var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/calendar/edit',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            events: JSON.stringify(normEvents)

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
    });*/

}
// End Http Request Section


// Custom functions section ---

function SelectMomentType($selectedValue, $modal) {
    if($selectedValue === 1)
    {
        $modal.find('#employeeSelect').prop('disabled', true);
        $modal.find('#eventName').prop('disabled', false);
        $modal.find('.employee-select').hide();
        $modal.find('.event-name').show();
    } else if($selectedValue === 2 || $selectedValue === 3) {
        $modal.find('#employeeSelect').prop('disabled', false);
        $modal.find('#eventName').prop('disabled', true);
        $modal.find('.employee-select').show();
        $modal.find('.event-name').hide();
    }
}

function NormalizeCalendarMomentsArray(events){

    var eventsArray = [];

    for (var i = 0; i < events.length; i++){

        var eventObj = {
            /*name: events[i].eventName,*/
            isAllDay: events[i].isAllDay,
            startTime: events[i].start.toString(),
            endTime: events[i].end.toString(),
            eventId: typeof events[i].eventId == 'undefined' ? '' : events[i].eventId,
            /*employeeId: events[i].employeeId,*/
            momentTypeId: events[i].momentTypeId
        };

        if(events[i].momentTypeId === 1)
        {
            eventObj.name =  events[i].eventName;
        } else if(events[i].momentTypeId === 2 || events[i].momentTypeId === 3) {
            eventObj.employeeId =  events[i].employeeId;
        }


        eventsArray.push(eventObj)
    }
    return eventsArray;
}

function GetUpdateAndDeleteEventsCompare(oldEvents, newEvents){
    var inserts = [];
    var updatesOrSame = [];
    var deletes = [];
    var updates = [];

    for (var i = 0; i < newEvents.length; i++) {
        if(typeof newEvents[i].eventId == "undefined") {
            inserts.push(newEvents[i]);
        } else {
            updatesOrSame.push(newEvents[i]);
        }
    }

    // Determines if the object have to be updated or have to stay the same
    for(var j = 0; j < oldEvents.length; j++){
        var eventFound = false;
        for (var k = 0; k < updatesOrSame.length; k++) {

            if(oldEvents[j].eventId === updatesOrSame[k].eventId){

                if(!EventIsEqual(oldEvents[j], updatesOrSame[k])){
                    updates.push(updatesOrSame[k]);
                }
                eventFound = true;
            }
        }
        if(!eventFound){
            deletes.push(oldEvents[j]);
        }

    }

    return {
        inserts: inserts,
        updates: updates,
        deletes: deletes
    }
}

function EventIsEqual(event1, event2) {
    var isEqual = true;
    if(event1.name != event2.name){
        isEqual = false;
    }

    if(event1.isAllDay != event2.isAllDay){
        isEqual = false;
    }

    if(event1.startTime !== event2.startTime){
        isEqual = false;
    }

    if(event1.endTime !== event2.endTime){
        isEqual = false;
    }

    if(event1.momentTypeId !== event2.momentTypeId){
        isEqual = false;
    }

    if(event1.employeeId !== event2.employeeId){
        isEqual = false;
    }

    return isEqual;

    /*isAllDay: events[i].isAllDay,
        StartTime: events[i].start.toString(),
        EndTime: events[i].end.toString(),
        /!*employeeId: events[i].employeeId,*!/
        momentTypeId: events[i].momentTypeId*/
}

// End custom function section

function addEvent() {

    $employeeId = parseInt($("#addModal #employeeSelect option:selected").val());
    $employeeName = $("#addModal #employeeSelect option:selected").text();
    $eventName = $("#addModal #eventName").val();

    $momentType = parseInt($("#addModal #momentType option:selected").val());
    switch ($momentType)
    {
        case 1:
            $color = "#0C0C50";
            $title = "Event - " + $eventName;
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
                title: $title,
                allDay: $('#addModal #chkOptAllDay').is(':checked'),
                start: startDate,
                end: endDate,
                description: '',
                employeeId: $employeeId,
                momentTypeId: $momentType,
                eventName: $eventName,
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
            allDay: $('#addModal #chkOptAllDay').is(':checked'),
            start: new Date(momentStart.tz(globTimeZoneAMontreal).format()),
            end: new Date(momentEnd.tz(globTimeZoneAMontreal).format()),
            description: '',
            employeeId: $employeeId,
            momentTypeId: $momentType,
            eventName:$eventName
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


    globStoredEvent.start = new Date(momentStart.tz(globTimeZoneAMontreal).format());
    globStoredEvent.end = new Date(momentEnd.tz(globTimeZoneAMontreal).format());

    $eventName = $editModal.find("#eventName").val();
    $momentType = parseInt($editModal.find("#momentType option:selected").val());
    switch ($momentType)
    {
        case 1:
            globStoredEvent.color = "#0C0C50";
            globStoredEvent.title = "Event - " + $eventName;
            break;
        case 2:
            globStoredEvent.color = "#b30000";
            globStoredEvent.title = "Unavailability - " + $employeeName;
            break;
        case 3:
            globStoredEvent.color = "#003300";
            globStoredEvent.title = "Day Off - " + $employeeName;
            break;
    }

    globStoredEvent.allDay = $editModal.find('#chkOptAllDay').is(':checked');
    globStoredEvent.employeeId = $employeeId;
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

    $etPick = $('#editModal #endTimePicker').data("DateTimePicker");
    $etPick.clear();


    $('#editModal #momentType').val(calEvent.momentTypeId);

    if(calEvent.momentTypeId === 2 || calEvent.momentTypeId === 3){
        $('#editModal #employeeSelect').val(calEvent.employeeId);
        SelectMomentType(calEvent.momentTypeId, $('#editModal'));
    } else if (calEvent.momentTypeId === 1){
        SelectMomentType(calEvent.momentTypeId, $('#editModal'))
        $('#editModal #eventName').val(calEvent.eventName);
    }

    if(calEvent.allDay){

        $('#editModal #chkOptAllDay').prop('checked', true);


        $stPick.defaultDate(moment(calEvent.start.format()).tz(globTimeZoneAMontreal).hours(8));
        $etPick.defaultDate(moment(calEvent.start.format()).tz(globTimeZoneAMontreal).hours(8).add(2, 'hours'));
    } else {
        $stPick.defaultDate(moment(calEvent.start.format()).tz(globTimeZoneAMontreal));
        $etPick.defaultDate(moment(calEvent.end.format()).tz(globTimeZoneAMontreal));
    }



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