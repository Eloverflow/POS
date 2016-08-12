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
                                    <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="{{ $tableRow->$dbColumn }}">
                                    <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
                                        @foreach($tableChoiceList["table"] as $oneChoice)
                                            <?php $titleColumn = $tableChoiceList["titleColumn"]; $contentColumn = $tableChoiceList["contentColumn"] ?>
                                            <a id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} @if($oneChoice->id == $tableRow->$dbColumn ) active @endif' ">
                                                <h4 class="list-group-item-heading">{{ $oneChoice->$titleColumn }}</h4>
                                                <p class="list-group-item-text">{{ $oneChoice->$contentColumn }}</p>
                                            </a>
                                        @endforeach
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
            <nav>
                <ul class="pager">
                    @if($previousTableRow->slug)
                        <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->slug }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->slug }}</a></li>
                    @endif

                    @if($nextTableRow->slug)
                        <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->slug }}">{{ $nextTableRow->slug }} <span aria-hidden="true">&rarr;</span></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@stop
