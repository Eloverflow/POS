@extends('master')

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('extra.detailsExtra') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('extras') }}"> {{ @Lang::get('extra.backToExtra') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-12">
                        @foreach($tableColumns as $column)
                            @if($column == 'effect')
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                        @if($extra[$column] == "") <p>Aucun</p> @endif
                                        @if($extra[$column] == "-") <p>Soustraire</p>  @endif
                                        @if($extra[$column] == "+") <p>Additionner</p>  @endif
                                        @if($extra[$column] == "/") <p>Soustraire pourcentage</p>  @endif
                                        @if($extra[$column] == "*") <p>Additionner pourcentage</p>  @endif
                                </div>
                            @elseif($column == 'avail_for_command')
                                <div class="form-group">
                                    <label for="{{ $column }}" >Peut être appliqué sur commande ?</label>
                                    @if($extra[$column] == 0)<p>Non</p>@endif
                                    @if($extra[$column] == 1)<p>Oui</p>@endif
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                  <p>{{ $extra[$column] }}</p>
                                </div>
                            @endif

                        @endforeach


                        <div class="form-group">
                               @foreach($extra['items'] as $extraItem) {{ $extraItem }}@endforeach</p>

{{--
                            <label for="itemtypes[]" >Associer aux types d'items</label>
                            <select multiple name="itemtypes[]" class="form-control">
                                @foreach($itemtypes as $itemtype)
                                    <option value="{{ $itemtype->id }}"  @foreach($extra['itemtypes'] as $extraItemtype) @if($itemtype->id == $extraItemtype->itemtype->id) selected @endif @endforeach>{{ $itemtype->type }}</option>
                                @endforeach
                            </select>--}}
                        </div>

                    </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@stop