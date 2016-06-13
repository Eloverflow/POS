@extends('shared.list')

@section('titleSection')
    <div class="col-md-6">
        <h1 class="page-header">Items</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-primary pull-right" href="{{ @URL::to('items/create') }}"> Create New </a>
        </div>
    </div>
@overwrite
