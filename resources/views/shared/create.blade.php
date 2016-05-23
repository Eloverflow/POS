@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('title', $title)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Create</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">

                    <form METHOD="POST" action="{{ @URL::to(Request::path()) }}">

                            @foreach($tableColumns as $column)
                                <div class="form-group">
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                </div>
                            @endforeach

                            @if(isset($tableChildColumns))
                                    @foreach($tableChildColumns as $column)
                                        <div class="form-group">
                                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ old($column) }}">
                                        </div>
                                    @endforeach
                            @endif

                            @if(isset($tableChoiceLists))
                                    <div class="form-group">
                                        @include('shared.choiceList')
                                    </div>
                            @endif

                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                        <button type="submit" class="btn btn-primary pull-right">Create</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    <div id="addModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('name', "Name" ) !!}
                            {!! Form::text('name', old('name'), array('class' => 'form-control', 'id' => 'name')) !!}
                        </div>
                        <div class="form-group">
                            <div class="labelBtn">
                                <div class="col-md-6">
                                    <label>Fields name</label>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('fieldName', null, array('class' => 'form-control', 'id' => 'fieldName', 'placeholder' => 'Field Name')) !!}
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-success pull-right" id="btnAddFieldName" href="#"> Add </a>
                                </div>
                            </div>
                            <table id="tbl-fields-name" class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <div class="labelBtn">
                                <div class="col-md-2">
                                    <label>Sizes name</label>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('sizeName', null, array('class' => 'form-control', 'id' => 'sizeName', 'placeholder' => 'Size Name')) !!}
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('price', null, array('class' => 'form-control', 'id' => 'price', 'placeholder' => 'Price')) !!}
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-success pull-right" id="btnAddSizeName" href="#"> Add </a>
                                </div>
                            </div>
                            <table id="tbl-sizes-name" class="table">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer"><button id="btnCreateItemType" type="button" class="btn btn-primary">Create</button></div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/itemTypesManage.js') }}"></script>
    <script type="text/javascript">
        $("#btnAddItemType").click(function () {
            $("#addModal").modal('show');
        });

        $("#btnAddFieldName").click(function () {

        });

        $("#btnAddSizeName").click(function () {

        });

        $('#btnCreateItemType').click(function(e) {
            e.preventDefault();
            postAddItemsType();

        });
    </script>
@stop