/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */

function punchEmployee() {

    var $selectedEmployeeText = $('#mainText').val();
    console.log($selectedEmployeeText);
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    $.ajax({
        url: '/employee/punch',
        type: 'POST',
        data: {
            _token: CSRF_TOKEN,
            EmployeeNumber: $selectedEmployeeText
        },
        dataType: 'JSON',
        success: function (data) {
            console.log(data);
            if (data["status"] == "Error") {
                $('#displayMessage').html(getErrorMessage(data["message"]));
            }
            else {
                $('#displayMessage').html(getSuccessMessage(data["message"]));
            }
        }
    });
}