@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

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

                                @include('shared.choiceList')
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
