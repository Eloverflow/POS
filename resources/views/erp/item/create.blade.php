@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('title', $title)

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Create Item</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('items') }}"> Back to items </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">

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

                        <button id="btnCreateItem" class="btn btn-primary pull-right">Create</button>

                    </div>
                    <div class="col-md-6">
                        <div id="formShowing">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="addModal" class="lumino modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Create Item Type</h4>
                </div>
                <div class="row">
                    <div id="displayErrors" style="display:none;" class="alert alert-danger">
                        <strong>Whoops!</strong><br><br>
                        <ul id="errors"></ul>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('typeName', "Type name" ) !!}
                            {!! Form::text('typeName', null, array('class' => 'form-control', 'id' => 'typeName')) !!}
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
                        <div class="parentSeparation">
                            <div class="separation"></div>
                        </div>
                        <div class="form-group">
                            <div class="labelBtn">
                                <div class="col-md-6">
                                    <label>Sizes name</label>
                                </div>
                                <div class="col-md-4">
                                    {!! Form::text('sizeName', null, array('class' => 'form-control', 'id' => 'sizeName', 'placeholder' => 'Size Name')) !!}
                                </div>
                                <div class="col-md-2">
                                    <a class="btn btn-success pull-right" id="btnAddSizeName" href="#"> Add </a>
                                </div>
                            </div>
                            <table id="tbl-sizes-name" class="table">
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
    <script src="{{ @URL::to('js/itemsManage.js') }}"></script>
    <script src="{{ @URL::to('js/itemTypesManage.js') }}"></script>
    <script type="text/javascript">
        $("#btnAddItemType").click(function () {
            $("#addModal").modal('show');
        });

        $("#btnAddFieldName").click(function () {
            addItemToFieldTable();
        });

        $("#btnAddSizeName").click(function () {
            addItemToSizeTable();
        });

        $('#btnCreateItemType').click(function(e) {
            e.preventDefault();
            postAddItemsType();

        });

        $("#btnCreateItem").click(function(e) {
            postCreateItem();
        });

        $("#tableChoiceList1 span").on("click", function() {
            //alert("span click !");


            drawFillingForms(this);


        });

    </script>
@stop