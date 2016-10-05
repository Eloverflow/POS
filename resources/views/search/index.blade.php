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
            <div class="panel panel-default">
                <div class="panel-body">

                    @if (count($articles) === 0)
                        ... html showing no articles found
                    @elseif (count($articles) >= 1)
                        ... print out results
                        @foreach($articles as $article)
                            print article
                        @endforeach
                    @endif

                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

@stop