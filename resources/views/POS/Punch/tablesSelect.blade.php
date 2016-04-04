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
                <li class="draggable" id="user_2">Bar</li>
            </ul>
        </div>
    </div>
@stop

@section('myjsfile')
    <script>
        $("li").draggable({
            revert: "invalid", // when not dropped, the item will revert back to its initial position
            containment: "document",
            helper: "clone",
            cursor: "move",
            start: function() {
                var role = $(this).closest(".role").attr("id");
                // Here, role is either the id or undefined if no role could be found
            },
            drag: function(){
                var offset = $(this).offset();
                var xPos = offset.left;
                var yPos = offset.top;
                $('#posX').text('x: ' + xPos);
                $('#posY').text('y: ' + yPos);
            }
        });
    </script>
@stop