@extends('master')

@section('title', $title)

@section('content')
    <div class="jumbotron">
        <h2>{{ $title }}</h2>

        <div class="well" id="rfidTablesGrid">
            <!-- Table Content --->

            @foreach($items as $item)

                <div class="rfidTableBorder">
                    <ul class="rfidTable"  style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                        @foreach($columns as $column)
                            <li>{{ucwords( str_replace('_', ' ', $column))}} : {{ $item->$column }}</li>
                        @endforeach

                    </ul>

                </div>
            @endforeach


            <?php $i = count($items) ?>
            @for( $i; $i < 20; $i++ )
                <div class="rfidTableBorder">
                    <ul class="rfidTable">
                        <li><button class="form-control">Add</button></li>
                    </ul>

                </div>
            @endfor

        </div>
    </div>

@stop
