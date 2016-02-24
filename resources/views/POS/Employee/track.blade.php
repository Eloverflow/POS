@extends('master')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">Track Employee</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">

                    <div class="form-group">
                        <label>Email :</label>
                        <p>{{ $ViewBag["employee"]->email }}</p>
                    </div>

                    <div class="form-group">
                        <label>First Name :</label>
                        <p>{{ $ViewBag["employee"]->firstName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Last Name :</label>
                        <p>{{ $ViewBag["employee"]->lastName }}</p>
                    </div>
                    <div class="form-group">
                        <label>Phone Number :</label>
                        <p>{{ $ViewBag["employee"]->phone }}</p>
                    </div>

                    <div class="form-group">
                        <label>Employee Title :</label>
                        <p>{{ $ViewBag["employee"]->employeeTitle }}</p>
                    </div>
                    <div class="form-group">
                        <label>Salary :</label>
                        <p>{{ $ViewBag["employee"]->salary }}</p>
                    </div>
                    <div class="form-group">
                        <label>Birth Date :</label>
                        <p>{{ $ViewBag["employee"]->birthDate }}</p>
                    </div>
                    <div class="form-group">
                        <label>Hire Date :</label>
                        <p>{{ $ViewBag["employee"]->hireDate }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <table data-toggle="table" >
                        <thead>
                        <tr>
                            <th class="col-md-1" data-field="inout">In/Out</th>
                            <th data-field="time">Time</th>
                            <th data-field="date">Date</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($ViewBag['punches'] as $punch)
                            <tr>
                                <?php  if($punch->inout == "in") {
                                    echo "<td class=\"tagin\">IN</td>"; } else {
                                    echo "<td class=\"tagout\">OUT</td>";
                                }
                                        ?>
                                <td>{{ $punch->time }}</td>
                                <td>{{ $punch->date }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop