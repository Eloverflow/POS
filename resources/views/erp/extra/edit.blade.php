@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('title', 'Extra')

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Edit Extra</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('extras') }}"> Back to extras </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => @URL::to('/extras/edit/' . $extra->slug), 'role' => 'form')) !!}
                        @foreach($tableColumns as $column)
                            @if($column == 'effect')
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <select name="{{ $column }}" class="form-control">
                                        <option value="" @if($extra[$column] == "") selected @endif >Aucun</option>
                                        <option value="-" @if($extra[$column] == "-") selected @endif >Soustraire</option>
                                        <option value="+" @if($extra[$column] == "+") selected @endif >Additionner</option>
                                        <option value="/" @if($extra[$column] == "/") selected @endif >Soustraire pourcentage</option>
                                        <option value="*" @if($extra[$column] == "*") selected @endif >Additionner pourcentage</option>
                                    </select>
                                </div>
                            @elseif($column == 'avail_for_command')
                                <div class="form-group">
                                    <label for="{{ $column }}" >Peut être appliqué sur commande ?</label>
                                    <select name="{{ $column }}" class="form-control">
                                        <option value="0" @if($extra[$column] == 0) selected @endif >Non</option>
                                        <option value="1" @if($extra[$column] == 1) selected @endif >Oui</option>
                                    </select>
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $extra[$column] }}">
                                </div>
                            @endif

                        @endforeach


                        <div class="form-group">
                            <p class="text-warning">* Pressez Ctrl pour selectionner/deselectionner unitairement</p>
                            <label for="items[]" >Associer aux items</label>
                            <select multiple name="items[]" class="form-control">
                                @foreach($items as $item)

                                    <option value="{{ $item->id }}" @foreach($extra['items'] as $extraItem) @if($item->id == $extraItem->item->id) selected @endif @endforeach>{{ $item->name }}</option>
                                @endforeach
                            </select>

                            <label for="itemtypes[]" >Associer aux types d'items</label>
                            <select multiple name="itemtypes[]" class="form-control">
                            @foreach($itemtypes as $itemtype)
                                    <option value="{{ $itemtype->id }}"  @foreach($extra['itemtypes'] as $extraItemtype) @if($itemtype->id == $extraItemtype->itemtype->id) selected @endif @endforeach>{{ $itemtype->type }}</option>
                            @endforeach
                            </select>
                        </div>

                    </div>

                </div>

                <!-- dialog buttons -->
                {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop