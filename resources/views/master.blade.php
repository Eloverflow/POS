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
        <li><a href="{{ URL::to('punch') }}"><svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg> Punch</a></li>
        <li><a href="{{ URL::to('employee') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Employees</a></li>
        <li><a href="{{ URL::to('disponibility') }}"><svg class="glyph stroked calendar blank"><use xlink:href="#stroked-calendar-blank"/></svg> Disponibilities</a></li>
        <li><a href="{{ URL::to('schedule') }}"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"/></svg> Schedules</a></li>
        <li><a href="{{ URL::to('items') }}"><svg class="glyph stroked bacon burger"><use xlink:href="#stroked-bacon-burger"/></svg></svg> Items</a></li>
        <li><a href="{{ URL::to('itemtypes') }}"><svg class="glyph stroked paper coffee cup"><use xlink:href="#stroked-paper-coffee-cup"/></svg> Item Types</a></li>
        <li><a href="{{ URL::to('inventory') }}"><svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg> Inventory</a></li>
        <li><a href="{{ URL::to('clients') }}"><svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg> Clients</a></li>
        <li><a href="{{ URL::to('addon/rfid/table') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> RFID Tables</a></li>
        <li><a href="{{ URL::to('addon/rfid/request') }}"><svg class="glyph stroked wireless router"><use xlink:href="#stroked-wireless-router"/></svg> RFID Request</a></li>
        <li><a href="{{ URL::to('menu') }}"><svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg> Menu</a></li>
        <li role="presentation" class="divider"></li>
        <li><a href="{{ URL::to('auth/login') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> Login Page</a></li>
    </ul>


</div><!--/.sidebar-->
<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
    <div class="row fixed">
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
</div>
<div id="contentPanel" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">


    @if(Session::has('success'))
        <div id="flash-msg" class="row collapse in">
            <div class="col-lg-12">
                <div id="flash-success" class="alert bg-success" role="alert">
                    <svg class="glyph stroked checkmark"><use xlink:href="#stroked-checkmark"></use></svg> {{ Session::get('success') }} <a data-toggle="collapse" href="#flash-msg" class="pull-right"><span class="glyphicon glyphicon-remove"></span></a>
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @if(!empty($title))
        <div class="col-md-6">
            <h1 class="page-header">{{$title}}</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                @if(!empty($_SERVER['HTTP_REFERER']))
                    <?php $path = $_SERVER['HTTP_REFERER'];?>
                    <?php $pathArray = explode('/', $path) ?>
                    <a class="btn btn-danger pull-right" href="{{@URL::to($path)}}" >Back to @if($pathArray[count($pathArray)-1] == "") Home @else {{$pathArray[count($pathArray)-1]}} @endif</a>
                @endif

                <?php $path = Request::path();
                    $pathArray = explode('/', $path);
                    if( count($pathArray) > 1 && ($pathArray[count($pathArray)-2] === 'view' || $pathArray[count($pathArray)-2] === 'edit')){
                        $path = dirname(dirname($path));
                    }
                    ;?>
                <a class="btn btn-primary pull-right" href="{{ @URL::to($path. '/create') }}">Add to {{$title}}</a>

            </div>
        </div>
        @endif
    </div>
    <div class="row">
        <div class="col-lg-12">
            @yield('content')
            @if(!empty($previousTableRow) || !empty($nextTableRow))
                <?php $path = dirname(Request::path()); ?>
                <nav>
                    <ul class="pager">
                        @if($previousTableRow->slug)
                            <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->slug }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->slug }}</a></li>
                        @elseif($previousTableRow->id)
                            <li class="previous"><a href="{{@URL::to( $path ) }}/{{ $previousTableRow->id }}"><span aria-hidden="true">&larr;</span> {{ $previousTableRow->id }}</a></li>
                        @endif

                        @if($nextTableRow->slug)
                            <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->slug }}">{{ $nextTableRow->slug }} <span aria-hidden="true">&rarr;</span></a></li>
                        @elseif($nextTableRow->id)
                            <li class="next"><a href="{{@URL::to( $path ) }}/{{ $nextTableRow->id }}">{{ $nextTableRow->id }} <span aria-hidden="true">&rarr;</span></a></li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>

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