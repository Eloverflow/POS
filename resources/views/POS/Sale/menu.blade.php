@extends('POS.Sale.menuLayout')

@section('content')

<div id="sidebar-collapse" class="col-sm-3 col-lg-5 sidebar">
    <uib-pagination ng-change="pageChanged()" total-items="bigTotalItems" ng ng-model="bigCurrentPage" max-size="maxSize" class="pagination-sm" boundary-link-numbers="true" rotate="false"></uib-pagination>

        <ul class="ng-binding nav menu menu-sale">
            <li><h2>Commande - Client: #<% bigCurrentPage %></h2> <div  uib-popover-template="dynamicPopover.templateUrl" popover-title="Title" popover-placement="<%placement.selected%>"   class="note"><span class="">Note</span><span class=" glyphicon glyphicon-comment"></span></div></li>
            <script type="text/ng-template" id="myPopoverTemplate.html">
              {{--  <div><%dynamicPopover.content%></div>--}}
                <div class="form-group">
                    <label>Ajouter un note :</label>

                    <div class="input-group">
                        <input type="text" ng-model="dynamicPopover.note" placeholder="Note" class="form-control">
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-default" aria-label="Help"><span class="glyphicon glyphicon-plus"></span></button>
                        </div>
                    </div>
                </div>
            </script>

             <li ng-repeat="commandItem in commandClient[bigCurrentPage].commandItems"  id="commandItem<% commandItem.id %>" class="sale-item">
                 <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                 <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>
                 <div class="saleTextZone"><input id="" ng-change="updateBill()" ng-model="commandItem.quantity" value=""> X <span class="sale-item-name"><% commandItem.size.name + " de " + commandItem.name + " = " + (commandItem.size.price*commandItem.quantity | number:2) %></span></div>
                 <span ng-click="delete2(commandItem)" class="glyphicon glyphicon-remove right"></span>
                 <span uib-popover-template="dynamicPopover.templateUrl" popover-title="Title" popover-placement="<%placement.selected%>"  class="glyphicon glyphicon-comment itemNote right"><span style="position: absolute; right: 10px; color: #30a5ff; background-color: #333; border-radius: 50%; width: 15px; height: 15px; font-size: 12px; margin: 1px; padding-left: 1px">1</span></span>

             </li>

            {{--<li ng-repeat="commandItem in commandItems"  id="commandItem<% commandItem.id %>" class="sale-item">
                 <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                 <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>
                 <div class="saleTextZone"><input id="" ng-change="updateBill()" ng-model="commandItem.quantity" value=""> X <span class="sale-item-name"><% commandItem.size.name + " de " + commandItem.name + " = " + (commandItem.size.price*commandItem.quantity | number:2) %></span></div>
                 <span ng-click="delete2(commandItem)" class="glyphicon glyphicon-remove right"></span>
             </li>--}}
        </ul>
    <h1 class="bill-total">Total = <% totalBill | number:2 %></h1>
    <button ng-click="payNow()" type="button" class="btn btn-success btn-payer">Payer</button>

</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">
    <div class="row fixed">
        <div class="row menu-filter">
           {{-- <button  ng-click="filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-star"></span> Favorites</button>--}}
            <button  ng-click="filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-star"></span> Favorie</button>
            <button ng-repeat="itemType in menuItemTypes" ng-click="filters.itemtype.type = itemType.type" type="button" class="btn btn-primary"><% itemType.type %></button>
        </div>
    </div>
</div>

<div id="contentPanel" class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">
    {{--Content--}}
    <div class="row beer-items">
        <div ng-repeat="menuItems in menuItemsExtended | filter:filters"  >
            <div ng-repeat="menuItemSize in menuItems.sizes" >
                <div ng-repeat="menuItem in menuItems" class="col-sm-6 col-md-3" >
                    <div ng-click="selectedItem(menuItem)" class="thumbnail beerItem">{{--
                        <img class="beerImage" ng-src="{{ @URL::to('/img/item/')}}/<% menuItem.img_id %>">--}}
                        <div class="caption">
                            <h3><span class="beerName"><% menuItemSize %> de <% menuItem.name %></span></h3>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div id="footPanel">
            <div class="upLeft">
                <h1>
                    <b>Size of </b>
                </h1>
            </div>
            <div class="upRight">
                <button ng-click="closeFoot()" type="button" class="btn btn-danger">FERMER</button>
            </div>

            <div class="bottomLeft">
                <div class="col-sm-6 col-md-3">
                    <div class="beerItem">
                        <div class="thumbnail">
                            <h3><span class="beerName"><% selectedItemForSize.name %></span></h3>
                            <img class="beerImage"  ng-src="{{ @URL::to('/img/item/')}}/<% selectedItemForSize.img_id %>">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="beerItem">
                        {{--<select size="3"  ng-model="selectedSize">
                            <option
                                    ng-repeat="size in selectedItemForSize.size"
                                    ng-selected="selectedSizeOption(size)"
                                    value="<% size %>"
                                    >
                                <%size.name%>
                            </option>
                        </select>--}}

                        {{-- <select size="3" ng-options="size as size.name for size in selectedItemForSize.size track by size.name" ng-model="selectedSize" --}}{{--ng-update="selectSize(size)"--}}{{-->
                         </select>--}}


                        <select size="3" ng-model="sizeProp.value" ng-options="o.name for o in sizeProp.values" ng-change="selectSize(sizeProp.value)"></select>

                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="beerItem">
                        <div class="priceBox"><label {{--ng-model="selectedSize"--}} class="amount"><% sizeProp.value.price %></label><span class="glyphicon glyphicon-usd"></span></div>
                    </div>
                </div>


                {{--
            <button ng-repeat="size in selectedItemForSize.size">
                <% size.name %>
            </button>--}}
            </div>

            <div class="bottomRight">
                <button id="boutonAdd" ng-click="addItem()" type="button" class="btn btn-primary">AJOUTER</button>
            </div>

        </div>
    </div>
</div>


@stop