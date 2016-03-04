/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */

function addSchedule($lethis) {

    $actionParent = $lethis.parent();
    $inptStartVal = $actionParent.find("input[name=startTime]").val(); //("input[name=startTime]").val();
    $inptEndVal = $actionParent.find("input[name=endTime]").val(); //("input[name=startTime]").val();
    $inptUserSelected = $actionParent.find("#employeeSelect option:selected");

    if($inptUserSelected.val() > 0) {
        $optionText = $inptUserSelected.text() + " - " + $inptStartVal + " To " + $inptEndVal;
        $optionJsonValue = "{\"EmployeeName\":\"" + $inptUserSelected.text() + "\", \"EmployeeId\":" + $inptUserSelected.val() + ", \"StartTime\":" + $inptStartVal + ", \"EndTime\":" + $inptEndVal + "}"
        console.log($optionJsonValue);
        switch ($lethis.data("day")) {
            case 0:
                addScheduleToMultiSelect("#sunMultiSelect", $optionText, $optionJsonValue)
                break;
            case 1:
                addScheduleToMultiSelect("#monMultiSelect", $optionText, $optionJsonValue)
                break;
            case 2:
                addScheduleToMultiSelect("#tueMultiSelect", $optionText, $optionJsonValue)
                break;
            case 3:
                addScheduleToMultiSelect("#wedMultiSelect", $optionText, $optionJsonValue)
                break;
            case 4:
                addScheduleToMultiSelect("#thuMultiSelect", $optionText, $optionJsonValue)
                break;
            case 5:
                addScheduleToMultiSelect("#friMultiSelect", $optionText, $optionJsonValue)
                break;
            case 6:
                addScheduleToMultiSelect("#satMultiSelect", $optionText, $optionJsonValue)
                break;

        }
    } else {
        alert("Please select an employee !")
    }
}

function remSchedule($lethis) {

    switch($lethis.data("day")) {
        case 0:
            remScheduleToMultiSelect("#sunMultiSelect")
            break;
        case 1:
            remScheduleToMultiSelect("#monMultiSelect")
            break;
        case 2:
            remScheduleToMultiSelect("#tueMultiSelect")
            break;
        case 3:
            remScheduleToMultiSelect("#wedMultiSelect")
            break;
        case 4:
            remScheduleToMultiSelect("#thuMultiSelect")
            break;
        case 5:
            remScheduleToMultiSelect("#friMultiSelect")
            break;
        case 6:
            remScheduleToMultiSelect("#satMultiSelect")
            break;

    }
}

function addScheduleToMultiSelect($multiSelectId, $text, $value) {
    $($multiSelectId).append($('<option selected></option>').attr('value', $value).text($text));
}

function remScheduleToMultiSelect($multiSelectId) {

    $($multiSelectId + ' option:selected').remove()
}