<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>POSIO @foreach(Request::segments() as $segment){{ ' | ' . ucwords( str_replace('_', ' ', $segment))}}@endforeach</title>
    <script src="{{ @URL::to('js/jquery/jquery-2.1.4.min.js') }}"></script>
    <script src="{{ @URL::to('Framework/Bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
@yield('csrfToken')
{{--Stylesheet call--}}
    <link href="{{ @URL::to('Framework/Bootstrap/3.3.7/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/datepicker3.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/Bootstrap/css/bootstrap-table.css')}}" rel="stylesheet">
    <link href="{{ @URL::to('Framework/LuminoAdmin/css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/styles.css') }}" rel="stylesheet">
    <link href="{{ @URL::to('css/modals.css') }}" rel="stylesheet">
    {{--End of Stylesheet call--}}

    <!--Icons-->
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/lumino.glyphs.js') }}"></script>


    <!--[if lt IE 9]>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/html5shiv.js') }}"></script>
    <script src="{{ @URL::to('Framework/LuminoAdmin/js/respond.min.js') }}"></script>
    <![endif]-->
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

            <a class="navbar-brand" href="#"><span>Pos</span>Io</a>
@if (Auth::check())
            <ul class="user-menu">
                <li class="dropdown pull-right">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> {{ Auth::user()->name }} <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
{{--User Menu definition--}}
<?php
$userMenuTabs = array
(
        //array('name' => 'Profile', 'href' => '#', 'class' => 'glyph stroked male-user', 'xlink' => 'stroked-male-user'),
        //array('name' => 'Settings', 'href' => '#', 'class'=> 'glyph stroked gear', 'xlink' => 'stroked-gear'),
        array('name' => 'Change password', 'href' => '/user/password/update', 'class'=> 'glyph stroked gear', 'xlink' => 'stroked-gear'),
        array('name' => 'Logout', 'href' => '/logout', 'class'=> 'glyph stroked cancel', 'xlink' => 'stroked-cancel'),
);
?>
{{--End of User Menu definition--}}
{{--User Menu rendering--}}
                    @for ($i = 0; $i < count($userMenuTabs); $i++) {{--For each item in the menu--}}
                    <li>
                        <a href="{{ @URL::to($userMenuTabs[$i]['href']) }}" {{ $userMenuTabs[$i]['href'] == '/logout' ? 'onclick=event.preventDefault();document.getElementById(\'logout-form\').submit();' : '' }}>
                            <svg class="{{ $userMenuTabs[$i]['class'] }}">
                                <use xlink:href="#{{ $userMenuTabs[$i]['xlink'] }}"></use>
                            </svg> {{ $userMenuTabs[$i]['name'] }}
                        </a>
                        @if($userMenuTabs[$i]['href'] == '/logout')
                            <form id="logout-form" action="{{ @URL::to($userMenuTabs[$i]['href']) }}" method="POST" style="display: none;">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            </form>
                        @endif
                    </li>
                    @endfor
{{--End of User Menu rendering--}}
                    </ul>
                </li>
            </ul>
@endif
        </div>

    </div><!-- /.container-fluid -->
</nav>

