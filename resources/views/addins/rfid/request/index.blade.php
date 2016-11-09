@extends('master')

@section('title', $title)

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('rfidrequest.title') }}</h1>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="panel-body">
                        <table class="table table-hover">

                            <!-- Table Header --->
                            <tr>
                                @foreach($columns as $column)
                                    <th>{{ucwords( str_replace('_', ' ', $column))}}</th>
                                @endforeach
                            </tr>
                            <!-- End Table Header --->

                            <!-- Table Content --->
                            @foreach($items as $item)
                                <tr style="cursor: pointer; cursor: hand;" onclick="location.href='{{ strtolower($title) }}/{{ $item->slug }}';">

                                    @foreach($columns as $column)
                                        <td>{{ $item->$column }}</td>
                                    @endforeach

                                </tr>
                                @endforeach
                                        <!-- End Table Content --->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@stop
