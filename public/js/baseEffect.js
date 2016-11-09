/**
 * Created by Jean on 2016-01-01.
 */

/*
var pageScroll = false;
setTimeout(function() { pageScroll.resize(); }, 500);*/
/*

setTimeout(function() { $('.fc-day-grid-container.fc-scroller').css('height', 'auto'); }, 100);
*/

/*This is to give the time to bootstrap table to load*/
var $contentPanel = $('#contentPanel .row');
if(!$contentPanel.hasClass('no-fade')){
    $contentPanel.hide(0);
    $contentPanel.css('visibility', 'visible');
    $contentPanel.fadeIn(200);
}

var calendar = $('.calendar-fix');
calendar.hide(0);
calendar.css('visibility', 'visible');
calendar.fadeIn(200);


/*
$('.datepickerInput').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
});*/
/*
document.getElementById("uploadId").onchange = function () {
    document.getElementById("uploadFile").value = this.value;
};
*/

/*
$("#uploadId").on('change',function(){
    $("#uploadFile").val = this.value;
});*/

$('#img_display').click(function(){

    $('#uploadId').click()
});


function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#img_display')
                .attr('src', e.target.result)

            $("#uploadFile").attr('value', input.value);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
/*
$("input[type=file]").on('change',function(){
    alert(this.files[0].name);
});*/



/*

$(document).ready(

    function() {

        pageScroll = $("html").niceScroll({cursorcolor:"#30a5ff", cursorborderradius:"2px", cursorwidth:"8px"});

    }

);
*/
