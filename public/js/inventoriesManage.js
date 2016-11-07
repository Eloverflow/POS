

function drawFillingForms(xEvent) {

    var itemFields = $(xEvent).attr("data-field-names");

    var arrFields =  itemFields.split(",");

    $("#formShowing").empty();


    var itemSizes = $(xEvent).attr("data-sizes").split(',');

    var sizesFormHTML = '<h4>Sizes</h4><div id="sizesContainer">';


    sizesFormHTML += '<div class="form-group">' +
        '<label for="item_size">Item Sizes</label>' +
        '<select name="item_size" class="form-control">';

    for(var j = 0; j < itemSizes.length; j++){
        sizesFormHTML += '<option value="'+itemSizes[j]+'">'+ itemSizes[j]+'</option>';
    }

    sizesFormHTML += '</select>';

    /*
    *
    *   <label for="itemtypes[]" >Associer aux types d'items</label>
     <select multiple name="itemtypes[]" class="form-control">
     @foreach($itemtypes as $itemtype)
     <option value="{{ $itemtype->id }}">{{ $itemtype->type }}</option>
     @endforeach
     </select>
    *
    * */

    sizesFormHTML += '</div>';
    sizesFormHTML += '<div><label for="quantity" >Quantité</label><input class="form-control" name="quantity" type="number" id="quantity"> </div>';

    $("#formShowing").append(sizesFormHTML);
}