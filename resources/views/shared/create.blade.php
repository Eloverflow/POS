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
                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                        @endforeach

                        @if(isset($tableChildColumns))
                                @foreach($tableChildColumns as $column)
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                @endforeach
                        @endif

                        @if(isset($tableChoiceLists))

                            <?php $tableIteration = 1; ?>

                            @foreach($tableChoiceLists as $tableChoiceList)

                                <label for="{{ $tableChoiceList['dbColumn'] }}">{{ $tableChoiceList["title"] }}</label>
                                <input class="form-control input{{$tableIteration}}" type="hidden" id="{{ $tableChoiceList['dbColumn'] }}" name="{{ $tableChoiceList['dbColumn'] }}" value="">
                                <div id="tableChoiceList{{$tableIteration}}" class="list-group tableChoiceList">
                                    @foreach($tableChoiceList["table"] as $oneChoice)
                                        <a id="{{$oneChoice->id}}" class="list-group-item tableChoice choiceList{{$tableIteration}} active' ">
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

                                            <span class="glyphicon glyphicon-plus-sign add-one"></span> New
                                            {{--<svg class="glyph stroked plus sign"><use xlink:href="#stroked-plus-sign"/></svg>--}}
                                        </a>

                                </div>
                                <a><div id="tableChoiceListArrow{{$tableIteration}}" class="alert alert-info tableChoiceListArrow" role="alert"><span class="glyphicon glyphicon-chevron-down"></span></div></a>

                                <?php $tableIteration++ ?>
                            @endforeach
                        @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    </div>
                    <button type="submit" class="btn btn-default">Create</button>
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
