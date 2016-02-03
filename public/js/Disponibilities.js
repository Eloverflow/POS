/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */

function findDisponibilities($lethis) {


    var optionSelected = $("option:selected", $lethis);
    var $idUser = $lethis.value;
    var $selectedDayNumber = $lethis.data("day")
    //alert(valueSelected);

    $.ajax({
        url: '/Schedule/AjaxFindDipos',
        type: 'POST',
        data: {_token: CSRF_TOKEN, dayNumber:$selectedDayNumber, idUser:$idUser },
        dataType: 'JSON',
        success: function (data) {
            if(data["status"] == "Error")
            {
                $('#displayMessage').html(getErrorMessage(data["message"]));
            }
            else{
                alert(data);
            }
        }
    });

}