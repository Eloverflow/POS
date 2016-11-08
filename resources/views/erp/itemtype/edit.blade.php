@extends('master')

@section('afterContent')
    @include('shared.afterContent')
@stop

@section('titleSection')
@stop

@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('itemtype.updateToItemtype') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('itemtypes') }}"> {{ @Lang::get('itemtype.backToItemtype') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $path = dirname(Request::path());?>
                    <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
                    <div class="panel-body">

                        {!! Form::open(array('url' => @URL::to(Request::path()),'files' => true)) !!}
                            <div class="form-group">
                                @foreach($tableColumns as $column)
                                        <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                        <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableRow->$column }}">
                                @endforeach

                                @if(!empty($tableChildRows))
                                    @if(is_array($tableChildRows))
                                        @foreach($tableChildRows as $tableChildRow)



                                            @foreach($tableChildColumns as $column)

                                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRow->$column != null){{ $tableChildRow->$column }}@endif">
                                            @endforeach

                                        @endforeach
                                    @else
                                        @foreach($tableChildColumns as $column)
                                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRows->$column != null){{ $tableChildRows->$column }}@endif">
                                        @endforeach
                                    @endif
                                @endif

                                @if(isset($tableChoiceLists))
                                    @include('erp.item.choiceList')
                                @endif


                                <div id="formShowing">

                                </div>

                                @if(Session::has('error'))
                                    <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                                <div id="success"> </div>

                                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            </div>
                            <button type="submit" class="btn btn-default">Update</button>
                        </form>
                        <br>

                        @include('partials.alerts.errors')

                        @if(Session::has('flash_message'))
                            <div class="alert alert-success">
                                {{ Session::get('flash_message') }}
                            </div>
                        @endif
                    </div>
                </div>
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
