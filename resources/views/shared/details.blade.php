@extends('master')
@section('csrfToken')

@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            @if (!empty($success))
                {{ $success }}
            @endif
                <?php $path = dirname(Request::path());?>
                <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
                <div class="panel-body">


                    @foreach($tableColumns as $column)
                        <div class="form-group">
                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                            <p id="{{ $column }}" name="{{ $column }}">{{ $tableRow->$column }}</p>
                        </div>
                    @endforeach

                    @if( isset($tableChildRows))
                        @foreach($tableChildRows as $tableChildRow)

                            @foreach($tableChildColumns as $column)
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <p id="{{ $column }}" name="{{ $column }}">{{ $tableChildRow->$column }}</p>
                                </div>
                            @endforeach

                        @endforeach
                    @endif

                </div>
        </div>
    </div>
@stop
