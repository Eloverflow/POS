<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Mirageflow @foreach(Request::segments() as $segment) {{ ' | ' . ucwords( str_replace('_', ' ', $segment))}} @endforeach</title>

    {{--Stylesheet call--}}
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap-table.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/styles.css') }}" rel="stylesheet">
    {{--End of Stylesheet call--}}

    <!--Icons-->
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/lumino.glyphs.js') }}"></script>

    <!--[if lt IE 9]>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/html5shiv.js') }}"></script>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/respond.min.js') }}"></script>
    <![endif]-->
    @yield('csrfToken')
</head>

<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><span>Pub</span>Alex</a>

        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search">
        <div class="form-group">
            <input type="text" class="form-control" placeholder="Search">
        </div>
    </form>
    <ul class="nav menu">
        <li><a href="{{ URL::to('Punch') }}"><svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg> Punch</a></li>
        <li><a href="{{ URL::to('Employee') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Employees</a></li>
        <li><a href="{{ URL::to('Disponibility') }}"><svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg> Disponibilities</a></li>
        <li><a href="{{ URL::to('Schedule') }}"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"/></svg> Schedules</a></li>
        <li role="presentation" class="divider"></li>
        <li><a href="login.html"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
    </ul>


</div><!--/.sidebar-->

<div id="contentPanel" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row">
        <ol class="breadcrumb">
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

    @if(Session::has('success'))
        <div id="flash-msg" class="row collapse in">
            <div class="col-lg-12">
                <div id="flash-success" class="alert bg-success" role="alert">
                    <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> {{ Session::get('success') }} <a data-toggle="collapse" href="#flash-msg" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </div>
        </div>
    @endif
    @yield('content')

</div>

{{--Script call--}}
<script src="{{ @URL::to('js/jquery-2.1.4.min.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart.min.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart-data.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-table.js') }}"></script>
<script src="{{ @URL::to('js/baseEffect.js') }}"></script>
@if(Request::path() == "Menu/Edit")
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