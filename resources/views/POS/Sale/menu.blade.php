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
    <script src="{{ @URL::to('js/menuApp/app.js') }}"></script>
    <script src="{{ @URL::to('js/menuApp/controllers/starterController.js') }}"></script>
    <script src="{{ @URL::to('js/menuApp/controllers/menuController.js') }}"></script>
    <script src="{{ @URL::to('js/menuApp/constants.js') }}"></script>
    <script src="{{ @URL::to('js/menuApp/services.js') }}"></script>
    <script src="{{ @URL::to('js/menuApp/directives.js') }}"></script>


    <script src="{{ @URL::to('js/utils.js') }}"></script>


    <script src="{{ @URL::to('js/jquery/panzoom.min.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/pointertouch.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
            <li><h2 id="command-client-number">Commande - Client: #<% commandCurrentClient %></h2>

                <div uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                     popover-placement="<%placement.selected%>" popover-trigger="outsideClick" class="note"><span
                            class="">Note</span><span class=" glyphicon glyphicon-comment"></span>
                    <span style="position: absolute; right: 6px; top:6px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandClient[commandCurrentClient].notes.length %></span>
                </div>
            </li>
            <li style="background-color: #d62728" ng-show="commandClient[commandCurrentClient].status == 3" class="sale-item">
                Commande annulé
            </li>
            <div ng-show="commandClient[commandCurrentClient].notes.length != 0 || commandClient[commandCurrentClient].extras.length != 0" class="itemNoteSeparation command">
                <p ng-repeat="currentNote in commandClient[commandCurrentClient].notes"><% currentNote.note %> <span
                            ng-click="deleteItemNote(currentNote)" class="glyphicon glyphicon-remove right"></span></p>

                <p ng-repeat="extra in commandClient[commandCurrentClient].extras track by $index"><% extra.name %>
                        <span ng-click="deleteItemExtra(item, commandClient[commandCurrentClient].extras)"
                              class="glyphicon glyphicon-remove right"></span>
                    <span ng-show="extra.effect == '+'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value %>$ </span>
                    <span ng-show="extra.effect == '-'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value %>$ </span>
                    <span ng-show="extra.effect == '*'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value | number:0 %>% </span>
                    <span ng-show="extra.effect == '/'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value | number:0 %>% </span>
                </p>
            </div>
            <script type="text/ng-template" id="notePopover.html">

                <button class="btn btn-success" style="position: absolute; top:3px; right:3px; width: 90px; color: #00a5ff; background-color: #333;" ng-click="addServiceNumberToCommandline(commandItem)">Service <% commandItem.service_number %></button>

                <div class="form-group">
                    <label style="color: #000">Ajouter une note :</label>

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
                    <button type="button" class="btn btn-note"
                            ng-click="addNote(suggestion, commandItem)"><% suggestion %></button>
                </div>

                <div ng-show="(extras | filter : {items:{item :{id: commandItem.id}}}).length > 0 || (extras | filter : {itemtypes:{itemtype: {id: commandItem.item_type_id}}}).length > 0" class="suggestions" >
                    <div class="separation-extra" ></div>
                    Extras
                    <div ng-show="commandItem" ng-repeat="extra in extras | filter : {items:{item :{id: commandItem.id}}}">
                        <button ng-show="extra.effect == '+'"  type="button" class="btn btn-extra"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '*'"  type="button" class="btn btn-extra pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '-'" type="button" class="btn btn-extra negative"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '/'" type="button" class="btn btn-extra negative pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                    </div>
                    <div ng-show="commandItem" ng-repeat="extra in extras | filter : {itemtypes:{itemtype: {id: commandItem.item_type_id}}}">
                        <button ng-show="extra.effect == '+'" type="button" class="btn btn-extra"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '*'" type="button" class="btn btn-extra pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '-'" type="button" class="btn btn-extra negative"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '/'" type="button" class="btn btn-extra negative pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                    </div>
                    <div ng-hide="commandItem" ng-repeat="extra in extras | filter : {avail_for_command: 1}">
                        <button ng-show="extra.effect == '+'"  type="button" class="btn btn-extra"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '*'"  type="button" class="btn btn-extra pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '-'" type="button" class="btn btn-extra negative"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                        <button ng-show="extra.effect == '/'" type="button" class="btn btn-extra negative pourcent"
                                ng-click="addExtra(extra, commandItem)"><% extra.name %></button>
                    </div>
                </div>

            </script>

            <li ng-repeat="commandItem in commandClient[commandCurrentClient].commandline | filter :  { status: 2 }"
                id="commandItem<% commandItem.id %>" class="sale-item">
                <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>

                <div class="saleTextZone"><input id="" type="number" ng-change="updateCommand()"
                                                 ng-model="commandItem.quantity" value=""><span
                            class="sale-item-name"><% commandItem.size.name + " " + commandItem.name%></span></div>
                <span ng-click="delete2(commandItem)" class="glyphicon glyphicon-remove right special"></span>
                <span ng-hide="commandItem.id > 2"uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                      popover-placement="<%placement.selected%>" popover-trigger="outsideClick"
                      class="glyphicon glyphicon-comment itemNote right"> <span
                            style="position: absolute; right: 1px; top:-8px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandItem.notes.length %></span></span>
                <span ng-show="commandItem.id > 2" uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                      popover-placement="<%placement.selectedBottom%>" popover-trigger="outsideClick"
                      class="glyphicon glyphicon-comment itemNote right"> <span
                            style="position: absolute; right: 1px; top:-8px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandItem.notes.length + commandItem.extras.length %></span></span>
                <span class="priceItems"
                      ng-hide="commandItemTimeToggle">$ <% (commandItem.size.price*commandItem.quantity | number:2) %></span>
                <span class="timeItems" ng-show="commandItemTimeToggle"><% commandItem.time %></span>

                <div ng-show="commandItem.notes.length != 0 || commandItem.extras.length != 0" class="itemNoteSeparation">
                    <p ng-repeat="item in commandItem.notes"><% item.note %><span
                                ng-click="deleteItemNote(item, commandItem.notes)"
                                class="glyphicon glyphicon-remove right"></span></p>
                    <p ng-repeat="extra in commandItem.extras track by $index"><% extra.name %>
                        <span ng-click="deleteItemExtra(item, commandItem.extras)"
                              class="glyphicon glyphicon-remove right"></span>
                        <span ng-show="extra.effect == '+'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value %>$ </span>
                        <span ng-show="extra.effect == '-'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value %>$ </span>
                        <span ng-show="extra.effect == '*'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value | number:0 %>% </span>
                        <span ng-show="extra.effect == '/'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value | number:0 %>% </span>
                    </p>
                </div>

                <span ng-show="commandItem.service_number" style="margin-right:10px;color: #30a5ff; position: absolute; top:2px; right:2px; font-size: 16px; width: 15px">#<% commandItem.service_number %></span>
                <span ng-hide="commandItem.service_number" style="margin-right:10px;color: #30a5ff; position: absolute; top:2px; right:2px; font-size: 16px; width: 15px" class="glyphicon glyphicon-cloud-upload"><% commandItem.service_number %></span>
            </li>
            <li ng-show="commandClient[commandCurrentClient].commandline.length > 0">
                <button ng-hide="commandClient[commandCurrentClient].status == 3" ng-click="cancelCommand(commandClient[commandCurrentClient])" href="#"
                        style="background-color: #30a5ff; width: 49%; height: 40px; margin-left: 3px; margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-danger"><span
                            class="glyphicon glyphicon-trash"></span>
                    Annuler la commande
                </button>
                <button ng-show="commandClient[commandCurrentClient].status == 3" ng-click="reactivateCommand(commandClient[commandCurrentClient])" href="#"
                        style="background-color: #30a5ff; width: 49%; height: 40px; margin-left: 3px; margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-success"><span
                            class="glyphicon glyphicon-repeat"></span>
                    Réactiver la commande
                </button>
                <button ng-show="(commandClient[commandCurrentClient].commandline | filter :  { status: 1 }).length > 0" ng-click="changecommandlineStatus()" href="#"
                        style="background-color: #30a5ff; width: 49%; height: 40px;  margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-success"><span
                            class="glyphicon glyphicon-upload"></span>
                    Tout ajouter à la commande
                </button>
                <button ng-hide="(commandClient[commandCurrentClient].commandline | filter :  { status: 1 }).length > 0" ng-click="terminateCommand(commandClient[commandCurrentClient])" href="#"
                        style="background-color: #333; width: 49%; height: 40px;  margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-success"><span
                            class="glyphicon glyphicon-save"></span>
                    Terminer la commande
                </button>
            </li>
            <li class="terminate-command-info" ng-show="showTerminateCommandInfo">
                <span ng-repeat="info in terminateCommandInfo"><% info %><br></span>
            </li>
            <li style="border-left: 10px #00a5ff solid;border-right: 10px #00a5ff solid;" ng-repeat="commandItem in commandClient[commandCurrentClient].commandline | filter :  { status: 1 }"
                id="commandItem<% commandItem.id %>" class="sale-item">
                <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>

                <div class="saleTextZone"><input id="" type="number" ng-change="updateCommand()"
                                                 ng-model="commandItem.quantity" value=""><span
                            class="sale-item-name"><% commandItem.size.name + " " + commandItem.name%></span></div>
                <span ng-click="delete2(commandItem)" class="glyphicon glyphicon-remove right special"></span>
                 <span ng-hide="commandItem.id > 3"uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                       popover-placement="<%placement.selected%>" popover-trigger="outsideClick"
                       class="glyphicon glyphicon-comment itemNote right"> <span
                             style="position: absolute; right: 1px; top:-8px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandItem.notes.length %></span></span>
                <span ng-show="commandItem.id > 3" uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                      popover-placement="<%placement.selectedBottom%>" popover-trigger="outsideClick"
                      class="glyphicon glyphicon-comment itemNote right"> <span
                            style="position: absolute; right: 1px; top:-8px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandItem.notes.length %></span></span>

                <span class="priceItems"
                      ng-hide="commandItemTimeToggle">$ <% (commandItem.size.price*commandItem.quantity | number:2) %></span>
                <span class="timeItems" ng-show="commandItemTimeToggle"><% commandItem.time %></span>

                <div ng-show="commandItem.notes.length != 0 || commandItem.extras.length != 0" class="itemNoteSeparation">
                    <p ng-repeat="item in commandItem.notes"><% item.note %><span
                                ng-click="deleteItemNote(item, commandItem.notes)"
                                class="glyphicon glyphicon-remove right"></span></p>
                    <p ng-repeat="extra in commandItem.extras track by $index"><% extra.name %>
                        <span ng-click="deleteItemExtra(item, commandItem.extras)"
                              class="glyphicon glyphicon-remove right"></span>
                        <span ng-show="extra.effect == '+'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value %>$ </span>
                        <span ng-show="extra.effect == '-'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value %>$ </span>
                        <span ng-show="extra.effect == '*'" style="color: #8ad919; float: right; margin-right: 10px;"> + <% extra.value | number:0 %>% </span>
                        <span ng-show="extra.effect == '/'" style="color: red; float: right; margin-right: 10px;"> - <% extra.value | number:0 %>% </span>
                    </p>
                </div>

                <button ng-show="(commandClient[commandCurrentClient].commandline | filter :  { status: 1 }).length > 1" ng-click="addServiceNumberToCommandline(commandItem)" href="#"
                        style="background-color: #30a5ff; width: 49%; height: 40px;  margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-default"><span
                            class="glyphicon glyphicon-time"></span>
                    Service # <% commandItem.service_number %>
                </button>
                <button ng-show="(commandClient[commandCurrentClient].commandline | filter :  { status: 1 }).length > 1" ng-click="changecommandlineStatusLine(commandItem)" href="#"
                        style="background-color: #30a5ff; width: 49%; height: 40px;  margin-bottom: 3px; margin-top: 3px;" type="button" class="btn btn-success"><span
                            class="glyphicon glyphicon-upload"></span>
                    Ajouter à la commande
                </button>

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
                <button ng-click="divideBill()" type="button" class="btn btn-success btn-facture">Diviser Factures</button>
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
                <button ng-click="removeFilters();filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary"><span
                            class="glyphicon glyphicon-star"></span> Tout
                </button>
                <button ng-repeat="menuFilter in menuFilters | orderBy:'importance':true" ng-click="applyFilter(menuFilter)"
                        type="button" class="btn btn-primary"><% menuFilter.name %></button>
                <button ng-repeat="itemType in menuItemTypes" ng-click="removeFilters();filters.itemtype.type = itemType.type"
                        type="button" class="btn btn-primary"><% itemType.type %></button>
            </div>
        </div>
    </div>

    <div id="contentPanel" class="col-sm-9 col-sm-offset-5 col-lg-7 col-lg-offset-5">
        {{--Content--}}
        <div class="row beer-items">
            <div ng-repeat="menuItems in menuItemsExtended | filter:filters ">
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
                <div ng-repeat="menuItems in filteredItems">
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
