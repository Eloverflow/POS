@extends('master')
@section('csrfToken')

    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">{{ $title }}</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('Schedule/Create') }}"> Create New </a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
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
            <nav>
                <ul class="pager">
                    @if($previousTableRow->slug)
                        <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->slug }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->slug }}</a></li>
                    @elseif($previousTableRow->id)
                        <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->id }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->id }}</a></li>
                    @endif
                    @if($nextTableRow->slug)
                        <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->slug }}">{{ $nextTableRow->slug }} <span aria-hidden="true">&rarr;</span></a></li>
                    @elseif($nextTableRow->id)
                        <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->id }}">{{ $nextTableRow->id }} <span aria-hidden="true">&rarr;</span></a></li>
                    @endif
                </ul>
            </nav>
        </div>
    </div>
@stop
