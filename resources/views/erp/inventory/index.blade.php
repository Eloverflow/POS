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
                                <th data-field="name" data-sortable="true" >Quantity</th>
                                <th data-field="desc" data-sortable="true" >Description</th>
                                <th data-field="effect" data-sortable="true" >Effet</th>
                                <th data-field="value" data-sortable="true" >Valeur</th>
                                <th data-field="items" data-sortable="true" >Items</th>
                                <th data-field="itemtypes" data-sortable="true" >Item Types</th>

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
                                  {{--  <td>@foreach($inventory->items as $item) {{ $item->item->name }} <br> @endforeach</td>--}}
                                    <td><a href="{{@URL::to('/inventory/edit/' . $inventory->slug)}}">Edit</a></td>
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