@extends('master')

@section('title', 'Beers')

@section('content')
    <div class="jumbotron">
        <h2>Beers</h2>

        <table class="table table-hover">

            <!-- Table Header --->
            <tr>
                @foreach($columns as $column)
                    <th>{{ucfirst($column)}}</th>
                @endforeach
            </tr>
            <!-- End Table Header --->

            <!-- Table Content --->
            @foreach($beers as $beer)
            <tr style="cursor: pointer; cursor: hand;" onclick="location.href='{{ @URL::to('/beers') }}/{{ $beer->slug }}';">

                @foreach($columns as $column)
                    <td>{{ $beer->$column }}</td>
                @endforeach

            </tr>
            @endforeach
            <!-- End Table Content --->
        </table>
    </div>

@stop
