@extends('master')

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('filter.detailsFilter') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('filters') }}"> {{ @Lang::get('filter.backToFilter') }} </a>
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
                                    @if($filter[$column] == "") <p>Aucun</p> @endif
                                    @if($filter[$column] == "-") <p>Soustraire</p>  @endif
                                    @if($filter[$column] == "+") <p>Additionner</p>  @endif
                                    @if($filter[$column] == "/") <p>Soustraire pourcentage</p>  @endif
                                    @if($filter[$column] == "*") <p>Additionner pourcentage</p>  @endif
                                </div>
                            @elseif($column == 'avail_for_command')
                                <div class="form-group">
                                    <label for="{{ $column }}" >Peut être appliqué sur commande ?</label>
                                    @if($filter[$column] == 0)<p>Non</p>@endif
                                    @if($filter[$column] == 1)<p>Oui</p>@endif
                                </div>
                            @else
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <p>{{ $filter[$column] }}</p>
                                </div>
                            @endif

                        @endforeach


                        <div class="form-group">
                            @if(!empty($filter['items']) && count($filter['items']) > 0)
                                <label for="" >Item:</label>
                                <p>@foreach($filter['items'] as $filterItem) {{ $filterItem->item->name }}@endforeach</p>
                            @endif

                            @if(!empty($filter['itemtypes']) && count($filter['itemtypes']) > 0)
                                <label for="" >Item type:</label>
                                <p>@foreach($filter['itemtypes'] as $filterItemtype) {{ $filterItemtype->itemtype->type }}@endforeach</p>
                            @endif

                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@stop