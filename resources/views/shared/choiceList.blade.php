
<?php $tableIteration = 1; ?>

@foreach($tableChoiceLists as $tableChoiceList)



    <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
    <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="@if(isset($tableRow)){{ $tableRow->$tableChoiceList['dbColumn'] }} @endif">
    <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
        @foreach($tableChoiceList["table"] as $oneChoice)
            <span id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} active' @if(isset($tableRow) && $oneChoice->id == $tableRow->$tableChoiceList['dbColumn']) active @endif ">
                @if($tableChoiceList["contentColumn"] != '' )
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-edit"></span></a>
                    <h4 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h4>
                    <p class="list-group-item-text">{{ $oneChoice->$tableChoiceList["contentColumn"] }}</p>
                @else
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-edit"></span></a>
                    <h2 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h2>
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

    @if(isset($savedChoice) && $savedChoice->fields_names != null)
        <?php $fields_name_array = explode (',' , $savedChoice->fields_names)  ?>
            @for($i = 0; $i < count($fields_name_array); $i++)
                <?php $currentCustomField = 'customField' . ($i + 1) ?>
                    <label class="control-label" for="customField{{$i+1}}" >{{ ucwords( str_replace('_', ' ', $fields_name_array[$i] )) }}</label>
                    <input class="form-control" type="text" id="customField{{$i+1}}" name="customField{{$i+1}}" value="@if($tableRow->$currentCustomField != null){{ $tableRow->$currentCustomField }}@endif">
            @endfor
    @endif

    <?php $tableIteration++ ?>
@endforeach