@extends('POS.Sale.mainLayout')

@section('content')

    <div class="row beer-items">
        <div ng-repeat="menuItem in menuItems | filter:filters"  class="col-sm-6 col-md-3" >
            <div ng-click="selectedItem(menuItem)" class="thumbnail beerItem">
                <div class="caption">
                    <h3><span class="beerName"><% menuItem.name %></span></h3>
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

        {{-- start keyboard--}}
        <div id="keyboardPanel">
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

                        <select size="3" ng-model="sizeProp.value" ng-options="o.name for o in sizeProp.values" ng-change="selectSize(sizeProp.value)"></select>

                    </div>
                </div>
                <div class="col-sm-6 col-md-3">
                    <div class="beerItem">
                        <div class="priceBox"><label {{--ng-model="selectedSize"--}} class="amount"><% sizeProp.value.price %></label><span class="glyphicon glyphicon-usd"></span></div>
                    </div>
                </div>

            </div>

            <div class="bottomRight">
                <button id="boutonAdd" ng-click="addItem()" type="button" class="btn btn-primary">AJOUTER</button>
            </div>

        </div>

        {{-- end keyboard--}}
    </div>

@stop