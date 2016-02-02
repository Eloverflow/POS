@extends('master')

@section('title', $title)

@section('content')
    <div class="jumbotron">
        <h2>{{ $title }}</h2>

        <table class="table table-hover">

            <!-- Table Header --->
            <tr>
                @foreach($columns as $column)
                    <th>{{ucwords( str_replace('_', ' ', $column))}}</th>
                @endforeach
            </tr>
            <!-- End Table Header --->

            <!-- Table Content --->
            @foreach($items as $item)
                <tr style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                    @foreach($columns as $column)
                        <td>{{ $item->$column }}</td>
                    @endforeach

                </tr>
                @endforeach
                        <!-- End Table Content --->
        </table>
    </div>

@stop