<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
    <form role="search" action="{{ @URL::to('/search') }}" method="get">
        <div class="form-group">
            <input type="text"  name="q" class="form-control" placeholder="Search">
        </div>
    </form>
    <ul class="nav menu">

        @if (Auth::check())
            <li class="{{isActiveRoute('/')}}"><a href="{{ URL::to('/') }}"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg> {{ Lang::get('menu.dashboard') }}</a></li>
            <li class="{{isActiveRoute('stats')}}"><a name="Statistics" href="{{ URL::to('stats') }}"><svg class="glyph stroked line-graph"><use xlink:href="#stroked-line-graph"></use></svg> {{ Lang::get('menu.statistics') }}</a></li>
            <li class="{{isActiveRoute('employee')}}"><a name="Employees"  href="{{ URL::to('employee') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> {{ Lang::get('menu.employees') }}</a></li>
            <li class="{{isActiveRoute('work/titles')}}"><a name="Work Titles"  href="{{ URL::to('work/titles') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> {{ Lang::get('menu.workTitles') }}</a></li>
            <li class="{{isActiveRoute('calendar')}}"><a name="Calendar"  href="{{ URL::to('calendar') }}"><svg class="glyph stroked calendar blank"><use xlink:href="#stroked-calendar-blank"/></svg> {{ Lang::get('menu.calendar') }}</a></li>
            <li class="{{isActiveRoute('schedule')}}"><a name="Schedules"  href="{{ URL::to('schedule') }}"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"/></svg> {{ Lang::get('menu.schedules') }}</a></li>
            <li class="{{isActiveRoute('availability')}}"><a name="Availability"  href="{{ URL::to('availability') }}"><svg class="glyph stroked calendar blank"><use xlink:href="#stroked-calendar-blank"/></svg> {{ Lang::get('menu.availability') }}</a></li>
            <li class="{{isActiveRoute('inventory')}}"><a name="Inventory"  href="{{ URL::to('inventory') }}"><svg class="glyph stroked clipboard with paper"><use xlink:href="#stroked-clipboard-with-paper"/></svg> {{ Lang::get('menu.inventory') }}</a></li>
            <li class="{{isActiveRoute('clients')}}"><a name="Clients"  href="{{ URL::to('clients') }}"><svg class="glyph stroked female user"><use xlink:href="#stroked-female-user"/></svg> Clients</a></li>
            <li id="" class="parent {{areActiveRoutes(['menu','plan','items','itemtypes','extras','filters','punch'])}}">
                <a id="" data-toggle="collapse" href="#sub-item-0" class="collapsed" aria-expanded="false">
                    <svg id="" class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg>
                    <span id="" class="menuLinkText">{{ Lang::get('menu.posMenu') }}</span>
                </a>
                <ul class="children collapse {{isCollapseIn(['menu','plan','items','itemtypes','extras','filters','punch'])}}" id="sub-item-0" aria-expanded="false">
                    <li class="{{isActiveRoute('menu')}}"><a name="Menu" href="{{ URL::to('menu') }}"><svg class="glyph stroked app window with content"><use xlink:href="#stroked-app-window-with-content"/></svg> {{ Lang::get('menu.menu') }}</a></li>
                    <li class="{{isActiveRoute('plan')}}"><a name="Plans" href="{{ URL::to('plan') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> {{ Lang::get('menu.plans') }}</a></li>
                    <li class="{{isActiveRoute('items')}}"><a name="Items" href="{{ URL::to('items') }}"><svg class="glyph stroked bacon burger"><use xlink:href="#stroked-bacon-burger"/></svg></svg> {{ Lang::get('menu.items') }}</a></li>
                    <li class="{{isActiveRoute('itemtypes')}}"><a  name="Item Types" href="{{ URL::to('itemtypes') }}"><svg class="glyph stroked paper coffee cup"><use xlink:href="#stroked-paper-coffee-cup"/></svg> {{ Lang::get('menu.itemTypes') }}</a></li>
                    <li class="{{isActiveRoute('extras')}}"><a name="Extras" href="{{ URL::to('extras') }}"><svg class="glyph stroked tag"><use xlink:href="#stroked-tag"/></svg> {{ Lang::get('menu.extras') }}</a></li>
                    <li class="{{isActiveRoute('filters')}}"><a name="Menu Filer" href="{{ URL::to('filters') }}"><svg class="glyph stroked monitor"><use xlink:href="#stroked-monitor"/></svg> {{ Lang::get('menu.posMenuFilter') }}</a></li>
                    <li class="{{isActiveRoute('punch')}}"><a href="{{ URL::to('punch') }}"><svg class="glyph stroked clock"><use xlink:href="#stroked-clock"/></svg> {{ Lang::get('menu.punch') }}</a></li>
                </ul>
            </li>
            <li role="presentation" class="divider"></li>
            <li id="" class="parent {{areActiveRoutes(['addon/rfid/table','addon/rfid/request'])}}">
                <a id="" data-toggle="collapse" href="#sub-item-1" class="collapsed" aria-expanded="false">
                    <svg id="" class="glyph stroked chevron-down"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="#stroked-chevron-down"></use></svg>
                    <span id="" class="menuLinkText"> {{ Lang::get('menu.addons') }}</span>
                </a>
                <ul class="children collapse {{isCollapseIn(['addon/rfid/table','addon/rfid/request'])}}" id="sub-item-1" aria-expanded="false">
                    <li class="{{isActiveRoute('addon/rfid/table')}}"><a href="{{ URL::to('addon/rfid/table') }}"><svg class="glyph stroked table"><use xlink:href="#stroked-table"/></svg> {{ Lang::get('menu.rfidTables') }}</a></li>
                    <li class="{{isActiveRoute('addon/rfid/request')}}"><a href="{{ URL::to('addon/rfid/request') }}"><svg class="glyph stroked wireless router"><use xlink:href="#stroked-wireless-router"/></svg> {{ Lang::get('menu.rfidRequests') }}</a></li>
                </ul>
            </li>
            <li role="presentation" class="divider"></li>
            <li class="{{isActiveRoute('activity-log')}}"><a name="Activity log" href="{{ URL::to('activity-log') }}"><svg class="glyph stroked internal hard drive"><use xlink:href="#stroked-internal-hard-drive"/></svg> {{ Lang::get('menu.activityLog') }}</a></li>
            <li class="{{isActiveRoute('menu-settings')}}"><a name="Settings" href="{{ URL::to('menu-settings') }}"><svg class="glyph stroked gear"><use xlink:href="#stroked-gear"/></svg> {{ Lang::get('menu.settings') }}</a></li>
            <li role="presentation" class="divider"></li>
        @else
            <li class="{{isActiveRoute('login')}}"><a href="{{ URL::to('login') }}"><svg class="glyph stroked male-user"><use xlink:href="#stroked-male-user"></use></svg> {{ Lang::get('menu.loginPage') }}</a></li><li role="presentation" class="divider"></li>
        @endif
    </ul>



</div><!--/.sidebar-->
<div style="z-index: 100;" class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2">
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

    <div class="row">
        @yield('titleSection')
    </div>
    <div class="row">
        <div class="col-lg-12">
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

            @yield('afterContent')
        </div>
    </div>

</div>

@yield('calendar')

{{--Script call--}}{{--
<script src="{{ @URL::to('Framework/Bootstrap/3.3.7/js/bootstrap.min.js') }}"></script>
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datepicker.min.js') }}"></script>--}}
{{--<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-datetimepicker.min.js') }}"></script>--}}
{{--
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart.min.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/chart-data.js') }}"></script>--}}{{--
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart.js') }}"></script>
<script src="{{ @URL::to('Framework/LuminoAdmin/js/easypiechart-data.js') }}"></script>--}}
<script src="{{ @URL::to('Framework/Bootstrap/js/bootstrap-table.min.js') }}"></script>
{{--<script src="{{ @URL::asset('js/jquery/jquery.nicescroll.min.js') }}"></script>--}}
<script src="{{ @URL::to('js/baseEffect.js') }}"></script>
@if(Request::path() == "addon/rfid/table")
    <script src="{{ @URL::asset('js/jquery/jquery.sortable.js') }}"></script>
    <script src="{{ @URL::asset('js/listener.js') }}"></script>
@endif
{{--End of Script call--}}

@yield('myjsfile')
</body>

</html>