<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirageflow @foreach(Request::segments() as $segment) {{ ' | ' . ucwords( str_replace('_', ' ', $segment))}} @endforeach</title>

    {{--Stylesheet call--}}
    <script src="{{ @URL::to('js/jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/3.3.6/js/bootstrap.min.js') }}"></script>
    <link href="{{ @URL::to('Framework/Bootstrap/3.3.6/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap-table.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/workerLayout.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/mainSale.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/tablesSelect.css') }}" rel="stylesheet">

    <!--Icons-->
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/lumino.glyphs.js') }}"></script>

    <script src="{{ @URL::to('Framework/Angular/angular.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-route.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-ui-router.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-animate.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Angular/angular-touch.min.js') }}"></script>

    @yield('csrfToken')
</head>

<div class="row">
    <div class="col-lg-12">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"><span>Easy</span>Pos</a>
            </div>
    </div>
</div>


<div class="row">
    <div class="col-sm-12">
        <div class="fixed">
            <ol  class="breadcrumb">
                <li><a href="{{ @URL::to('/') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
                <?php $url = "";?>
                @foreach(Request::segments() as $segment)
                    <?php $url = $url . $segment . '/' ?>
                    <li>
                        <a href="{{ @URL::to($url) }}">{{ucwords( str_replace('_', ' ', $segment))}}</a>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-body">
                @yield('content')
            </div>
        </div>
    </div>
</div>

@yield('myjsfile');
</body>

</html>