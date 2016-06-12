@extends('POS.Sale.menuLayout')

@section('csrfToken')


    <script src="{{ @URL::to('Framework/Angular/angular-route.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-ui-router.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-animate.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-touch.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-idle.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/ui-bootstrap-tpls-1.2.5.min.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>
    <script src="{{ @URL::to('js/menuAngular.js') }}"></script>


    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/punchEmployee.js') }}"></script>


    <script src="{{ @URL::to('js/jquery/panzoom.min.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/pointertouch.js') }}"></script>
@stop


@section('content')
    <div id="splashFullScreen">Maintenant en mode plein écran.</div>
    <div id="sidebar-collapse" class="col-sm-5 col-lg-5 sidebar">
        <uib-pagination ng-change="pageChanged()" total-items="clientPagerTotalItems" ng ng-model="commandCurrentClient"
                        max-size="clientPagerMaxSize" class="pagination-sm" boundary-link-numbers="true"
                        rotate="false"></uib-pagination>
        <button style="background-color: #444; border-color: #444;position: absolute; right: 0; top:0; padding: 0 0 14px 14px; font-size: 25px; height: 44px; margin-top: 1%;margin-right: 1%;" href="#" ng-click="ajouterClient()" type="button" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span>
        </button>
        <ul class="ng-binding nav menu menu-sale">
            <li><h2>Commande - Client: #<% commandCurrentClient %></h2>

                <div uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                     popover-placement="<%placement.selected%>" popover-trigger="outsideClick" class="note"><span
                            class="">Note</span><span class=" glyphicon glyphicon-comment"></span>
                    <span style="position: absolute; right: 6px; top:6px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandClient[commandCurrentClient].notes.length %></span>
                </div>
            </li>
            <div ng-show="commandClient[commandCurrentClient].notes.length != 0" class="itemNoteSeparation command">
                <p ng-repeat="currentNote in commandClient[commandCurrentClient].notes"><% currentNote.note %> <span
                            ng-click="deleteItemNote(currentNote)" class="glyphicon glyphicon-remove right"></span></p>
            </div>
            <script type="text/ng-template" id="notePopover.html">

                <div class="form-group">
                    <label>Ajouter un note :</label>

                    <div class="input-group">
                        <input type="text" ng-model="noteDynamicPopover.note" placeholder="Note" class="form-control">

                        <div class="input-group-btn">
                            <button ng-click="addNote(noteDynamicPopover.note, commandItem)" type="button"
                                    class="btn btn-default" aria-label="Help"><span
                                        class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
                <div ng-repeat="suggestion in noteSuggestions">
                    <button type="button" class="btn btn-success"
                            ng-click="addNote(suggestion, commandItem)"><% suggestion %></button>
                </div>
            </script>

            <li ng-repeat="commandItem in commandClient[commandCurrentClient].commandItems"
                id="commandItem<% commandItem.id %>" class="sale-item">
                <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>

                <div class="saleTextZone"><input id="" type="number" ng-change="updateCommand()"
                                                 ng-model="commandItem.quantity" value=""><span
                            class="sale-item-name"><% commandItem.size.name + " " + commandItem.name%></span></div>
                <span ng-click="delete2(commandItem)" class="glyphicon glyphicon-remove right special"></span>
                <span uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                      popover-placement="<%placement.selected%>" popover-trigger="outsideClick"
                      class="glyphicon glyphicon-comment itemNote right"> <span
                            style="position: absolute; right: 1px; top:-8px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandItem.notes.length %></span></span>
                <span class="priceItems"
                      ng-hide="commandItemTimeToggle">$ <% (commandItem.size.price*commandItem.quantity | number:2) %></span>
                <span class="timeItems" ng-show="commandItemTimeToggle"><% commandItem.time %></span>

                <div ng-show="commandItem.notes.length != 0" class="itemNoteSeparation">
                    <p ng-repeat="item in commandItem.notes"><% item.note %><span
                                ng-click="deleteItemNote(item, commandItem.notes)"
                                class="glyphicon glyphicon-remove right"></span></p>
                </div>
            </li>
        </ul>
    </div>

    <div id="sidebar-collapse2" class="col-sm-5 col-lg-5 sidebar bill-bottom">

        <div class="div-bill-sub-total">
            <h2>Sous-total : <span class="number"><% subTotalBill | number:2 %></span></h2><div class="right"><h3 ng-repeat="taxe in taxes"><% taxe.name %> : <span class="number"><% taxe.total | number:2 %></span></h3></div>
            <div class="div-bill-total">
                <h1 class="bill-total">Total : <span class="number"><% totalBill | number:2 %></span></h1>

                <button ng-show="commandItemTimeToggle" href="#" ng-click="toggleCommandTime()"
                        style="background-color: #8ad919" type="button" class="btn btn-success"><span
                            class="glyphicon glyphicon-euro"></span>
                    Afficher le montant
                </button>
                <button ng-hide="commandItemTimeToggle" href="#" ng-click="toggleCommandTime()" type="button"
                        class="btn btn-success"><span class="glyphicon glyphicon-time"></span>
                    Afficher le temps
                </button>

            </div>
            <div class="div-btn-facture">
                <button ng-click="" type="button" class="btn btn-success btn-facture">Imprimer Factures</button>
                <button ng-click="toggleDivideBillModal()" type="button" class="btn btn-success btn-facture">Diviser Factures</button>
            </div>
            <uib-progressbar class="progress-striped active" animate="true" max="100" value="progressValue" type="success">
                <i><%savingMessage%> {{--<span count-to="5" duration="5" count-from="0"></span>/5 secondes--}}</i>
            </uib-progressbar>

        </div>



    </div>

    <!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-5 col-lg-7 col-lg-offset-5 div-filter">
        {{--<div style="background-color: #444; width: 200px; height: 80px"> </div>--}}

        <div id="filter-wrapper" style="overflow: hidden;">

            <div class="menu-filter">
                <button ng-click="filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary"><span
                            class="glyphicon glyphicon-star"></span> Tout
                </button>
                <button ng-repeat="itemType in menuItemTypes" ng-click="filters.itemtype.type = itemType.type"
                        type="button" class="btn btn-primary"><% itemType.type %></button>
            </div>
        </div>
    </div>

    <div id="contentPanel" class="col-sm-9 col-sm-offset-5 col-lg-7 col-lg-offset-5 main">
        {{--Content--}}
        <div class="row beer-items">
            <div ng-repeat="menuItems in menuItemsExtended | filter:filters">
                <div ng-repeat="menuItemSize in menuItems.sizes" class="sizeBlock">
                    <div ng-repeat="menuItem in menuItems" class="col-sm-6 col-md-3">
                        <div{{-- ng-click="selectedItem(menuItem)" --}}
                                ng-click="selectedItem(menuItem,menuItemSize.name);addItem()" class="thumbnail beerItem"
                                style="background-color: <% menuItemSize.color.boxColor %>; ">{{--
                        <img class="beerImage" ng-src="{{ @URL::to('/img/item/')}}/<% menuItem.img_id %>">--}}
                            <div class="caption">
                                <h3 style="color: <% menuItemSize.color.textColor %>"><span class="beerName"><% menuItemSize.name %>
                                        de <% menuItem.name %></span></h3>
                            </div>
                        </div>
                    </div>
                </div>

            </div>



        </div>
    </div>

@stop

@section('myjsfile')
    <script type="application/javascript" src="{{ @URL::to('Framework/iscroll.js') }}"></script>
    <script type="text/javascript">
        var myScroll,myBillScroll;

            myScroll = new iScroll('filter-wrapper', {
                hideScrollbar: true
            });

            myBillScroll = new iScroll('filter-wrapper-bill', {
                hideScrollbar: true
            });

        //This block cellphone touch
        /*
        document.addEventListener('touchmove', function (e) { e.preventDefault(); }, false);*/

    </script>
@stop
