@extends('master')
@section('csrfToken')
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="{{ @URL::to('css/scheduleTracking.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Schedule Tracking</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="col-md-6">
                        <div id="tracking-display">
                            {{--<table>
                                <thead>
                                <tr>
                                    <th>Starts At</th>
                                    <th>Finish At</th>
                                    <th>Total</th>
                                </tr>
                                </thead>--}}
                            <?php
                            $s_lastEmpl = "";
                            $s_totalHours = 0;
                            $s_totalMinutes = 0;

                            $s_numItems = count($ViewBag['scheduleInfos']) - 1;
                            $i = 0;
                            ?>
                            {{--@foreach ($ViewBag['scheduleInfos'] as $schedule)--}}
                                <?php
                                    foreach($ViewBag['scheduleInfos'] as $schedule){

                                        if($s_lastEmpl == ""){
                                            $s_lastEmpl = $schedule->idEmployee;

                                ?>
                                <div class="employee">
                                    <h2>{{ $schedule->firstName . " " . $schedule->lastName}} </h2>
                                    <label>Total: </label>{{ $schedule->total->format("%H:%I") }}
                                </div>
                                <div class="content">
                                    <tr>
                                        <td>{{ $schedule->startTime }}</td>
                                        <td>{{ $schedule->endTime }}</td>
                                        <td>{{ $schedule->interval->format("%H:%I")}}</td>
                                    </tr>
                                </div>
                                <?php
                                    } else if($s_lastEmpl == $schedule->idEmployee){

                                ?>
                                <div class="content">
                                    <tr>
                                        <td>{{ $schedule->startTime }}</td>
                                        <td>{{ $schedule->endTime }}</td>
                                        <td>{{ $schedule->interval->format("%H:%I")}}</td>
                                    </tr>
                                </div>
                                <?php
                                    } else {
                                        $s_lastEmpl = $schedule->idEmployee;

                                ?>
                                <div class="employee">
                                    <h2>{{ $schedule->firstName . " " . $schedule->lastName}} </h2>
                                    <label>Total: </label>{{ $schedule->total->format("%H:%I") }}
                                </div>
                                <div class="content">
                                    <tr>
                                        <td>{{ $schedule->startTime }}</td>
                                        <td>{{ $schedule->endTime }}</td>
                                        <td>{{ $schedule->interval->format("%H:%I")}}</td>
                                    </tr>
                                </div>
                                <?php
                                        }
                                        $i++;
                                    }
                                ?>
                        </div>
                    </div>
                    <div class="col-md-6">



                        <div id="tracking-display">
                            {{--<table>
                                <thead>
                                <tr>
                                    <th>Starts At</th>
                                    <th>Finish At</th>
                                    <th>Total</th>
                                </tr>
                                </thead>--}}
                            <?php
                            $p_lastEmpl = "";
                            $p_totalHours = 0;
                            $p_totalMinutes = 0;

                            $p_numItems = count($ViewBag['punches']) - 1;
                            $j = 0;
                            ?>
                            {{--@foreach ($ViewBag['scheduleInfos'] as $schedule)--}}
                            <?php
                            foreach($ViewBag['punches'] as $punch){

                            if($p_lastEmpl == ""){
                            $p_lastEmpl = $punch->idEmployee;

                            ?>
                            <div class="employee">
                                <h2>{{ $punch->firstName . " " . $punch->lastName}} </h2>
                                <label>Total: </label>{{ $punch->total->format("%H:%I") }}
                            </div>
                            <div class="content">
                                <tr>
                                    <td>{{ $punch->startTime }}</td>
                                    <td>{{ $punch->endTime }}</td>
                                    <td>{{ $punch->interval->format("%H:%I")}}</td>
                                </tr>
                            </div>
                            <?php
                            } else if($p_lastEmpl == $punch->idEmployee){

                            ?>
                            <div class="content">
                                <tr>
                                    <td>{{ $punch->startTime }}</td>
                                    <td>{{ $punch->endTime }}</td>
                                    <td>{{ $punch->interval->format("%H:%I")}}</td>
                                </tr>
                            </div>
                            <?php
                            } else {
                            $p_lastEmpl = $punch->idEmployee;

                            ?>
                            <div class="employee">
                                <h2>{{ $punch->firstName . " " . $punch->lastName}} </h2>
                                <label>Total: </label>{{ $punch->total->format("%H:%I") }}
                            </div>
                            <div class="content">
                                <tr>
                                    <td>{{ $punch->startTime }}</td>
                                    <td>{{ $punch->endTime }}</td>
                                    <td>{{ $punch->interval->format("%H:%I")}}</td>
                                </tr>
                            </div>
                            <?php
                            }
                            $j++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop



@section("myjsfile")
    <script src="{{ @URL::to('js/utils.js') }}"></script>
    <script type="text/javascript">
        // var for edit Event

    </script>
@stop