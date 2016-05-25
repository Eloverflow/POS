
<?php $tableIteration = 1; ?>

@foreach($tableChoiceLists as $tableChoiceList)

    <div class="labelBtn">
        <label>Item type</label>
        <a class="btn btn-success pull-right" id="btnAddItemType" href="#"> Add </a>
    </div>
    <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="@if(isset($tableRow)){{ $tableRow->$tableChoiceList['dbColumn'] }} @endif">
    <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
        @foreach($tableChoiceList["table"] as $oneChoice)
            <span id="{{$oneChoice->id}}" data-field-names="{{$oneChoice->field_names}}" data-size-names="{{$oneChoice->size_names}}" class="list-group-item tableChoice choiceList{{$tableIteration}} @if(isset($tableRow) && $oneChoice->id == $tableRow->$tableChoiceList['dbColumn']) active @endif ">
                @if($tableChoiceList["contentColumn"] != '' )
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-pencil"></span></a>
                    <h4 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h4>
                    <p class="list-group-item-text">{Type { $oneChoice->$tableChoiceList["contentColumn"] }}</p>
                @else
                    <a class="view" href="{{ $tableChoiceList["postUrl"]}}/edit/{{$oneChoice->slug}}"><span class="glyphicon glyphicon-pencil"></span></a>
                    <h2 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h2>
                @endif

            </span>
        @endforeach
    </div>

    <?php $tableIteration++ ?>
@endforeach