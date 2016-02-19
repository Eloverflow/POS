@extends('master')



@section('content')

    <div class="panel-body">
        <div class="col-md-6">
            {!! Form::open(array('url' => @URL::current(), 'role' => 'form')) !!}
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

            @foreach($formSections as $section)
            <fieldset>
                <legend>{{$section['title']}}</legend>
                <div class="mfs">
                    @foreach($section['fields'] as $field)
                    <div class="form-group">
                        {!! Form::label($field['input'], $field['label'] ) !!}
                        @if($errors->has('email'))
                            <div class="form-group has-error">
                                {!! Form::text($field['input'], null, array('class' => 'form-control')) !!}
                            </div>
                        @else
                            {!! Form::text($field['input'], null, array('class' => 'form-control')) !!}
                        @endif
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @endforeach

            {!! Form::submit('Create', array('class' => 'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>

@stop