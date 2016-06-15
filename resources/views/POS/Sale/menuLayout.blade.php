<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POSIO @foreach(Request::segments() as $segment) {{ ' | ' . ucwords( str_replace('_', ' ', $segment))}} @endforeach</title>

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
        logo: "{{ URL::to('Framework/please-wait/posio.png')  }}",
        backgroundColor: '#222',
        loadingHtml: "<div class='spinner'><div class='rect1'></div> <div class='rect2'></div> <div class='rect3'></div> <div class='rect4'></div> <div class='rect5'></div> </div>"
    });
</script>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle command</span>
                <span>Commande</span> <span class="glyphicon glyphicon-barcode"></span>
            </button>
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse2">
                <span class="sr-only">Toggle navigation</span>
                <span>Prix</span> <span class="glyphicon glyphicon-euro"></span>
            </button>
            <button type="button" class="navbar-toggle collapsed" ng-click="toggleHeaderOptions()">
                <span class="sr-only">Toggle options</span>
                <span>Options</span> <span class="glyphicon glyphicon-list-alt"></span>
            </button>
            <a class="navbar-brand" href="{{@URL::to('/menu')}}"><span>Pos</span>Io</a>
            <div ng-show="showHeaderOptions" id="header-options">
                <span  ng-click="changeEmployee()"  class="menu-option">
                    <a href="#"><span class="glyphicon glyphicon-user"></span>
                        Employé #<% currentEmploye.id %></a>
                </span>
                <span  ng-click="toggleTableModal()" class="menu-option">
                    <a href="#"><span class="glyphicon glyphicon-unchecked"></span>
                        Table #<% currentTable.tblNumber %>
                    </a>
                </span>
                <span ng-click="toggleBill()" class="menu-option">
                    <a href="#" ><span class="glyphicon glyphicon-bitcoin"></span>
                        Factures
                    </a>
                </span>
                <span ng-click="togglePlanModal()" class="menu-option">
                    <a href="#" ><span class="glyphicon glyphicon-map-marker"></span>
                        Plan
                    </a>
                </span>
                <span  ng-click="toogleFullscreen()" class="menu-option">
                    <a href="#"><span class="glyphicon glyphicon-fullscreen"></span>
                        Plein écran
                    </a>
                </span>
            </div>
        </div>


</nav>

<modal title="Selectionne une table" visible="showTableModal">
    <div ng-repeat="n in [] | floor:plan.nbFloor" >
        <span class="floor">Étage <% n+1 %></span>
        <div ng-repeat="i in plan.table | filter:{noFloor: n}">
            <button type="button" class="btn btn-success btn-table status<% i.status %>" ng-click="changeTable(i)" >Table #<% i.tblNumber %></button>
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

        <div  ng-click="manualBill()" class="divideBillChoice">
            Diviser manuellement
        </div>
    </div>
</modal>
<modal title="Êtes-vous sure ?" class="center-modal" visible="showPanelOverwriteBill">
    <div class="divideBillChoices" >
        <div ng-click="toggleDivideBillModal();togglePanelOverwriteBill();" class="divideBillChoice">
            Rediviser les factures
        </div>
        <div ng-click="togglePanelOverwriteBill();openBill();" class="divideBillChoice">
            Voir les factures
        </div>
    </div>
</modal>
<modal title="Changement d'employee" id="changeEmployee" class="center-modal employee-modal" visible="showEmployeeModal">
        <div>
            {{--
        Employee courant : <% currentEmploye.firstName %> <% currentEmploye.lastName %>--}}
            <span ng-click="changeEmployeeStepBack()" ng-show="validation" style="margin: 10px 0 0 20px ; cursor:pointer; padding: 10px; background-color: #444; border-radius: 50%; font-size: 25px; float: left; color: #fff; position: absolute" class='glyphicon glyphicon-arrow-left'></span>
            <a ng-show="!validation" href="/"><span id="quit-emplye-modal" class='glyphicon glyphicon-remove-sign'></span></a>
            <div style="width: 100%; text-align: center; padding-top: 10px"><span style="color: red; font-size: 15px;"><% numPadErrMsg %></span></div>
            <table id="keyboard">
                <tbody>
                <tr id="rowTitle">
                    <td colspan="4" id="displayTitle"><% numPadMsg %></td>
                </tr>
                <tr>
                    <td colspan="4" id="displayMessage">
                        <input type="text" name="mainText" value="<% mainText %>" class="form-control" id="mainText">
                        <em style="color: white; font-size: 18px;">Utilisez : 3 : 11</em>
                    </td>

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

<div  id="planModal" ng-show="showPlanModal">
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

