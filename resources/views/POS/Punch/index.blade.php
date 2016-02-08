@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Punch</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">

            <div class="panel panel-red">
                <div class="panel-heading dark-overlay"><svg class="glyph stroked calendar"><use xlink:href="#stroked-calendar"></use></svg>Calendar</div>
                <div class="panel-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-body">
                    <h2 id="time"></h2>
                    <div id="displayMessage">

                    </div>
                    <div class="form-group">
                        <input id="EmployeeNumber" class="form-control" placeholder="Employee Number Here" name="employeeNumber" type="text">
                    </div>
                    <div class="form-group">
                        <a id="punch" class="btn btn-primary pull-right" href="#"> Punch </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('myjsfile')
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script src="{{ @URL::to('js/punchEmployee.js') }}"></script>
    <script>
        $('#punch').click(function (e) {
            punchEmployee($(this));
        });
    </script>
    <script>
        (function () {
            function checkTime(i) {
                return (i < 10) ? "0" + i : i;
            }

            function startTime() {
                var today = new Date(),
                        h = checkTime(today.getHours()),
                        m = checkTime(today.getMinutes()),
                        s = checkTime(today.getSeconds());
                document.getElementById('time').innerHTML = h + ":" + m + ":" + s;
                t = setTimeout(function () {
                    startTime()
                }, 500);
            }
            startTime();
        })();
    </script>
@stop
