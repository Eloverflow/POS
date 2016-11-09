@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop


@section('afterContent')
    @include('shared.afterContent')
@stop


@section('title', 'Extra')

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('inventory.updateToInventory') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('inventory') }}"> {{ @Lang::get('inventory.backToInventory') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                    {!! Form::open(array('url' => 'inventory/edit/'.$inventory->slug, 'role' => 'form')) !!}


                    <div class="form-group">
                        <label for="item" >Item</label>
                        <p>{{ $inventory->item->name }}</p>
                        <label for="item" >Item Size</label>
                        <p>{{ $inventory->item_size }}</p>
                    </div>


                    <div class="form-group">
                        <label for="quantity" >Quantité</label>
                        <input class="form-control" type="number" id="quantity" name="quantity" value="{{ $inventory->quantity }}">
                    </div>


                    </div>
                    <div class="col-md-12">
                        <!-- dialog buttons -->
                        {!! Form::submit('Metre à jour', array('id' => 'btn-edit-inventory','class' => 'btn btn-primary pull-right ')) !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop