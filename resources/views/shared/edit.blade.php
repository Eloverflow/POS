@extends('master')

@section('title', $title)

@section('content')
    <div class="panel panel-default">
        <div class="panel-body">
            <?php $path = dirname(Request::path());?>
            <div class="panel-heading"><h2><a href="{{@URL::to($path)}}">{{ $title }}</a></h2></div>
            <div class="panel-body">

                {!! Form::open(array('url' => @URL::to(Request::path()),'files' => true)) !!}
                    <div class="form-group">
                        @foreach($tableColumns as $column)
                            @if($column == "img_id")
                                <label for="image" class="secure">Upload form</label>
                                <div class="fileUpload input-group">
                                    <span>Upload</span>
                                    {{--{!! Form::file('image')  !!}--}}
                                    <input id="uploadId" class="upload form-control" type='file' name="image" onchange="readURL(this);" />
                                </div>
                                <p class="errors">{!!$errors->first('image')!!}</p>
                                @if($tableRow->$column != null)
                                    <img id="img_display" src="{{ @URL::to('img/item/' . $tableRow->$column) }}" alt="Smiley face"  width="200">
                                @endif
                            @else
                                <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="{{ $tableRow->$column }}">
                            @endif
                        @endforeach

                        @if(!empty($tableChildRows))
                            @if(is_array($tableChildRows))
                                @foreach($tableChildRows as $tableChildRow)

                                    @foreach($tableChildColumns as $column)

                                            <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                            <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRow->$column != null){{ $tableChildRow->$column }}@endif">
                                    @endforeach

                                @endforeach
                            @else
                                @foreach($tableChildColumns as $column)
                                    <label for="{{ $column }}" >{{ ucwords( str_replace('_', ' ', $column)) }}</label>
                                    <input class="form-control" type="text" id="{{ $column }}" name="{{ $column }}" value="@if($tableChildRows->$column != null){{ $tableChildRows->$column }}@endif">
                                @endforeach
                            @endif
                        @endif

                        @if(isset($tableChoiceLists))
                            @include('shared.choiceList')
                        @endif

                            @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
                            @endif
                            <div id="success"> </div>

                        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                    </div>
                    <button type="submit" class="btn btn-default">Update</button>
                </form>
                <br>

                @include('partials.alerts.errors')

                @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                        {{ Session::get('flash_message') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@stop
