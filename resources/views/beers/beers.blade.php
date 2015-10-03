@extends('master')

@section('title', 'Beers')

@section('content')
    <div class="jumbotron">
        <h1>Beers</h1>

        <table class="table table-hover">
            <tr><th>#</th><th>Name</th><th>Style</th><th>Percent</th><th>Brand</th></tr>
            <?php
            foreach ($beers as $beer) {
            ?>
            <tr style="cursor: pointer; cursor: hand;" onclick="location.reload();location.href='{{ @URL::to('/beers') }}/{{ $beer->slug }}';">
                <td>{{ $beer->id }}</td><td>{{ $beer->name }}</td><td>{{ $beer->style }}</td><td>{{ $beer->percent }}</td><td>{{ $beer->brand }}</td>
            </tr>
            <?php
            }
            ?>
        </table>
    </div>

@stop
