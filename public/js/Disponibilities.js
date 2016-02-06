/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */

function findDisponibilities($lethis) {

    var idEmployee = $lethis.value;

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $DayNumber  = $($lethis).data("day");

    $.ajax({
        url: '/Schedule/AjaxFindDispos',
        type: 'POST',
        data: {_token: CSRF_TOKEN, dayNumber:$DayNumber, idEmployee:idEmployee },
        dataType: 'JSON',
        success: function (data) {
            if(data["status"] == "Error")
            {
                $('#displayMessage').html(getErrorMessage(data["message"]));
            }
            else{

                $nestedListName = "";

                switch($DayNumber) {
                    case 0:
                        $nestedListName =  "sunNestedList";
                        break;
                    case 1:
                        $nestedListName =  "monNestedList";
                        break;
                    case 2:
                        $nestedListName =  "tueNestedList";
                        break;
                    case 3:
                        $nestedListName =  "wedNestedList";
                        break;
                    case 4:
                        $nestedListName =  "thuNestedList";
                        break;
                    case 5:
                        $nestedListName =  "friNestedList";
                        break;
                    case 6:
                        $nestedListName =  "satNestedList";
                        break;

                }
                $("#" + $nestedListName ).empty();
                var validJsonData = JSON.parse(data);
                var list = $("#" + $nestedListName).append('<ul></ul>').find('ul');


                var lastPerson = "";

                var current = '';
                var personCounter = -1;
                for (var i = 0; i < validJsonData.length; i++) {

                    var currentPerson = validJsonData[i].firstName + " " + validJsonData[i].lastName;

                    if(lastPerson != currentPerson ){

                        personCounter++;
                        current = list.append('<li><a href="#">' + currentPerson + '</a><ul></ul>').find('ul:eq(' + personCounter + ')');

                        current.append('<li><a href="#">' + validJsonData[i].startTime + ' To ' + validJsonData[i].endTime + '</a></li>');
                    }
                    else{
                        current.append('<li><a href="#">' + validJsonData[i].startTime + ' To ' + validJsonData[i].endTime + '</a></li>');
                    }

                    lastPerson = currentPerson;
                }
            }
        }
    });

}