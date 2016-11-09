@extends('master')

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('rfidtable.title') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a href="{{@URL::to('/addon/rfid/table/create')}}"  ><button type="button" class="btn btn-primary">{{ @Lang::get('rfidtable.addToRfidtable') }}</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (!empty($success))
                        {{ $success }}
                    @endif
                    <?php $path = Request::path();?>
                    <table data-toggle="table" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">
                        <!-- Table Header --->
                        <thead>
                        <tr>
                            @if(!empty($tableColumns ))
                                @foreach($tableColumns as $column)
                                    <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                                @endforeach
                            @else


                                @if(!empty($tableRows[0]))

                                    <th data-field="id" data-checkbox="true">ID</th>

                                    @foreach($tableRows[0]['attributes'] as $column=>$value)
                                        @if($column != "id" && $column != "created_at" && $column != "updated_at" && $column != "slug" && !strpos($column, 'id'))
                                            <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                                        @endif
                                    @endforeach
                                @endif

                            @endif
                            <th>Beer 1</th>
                            <th>Beer 2</th>
                            <th>Options</th>
                        </tr>
                        </thead>
                        <!-- End Table Header --->

                        <!-- Table Content --->
                        <tbody>
                        <?php $i = 0;?>

                        @for($i; $i < count($tableRows); $i++)

                            <tr>

                                @if(!empty($tableColumns ))
                                    @foreach($tableColumns as $column)
                                        <td>{{ $tableRows[$i]->$column }}</td>
                                    @endforeach
                                @else
                                    <td>{{ $tableRows[$i]->id }}</td>

                                    @foreach($tableRows[$i]['attributes'] as $column=>$value)
                                        @if($column != "id" && $column != "created_at" && $column != "updated_at" && $column != "slug" && !strpos($column, 'id'))
                                            <td>

                                                @if(strpos($column, 'array'))
                                                    {{ implode(",",unserialize($tableRows[$i]->$column)) }}
                                                @else
                                                    {{ $tableRows[$i]->$column }}
                                                @endif

                                            </td>

                                        @endif
                                    @endforeach
                                @endif

                                <td class="">
                                    {{$tableRows[$i]->beer1['name']}}
                                </td>
                                <td class="">
                                    {{$tableRows[$i]->beer2['name']}}
                                </td>
                                <td class="table-options">
                                    <?php !empty($tableRows[$i]->slug) ? $target = $tableRows[$i]->slug : $target = $tableRows[$i]->id ?>
                                    <a href="{{ @URL::to(Request::path().'/details/'. $target)}}">Details</a>
                                    <a href="{{ @URL::to(Request::path().'/edit/'. $target)}}">Edit</a>
                                    <a href="{{ @URL::to(Request::path().'/delete/'. $target)}}">Delete</a>
                                </td>

                            </tr>

                        @endfor

                        </tbody>
                        <!-- End Table Content --->
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop