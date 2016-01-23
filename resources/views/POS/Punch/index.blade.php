@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Punch</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="panel panel-red">
                <div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Calendar</div>
                <div class="panel-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if (!empty($success))
                        {{ $success }}
                    @endif
                        <div class="col-md-6">
                            <div class="vcenter">
                                <a class="btn btn-primary pull-right" href="{{ @URL::to('/Create') }}"> Create New </a>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
@stop
