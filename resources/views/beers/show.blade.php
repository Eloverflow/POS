@extends('master')

@section('title', 'Beer')

@section('content')
    <div class="jumbotron">
        <h2><a href="{{@URL::to('/beers')}}">Beers</a> -> Beer -> {{ $beer->brand }} -> {{ $beer->name }}</h2>
        <form METHOD="POST" action="{{ URL::to('beers') }}/{{ $beer->slug }}">
            <div class="form-group">
                @foreach($columns as $column)
                    <label for="{{ $column }}" >{{ ucfirst($column) }}</label>
                    <input class="form-control" type="text" name="{{ $column }}" value="{{ $beer->$column }}">
                @endforeach
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
            @if($previous_beer->slug)
            <li class="previous"><a href="{{@URL::to('/beers/')}}/{{ $previous_beer->slug }}"><span aria-hidden="true">&larr;</span> {{ $previous_beer->slug }}</a></li>
            @endif

            @if($next_beer->slug)
            <li class="next"><a href="{{@URL::to('/beers/')}}/{{ $next_beer->slug }}">{{ $next_beer->slug }} <span aria-hidden="true">&rarr;</span></a></li>
            @endif
        </ul>
    </nav>

@stop
