@if(!empty($title))
    <div class="col-md-6">
        <h1 class="page-header">{{$title}}</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            @if(!empty($_SERVER['HTTP_REFERER']))
                <?php $path = $_SERVER['HTTP_REFERER'];?>
                <?php $pathArray = explode('/', $path) ?>
                <a class="btn btn-danger pull-right" href="{{@URL::to($path)}}" >Back to @if($pathArray[count($pathArray)-1] == "") Home @else {{$pathArray[count($pathArray)-1]}} @endif</a>
            @endif

            <?php $path = Request::path();
            $pathArray = explode('/', $path);
            if( count($pathArray) > 1 && ($pathArray[count($pathArray)-2] === 'view' || $pathArray[count($pathArray)-2] === 'edit')){
                $path = dirname(dirname($path));
            }
            ;?>
            <a class="btn btn-primary pull-right" href="{{ @URL::to($path. '/create') }}">Add to {{$title}}</a>

        </div>
    </div>
@endif