/**
 * Created by Maype-IsaelBlais on 2016-01-25.
 */
/**
 * Created by isaelblais on 1/9/2016.
 */

function getSuccessMessage($message)
{
    return '<div class=\"alert bg-success\" role=\"alert\">' +
        '<svg class=\"glyph stroked checkmark\">' +
        '<use xlink:href=\"#stroked-checkmark\"></use>' +
        '</svg>' +
        $message +
        '<a href=\"#\" class=\"pull-right\">' +
        '<span class=\"glyphicon glyphicon-remove\"></span>' +
        '</a>' +
        '</div>';
}

function getErrorMessage($message)
{
    return '<div class=\"alert bg-danger\" role=\"alert\">' +
        '<svg class=\"glyph stroked cancel\">' +
        '<use xlink:href=\"#stroked-cancel\"></use>' +
        '</svg>' +
        $message +
        '<a href=\"#\" class=\"pull-right\">' +
        '<span class=\"glyphicon glyphicon-remove\"></span>' +
        '</a>' +
        '</div>';
}

function formatDate(date) {
    var hours = date.getHours();
    var minutes = date.getMinutes();
    var month = (date.getMonth() + 1)
    var formMonth = month < 10 ? ("0" + month) : month;
    var day = date.getDate();
    var formDay = day < 10 ? ("0" + day) : day;
    return date.getFullYear() + "-" + formMonth + "-" + formDay;
}