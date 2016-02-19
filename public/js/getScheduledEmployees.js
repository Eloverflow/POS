/**
 * Created by isaelblais on 2/19/2016.
 */
function GetScheduledEmployees($dayNumber, $hour) {

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    var Schedule_ID = $('meta[name="schedule-id"]').attr('content');

    $.ajax({
        url: '/schedule/AjaxGetEmployeeDaySchedules',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            scheduleId: Schedule_ID,
            dayNumber: $dayNumber,
            hour: $hour
        },
        dataType: 'JSON',
        success: function (data) {

            console.log(data);

            var validJsonData = JSON.parse(data);

             var mytable = "<table id=\"modalTable\"><thead><tr><th>Full Name</th><th>Scheduled Time</th></tr></thead><tbody><tr>";

             for (var i = 0; i < validJsonData.length; i++) {
                 mytable += "</tr><tr>";
                 mytable += "<td>" + validJsonData[i].firstName + " - " + validJsonData[i].lastName + "</td><td>" + validJsonData[i].startTime + " To " + validJsonData[i].endTime + "</td>";
             }

             mytable += "</tr></tbody></table>";

            bootbox.dialog({
                message: mytable,
                title: "Scheduled employees",
                buttons: {
                    main: {
                        label: "Ok",
                        className: "btn-primary",
                        callback: function() {
                            $("#myModal").modal('hide');
                        }
                    }
                }
            });
        }
    });
}