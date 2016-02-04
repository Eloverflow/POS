@extends('master')

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div id="panel-auth" class="panel panel-default">
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

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                        </div>
                        <button type="submit" class="btn btn-default">Update</button>
                    </form>
                    <br>

                        <label for="sel1">Select list:</label>
                        @if(isset($tableChoiceList))

                            <div class="list-group tableChoiceList">
                                        @foreach($tableChoiceList as $oneChoice)
                                                <a class="list-group-item tableChoice @if($oneChoice->id == 1) active @endif' ">
                                                    <h4 class="list-group-item-heading">{{ $oneChoice->$tableChoiceListTitleColumn }}</h4>
                                                    <p class="list-group-item-text">{{ $oneChoice->$tableChoiceListContentColumn }}</p>
                                                </a>
                                        @endforeach
                            </div>
                            <a><div class="alert alert-info tableChoiceListArrow" role="alert"><span class="glyphicon glyphicon-chevron-down"></span></div></a>
                        @endif

                    @include('partials.alerts.errors')

                    @if(Session::has('flash_message'))
                        <div class="alert alert-success">
                            {{ Session::get('flash_message') }}
                        </div>
                    @endif

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
    </div>

@stop
