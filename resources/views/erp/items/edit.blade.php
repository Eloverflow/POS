@extends('master')

@section('title', $title)

@section('content')
    <div class="jumbotron">
        <h2><a href="{{@URL::to($title)}}">{{ $title }}</a> -> {{ $item->name }}</h2>
        <form METHOD="POST" action="{{ URL::to($title) }}/{{ $item->slug }}">
            <div class="form-group">
                @foreach($columns as $column)
                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $item->$column }}">
                @endforeach
                @foreach($columnsWith as $columnWith)
                    <label for="{{ $columnWith }}" >{{ ucwords( str_replace('_', ' ', $columnWith)) }}</label>
                    <input class="form-control" type="text" id="{{ $columnWith }}" name="{{ $columnWith }}" value="{{ $item->$withName->$columnWith }}">
                @endforeach

                    <?php $test = explode(',', $item->$withName->fields_names) ?>

                @foreach($item->$withName->$columnWith as $columnWith)
                    <label for="{{ $columnWith }}" >{{ ucwords( str_replace('_', ' ', $columnWith)) }}</label>
                    <input class="form-control" type="text" id="{{ $columnWith }}" name="{{ $columnWith }}" value="{{ $item->$withName->$columnWith }}">
                @endforeach

                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            </div>
            <button type="submit" class="btn btn-default">Update</button>
        </form>

        {{ var_dump($item) }}
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
            @if($previous_item->slug)
            <li class="previous"><a href="./{{ $previous_item->slug }}"><span aria-hidden="true">&larr;</span> {{ $previous_item->slug }}</a></li>
            @endif

            @if($next_item->slug)
            <li class="next"><a href="./{{ $next_item->slug }}">{{ $next_item->slug }} <span aria-hidden="true">&rarr;</span></a></li>
            @endif
        </ul>
    </nav>

@stop
