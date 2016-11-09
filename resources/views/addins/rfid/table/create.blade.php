@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('rfidtable.addToRfidtable') }}</h1>
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
                                        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="">
                                    @endforeach

                                    @if( isset($tableChildRows))
                                        @foreach($tableChildRows as $tableChildRow)

                                            @foreach($tableChildColumns as $column)
                                                <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                                <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableChildRow->$column }}">
                                            @endforeach

                                        @endforeach
                                    @endif

                                    @if(isset($tableChoiceLists))

                                        <?php $tableIteration = 1; ?>

                                        @foreach($tableChoiceLists as $tableChoiceList)

                                            <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
                                            <?php $dbColumn = $tableChoiceList['dbColumn'] ?>
                                            <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="">
                                            <div id="tableChoiceList{{$tableIteration}}" class="tableChoiceList tableChoiceListRfid">
                                                @foreach($tableChoiceList["table"] as $oneChoice)
                                                    <?php $titleColumn = $tableChoiceList["titleColumn"]; $contentColumn = $tableChoiceList["contentColumn"] ?>
                                                    <a id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} @if($oneChoice->id == 0 ) active @endif' ">
                                                        <h4 class="list-group-item-heading">{{ $oneChoice->$titleColumn }}</h4>
                                                        <p class="list-group-item-text">{{ $oneChoice->$contentColumn }}</p>
                                                    </a>
                                                @endforeach
                                            </div>
                                            <a><div id="tableChoiceListArrow{{$tableIteration}}" class="alert-info tableChoiceListArrow" role="alert"><span class="glyphicon glyphicon-chevron-down"></span></div></a>

                                            <?php $tableIteration++ ?>
                                        @endforeach
                                    @endif

                                    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                                </div>
                                <button type="submit" class="btn btn-default pull-right">{{ @Lang::get('rfidtable.addToRfidtable') }}</button>
                            </form>
                        <br>

                        @include('partials.alerts.errors')

                        </div>
                    </div>
                </div>
            </div>
        </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/tableChoiceListRfidTable.js') }}"></script>
@stop