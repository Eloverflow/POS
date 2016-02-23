@extends('master')

@section('title', $title)

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $path = dirname(Request::path());?>
            <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
            <div class="panel-body">
                <form METHOD="POST" action="{{ @URL::to(Request::path()) }}">
                    <div class="form-group">
                        @foreach($tableColumns as $column)
                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableRow->$column }}">
                        @endforeach

                        @if(!empty($tableChildRows))
                            @if(is_array($tableChildRows))
                                @foreach($tableChildRows as $tableChildRow)

                                    @foreach($tableChildColumns as $column)
                                        <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRow->$column != null){{ $tableChildRow->$column }}@endif">
                                    @endforeach

                                @endforeach
                            @else
                                @foreach($tableChildColumns as $column)
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRows->$column != null){{ $tableChildRows->$column }}@endif">
                                @endforeach
                            @endif
                        @endif

                        @if(isset($tableChoiceLists))

                                <?php $tableIteration = 1; ?>

                                @foreach($tableChoiceLists as $tableChoiceList)

                                    <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
                                    <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="{{ $tableRow->$tableChoiceList['dbColumn'] }}">
                                    <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
                                        @foreach($tableChoiceList["table"] as $oneChoice)
                                            <a id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} active' @if( $oneChoice->id == $tableRow->$tableChoiceList['dbColumn']) active @endif ">
                                                @if($tableChoiceList["contentColumn"] != '' )
                                                    <h4 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h4>
                                                    <p class="list-group-item-text">{{ $oneChoice->$tableChoiceList["contentColumn"] }}</p>
                                                @else
                                                    <h2 class="list-group-item-heading">{{ $oneChoice->$tableChoiceList["titleColumn"] }}</h2>
                                                    <p class="list-group-item-text">{{ $oneChoice->created_at }}</p>
                                                @endif

                                            </a>
                                        @endforeach
                                        <a id="{{$oneChoice->id}}" class="list-group-item tableChoice focus choiceList{{$tableIteration}} active' ">

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

                                                <span id="{{ $tableChoiceList["postUrl"] }}" class="glyphicon glyphicon-ok-sign choiceList{{$tableIteration}}  sumbit-one action"></span>
                                                <span class="glyphicon glyphicon-remove-sign choiceList{{$tableIteration}}  cancel-one action"></span>
                                            </div>
                                            <span class="glyphicon glyphicon-plus-sign choiceList{{$tableIteration}}  add-one"></span>
                                        </a>

                                    </div>
                                    <a><div id="tableChoiceListArrow{{$tableIteration}}" class="alert alert-info tableChoiceListArrow" role="alert"><span class="glyphicon glyphicon-chevron-down"></span></div></a>

                                    <?php $tableIteration++ ?>
                                @endforeach
                        @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    </div>
                    <button type="submit" class="btn btn-default">Update</button>
                </form>
                <br>

                @include('partials.alerts.errors')

                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
