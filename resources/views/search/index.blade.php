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

                                <span class="pull-right">
                                  @if($articleType == 'work_title')
                                        <a href="{{@URL::to('/work/titles')}}">
                                            View
                                        </a>
                                    @else
                                        <a href="{{@URL::to($articleType . '/details/' . $article['attributes']['id'])}}">
                                            Details
                                        </a>
                                        <a href="{{@URL::to($articleType . '/edit/' . $article['attributes']['id'])}}">
                                            Edit
                                        </a>
                                    @endif
                                </span>
                                <span style="font-size: 13px;">
                                        - Dernière mise à jour: <em>{{$article['attributes']['updated_at']}}</em>
                                        - Création: <em>{{$article['attributes']['created_at']}}</em><br>
                                </span>
                            </div>
                            <div class="panel-body">
                                @foreach($article['attributes'] as $key=>$value)
                                    @if($key != "updated_at" && $key != "created_at" && $key != "slug" && $key != "id"  && !strpos($key, "id"))
                                    {{$key}} : {{ $value }}<br>
                                    @endif
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