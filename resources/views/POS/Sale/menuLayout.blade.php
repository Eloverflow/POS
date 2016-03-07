<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirageflow @foreach(Request::segments() as $segment) {{ ' | ' . ucwords( str_replace('_', ' ', $segment))}} @endforeach</title>

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
    <script src="{{ @URL::to('Framework/Angular/angular-animate.min.js') }}"></script>
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

        </div>

    </div><!-- /.container-fluid -->
</nav>



<div id="sidebar-collapse" class="col-sm-3 col-lg-5 sidebar">
    <ul class="nav menu menu-sale">
        <li><h1>Facture</h1></li>
        <li ng-repeat="factureItem in factureItems"  id="factureItem<% factureItem.id %>" class="sale-item">
            <span ng-click="increase(factureItem)" class="glyphicon glyphicon-plus"></span>
            <span ng-click="decrease(factureItem)" class="glyphicon glyphicon-minus"></span>
            <div class="saleTextZone"><input id="" ng-model="factureItem.quantity" value=""> X <span class="sale-item-name"><% factureItem.name %></span></div>
            <span ng-click="delete2(factureItem)" class="glyphicon glyphicon-remove right"></span>
        </li>
    </ul>


</div><!--/.sidebar-->

<div class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">
    <div class="row fixed">
        <div class="row menu-filter">
            <button type="button" class="btn btn-default btn-primary" ><span class="glyphicon glyphicon-star"></span> Favorie</button>
            <button type="button" class="btn btn-primary active">Beer</button>
            <button type="button" class="btn btn-primary">Drink</button>
            <button type="button" class="btn btn-primary">Food</button>
            <button type="button" class="btn btn-primary">Food</button>
            <button type="button" class="btn btn-primary">Food</button>
            <button type="button" class="btn btn-primary">Food</button>
            <button type="button" class="btn btn-primary">Food</button>
        </div>
    </div>
</div>
<div id="contentPanel" class="col-sm-9 col-sm-offset-3 col-lg-7 col-lg-offset-5 main">

    @yield('content')
</div>




{{--Script call--}}
<script src="{{ @URL::to('js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart.min.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-table.js') }}"></script>
<script src="{{ @URL::asset('js/jquery.nicescroll.min.js') }}"></script>
<script src="{{ @URL::to('js/baseEffect.js') }}"></script>
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
</script>

@yield('myjsfile')
</body>

</html>