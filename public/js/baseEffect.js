/**
 * Created by Jean on 2016-01-01.
 */


var pageScroll = false;

$('#contentPanel').hide(0);
$('#contentPanel').css('visibility', 'visible');

$('#contentPanel').show(200);

$('.datepickerInput').datepicker({
    format: 'yyyy-mm-dd',
    startDate: '-3d'
});

$('.tableChoiceList').slideUp(0);
$('.tableChoiceList').css('visibility', 'visible');
$('.tableChoiceList').slideDown(500);

$('.tableChoiceListArrow').click(function(){
        if($('.tableChoiceListArrow').html() == '<span class="glyphicon glyphicon-chevron-down"></span>'){
            autoHeightAnimate($('.tableChoiceList'), 1000);

            setTimeout(function() { pageScroll.resize(); }, 800);

            $('.tableChoiceListArrow').html('<span class="glyphicon glyphicon-chevron-up"></span>');

        }else{

            var selected = $('.tableChoice.active');
            selected.delay(100).slideUp(600);


            setTimeout(function() {$('.tableChoiceList').prepend(selected); }, 700);

            selected.slideDown(300);


            $('.tableChoiceList').animate({height: 140 }, 1000);
            pageScroll.resize();
            $('.tableChoiceListArrow').html('<span class="glyphicon glyphicon-chevron-down"></span>');
        }
    }
);



$('.tableChoice').click(function(){

    $('.tableChoice').removeClass("active");

    this.className = this.className + " active";


});


/*
$('.tableChoiceListArrow').onmouseover(function(){

});*/

/* Function to animate height: auto */
function autoHeightAnimate(element, time){
    var curHeight = element.height(), // Get Default Height
        autoHeight = element.css('height', 'auto').height(); // Get Auto Height
    element.height(curHeight); // Reset to Default Height
    element.stop().animate({ height: autoHeight }, parseInt(time)); // Animate to Auto Height
}



$(document).ready(

    function() {

        pageScroll = $("html").niceScroll({cursorcolor:"#30a5ff", cursorborderradius:"4px", cursorwidth:"10px"});

    }

);
