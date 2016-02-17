@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Menus</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table class="table table-hover"  data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">

                        <!-- Table Header --->
                        <thead>
                        <tr>
                            @foreach($tableColumns as $column)
                                <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                            @endforeach

                            @if( isset($tableChildRows))
                                @foreach($tableChildRows as $tableChildRow)

                                    @foreach($tableChildColumns as $column)
                                        <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                                    @endforeach
                                @endforeach
                            @endif
                        </tr>
                        </thead>
                        <!-- End Table Header --->

                        <!-- Table Content --->
                        <tbody>
                        @foreach($tableRows as $tableRow)

                            <tr style="cursor: pointer; cursor: hand;" onclick="location.href='{{ Request::path() }}/{{ $tableRow->slug }}';">

                                @foreach($tableColumns as $column)
                                    <td>{{ $tableRow->$column }}</td>
                                @endforeach
                                    @if( isset($tableChildRows))
                                        @foreach($tableChildRows as $tableChildRow)

                                            @foreach($tableChildColumns as $column)
                                                <td>{{ $tableChildRow->$column }}</td>
                                            @endforeach
                                        @endforeach
                                    @endif
                            </tr>
                        @endforeach

                        </tbody>
                        <!-- End Table Content --->
                    </table>
                </div>
            </div>
        </div>
    </div>

@stop