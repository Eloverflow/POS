@extends('master')


@section('csrfToken')
    <meta name="csrf-token" content="{{ csrf_token() }}" />
@stop
{{--
@section('title', $title)--}}

@section('content')
    <div class="col-md-6">
        <h1 class="page-header">Activity Log</h1>
    </div>
    <div class="col-md-6">
        <div class="vcenter">
            <a href="#" id="displayLive" ><button type="button" class="btn btn-primary">Afficher en Live</button></a>
            <a hidden href="#" id="live" ><button type="button" class="btn btn-warning">En Live</button></a>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div style="font-family: 'Consolas', 'Arial', sans-serif;overflow-y: scroll;height: 30px; width: 100%; padding: 5px; border-radius: 4px; background-color: #333; color: #fff" id="filtre">
                        {{--  --}}
                            <form style="height: 20px; "><label for="query">Search:</label> <input placeholder="Eventually filtering line !" style="height: 20px; color: #222" name="query" id="query" type="text" size="30" maxlength="30"></form>
                    </div>

                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                       <div id="terminal"></div>

                </div>

            </div>
        </div>
    </div>
@stop

@section("myjsfile")

    <script type="application/javascript">

        var isLive = false;
        var noResultIteration = 0;
        var lastId, firstId;

        $('#displayLive').click(function() {
            noResultIteration = 0;
            isLive = true;
            getActivityLogOverId(lastId);
            $( "#live" ).show();
            $( "#displayLive" ).hide();



            if($('.lastPosition').length == 1)
                $('.lastPosition').remove();


            if($('.liveActionMsg').length == 0){
                $('#terminal').append('<div class="lastPosition" style="border-bottom: 1px solid #00a5ff; height: 3px; margin-bottom: 3px; width: 100%"></div>');
                $('#terminal').append('<div class="loadBlock" style="height: 18px; "></div>');
            }
            else
                $('.liveActionMsg').before('<div class="lastPosition" style="border-bottom: 1px solid #00a5ff; height: 3px; margin-bottom: 3px; width: 100%"></div>');


            if($('.liveActionLoading').length == 0){
                $('#terminal').append('<div class="liveActionLoading"><span class="glyphicon glyphicon-refresh"></span></div>');

                updateScroll();
            }

        });

        $('#live').click(function() {
            noResultIteration = 0;
            isLive = false;
            $( "#displayLive" ).show();
            $( "#live" ).hide();
            $('.liveActionLoading').remove();
        });


        function getLogString(log) {

            var finalString = "";
            /*finalString += log.id+ ' : ';*/
            finalString += '<span style="color: #30a5ff">[' + log.updated_at + ']</span> ';


            if(log.user){

                var user_link = "{{ @URL::to('employee/track') }}/" + log.employee.id;

                if(log.user.name == 'user_employee'){
                    finalString += '<span >';
                    finalString += '<a style="color: #fff" href="' + user_link + '">';
                    finalString += log.employee.firstName + ' ' +  log.employee.lastName;
                    finalString += '</a>';
                }
                else{
                    finalString += '<span style="color: #fff; text-shadow: 0 0 5px rgba(255,255,255,.2);">';
                    finalString += log.user.name + '(Admin)'
                }
            }else{
                finalString += '<span style="color: #fff; text-shadow: 0 0 5px rgba(255,255,255,.2);">';
                finalString += '(Server)'
            }


            finalString += '</span>';
            finalString += ' - ';

            try {
                //var logObject = JSON.parse(log.text);
                var logObject = log;

                var type = logObject.subject_type.split('\\');
                type = type[type.length-1];

                if(logObject.description == "created"){
                    finalString += '<span style="color: green">Created: ';
                    finalString += type;

                }
                else if(logObject.description == "updated"){
                    finalString += '<span style="color: #30a5ff">Updated: ';
                    finalString += type;

                }
                else if(logObject.description == "deleted"){
                    finalString += '<span style="color: red">Deleted: ';
                    finalString += type;

                }
                else {
                    finalString += '<span style="color: #8ad919">';
                    finalString += log;
                }
                finalString += '</span>';

                if(logObject['related_table']){
                    finalString += ' - <span style="color: white">';
                    finalString += 'Table #' + logObject['related_table'].tblNumber + ' ';
                    finalString += '</span>';
                }

                if(logObject['related_command']){
                    finalString += ' - <span style="color: white">';
                    finalString += 'Command #' + logObject['related_command'].command_number + ' ';
                    finalString += '</span>';
                }

                finalString += ' <button onclick="updateScrollDelayed(this)" class="btn btn-info" style="height: 30px; margin: 2px;" data-toggle="collapse" href="#data-'+ log.id + '"> Object </button>'
                finalString += '<span style="margin-left: 0;" id="data-'+ log.id + '" class="collapse" >';

                var row = logObject['properties'];


                finalString += '<table style="width: 100%; box-shadow: 2px 2px 6px #222;border: 4px #31b0d5 solid; color: #fff"><tr>';
                $.each(row, function(key, data) {
                    finalString += '<th  style=" padding: 3px; border: 3px #31b0d5 solid; ">';
                    finalString += key;
                    finalString += '</th>';
                });
                finalString += '</tr>';

                finalString += '<tr>';
                $.each(row, function(key, data) {
                    finalString += '<td style=" max-width:430px; overflow: auto;  border: 2px #555 solid; border-top: none">';

                    if(typeof data =='object' && data != null)
                    {
                        $.each(data, function(dataKey, dataData) {
                            finalString += dataKey;
                            finalString += ': ';
                            finalString += dataData;
                            finalString += '<br>';
                        });
                    }
                    else {

                        try {
                            var newData = JSON.parse(data);

                            if(typeof newData =='object' && newData != null)
                            {
                                $.each(newData, function(dataKey, dataData) {
                                    finalString += dataKey;
                                    finalString += ': ';
                                    finalString += dataData;
                                  finalString += '<br>';
                                });
                            }
                            else {
                                finalString += data
                            }

                        }catch (e) {

                            finalString += data
                        }

                    }

                    finalString += '</td>';
                });
                finalString += '</tr></table>'

                finalString += '</span>'
            }catch (e) {
                finalString += '<span style="color: #fff">'
                finalString += log.text;
                finalString += '</span>'
            }


            return finalString

        }

        function getActivityLog() {
            $.ajax({
                url:'{{ @URL::to('/activity-log/list') }}',
                complete: function (response) {
                    if(typeof response.responseJSON != 'undefined'){
                        var i;

                        for(i = response.responseJSON.length-1; i >= 0; i--){
                            $('#terminal').append(getLogString(response.responseJSON[i])+ '<br>');

                            if(i == response.responseJSON.length-1){
                                firstId = response.responseJSON[i].id;
                            }
                        }

                        if(response.responseJSON.length >= 20){
                            $('#terminal').prepend('<div class="olderThanBox" style="text-align: center; width: 100%;"><a href="#" onclick="getActivityLogOlderThanId(firstId)">(Show more logs)</a></div>');
                        }

                        updateScroll();
                        if(isLive)
                        setTimeout(function() {getActivityLogOverId(response.responseJSON[i-1].id)}, 1000);
                        else
                        lastId = response.responseJSON[0].id;
                    }
                },
                error: function () {
                    $('#terminal').append('<div style="position: absolute; bottom:40px;z-index:6;background-color: #333;width:90%;">Bummer: there was an error! <a href="">(Refresh the page)</a></div>');
                    updateScroll();
                    setTimeout(function() {getActivityLog()}, 2000);
                },
            });
            return false;
        }
        getActivityLog();


        function getActivityLogOlderThanId($id) {

            $('.olderThanBox').remove();
            $('#terminal').prepend('<div class="firstPosition" style="border-bottom: 1px solid #00a5ff; height: 3px; margin-bottom: 3px; width: 100%"></div>');


            $.ajax({
                    url:'{{ @URL::to('/activity-log/olderthan') }}/'+ $id,
                    complete: function (response) {
                        if(typeof response.responseJSON != 'undefined'){
                            var i
                            for(i= 0; i< response.responseJSON.length; i++){
                                $('#terminal').prepend(getLogString(response.responseJSON[i])+ '<br>');

                                if(i == response.responseJSON.length-1){
                                    firstId = response.responseJSON[i].id;
                                }
                            }

                            if(response.responseJSON.length >= 20){
                                $('#terminal').prepend('<div class="olderThanBox" style="text-align: center; width: 100%;"><a href="#" onclick="getActivityLogOlderThanId(firstId)">(Show more logs)</a></div>');
                            }
                            else {
                                $('#terminal').prepend('<div class="olderThanBox" style="text-align: center; width: 100%;">*No more logs</div>');
                            }

                        }
                    },
                    error: function () {
                        $('#terminal').prepend('<div style="position: absolute; bottom:40px;z-index:6;background-color: #333;width:90%;">Bummer: there was an error! <a href="">(Refresh the page)</a></div>');
                        updateScroll();
                    },
                });
            return false;
        }


        function getActivityLogOverId($id) {


            if(noResultIteration > 10){
                isLive = false;


                if($('.liveActionLoading').length == 1)
                    $('.liveActionLoading').remove();

                if($('.loadBlock').length == 1)
                    $('.loadBlock').remove();

                $('.liveActionMsg').fadeOut( 200, function() {
                    $(this).remove();
                    $('#terminal').append('<span class="liveActionMsg" style="color:red;">The live action log has been stopped after 10 empty request.' + '<br></span>');

                });

                if($('.liveActionMsg').length == 0)
                $('#terminal').append('<span class="liveActionMsg" style="color:red;">The live action log has been stopped after 10 empty request.' + '<br></span>');


                $( "#displayLive" ).show();
                $( "#live" ).hide();
                updateScroll();
            }

            if(isLive)
            $.ajax({
                url:'{{ @URL::to('/activity-log/over') }}/'+ $id,
                complete: function (response) {
                    if(typeof response.responseJSON != 'undefined'){
                        var i
                        for(i= 0; i< response.responseJSON.length; i++){
                            $('#terminal').append(getLogString(response.responseJSON[i])+ '<br>');
                        }
                        if(i>0)
                        {
                            updateScroll();
                            setTimeout(function() {getActivityLogOverId(response.responseJSON[i-1].id)}, 1000);
                            lastId = response.responseJSON[i-1].id;
                            noResultIteration = 0
                        }
                        else{
                            setTimeout(function() {getActivityLogOverId($id)}, 1000);
                            noResultIteration++;
                        }

                    }
                },
                error: function () {
                    $('#terminal').append('<div style="position: absolute; bottom:40px;z-index:6;background-color: #333;width:90%;">Bummer: there was an error! <a href="">(Refresh the page)</a></div>');
                    updateScroll();
                },
            });

            return false;
        }

        function updateScroll(){
            var element = document.getElementById("terminal");
            element.scrollTop = element.scrollHeight;
        }
        function updateScrollDelayed(e){
            var element = document.getElementById("terminal");
            if(e.offsetTop > element.scrollHeight-200)
            setTimeout(updateScroll, 100)

        }


        $('#query').bind('input', function() {
            highlightSearch()
        });

        function highlightSearch() {
            var text = document.getElementById("query").value;

            if(text.length > 3){

                var query = new RegExp("(" + text + ")", "gim");
                var e = document.getElementById("terminal").innerHTML;
                var enew = e.replace(/(<em>|<\/em>)/igm, "");
                document.getElementById("terminal").innerHTML = enew;
                var newe = enew.replace(query, "<em>$1</em>");
                document.getElementById("terminal").innerHTML = newe;
            }else {
                var query = new RegExp("(\\b" + text + "\\b)", "gim");
                var e = document.getElementById("terminal").innerHTML;
                var enew = e.replace(/(<em>|<\/em>)/igm, "");
                document.getElementById("terminal").innerHTML = enew;
            }

        }
    </script>

@stop