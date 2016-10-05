@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
{{--
@section('title', $title)--}}

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Search</h1>
    </div>{{--
    <div class="col-md-6">
        <div class="vcenter">
            <a href="{{@URL::to('/filters/create')}}"  ><button type="button" class="btn btn-primary">Create</button></a>
        </div>
    </div>--}}
    <div class="row">
        <div class="col-lg-12">
            @if (count($articles) === 0)
                ... no articles found
            @elseif (count($articles) >= 1)
                @foreach($articles as $articleType=>$currentArticle)
                    @foreach($currentArticle as $article)
                        <div class="panel panel-default">
                            <div class="panel-heading">{{ucwords( str_replace('_', ' ', $articleType))}}

                                @if($articleType == 'work_title')
                                    <span class="pull-right">
                                        <a href="{{@URL::to('/work/titles')}}">
                                            View
                                        </a>
                                    </span>
                                @else
                                    <span class="pull-right">
                                        <a href="{{@URL::to($articleType . '/details/' . $article['attributes']['id'])}}">
                                            Details
                                        </a>
                                        <a href="{{@URL::to($articleType . '/edit/' . $article['attributes']['id'])}}">
                                            Edit
                                        </a>
                                    </span>
                                @endif
                            </div>
                            <div class="panel-body">
                                @foreach($article['attributes'] as $key=>$value)
                                    {{$key}} : {{ $value }}<br>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @endif
        </div>
    </div>
@stop

@section("myjsfile")

@stop