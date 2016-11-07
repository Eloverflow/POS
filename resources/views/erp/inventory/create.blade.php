@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop

@section('title', 'Extra')

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">{{ @Lang::get('inventory.addToInventory') }}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a class="btn btn-danger pull-right" href="{{ @URL::to('inventory') }}"> {{ @Lang::get('inventory.backToInventory') }} </a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        {!! Form::open(array('url' => 'extras/create', 'role' => 'form')) !!}

                       {{--     <select multiple name="items[]" class="form-control">
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>--}}

                            @if(isset($tableChoiceLists))
                                <div class="form-group">
                                    @include('erp.inventory.choiceList')
                                </div>
                            @endif


                    </div>
                    <div class="col-md-6">
                        <div id="formShowing">

                        </div>
                    </div>

                    <!-- dialog buttons -->
                    {!! Form::submit('Ajouter', array('class' => 'btn btn-primary')) !!}
                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

    <script src="{{ @URL::to('js/inventoriesManage.js') }}"></script>
    <script type="text/javascript">

        $("#tableChoiceList1 span").on("click", function() {
            //alert("span click !");


            drawFillingForms(this);


        });

    </script>
@stop