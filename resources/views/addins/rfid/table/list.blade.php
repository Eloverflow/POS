@extends('master')

@section('title', $title)

@section('content')
        <h2>{{ $title }}</h2>

        <div class="row">
        <div class="col-lg-12" id="rfidTablesGrid">
            <!-- Table Content --->
            <div class="panel well">

            <table>
            @foreach($items as $item)

                <td class="rfidTableBorder">
                    <ul class="rfidTable"  style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                        @foreach($columns as $column)
                            <li>{{ucwords( str_replace('_', ' ', $column))}} : {{ $item->$column }}</li>
                        @endforeach

                    </ul>

                </td>
            @endforeach


                <?php $i = count($items) ?>
                {{--@for( $i; $i < 20; $i++ )
                    <td class="rfidTableBorder">
                        <ul class="rfidTable">
                            <li class="addTable"><span class="glyphicon glyphicon-plus-sign"></span></li>
                        </ul>

                    </td>
                @endfor--}}
            </table>
        </div>
        </div>
        </div>

@stop
