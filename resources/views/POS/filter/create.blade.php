@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('title', 'Filter')

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Create Filter</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('filters') }}"> Back to filters </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'filters/create', 'role' => 'form')) !!}
                        @foreach($tableColumns as $column)
                            @if($column == 'importance')
                                <div class="form-group">
                                    <p class="text-warning">* Plus l'importance est eleve, le menu apparaitera en premier dans la liste</p>
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="number" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                </div>
                            @endif

                        @endforeach


                        <div class="form-group">
                            <p class="text-warning">* Pressez Ctrl pour selectionner/deselectionner unitairement</p>
                            <label for="items[]" >Associer aux items</label>
                            <select multiple name="items[]" class="form-control">
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <label for="itemtypes[]" >Associer aux types d'items</label>
                            <select multiple name="itemtypes[]" class="form-control">
                            @foreach($itemtypes as $itemtype)
                                    <option value="{{ $itemtype->id }}">{{ $itemtype->type }}</option>
                            @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                <!-- dialog buttons -->
                {!! Form::submit('Create', array('class' => 'btn btn-primary')) !!}
            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop