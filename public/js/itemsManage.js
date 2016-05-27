/**
 * Created by isaelblais on 3/21/2016.
 */
// var for edit Event
function postCreateItem() {

    var inptName = $("#name").val();
    var inptDescription = $("#description").val();

    var selectedTypeId = $('#selectedItem').val();

    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

    var objChoiceList = $("#tableChoiceList1");

    var selectedItem = GetSelectedItem(objChoiceList);

    var arrayFields = GetSelectedItemFields(selectedItem);

    var arraySizes = GetSelectedItemSizes(selectedItem);

    var $fieldValues = [];
    var $sizeValues = [];

    for (var i = 0; i < arrayFields.length; i++){
        var fieldName = arrayFields[i].trim();
        var fieldValue = $('#fieldsContainer #' + fieldName).val();
        $fieldValues.push(fieldValue)
    }

    for (var j = 0; j < arraySizes.length; j++){
        var sizeName = arraySizes[j].trim();
        var sizeValue = $('#sizesContainer #' + sizeName).val();
        $sizeValues.push(sizeValue)
    }

    /*console.log(JSON.stringify($fieldValues));
    console.log(" ------------ ");
    console.log(JSON.stringify($sizeValues));*/

    $.ajax({
        url: '/item/create',
        type: 'POST',
        async: true,
        data: {
            _token: CSRF_TOKEN,
            name: inptName,
            description: inptDescription,
            itemTypeId: selectedTypeId,
            fieldValues: JSON.stringify($fieldValues),
            sizeValues: JSON.stringify($sizeValues)

        },
        dataType: 'JSON',
        error: function (xhr, status, error) {
            var erro = jQuery.parseJSON(xhr.responseText);
            $("#errors").empty();
            //$("##errors").append('<ul id="errorsul">');
            [].forEach.call( Object.keys( erro ), function( key ){
                [].forEach.call( Object.keys( erro[key] ), function( keyy ) {
                    $("#errors").append('<li class="errors">' + erro[key][keyy][0] + '</li>');
                });
                //console.log( key , erro[key] );
            });
            //$("#displayErrors").append('</ul>');
            $("#displayErrors").show();
        },
        success: function(xhr) {

            alert(xhr["success"]);
            //$("#addModal").modal('hide');
            /*[].forEach.call( Object.keys( xhr ), function( key ) {
                alert(xhr[key]);
            });*/
        }
    });

}

function GetSelectedItemFields(objChoice){
    var strFields = $(objChoice).attr("data-field-names");
    return strFields.split(",");
}

function GetSelectedItemSizes(objChoice){
    var strSizes = $(objChoice).attr("data-size-names");
    return strSizes.split(",");
}