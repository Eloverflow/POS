@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Plan Preview</h1>
        </div>
    </div>
    <div class="row" ng-app="myApp" >
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body" ng-controller="menuController">
                    <div id="planModal">
                        <span id="floorNumber" >Étage #<% plan.currentFloor+1 %></span>
                        <div class="planRightButton">
                            <span id="planZoomout" class="glyphicon glyphicon-zoom-out"></span>
                            <span ng-show="plan.currentFloor < plan.nbFloor-1"  ng-click="floorUp()"  id="floorup" class="glyphicon glyphicon-upload"></span>
                            <span ng-show="plan.currentFloor > 0" ng-click="floorDown()" id="floordown" class="glyphicon glyphicon-download"></span>
                        </div>
                        <div class="parent">
                            <div class="panzoom">
                                <canvas style="margin: 0;" id="planCanvas" width="0" height="0" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop


@section('myjsfile')
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.8/angular.min.js"></script>
    <script src="{{ @URL::to('js/jquery.panzoom.min.js') }}"></script>
    <script src="{{ @URL::to('js/posMenuPlanPreview.js') }}"></script>
    <script >
        $('#sidebar-collapse').delay(50).animate({width: 0}, 200);
        $('.col-sm-9.col-sm-offset-3.col-lg-10.col-lg-offset-2').delay(50).animate({width: '100%', marginLeft: 0, position: 'absolute'}, 200)

    </script>

@stop

