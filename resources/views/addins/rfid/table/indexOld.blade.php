@extends('master')

@section('title', $title)

@section('content')
            <div class="panel">
                <div class="panel-body">
            <!-- Table Content --->
                    <ul class="sortable grid ">
                    <?php $i = count($tableRows); ?>


                        @foreach($tableRows as $item)


                            <div class="rfidTable">

                                <div class="rfidTableInside">
                                    <ul style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                                        @foreach($columns as $column)
                                            <li><span class="itemColumnTitle">{{ucwords( str_replace('_', ' ', $column))}} </span> @if( strlen($item->$column) > 10 || strlen($column) > 10)<br> @else : @endif {{ $item->$column }}</li>
                                        @endforeach

                                    </ul>
                                </div>
                            </div>
                    @endforeach


                    @for( $i; $i < count($tableRows)+1; $i++ )
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

@stop
