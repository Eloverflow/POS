@extends('master')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <h1 class="page-header">Error 404</h1>
        </div>
        <div class="col-md-6">
            <div class="vcenter">
                <a class="btn btn-primary pull-right" href="{{ @URL::to('/') }}">Go Home</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <?php $path = dirname(Request::path());?>
                    <h3>Nothing to be found at : <a href="{{ @URL::to('/'. Request::path()) }}">{{ @URL::to('/'. Request::path()) }}</a> </h3>
                    <h4>You can try : <a href="{{ @URL::to($path) }}"> @if($path != ".") {{@URL::to($path)}} @else {{@URL::to('/')}} @endif</a> </h4><br>
                    Domain : <a href="{{ @URL::to('/') }}">{{ @URL::to('/') }}</a> <br>
                    Page : <a href="{{ @URL::to('/'. Request::path()) }}">{{ Request::path() }}</a><br><br>

                    @if(!empty($_SERVER['HTTP_REFERER']))
                    You were coming from : <a href="{{ $_SERVER['HTTP_REFERER'] }}" >{{ $_SERVER['HTTP_REFERER'] }}</a><br><br>
                    @endif
                    User IP : {{ $_SERVER["REMOTE_ADDR"] }} <br>
                    User Agent :  {{$_SERVER['HTTP_USER_AGENT']}}<br>
                </div>
            </div>
        </div>
    </div>


@stop