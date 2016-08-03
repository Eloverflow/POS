@extends('master')

@section("csrfToken")
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="{{ @URL::to('js/utils.js') }}"></script>

@stop


@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    {!! Form::open(array('url' => @URL::to('/menu-settings'), 'role' => 'form')) !!}
                    <div class="col-md-6">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <fieldset>
                            <legend>General Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Language" ) !!}
                                    <select name="language" class="form-control" style="width: 200px">
                                        <option value="fr" @if($menuSetting['language'] == "fr") selected @endif >Français</option>
                                        <option value="en" @if($menuSetting['language'] == "en") selected @endif >English</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('use_email', "Use email ?" ) !!}
                                    <input name="use_email" id="use_email" value="1" type="checkbox" @if($menuSetting['use_email'] == 1) checked="checked" @endif >
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <legend>POS Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Timezone" ) !!}
                                    <select name="timezone" class="form-control">
                                        @foreach($timezones as $timezone)
                                            <option value="{{$timezone['value']}}" @if($menuSetting['timezone'] == $timezone['value']) selected @endif >{{$timezone['text']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Format de l'heure" ) !!}
                                    <select name="use_time_24" class="form-control" style="width: 70px">
                                        <option value="0" @if($menuSetting['use_time_24'] == 0) selected @endif>12</option>
                                        <option value="1" @if($menuSetting['use_time_24'] == 1) selected @endif>24</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Plan courant" ) !!}
                                    <select name="plan_id" class="form-control" >
                                        @foreach($plans as $plan)
                                            <option value="{{$plan->id}}" @if($menuSetting['plan_id'] == $plan->id) selected @endif >{{$plan->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Heure d'ete" ) !!}
                                    <input name="daylight" id="daylight" type="checkbox" @if($menuSetting['daylight']) checked="checked" @endif >
                                </div>
                            </div>
                            <div class="mfs">
                                <div class="form-group">
                                    {!! Form::label('title', "Taxes" ) !!}
                                    {!! Form::text('taxes', $menuSetting['taxes'], array('class' => 'form-control')) !!}
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">

                        <fieldset>
                            <legend>Other Informations</legend>
                            <div class="mfs">
                                <div class="form-group">
                                </div>
                            </div>
                        </fieldset>
                    </div>

                    <div class="col-md-6">
                        <div class="vcenter">
                            {!! Form::submit('Apply modification', array('class' => 'btn btn-primary right')) !!}
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@stop

@section('myjsfile')
@stop