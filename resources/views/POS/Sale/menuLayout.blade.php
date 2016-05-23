<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PUBALEX @foreach(Request::segments() as $segment) {{ ' | ' . ucwords( str_replace('_', ' ', $segment))}} @endforeach</title>

    {{--Stylesheet call--}}
    <link href="{{ @URL::to('Framework/Bootstrap/3.3.6/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap-table.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/mainSale.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/menuSale.css') }}" rel="stylesheet">
    {{--End of Stylesheet call--}}

    <link href="{{ URL::to('Framework/please-wait/please-wait.css') }}" rel="stylesheet">

    <!--Icons-->
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/lumino.glyphs.js') }}"></script>


    <script src="{{ @URL::to('Framework/Angular/angular.min.js') }}"></script>


    <!--[if lt IE 9]>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/html5shiv.js') }}"></script>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/respond.min.js') }}"></script>
    <![endif]-->
    @yield('csrfToken')
</head>

<body ng-app="menu" ng-controller="menuController">
<script type="text/javascript" src="{{ URL::to('Framework/please-wait/please-wait.min.js')  }}"></script>
<script type="text/javascript">
    window.loading_screen = window.pleaseWait({
        logo: "{{ URL::to('Framework/please-wait/easypos.png')  }}",
        backgroundColor: '#222',
        loadingHtml: "<div class='spinner'><div class='rect1'></div> <div class='rect2'></div> <div class='rect3'></div> <div class='rect4'></div> <div class='rect5'></div> </div>"
    });
</script>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span>Facture</span> <span class="glyphicon glyphicon-barcode"></span>
            </button>
            <a class="navbar-brand" href="{{@URL::to('/menu/start')}}"> <span class="glyphicon glyphicon-circle-arrow-left"></span> <span>EASY</span>POS</a>
            <ul class="user-menu">

                <li  class="dropdown pull-right">
                    <a href="#" ng-click="changeEmployee()" ><svg class="glyph stroked male-user"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-male-user"></use></svg>
                        Employé #<% currentEmploye.number %></a>
                </li>
            </ul>
            <ul class="user-menu tableNumber">
                <li>
                    <a href="#" ng-click="toggleTableModal()"><span class="glyphicon glyphicon-unchecked"></span>
                        Table #<% currentTable.tblNumber %>
                       </a>
                </li>
            </ul>
            <ul class="user-menu">
                <li>
                    <a href="#" ng-click="openBill()"><span class="glyphicon glyphicon-bitcoin"></span>
                        Factures
                    </a>
                </li>
            </ul>
            <ul class="user-menu">
                <li>
                    <a style="cursor: not-allowed" href="#" ng-click="togglePlanModal()"><span class="glyphicon glyphicon-map-marker"></span>
                        Plan
                    </a>
                </li>
            </ul>

        </div>

    </div><!-- /.container-fluid -->
</nav>
<modal title="Selectionne une table" visible="showTableModal">
    <div ng-repeat="n in [] | floor:plan.nbFloor" >
        <span class="floor">Étage <% n+1 %></span>
        <div ng-repeat="i in plan.table | filter:{noFloor: n}">
            <button type="button" class="btn btn-success btn-table" ng-click="changeTable(i)" >Table #<% i.tblNumber %></button>
        </div>
    </div>
</modal>
<modal title="Diviser Factures" class="center-modal" visible="showDivideBillModal">
    <div class="divideBillChoices" >
        <div ng-click="perClientBill()" class="divideBillChoice">
            Une Facture par Personne
        </div>
        <div ng-click="oneBill()" class="divideBillChoice">
            Une Seule Facture
        </div>

        <div style="background-color: grey; cursor: default" ng-click="divideBill()" class="divideBillChoice">
            Diviser manuellement
        </div>
    </div>
</modal>
<modal title="Changement d'employee" class="center-modal" visible="showEmployeeModal">
        <div>
        <% currentEmploye.name %>
            <table id="keyboard">
                <tbody>
                <tr>
                    <td colspan="4" id="displayMessage"><% numPadMsg %></td>
                </tr>
                <tr>
                    <td colspan="4"><input id="mainText" type="text" name="mainText" value="<% mainText %>" class="form-control" id="mainText"></td>
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
    </div>
</modal>


@yield('content')


<div id="billWindow">
    <h1>Factures</h1>
    <div class="upRight">
        <button ng-click="closeBill()" type="button" class="btn btn-danger">FERMER</button>
    </div>
    <div class="bill-separation">
    </div>
    <div class="container-outer">
        <div class="container-inner">{{--
        <div ng-repeat="n in [] | floor:4" class="bill">--}}
           {{-- <ul>
                <li>test</li>
                <li>test</li>
            </ul>--}}

            <div ng-repeat="bill in bills"  class="bill" >

            <h2>Facture <% bill.number %></h2>
            <ul>


                <li ng-click="checkBillItem(commandItem)" ng-repeat="commandItem in bill" id="commandItem<% commandItem.id %>" class="sale-item">

                    <span ng-show="commandItem.checked" class="glyphicon glyphicon-check move-bill-item-check"></span>
                    <span ng-hide="commandItem.checked" class="glyphicon glyphicon-unchecked move-bill-item-check"></span>
                    <div class="saleTextZone">
                        <span><%commandItem.quantity%></span> x
                        <span class="sale-item-name"> <% commandItem.size.name + " " + commandItem.name%></span></div>
                    <span class="">$ <% (commandItem.size.price*commandItem.quantity | number:2) %></span>

                    <div ng-show="commandItem.notes.length != 0" class="itemNoteSeparation">
                        <p ng-repeat="item in commandItem.notes"><% item.note %></p>
                    </div>
                </li>
                <li class="add-bill-item">
                    <span class="glyphicon glyphicon-plus"></span>
                </li>

                <li ng-show="movingBillItem" class="move-bill-item">
                    <span class="glyphicon glyphicon glyphicon-share"></span>
                </li>
            </ul>
                <h3>Total: $ <% bill.total | number:2 %></h3>
            </div>
        </div>
    </div>
</div>

@yield('myjsfile')
</body>

</html>