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
    <link href="{{ @URL::to('css/menuSale.css') }}" rel="stylesheet">
    {{--End of Stylesheet call--}}

    <!--Icons-->
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/lumino.glyphs.js') }}"></script>


    <script src="{{ @URL::to('Framework/Angular/angular.min.js') }}"></script>
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

    <!--[if lt IE 9]>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/html5shiv.js') }}"></script>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/respond.min.js') }}"></script>
    <![endif]-->
    @yield('csrfToken')
</head>

<body ng-app="menu" ng-controller="menuController">
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span>Facture</span> <span class="glyphicon glyphicon-barcode"></span>
            </button>
            <a class="navbar-brand" href="{{@URL::to('/')}}"> <span class="glyphicon glyphicon-circle-arrow-left"></span> <span>Pub</span>Alex</a>
            <ul class="user-menu">

                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><svg class="glyph stroked male-user"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-male-user"></use></svg>
                        Employé #<% currentEmploye %>
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">


                        <li><a href="#"><svg class="glyph stroked male-user"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-male-user"></use></svg> Profile</a></li>

                        <li><a href="#"><svg class="glyph stroked gear"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-gear"></use></svg> Settings</a></li>

                        <li><a href="http://mirageflow.com/auth/logout"><svg class="glyph stroked cancel"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-cancel"></use></svg> Logout</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="user-menu tableNumber">
                <li>
                    <a href="#" ng-click="toggleTableModal()"><span class="glyphicon glyphicon-unchecked"></span>
                        Table #<% currentTable.tblNumber %>
                       </a>
                </li>
            </ul>
            <ul class="user-menu tableNumber">
                <li>
                    <a href="#" ng-click="togglePlanModal()"><span class="glyphicon glyphicon-map-marker"></span>
                        Plan
                    </a>
                </li>
            </ul>
            <ul class="user-menu tableNumber">
                <li>
                    <a href="#" ng-click="openBill()"><span class="glyphicon glyphicon-bitcoin"></span>
                        Factures
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
        <div class="divideBillChoice">
            Une Facture par Personne
        </div>
        <div class="divideBillChoice">
            Une Seule Facture
        </div>

        <div ng-click="divideBill()" class="divideBillChoice">
            Diviser manuellement
        </div>
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
        <div class="container-inner">
        <div ng-repeat="n in [] | floor:4" class="bill">
           {{-- <ul>
                <li>test</li>
                <li>test</li>
            </ul>--}}
            <h2>Facture #n</h2>
            <ul>
            <li ng-repeat="commandItem in commandClient[bigCurrentPage].commandItems"
                id="commandItem<% commandItem.id %>" class="sale-item">

                <div class="saleTextZone">
                    <span><%commandItem.quantity%></span> x
                    <span class="sale-item-name"> <% commandItem.size.name + " " + commandItem.name%></span></div>
                    <span class="">$ <% (commandItem.size.price*commandItem.quantity | number:2) %></span>

                <div ng-show="commandItem.notes.length != 0" class="itemNoteSeparation">
                    <p ng-repeat="item in commandItem.notes"><% item.note %></p>
                </div>
            </li>
            </ul>
            </div>
        </div>
    </div>
</div>


{{--Script call--}}
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart.min.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-table.js') }}"></script>{{--
<script src="{{ @URL::asset('js/jquery.nicescroll.min.js') }}"></script>--}}{{--
<script src="{{ @URL::to('js/baseEffect.js') }}"></script>--}}
@if(Request::path() == "addon/rfid/table")
    <script src="{{ @URL::asset('js/jquery.sortable.js') }}"></script>
    <script src="{{ @URL::asset('js/listener.js') }}"></script>
@endif
{{--End of Script call--}}

<script>
    $('#calendar').datepicker({
    });

    !function ($) {
        $(document).on("click","ul.nav li.parent > a > span.icon", function(){
            $(this).find('em:first').toggleClass("glyphicon-minus");
        });
        $(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
    }(window.jQuery);

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


@yield('myjsfile')
</body>

</html>