/**
 * Created by Jean on 2016-01-01.
 */

$('#contentPanel').hide(0);
$('#contentPanel').css('visibility', 'visible');

$('#contentPanel').show(200);

$('.datepickerInput').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
});