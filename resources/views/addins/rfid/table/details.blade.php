@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('afterContent')
    @include('shared.afterContent')
@stop


@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('rfidtable.detailsToRfidtable') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('addon/rfid/table') }}">{{ @Lang::get('rfidtable.backToRfidtable') }}</a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                        <div class="panel-body">
                            <form METHOD="POST" action="{{ @URL::to(Request::path()) }}">
                                <div class="form-group">
                                    @foreach($tableColumns as $column)
                                        <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                        <p>{{ $tableRow->$column }}</p>
                                    @endforeach

                                    @if( isset($tableChildRows))
                                        @foreach($tableChildRows as $tableChildRow)

                                            @foreach($tableChildColumns as $column)
                                                <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                                <p>{{ $tableChildRow->$column }}</p>
                                            @endforeach

                                        @endforeach
                                    @endif

                                    @if(isset($tableChoiceLists))

                                        <?php $tableIteration = 1; ?>

                                        @foreach($tableChoiceLists as $tableChoiceList)
                                            <?php $dbColumn = $tableChoiceList['dbColumn'] ?>
                                            @if(!empty($tableRow->$dbColumn))

                                                <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
                                                <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="{{ $tableRow->$dbColumn }}">
                                                <div id="tableChoiceList{{$tableIteration}}" class="tableChoiceList tableChoiceListRfid">
                                                    @foreach($tableChoiceList["table"] as $oneChoice)
                                                        @if($oneChoice->id == $tableRow->$dbColumn )
                                                            <?php $titleColumn = $tableChoiceList["titleColumn"]; $contentColumn = $tableChoiceList["contentColumn"] ?>
                                                            <a id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}}' ">
                                                                <h4 class="list-group-item-heading">{{ $oneChoice->$titleColumn }}</h4>
                                                                <p class="list-group-item-text">{{ $oneChoice->$contentColumn }}</p>
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                <?php $tableIteration++ ?>
                                            @endif
                                        @endforeach
                                    @endif

                                </div>
                            </form>
                        <br>

                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop

@section("myjsfile")
@stop