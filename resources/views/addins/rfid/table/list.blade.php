@extends('master')

@section('title', $title)

@section('content')
        <h2>{{ $title }}</h2>

        <div class="row">
        <div class="col-lg-12 panel-rfidTable" >
            <div class="panel">
                <div class="panel-body">
            <!-- Table Content --->
                    <ul class="sortable grid ">
                    <?php $i = count($items); ?>


                        @foreach($items as $item)


                            <div class="rfidTable">

                                <div class="rfidTableInside">
                                    <ul style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                                        @foreach($columns as $column)
                                            <li>{{ucwords( str_replace('_', ' ', $column))}} : {{ $item->$column }}</li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                    @endforeach


                    @for( $i; $i < count($items)+1; $i++ )
                            <div class="rfidTable">
                                <div class="rfidTableInside">
                                    <ul>
                                        <li class="addTable"><span class="glyphicon glyphicon-plus-sign"></span></li>
                                    </ul>
                                </div>
                            </div>

                    @endfor
                    </ul>
                </div>
            </div>
        </div>
        </div>

@stop
