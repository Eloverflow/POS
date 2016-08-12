
<?php $tableIteration = 1; ?>

@foreach($tableChoiceLists as $tableChoiceList)



    <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
    <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="@if(isset($tableRow)){{ $tableRow->$tableChoiceList['dbColumn'] }} @endif">
    <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
        @foreach($tableChoiceList["table"] as $oneChoice)
            <span id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} active' @if(isset($tableRow) && $oneChoice->id == $tableRow->$tableChoiceList['dbColumn']) active @endif ">
                <?php $titleColumn = $tableChoiceList["titleColumn"]; ?>
                @if($tableChoiceList["contentColumn"] != '' )
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-edit"></span></a>
                    <h4 class="list-group-item-heading">{{ $oneChoice->$titleColumn }}</h4>
                    <p class="list-group-item-text">{{ $oneChoice->$tableChoiceList["contentColumn"] }}</p>
                @else
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-edit"></span></a>
                    <h2 class="list-group-item-heading">{{ $oneChoice->$titleColumn }}</h2>
                    <p class="list-group-item-text">{{ $oneChoice->created_at }}</p>
                @endif

                <?php if(isset($tableRow) && $oneChoice->id == $tableRow->$tableChoiceList['dbColumn']){
                        $savedChoice = $oneChoice;
                    }
                ?>
            </span>
        @endforeach
        <span id="{{$oneChoice->id}}" class="list-group-item tableChoice focus choiceList{{$tableIteration}} active' ">

            <div class="form-group choiceList{{$tableIteration}} add-new">

                <div class="block">
                    <label class="control-label">{{ucwords( str_replace('_', ' ', $tableChoiceList["titleColumn"])) }} </label>
                    <input id="newItemValue1" type="text" class="form-control choiceList{{$tableIteration}}" name="{{ $tableChoiceList["titleColumn"] }}" value="{{ old($tableChoiceList["titleColumn"]) }}"  disabled=true>
                </div>
                @if($tableChoiceList["contentColumn"] != "")
                    <div class="block">
                        <label  class="control-label">{{ ucwords( str_replace('_', ' ', $tableChoiceList["contentColumn"])) }}</label>
                        <input  id="newItemValue2" type="text" class="form-control choiceList{{$tableIteration}}" name="{{ $tableChoiceList["contentColumn"] }}" value="{{old($tableChoiceList["contentColumn"])}}" disabled=true>
                    </div>
                @endif

                <span id="{{ $tableChoiceList["postUrl"] }}/create" class="glyphicon glyphicon-ok-sign choiceList{{$tableIteration}}  sumbit-one action"></span>
                <span class="glyphicon glyphicon-remove-sign choiceList{{$tableIteration}}  cancel-one action"></span>
            </div>
            <span class="glyphicon glyphicon-plus-sign choiceList{{$tableIteration}}  add-one"></span>
        </span>

    </div>
    <a><div id="tableChoiceListArrow{{$tableIteration}}" class="alert alert-info tableChoiceListArrow" role="alert"><span class="glyphicon glyphicon-chevron-down"></span></div></a>

    @if(isset($savedChoice) && $savedChoice->field_names != null)
        <h1>Fields</h1>
        <?php $fields_name_array = explode (',' , $savedChoice->field_names)  ?>
            @for($i = 0; $i < count($fields_name_array); $i++)
                <?php $unserialized_fields = unserialize($tableRow->custom_fields_array); ?>
                    <label class="control-label" for="custom_fields_array[]" >{{ ucwords( str_replace('_', ' ', $fields_name_array[$i] )) }}</label>
                    <input class="form-control" type="text" id="custom_fields_array[]" name="custom_fields_array[]" value="@if(!empty($unserialized_fields[$i])){{ $unserialized_fields[$i] }}@endif">
            @endfor

        <h1>Sizes price</h1>
        <?php $size_name_array = explode (',' , $savedChoice->size_names)  ?>
        @for($i = 0; $i < count($size_name_array); $i++)
            <?php $unserialized_sizes = unserialize($tableRow->size_prices_array); ?>
            <label class="control-label" for="size_prices_array[]" >{{ ucwords( str_replace('_', ' ', $size_name_array[$i] )) }}</label>
            <input class="form-control" type="text" id="size_prices_array[]" name="size_prices_array[]" value="@if(!empty($unserialized_sizes[$i])){{ $unserialized_sizes[$i] }}@endif">
        @endfor
    @endif

    <?php $tableIteration++ ?>
@endforeach