@extends('POS.Sale.menuLayout')

@section('csrfToken')
    <script src="{{ @URL::to('Framework/Angular/angular-route.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-ui-router.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-animate.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-touch.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/js/ui-bootstrap-tpls-1.2.5.min.js') }}"></script>
    <script src="{{ @URL::to('js/jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-count-to.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>
    <script src="{{ @URL::to('js/unserialize.js') }}"></script>
    <script src="{{ @URL::to('js/menuAngular.js') }}"></script>
@stop


@section('content')
    <div id="splashFullScreen">Maintenant en mode plein écran.</div>
    <div id="sidebar-collapse" class="col-sm-3 col-lg-5 sidebar">
        <uib-pagination ng-change="pageChanged()" total-items="bigTotalItems" ng ng-model="bigCurrentPage"
                        max-size="maxSize" class="pagination-sm" boundary-link-numbers="true"
                        rotate="false"></uib-pagination>

        <ul class="ng-binding nav menu menu-sale">
            <li><h2>Commande - Client: #<% bigCurrentPage %></h2>

                <div uib-popover-template="noteDynamicPopover.templateUrl" popover-title="<% noteDynamicPopover.title %>"
                     popover-placement="<%placement.selected%>" popover-trigger="outsideClick" class="note"><span
                            class="">Note</span><span class=" glyphicon glyphicon-comment"></span>
                    <span style="position: absolute; right: 6px; top:6px;  color: #30a5ff; background-color: #333; border-radius: 50%; width: 20px; height: 20px; font-size: 17px!important;  padding: 0!important; text-align: center; "><% commandClient[bigCurrentPage].notes.length %></span>
                </div>
            </li>
            <div ng-show="commandClient[bigCurrentPage].notes.length != 0" class="itemNoteSeparation command">
                <p ng-repeat="currentNote in commandClient[bigCurrentPage].notes"><% currentNote.note %> <span
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

            <li ng-repeat="commandItem in commandClient[bigCurrentPage].commandItems"
                id="commandItem<% commandItem.id %>" class="sale-item">
                <span ng-click="increase(commandItem)" class="glyphicon glyphicon-plus"></span>
                <span ng-click="decrease(commandItem)" class="glyphicon glyphicon-minus"></span>

                <div class="saleTextZone"><input id="" type="number" ng-change="updateBill()"
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

        <div class="div-bill-total">
            <h1 class="bill-total">Total = <% totalBill | number:2 %></h1>

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
            <i><%savingMessage%>{{-- <span count-to="5" duration="5" count-from="0"></span>/5 secondes--}}</i>
        </uib-progressbar>


    </div><!--/.sidebar-->

    <div class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">
        <div class="row fixed">
            <div class="row menu-filter">
                {{-- <button  ng-click="filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-star"></span> Favorites</button>--}}
                <button ng-click="filters.itemtype.type = ''" type="button" class="btn btn-default btn-primary"><span
                            class="glyphicon glyphicon-star"></span> Favorie
                </button>
                <button ng-repeat="itemType in menuItemTypes" ng-click="filters.itemtype.type = itemType.type"
                        type="button" class="btn btn-primary"><% itemType.type %></button>
            </div>
        </div>
    </div>

    <div id="contentPanel" class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">
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
                                <img class="beerImage"
                                     ng-src="{{ @URL::to('/img/item/')}}/<% selectedItemForSize.img_id %>">
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="beerItem">

                            <select size="3" ng-model="sizeProp.value" ng-options="o.name for o in sizeProp.values"
                                    ng-change="selectSize(sizeProp.value)"></select>

                        </div>
                    </div>
                    <div class="col-sm-6 col-md-3">
                        <div class="beerItem">
                            <div class="priceBox"><label class="amount"><% sizeProp.value.price %></label><span
                                        class="glyphicon glyphicon-usd"></span></div>
                        </div>
                    </div>

                </div>

                <div class="bottomRight">
                    <button id="boutonAdd" ng-click="addItem()" type="button" class="btn btn-primary">AJOUTER</button>
                </div>

            </div>
        </div>
    </div>

@stop

@section('myjsfile')
    <script>
        /*    $('#calendar').datepicker({
         });

         !function ($) {
         $(document).on("click","ul.nav li.parent > a > span.icon", function(){
         $(this).find('em:first').toggleClass("glyphicon-minus");
         });
         $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
         }(window.jQuery);*/

        $(window).on('resize', function () {
            if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
        })
        $(window).on('resize', function () {
            if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
        })

        $(document).on('click', function(){

            //Going fullscren splash
            //$('body').css("visibility","hidden");
            $('#splashFullScreen').css("visibility","visible");
            $('#splashFullScreen').css("font-size","50px");

            requestFullScreen(elem);
            $('#splashFullScreen').delay(200).fadeTo( 800, 0, function() {
                $('#splashFullScreen').css("visibility","hidden");
            });
            /*
             $('body').delay(4000).css("visibility","visible");*/
            //leaving fullscren splash
            $(document).unbind();

            console.log("Here we go fullscreen");
        });



        function requestFullScreen(element) {
            // Supports most browsers and their versions.
            var requestMethod = element.requestFullScreen || element.webkitRequestFullScreen || element.mozRequestFullScreen || element.msRequestFullscreen;

            if (requestMethod) { // Native full screen.
                requestMethod.call(element);
            } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
                var wscript = new ActiveXObject("WScript.Shell");
                if (wscript !== null) {
                    wscript.SendKeys("{F11}");
                }
            }
        }

        var elem = document.body; // Make the body go full screen.



    </script>
@stop