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
        <div class="col-lg-6">
            <div class="panel panel-default">
                <div class="panel-body">

                <?php
                    //var_dump($ViewBag['scheduleInfos']['grid']);
                    foreach($ViewBag['scheduleInfos']['grid'] as $employee){
                ?>
                    <div class="col-lg-12 tracking-bloc">
                        <h2>{{ $employee->id }}</h2>
                        <div class="employee">
                        </div>
                <?php
                        foreach($employee->daySchedules as $daySchedule){
                        ?>

                    <div class="content">
                        <div class="header">
                            <span>{{ $daySchedule->startTime }}</span>
                            <span>{{ $daySchedule->endTime }}</span>
                            {{--<span style="color:blue">{{ $schedule->interval->format("%H:%I")}}</span>--}}
                        </div>
                        <div class="sub-content">
                            <div class="row-container">
                                <?php


                                $e = new DateTime('00:00');
                                $f = clone($e);
                                foreach($daySchedule->corresps as $corresp){
                                $st_pieces = explode(' ', $corresp->startTime);
                                $et_pieces = explode(' ', $corresp->endTime);
                                ?>
                                <div class="p-row">
                                    <span>{{ $corresp->id }}</span>
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
                        }


                        ?>
                        {{ var_dump($employee->offTracks) }}
                    </div>
                    <?php
                    }
                ?>
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