<div id="billWindow">
    <h1>Factures</h1>
    <div class="upRight">
        <button  style="background-color: #333; border-color: #8ad919" ng-click="terminateCommands()" type="button" class="btn btn-info">Terminer les commandes</button>
        <button  style="background-color: #333; border-color: #30a5ff" ng-click="" type="button" class="btn btn-success">Imprimer les factures</button>
        <button ng-click="closeBill()" type="button" class="btn btn-danger">FERMER</button>
    </div>
    <div class="bill-separation">
        <uib-progressbar class="progress-striped active bill" animate="true" max="100" value="progressValue" type="success">
            <i><%savingMessage%></i>
        </uib-progressbar>
    </div>
        <div id="filter-wrapper-bill" style="overflow: hidden;">


            <div class="bills-inner">{{--
            <div ng-repeat="n in [] | floor:4" class="bill">--}}
               {{-- <ul>
                    <li>test</li>
                    <li>test</li>
                </ul>--}}

                <div ng-repeat="bill in bills" class="bill" >

                    <span ng-show="bill.checked"  ng-click="checkBill(bill)" class="glyphicon glyphicon-check move-bill-check"></span>
                    <span ng-hide="bill.checked"  ng-click="checkBill(bill)" class="glyphicon glyphicon-unchecked move-bill-check"></span>
                <h2 style="color: white">Facture <% bill.number %></h2>
                <ul>


                    <li ng-click="checkBillItem(commandItem)" ng-repeat="commandItem in bill" id="commandItem<% commandItem.id %>" class="sale-item">

                        <span ng-show="commandItem.checked" class="glyphicon glyphicon-check move-bill-item-check"></span>
                        <span ng-hide="commandItem.checked" class="glyphicon glyphicon-unchecked move-bill-item-check"></span>
                        <div class="billTextZone">
                            <span><%commandItem.quantity%></span> x
                            <span ng-show="commandItem.size.name"> <% commandItem.size.name + " de " + commandItem.name%></span>
                            <span ng-hide="commandItem.size.name" class="sale-item-name"> <% commandItem.size + " de " + commandItem.name%></span></div>
                        <span class="" ng-hide="commandItem.cost">$ <%(commandItem.size.price*commandItem.quantity | number:2) %></span>
                        <span class="" ng-show="commandItem.cost">$ <% (commandItem.cost*commandItem.quantity | number:2) %></span>

                        <div ng-show="commandItem.notes.length != 0" class="itemNoteSeparation">
                            <p ng-repeat="item in commandItem.notes"><% item.note %></p>
                        </div>
                    </li>

                    <li ng-click="toggleBillDemo()" ng-show="bill.total == 0 && !movingBillItem" class="add-bill-item">
                        <span class="glyphicon glyphicon-plus"></span>
                    </li>
                    <li style="text-align: center" ng-show="showBillDemo" ng-click="moveToBill(bill)">
                        <span ng-show="bill.number != 1" style="float: left" class="glyphicon glyphicon-arrow-left"></span>
                        <span ng-show="bill.number === bills.length" style=" font-size:30px; float: right" class="glyphicon glyphicon-arrow-up"></span>
                        <span ng-hide="bill.number === bills.length" style=" float: right" class="glyphicon glyphicon-arrow-up"></span>
                        <span style=" font-size:30px;" >Selectionnez !</span><br>
                        <span style=" font-size:24px; color: #00a5ff" >Cliquez sur le bouton.</span>
                    </li>

                    <li ng-show="movingBillItem && !showBillDemo" ng-click="moveToBill(bill)" class="move-bill-item">
                        <span class="glyphicon glyphicon-share"></span>
                    </li>
                    <li ng-show="showBillDemo " ng-click="moveToBill(bill)" class="move-bill-item">
                        <span class="glyphicon glyphicon-share"></span> Deplacer ici
                    </li>
                    <li style="background-color: #8ad919" ng-click="toggleBillDemo()" ng-show="showBillDemo" class="add-bill-item">
                        <span class="glyphicon glyphicon-remove-sign"></span> Annuler
                    </li>
                </ul>
                    <div ng-show="bill.total > 0">
                    <h3>Sous-total : <span class="number"><% bill.subTotal | number:2 %></span></h3>
                    <h3 ng-repeat="taxe in bill.taxes"><% taxe.name %> : <span class="number"><% taxe.total | number:2 %></span></h3>
                    <h2>Total: <span class="number"><% bill.total | number:2 %></span></h2>
                    </div>
                </div>
        </div>
    </div>
    <div ng-show="showTerminateCommandInfo" style="position: fixed; bottom: 0; left: 0; width: 100%; z-index: 1051; font-size: 22px!important;">
        <li class="terminate-command-info" >
            <span ng-repeat="info in terminateCommandInfo"><% info %><br></span>
        </li>
    </div>
</div>

@yield('myjsfile')
</body>

</html>