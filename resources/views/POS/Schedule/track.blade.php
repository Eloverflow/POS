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
                    <h3>Scheduled Hours</h3>
                    <label>Total Scheduled: </label>{{ $ViewBag['scheduleInfos']['summary']['scheduled'] }}
                    <label>Total Worked: </label>{{ $ViewBag['scheduleInfos']['summary']['worked'] }}
                    {{--@if($schedule->difference[0] != "-")
                        <span class="positive-green">{{ $schedule->difference }}</span>
                    @else
                        <span class="negative-red">{{ $schedule->difference }}</span>
                    @endif--}}
                    <label>Cost Calculated: </label>{{ number_format((float)$ViewBag['scheduleInfos']['summary']['cost'], 2, '.', '') . " $" }}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                            <?php
                            $s_lastEmpl = "";
                            $s_totalHours = 0;
                            $s_totalMinutes = 0;

                            $s_numItems = count($ViewBag['scheduleInfos']['grid']) - 1;
                            $i = 0;
                            ?>
                            {{--@foreach ($ViewBag['scheduleInfos'] as $schedule)--}}
                                <?php
                                    foreach($ViewBag['scheduleInfos']['grid'] as $schedule){

                                        if($s_lastEmpl == "" || $s_lastEmpl != $schedule->idEmployee){
                                            $s_lastEmpl = $schedule->idEmployee;

                                ?>
                                <div class="col-lg-6 tracking-bloc">
                                <h2>{{ $schedule->firstName . " " . $schedule->lastName}}</h2>
                                <div class="employee">
                                    <h3>Scheduled Hours</h3>
                                    <label>Total Scheduled: </label>{{ $schedule->total }}
                                    <label>Total Worked: </label>{{ $schedule->totalWorked }}
                                    @if($schedule->difference[0] != "-")
                                        <span class="positive-green">{{ $schedule->difference }}</span>
                                    @else
                                        <span class="negative-red">{{ $schedule->difference }}</span>
                                    @endif
                                    <label>Cost Calculated: </label>{{ number_format((float)$schedule->totalPayed, 2, '.', '') . " $" }}
                                </div>
                                <div>
                                    {{ var_dump($schedule->offTrack) }}
                                </div>
                                <?php } ?>
                                <div class="content">
                                    <div class="header">
                                        <span>{{ $schedule->startTime }}</span>
                                        <span>{{ $schedule->endTime }}</span>
                                        <span style="color:blue">{{ $schedule->interval->format("%H:%I")}}</span>
                                    </div>
                                    <div class="sub-content">
                                        <div class="row-container">
                                        <?php

                                            $e = new DateTime('00:00');
                                            $f = clone($e);
                                            foreach($schedule->corresponds as $corresp){
                                                $st_pieces = explode(' ', $corresp->startTime);;
                                                $et_pieces = explode(' ', $corresp->endTime);
                                            ?>
                                            <div class="p-row">
                                                <span>{{ $st_pieces[0] }}&nbsp;<strong>{{ $st_pieces[1] }}</strong></span>
                                                <span>{{ $et_pieces[0] }}&nbsp;<strong>{{ $et_pieces[1] }}</strong></span>
                                                <span style="color:blue">{{ $corresp->interval->format("%H:%I")}}</span>
                                                <span><strong>{{ $corresp->name }}</strong></span>
                                                <span>{{ number_format((float)$corresp->totalPay, 2, '.', '') . " $" }}</span>
                                            </div>
                                            <?php
                                                $e->add($corresp->interval);
                                            }
                                        ?>
                                        </div>
                                        <div class="total-square">
                                            <span>{{ $f->diff($e)->format("%H:%I") }}</span>
                                        </div>

                                    </div>
                                </div>
                                <?php
                                    if((count($ViewBag['scheduleInfos']['grid']) - 1) != $i){
                                        if($ViewBag['scheduleInfos']['grid'][$i+1]->idEmployee != $s_lastEmpl){
                                ?>
                                </div>
                                <?php
                                        }
                                    } else {
                                    ?>
                                </div>
                                <?php
                                    }
                                ?>

                                <?php
                                        $i++;
                                    }
                                ?>
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