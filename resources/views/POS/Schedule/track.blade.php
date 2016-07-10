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
                    var_dump($ViewBag['scheduleInfos']['grid']);
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