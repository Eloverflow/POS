@extends('master')

@section('title', 'Beers')

@section('content')
    <div class="jumbotron">
        <h1>Beers</h1>
        <form>
            <div class="form-group">
            <label>Name</label> <input class="form-control" type="text" name="name" value="{{ $beer->name }}">
            <label>Style</label> <input class="form-control" type="text" name="style" value="{{ $beer->style }}">
            <label>Percent</label> <input class="form-control" type="text" name="percent" value="{{ $beer->percent }}">
            <label>Brand</label> <input class="form-control" type="text" name="brand" value="{{ $beer->brand }}">
            </div>
            <button type="submit" class="btn btn-default">Submit</button>
        </form>
    </div>

@stop
