@extends('master')

@section("csrfToken")
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{ @URL::to('js/utils.js') }}"></script>

@stop


@section('content')
    <div id="displayErrors" style="display:none;" class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul id="errors"></ul>
    </div>
    <h3>Settings: </h3>
    <h5>Floor Number:</h5>
    <br/>
    {!! Form::text('jsonTables', $menuSetting['use_email'], array('class' => 'form-control', 'id' => 'jsonTables', 'style' => 'display:none;visibility:hidden;')) !!}
    <div id="rowCmd">
        <a id="btnNewTable" class="btn btn-primary" href="#"> Save </a>
    </div>
    <div hidden id="follower"><span class="glyphicon glyphicon-plus"></span></div>

    <!--Horizontal Tab-->
    <div id="parentHorizontalTab">
        <ul class="resp-tabs-list hor_1">

        </ul>
        <div id="tabControl" class="resp-tabs-container hor_1">

        </div>
    </div>

    <div id="editModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- dialog body -->
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <div class="col-md-4">
                        <div class="form-group">
                            {!! Form::label('tblNum', "Table Number" ) !!}
                            {!! Form::text('tblNum', null, array('class' => 'form-control', 'id' => 'tblNum')) !!}
                        </div>
                    </div>
                </div>

                <!-- dialog buttons -->
                <div class="modal-footer">
                    <button id="btnDelTable" type="button" class="btn btn-danger">Delete</button>
                    <button id="btnEditTable" type="button" class="btn btn-primary">Edit</button>
                </div>
            </div>
        </div>
    </div>
@stop

@section('myjsfile')
@stop