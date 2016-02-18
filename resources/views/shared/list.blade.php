@extends('master')

@section('title', $title)

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
                <?php $path = Request::path();?>
                <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
                <div class="panel-body">
                    <table class="table table-hover"  data-toggle="table" data-url="tables/data1.json"  data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-search="true" data-select-item-name="toolbar1" data-pagination="true" data-sort-name="name" data-sort-order="desc">

                        <!-- Table Header --->
                        <thead>
                        <tr>
                            @foreach($tableColumns as $column)
                                <th data-field="{{ $column }}" @if($column == 'id')data-checkbox="true"@else  data-sortable="true" @endif >{{ucwords( str_replace('_', ' ', $column))}}</th>
                            @endforeach

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

                                @foreach($tableColumns as $column)
                                    <td>{{ $tableRows[$i]->$column }}</td>
                                @endforeach

                                @if( isset($tableChildren))
                                        @foreach($tableChildren as $tableChild)
                                            @foreach($tableChild['columns'] as $column)
                                                <td>{{ $tableChildRows[$i]->$tableChild['name']->$column }}</td>
                                            @endforeach
                                        @endforeach
                                @endif
                                <td class="table-options">
                                    <a href="{{ @URL::to(Request::path().'/View/'.$tableRows[$i]->id)}}"><svg class="glyph stroked eye table-options-view"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-eye"></use></svg></a>
                                    <a href="{{ @URL::to(Request::path().'/Edit/'.$tableRows[$i]->id)}}"><svg class="glyph stroked pencil table-options-modify"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-pencil"></use></svg></a>
                                    <a href="{{ @URL::to(Request::path().'/Delete/'.$tableRows[$i]->id)}}"><svg class="glyph stroked cancel table-options-delete"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel"></use></svg></a>
                                </td>

                            </tr>

                        @endfor

                        </tbody>
                        <!-- End Table Content --->
                    </table>
                </div>
            </div>
        </div>
@stop