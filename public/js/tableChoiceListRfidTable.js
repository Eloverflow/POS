var tableItaration = 1;


while(document.getElementById('tableChoiceList'+tableItaration) !=null){


    var sumbitOneAction = $('.choiceList'+tableItaration+'.sumbit-one.action');

    sumbitOneActionClick(sumbitOneAction, tableItaration);

    var currentTableChoiceList = $('#tableChoiceList'+tableItaration);
    var currentTableChoiceListArrow = $('#tableChoiceListArrow'+tableItaration);
    var currentTableChoiceActive = $('.tableChoice.choiceList'+tableItaration+'.active');
    var allCurrentTableChoice = $('.tableChoice.choiceList'+tableItaration);

    currentTableChoiceList.slideUp(0);
    currentTableChoiceList.css('visibility', 'visible');
    currentTableChoiceList.slideDown(500);


    var currentTableChoiceAddNew = $('.choiceList'+tableItaration+'.add-new');
    currentTableChoiceAddNew.hide(0);

    var currentTableChoiceFocus = $('.tableChoice.choiceList'+tableItaration+'.focus');

    currentTableChoiceAdd(currentTableChoiceFocus, tableItaration);


    arrowClick(currentTableChoiceList, currentTableChoiceListArrow, tableItaration);

    choiceClick(allCurrentTableChoice, tableItaration);

    currentTableChoiceList.prepend(currentTableChoiceActive);

    tableItaration++;
}


function sumbitOneActionClick(sumbitOneAction, tableItaration){
    sumbitOneAction.click(function(){
        var currentTableChoiceActive = $('.tableChoice.choiceList'+tableItaration+'.active');
        //We store inpout here

        var newItem1 = $('.choiceList'+tableItaration+'#newItemValue1');
        var newItem2 = $('.choiceList'+tableItaration+'#newItemValue2');

        var postAddr = sumbitOneAction.attr('id');

        var newItemName1 = newItem1.attr('name');
        var newItemName2 = newItem2.attr('name');

        var newItemValue1 = newItem1.val();
        var newItemValue2 = newItem2.val();

        newItem1.prop('disabled', true);
        newItem2.prop('disabled', true);


        currentTableChoiceActive.fadeOut(200);
        /*
         newItem2.ajax*//*
         $.ajax({
         statusCode: {
         404: function() {
         alert( "page not found" );
         }
         }
         });*/

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');


        var values = { };
        values['_token'] = CSRF_TOKEN;
        values[newItemName1] =  newItemValue1;
        values[newItemName2] =  newItemValue2;

        var request = $.ajax({
            url: postAddr,
            method: "POST",
            data: values
        });

        request.done(function( data ) {
            $( "#log" ).html( data );

            var currentTableChoiceAddNew = $('.choiceList'+tableItaration+'.add-new');

            currentTableChoiceAddNew.remove();



            currentTableChoiceActive.fadeIn(200);

            currentTableChoiceActive.append('<h4 class="list-group-item-heading">' + values[newItemName1] +'</h4>')
            currentTableChoiceActive.append('<p class="list-group-item-text">' + values[newItemName2] +'</p>')

            currentTableChoiceActive.attr('id', data['id']);

            $('.input'+tableItaration).attr("value", data['id']);

        });

        request.fail(function( jqXHR, textStatus ) {
            alert( "Request failed: " + textStatus );
        });

        //we display new input now, fadein
    });


}

function currentTableChoiceAdd(currentTableChoiceFocus, tableItaration){
    currentTableChoiceFocus.click(function(){

        var currentTableChoiceFocus = $('.tableChoice.choiceList'+tableItaration+'.focus');


        var newItem1 = $('.choiceList'+tableItaration+'#newItemValue1');
        var newItem2 = $('.choiceList'+tableItaration+'#newItemValue2');


        newItem1.prop('disabled', false);
        newItem2.prop('disabled', false);


        currentTableChoiceFocus.children().fadeOut(200).promise().then(function() {
            /*currentTableChoiceFocus.empty();*/
            /*var currentTableChoiceAddOne = $('.choiceList'+tableItaration+'.add-one');
             currentTableChoiceAddOne.remove();*/

            var currentTableChoiceAddNew = $('.choiceList'+tableItaration+'.add-new');

            currentTableChoiceFocus.removeClass("focus");
            currentTableChoiceAddNew.fadeIn(200);
        });



    });

}


function choiceClick(allCurrentTableChoice, tableItaration){
    allCurrentTableChoice.click(function(){

        var currentTableChoiceActive = $('.tableChoice.choiceList'+tableItaration+'.active');

        currentTableChoiceActive.removeClass("active");

        this.className = this.className + " active";

        $('.input'+tableItaration).attr("value", this.id);

    });

}


function arrowClick(currentTableChoiceList, currentTableChoiceListArrow, tableItaration){
    currentTableChoiceListArrow.click(function() {


        var currentTableChoiceActive = $('.tableChoice.choiceList'+tableItaration+'.active');


        if(currentTableChoiceListArrow.html() == '<span class="glyphicon glyphicon-chevron-down"></span>'){
            autoHeightAnimate(currentTableChoiceList, 300);


            currentTableChoiceListArrow.html('<span class="glyphicon glyphicon-chevron-up"></span>');

        }else{

            currentTableChoiceActive.slideUp(150);


            setTimeout(function() {currentTableChoiceList.prepend(currentTableChoiceActive); }, 200);

            currentTableChoiceActive.slideDown(150);


            currentTableChoiceList.animate({height: 80 }, 300);
            currentTableChoiceListArrow.html('<span class="glyphicon glyphicon-chevron-down"></span>');
        }
    });

}




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