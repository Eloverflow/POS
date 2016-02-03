@extends('master')

@section('title', $title)

@section('content')
    <div class="jumbotron">
        <?php $path = dirname(Request::path());?>
        <h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2>
        <form METHOD="POST" action="{{ @URL::to(Request::path()) }}">
            <div class="form-group">
                @foreach($tableColumns as $column)
                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableRow->$column }}">
                @endforeach

                @if( is_array($tableChildRows))
                    @foreach($tableChildRows as $tableChildRow)

                        @foreach($tableChildColumns as $column)
                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableChildRow->$column }}">
                        @endforeach

                    @endforeach
                @else
                    @foreach($tableChildColumns as $column)
                        <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableChildRows->$column }}">
                    @endforeach
                @endif

                    <label for="image" >Image</label>
                    {!! Form::open(array('url'=>'apply/upload','method'=>'POST', 'files'=>true)) !!}
                    <div class="control-group">
                        <div class="controls">
                            {!! Form::file('image') !!}
                            <p class="errors">{!!$errors->first('image')!!}</p>
                            @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
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

@stop
