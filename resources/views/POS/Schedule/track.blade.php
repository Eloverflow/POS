@extends('master')
@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Track Schedule</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="form-group">
                        <label>Name :</label>
                        <p>{{ $ViewBag['schedule']->name}}</p>
                    </div>
                    <div class="form-group">
                        <label>Start Date :</label>
                        <p>{{ $ViewBag['schedule']->startDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>End Date :</label>
                        <p>{{ $ViewBag['schedule']->endDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>Created At :</label>
                        <p>{{ $ViewBag['schedule']->created_at }}</p>
                    </div>
                    <div class="form-group">
                        <label>Updated At :</label>
                        <p>{{ $ViewBag['schedule']->updated_at }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php
                    $currentDay = 0;
                    $lastDay = 0;
                    $monthArray = array (
                            0 => "Sunday",
                            1 => "Monday",
                            2 => "Tuesday",
                            3 => "Wednesday",
                            4 => "Thursday",
                            5 => "Friday",
                            6 => "Saturday"
                    );
                    //var_dump($ViewBag['scheduleInfos']);
                    for($i = 0; $i < 7; $i++) {
                        echo "<div class=\"trackBloc\">";
                        if($i == 0){
                            echo "<h2>" . $monthArray[$i] . "</h2><h4>" . $ViewBag['schedule']->startDate . "</h4>";
                        } else {
                            echo "<h2>" . $monthArray[$i] . "</h2><h4>" . date('Y-m-d', strtotime($ViewBag['schedule']->startDate. ' + ' . $i .' days')) . "</h4>";
                        }

                        $lastPerson = "";

                        $current = "";
                        $personCounter = 0;



                        foreach ($ViewBag['scheduleInfos'] as $scheduleInfos) {

                            $currentDay = $i;
                            $currentPerson = $scheduleInfos->firstName . " " . $scheduleInfos->lastName;


                            if($lastPerson != $currentPerson || $personCounter == 0){

                                if($personCounter > 0){
                                    echo "</div>";
                                }

                                if($scheduleInfos->day_number == $i) {
                                    $personCounter++;
                                    echo "<div class=\"emplTrackBlock\">
                                        <h4>" . $scheduleInfos->firstName . " " . $scheduleInfos->lastName . "</h4><h5>" . $scheduleInfos->emplTitle . "</h4>";
                                    echo "<p>Latest Punch: " . "Unknown" . " - " . "Unknown" . "</p>" .
                                            "<p>" . $scheduleInfos->startTime . " To " . $scheduleInfos->endTime . "</p>";

                                }

                            }
                            else{

                                if($scheduleInfos->day_number == $i) {
                                    echo "<p>" . $scheduleInfos->startTime . " To " . $scheduleInfos->endTime . "</p>";
                                }
                            }

                            $lastPerson = $currentPerson;
                        }
                        if($personCounter > 0){
                            echo "</div>";
                        }

                        $lastDay = $currentDay;
                        echo "</div>";
                    }
                    ?>



                </div>
            </div>
        </div>
    </div>

@stop

@section("myjsfile")
    <script>
    </script>
@stop