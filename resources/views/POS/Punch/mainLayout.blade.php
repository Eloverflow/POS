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
    <link href="{{ @URL::to('css/mainSale.css') }}" rel="stylesheet">

    <script src="{{ @URL::to('js/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ @URL::to('js/jquery-ui.js') }}"></script>
    <![endif]-->
    @yield('csrfToken')
</head>

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

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@yield('myjsfile')
</body>

</html>