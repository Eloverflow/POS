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
                console.log(data);
                var validJsonData = JSON.parse(data);
                console.log(validJsonData[0].day)
                //console.log(penis);
                //$validJsonData = JSON.parse($JsonData);
                var list = $("#" + $nestedListName).append('<ul></ul>').find('ul');
                //alert($validJsonData.length)

                var lastPerson = "";


                //li.appendChild('<a href="#"></a>');
                var textnode = document.createTextNode("Water");
                for (var i = 0; i < validJsonData.length; i++) {
                    //var counter = data.counters[i];

                    var currentPerson = validJsonData[i].firstName + " " + validJsonData[i].lastName;
                    //var current = '';

                    if(lastPerson != currentPerson ){
                        current = list.append('<li><a href="#">' + currentPerson + '</a><ul></ul>').find('ul');

                        current.append('<li><a href="#">' + validJsonData[i].startTime + ' To ' + validJsonData[i].endTime + '</a></li>');
                    }
                    else{
                        //current = list.append('<li><a href="#">' + currentPerson + '</a><ul></ul>').find('ul');
                        current.append('<li><a href="#">' + validJsonData[i].startTime + ' To ' + validJsonData[i].endTime + '</a></li>');
                    }

                    lastPerson = currentPerson;

                }

                console.log(list);
            }
        }
    });

}