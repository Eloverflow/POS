@extends('POS.Command.mainLayout')

@section("csrfToken")
    <script src="{{ @URL::to('js/numPad.js') }}"></script>
@stop

@section('content')
    <table id="keyboard" ng-app="myApp" ng-controller="myCtrl">
        <tbody>
            <tr>
                <td colspan="4"><input type="text" name="mainText" value="<% mainText %>" class="form-control" id="mainText"></td>
            </tr>
            <tr>
                <td colspan="2"><button class="button" ng-click="padClick('dl')">Del</button></td>
                <td colspan="2"><button class="button" ng-click="padClick('cl')">Clear</button></td>
            </tr>

            <tr>
                <td><button class="button" ng-click="padClick(7)">7</button></td>
                <td><button class="button" ng-click="padClick(8)">8</button></td>
                <td><button class="button" ng-click="padClick(9)">9</button></td>
                <td rowspan="2"><button class="button" ng-click="padClick('clk')">Clock in/out</button></td>
            </tr>

            <tr>
                <td><button class="button" ng-click="padClick(4)">4</button></td>
                <td><button class="button" ng-click="padClick(5)">5</button></td>
                <td><button class="button" ng-click="padClick(6)">6</button></td>
            </tr>

            <tr>
                <td><button class="button" ng-click="padClick(1)">1</button></td>
                <td><button class="button" ng-click="padClick(2)">2</button></td>
                <td><button class="button" ng-click="padClick(3)">3</button></td>
                <td rowspan="2"><button class="button" ng-click="padClick('ent')">Ent</button></td>
            </tr>

            <tr>
                <td colspan="2"><button class="button" ng-click="padClick(0)">0</button></td>
                <td><button class="button" ng-click="padClick('pt')">.</button></td>
            </tr>
        </tbody>
    </table>
@stop

