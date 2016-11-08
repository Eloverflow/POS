@extends('master')

@section('title', $title)

@section('afterContent')
    @include('shared.afterContent')
@stop


@section('titleSection')
    @include('shared.titleSection')
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('client.title') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a href="{{@URL::to('/clients/create')}}"  ><button type="button" class="btn btn-primary">{{ @Lang::get('client.addToClient') }}</button></a>
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

                                    @foreach($tableRows[0]['relations'] as $column=>$value)

                                            @if(is_array($value['relations']))

                                                @foreach($value['attributes'] as $subColumn=>$subValue)
                                                    @if($subColumn != "id" && $subColumn != "created_at" && $subColumn != "updated_at" && $subColumn != "slug" && !strpos($subColumn, 'id'))
                                                        <th data-field="{{ $subColumn }}" @if($subColumn == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $subColumn))}}</th>
                                                    @endif
                                                @endforeach

                                            @else

                                                <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>

                                            @endif
                                    @endforeach
                                @endif

                            @endif

                            @if( isset($tableChildren))
                                @foreach($tableChildren as $tableChild)
                                    @foreach($tableChild['columns'] as $column)
                                        <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                                    @endforeach
                                @endforeach
                            @endif
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


                                    @foreach($tableRows[$i]['relations'] as $column=>$value)

                                        @if(is_array($value['relations']))

                                            @foreach($value['attributes'] as $subColumn=>$subValue)
                                                @if($subColumn != "id" && $subColumn != "created_at" && $subColumn != "updated_at" && $subColumn != "slug" && !strpos($subColumn, 'id'))

                                                    <td>

                                                        @if(strpos($subColumn, 'array'))
                                                            {{ implode(",",unserialize($tableRows[$i]->$column->$subColumn)) }}
                                                        @else
                                                            {{ $tableRows[$i]->$column->$subColumn }}
                                                        @endif


                                                    </td>
                                                @endif
                                            @endforeach

                                        @else
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

                                @if( isset($tableChildren))
                                        @foreach($tableChildren as $tableChild)
                                            @foreach($tableChild['columns'] as $column)
                                                <td>
                                                    <?php $name  = $tableChild['name']; ?>
                                                @if($tableChildRows[$i]->$name != null)
                                                    {{ $tableChildRows[$i]->$name->$column }}
                                                @endif
                                                </td>
                                            @endforeach
                                        @endforeach
                                @endif
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