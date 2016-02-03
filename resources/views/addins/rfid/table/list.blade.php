@extends('master')

@section('title', $title)

@section('content')
        <h2>{{ $title }}</h2>

        <div class="row">
        <div class="col-lg-12" >
            <!-- Table Content --->
            <div class="panel well">

            <table class="table table-bordered rfidTableGrid">
                <tbody>
                <tr>

                    <?php $i = count($items); $j = 0; ?>

                        @for(  $j; $j < $i; $j++)

                        @if(($i % 4) == 0)
                            </tr>
                            <tr>

                        @endif

                        <td class="">
                            <div class="rfidTableBorder">
                            <ul class="rfidTable"  style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $items[$j]->slug }}';">

                                @foreach($columns as $column)
                                    <li>{{ucwords( str_replace('_', ' ', $column))}} : {{ $items[$j]->$column }}</li>
                                @endforeach

                            </ul>
                            </div>
                        </td>
                    @endfor


                    @for( $i; $i <= $j*2*3 -1; $i++ )
                                    @if(($i % 4) == 0)
                            </tr>
                <tr>

                    @endif
                        <td class="">
                            <div class="rfidTableBorder">
                            <ul class="rfidTable">
                                <li class="addTable"><span class="glyphicon glyphicon-plus-sign"></span></li>
                            </ul>
                            </div>
                        </td>
                    @endfor
                </tr>
                </tbody>
            </table>
        </div>
        </div>
        </div>

@stop
