@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
{{--
@section('title', $title)--}}

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('inventory.title') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a href="{{@URL::to('/inventory/create')}}"  ><button type="button" class="btn btn-primary">{{ @Lang::get('inventory.addToInventory') }}</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                        <table class="table table-hover"  data-toggle="table"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">

                            <!-- Table Header --->
                            <thead>
                            <tr>
                                <th data-field="id" data-checkbox="true"  >id</th>
                                <th data-field="quantity" data-sortable="true" >Quantity</th>
                                <th data-field="item_id" data-sortable="true" >Item</th>
                                <th data-field="item_size" data-sortable="true" >Item Size</th>

                                <th>Options</th>
                            </tr>
                            </thead>
                            <!-- End Table Header --->

                            <!-- Table Content --->
                            <tbody>
                            @foreach($inventories as $inventory)
                                <tr>
                                    <td>{{ $inventory->id }}</td>
                                    <td>{{ $inventory->quantity }}</td>
                                    <td>{{ $inventory->item->name }}</td>
                                    <td>{{ $inventory->item_size }}</td>
                                    <td>
                                        <a href="{{@URL::to('/inventory/details/' . $inventory->slug)}}">Details</a>
                                        <a href="{{@URL::to('/inventory/edit/' . $inventory->slug)}}">Edit</a>
                                        <a href="{{@URL::to('/inventory/delete/' . $inventory->slug)}}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach()
                            </tbody>
                            <!-- End Table Content --->
                        </table>

                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop