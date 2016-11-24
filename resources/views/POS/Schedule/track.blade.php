@extends('master')
@section('csrfToken')
    <script src="{{ @URL::to('js/moment/moment.js') }}"></script>
    <script src="{{ @URL::to('js/moment/moment-timezone.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
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
                    <label>Total Scheduled:&nbsp;</label>{{ $ViewBag['scheduleInfos']['summary']['scheduled'] }}
                    <label>Total Worked:&nbsp;</label>{{ $ViewBag['scheduleInfos']['summary']['worked'] }}
                    {{--@if($schedule->difference[0] != "-")
                        <span class="positive-green">{{ $schedule->difference }}</span>
                    @else
                        <span class="negative-red">{{ $schedule->difference }}</span>
                    @endif--}}
                    <label>Cost Calculated:&nbsp;</label>{{ number_format((float)$ViewBag['scheduleInfos']['summary']['cost'], 2, '.', '') . " $" }}
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
                        <h2>{{ $employee->firstName . " " . $employee->lastName }}</h2>
                        <div class="employee">
                            <label>Total Scheduled:&nbsp;</label>{{ $employee->infos->scheduled }}
                            <label>Total Worked:&nbsp;</label>{{ $employee->infos->worked }}
                            @if($employee->infos->difference[0] != "-")
                                <span class="positive-green">{{ $employee->infos->difference }}</span>
                            @else
                                <span class="negative-red">{{ $employee->infos->difference }}</span>
                            @endif
                            <label>Cost Calculated:&nbsp;</label>{{ round($employee->infos->cost, 2) . " $"}}
                        </div>
                <?php
                        foreach($employee->daySchedules as $daySchedule){
                        $dsSt = explode(' ', $daySchedule->startTime);
                        $dtEt = explode(' ', $daySchedule->endTime);

                        ?>

                    <div class="content">
                        <div class="header">
                            <span>{{ $dsSt[0] }}&nbsp;<strong>{{ $dsSt[1] }}</strong></span>
                            <span>{{ $dtEt[0] }}&nbsp;<strong>{{ $dtEt[1] }}</strong></span>
                            <span style="color:blue">{{ $daySchedule->interval->format("%H:%I")}}</span>
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
                        <div class="content">
                            <div class="header">
                                <span>Off Tracking</span>
                            </div>
                            <div class="sub-content">
                                <div class="row-container">
                        <?php
                        $e = new DateTime('00:00');
                        $f = clone($e);
                        foreach($employee->offTracks as $offTrack){

                        $st_pieces = explode(' ', $offTrack->startTime);
                        $et_pieces = explode(' ', $offTrack->endTime);
                        ?>

                        <div class="p-row">
                            <span>{{ $offTrack->id }}</span>
                            <span>{{ $st_pieces[0] }}&nbsp;<strong>{{ $st_pieces[1] }}</strong></span>
                            <span>{{ $et_pieces[0] }}&nbsp;<strong>{{ $et_pieces[1] }}</strong></span>
                            <span style="color:blue">{{ $offTrack->interval->format("%H:%I")}}</span>
                            <span><strong>{{ $offTrack->name }}</strong></span>
                            <span>{{ number_format((float)$offTrack->totalPay, 2, '.', '') . " $" }}</span>
                        </div>
                        <?php
                        $e->add($offTrack->interval);
                        }
                        ?>

                    </div>
                    <div class="total-square">
                        <span>{{ $f->diff($e)->format("%H:%I") }}</span>
                    </div>
                    </div>
                    </div>

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