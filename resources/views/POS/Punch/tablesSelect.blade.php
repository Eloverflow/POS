@extends('POS.Punch.mainLayout')

@section("csrfToken")
    <script src="{{ @URL::to('js/utils.js') }}"></script>

@stop

@section('content')
    <div>
        <div id="role_1" class="role">
            <h5>Administrator</h5>
            <ul class="users">
                <li class="draggable" id="user_1">
                    <span id="posX"></span>
                    <span id="posY"></span>
                </li>
                <li class="draggable" id="user_2">
                    <span id="posX"></span>
                    <span id="posY"></span>
                </li>
            </ul>
        </div>
    </div>
@stop

@section('myjsfile')
    <script>
        $("li").draggable({
            drag: function(){
                var offset = $(this).offset();
                var xPos = offset.left;
                var yPos = offset.top;
                $(this).find('#posX').text('x: ' + xPos);
                $(this).find('#posY').text('y: ' + yPos);
            }
        });
    </script>
@stop