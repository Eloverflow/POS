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
                    for($i = 0; $i < 7; $i++) {
                        echo "<h2>$i</h2>";
                        $lastPerson = "";

                        $current = '';
                        $personCounter = 0;


                        foreach ($ViewBag['scheduleInfos'] as $scheduleInfos) {


                                $currentPerson = $scheduleInfos->firstName . " " . $scheduleInfos->lastName;

                                if($lastPerson != $currentPerson ){
                                    if($personCounter > 0){
                                        echo "</div>";
                                    } else {

                                    }


                                    // echo $currentPerson;
                                    if($scheduleInfos->day_number == $i) {
                                        $personCounter++;
                                        echo "<div class=\"emplTrackBlock\">
                                        <h2>" . $scheduleInfos->firstName . " " . $scheduleInfos->lastName . "</h2><h4>" . $scheduleInfos->emplTitle . "</h4>";
                                        echo "<p>Latest Punch: " . $scheduleInfos->inout . " - " . $scheduleInfos->created_at . "</p>" .
                                                "<p>" . $scheduleInfos->startTime . " To " . $scheduleInfos->endTime . "</p>";
                                    }else {
                                        //echo "<div class=\"emplTrackBlock\"></div>";
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
                                echo "</div>" . $personCounter;
                            }

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