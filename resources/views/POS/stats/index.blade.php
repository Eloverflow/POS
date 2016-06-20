@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{ @URL::to('js/chart.min.js') }}" ></script>


    @stop
@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Statistics</h1>
            <input type="text" id="workedHours" style="visibility: hidden;display: none" value="{{ json_encode($ViewBag['workedHours']) }}">
            <input type="text" id="scheduledHours" style="visibility: hidden;display: none" value="{{ json_encode($ViewBag['scheduledHours']) }}">
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Montly scheduled & worked hours</div>
                <div class="panel-body">
                    <div class="canvas-wrapper">
                        <canvas class="main-chart" id="bar-chart" height="350" width="800"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section("myjsfile")

    <script>
        var randomScalingFactor = function(){ return Math.round(Math.random()*120)};

        var workedHoursArray  = JSON.parse($('#workedHours').val());
        var scheduledHours = JSON.parse($('#scheduledHours').val());;

        var barChartData = {
            labels : ["January","February","March","April","May","June","July", "August", "September", "October", "November", "December"],
            datasets : [
                {
                    fillColor : "rgba(220,220,220,0.5)",
                    strokeColor : "rgba(220,220,220,0.8)",
                    highlightFill: "rgba(220,220,220,0.75)",
                    highlightStroke: "rgba(220,220,220,1)",
                    data : scheduledHours
                },
                {
                    fillColor : "rgba(48, 164, 255, 0.2)",
                    strokeColor : "rgba(48, 164, 255, 0.8)",
                    highlightFill : "rgba(48, 164, 255, 0.75)",
                    highlightStroke : "rgba(48, 164, 255, 1)",
                    data : workedHoursArray
                }
            ]

        };


        $_scaleSteps = 0;
        $maxWorkedHours = Math.max.apply(Math,workedHoursArray);
        $maxScheduledHours = Math.max.apply(Math,workedHoursArray);
        if($maxWorkedHours > 120 && $maxScheduledHours > 120){
            $_scaleSteps = 12;
        } else if($maxWorkedHours > 60 && $maxScheduledHours > 60)  {
            $_scaleSteps = 6
        } else {
            $_scaleSteps = 3
        }

        var countries= document.getElementById("bar-chart").getContext("2d");
        new Chart(countries).Bar(barChartData, {
            scaleOverride : true,
            scaleSteps : $_scaleSteps,
            scaleStepWidth : 20,
            scaleStartValue : 0
        });
    </script>
@stop