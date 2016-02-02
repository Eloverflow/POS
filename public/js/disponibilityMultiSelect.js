/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */

function addDisponibility($lethis) {

    $actionParent = $lethis.parent();
    $inptStartVal = $actionParent.find("input[name=startTime]").val(); //("input[name=startTime]").val();
    $inptEndVal = $actionParent.find("input[name=endTime]").val(); //("input[name=startTime]").val();

    $optionText = $inptStartVal + " To " + $inptEndVal;
    $optionJsonValue = "{\"StartTime\":" + $inptStartVal + ", \"EndTime\":" + $inptEndVal + "}"
    console.log($optionJsonValue);
    switch($lethis.data("day")) {
        case 0:
            addDisponibilityToMultiSelect("#sunMultiSelect", $optionText, $optionJsonValue)
            break;
        case 1:
            addDisponibilityToMultiSelect("#monMultiSelect", $optionText, $optionJsonValue)
            break;
        case 2:
            addDisponibilityToMultiSelect("#tueMultiSelect", $optionText, $optionJsonValue)
            break;
        case 3:
            addDisponibilityToMultiSelect("#wedMultiSelect", $optionText, $optionJsonValue)
            break;
        case 4:
            addDisponibilityToMultiSelect("#thuMultiSelect", $optionText, $optionJsonValue)
            break;
        case 5:
            addDisponibilityToMultiSelect("#friMultiSelect", $optionText, $optionJsonValue)
            break;
        case 6:
            addDisponibilityToMultiSelect("#satMultiSelect", $optionText, $optionJsonValue)
            break;

    }
}

function remDisponibility($lethis) {

    switch($lethis.data("day")) {
        case 0:
            remDisponibilityToMultiSelect("#sunMultiSelect")
            break;
        case 1:
            remDisponibilityToMultiSelect("#monMultiSelect")
            break;
        case 2:
            remDisponibilityToMultiSelect("#tueMultiSelect")
            break;
        case 3:
            remDisponibilityToMultiSelect("#wedMultiSelect")
            break;
        case 4:
            remDisponibilityToMultiSelect("#thuMultiSelect")
            break;
        case 5:
            remDisponibilityToMultiSelect("#friMultiSelect")
            break;
        case 6:
            remDisponibilityToMultiSelect("#satMultiSelect")
            break;

    }
}

function addDisponibilityToMultiSelect($multiSelectId, $text, $value) {
    $($multiSelectId).append($('<option selected></option>').attr('value', $value).text($text));
}

function remDisponibilityToMultiSelect($multiSelectId) {

    $($multiSelectId + ' option:selected').remove()
}