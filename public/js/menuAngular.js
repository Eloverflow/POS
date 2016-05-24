var app = angular.module('menu', ['ui.bootstrap','countTo'], function($interpolateProvider, uibPaginationConfig) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    uibPaginationConfig.previousText='Précédent';
    uibPaginationConfig.nextText='Suivant';

})

.filter('floor', function() {
    return function(input, total) {
        total = parseInt(total);
        for (var i=0; i<total; i++)
            input.push(i);
        return input;
    };
})



.factory('getReq', function ($http, $location) {

    return {
        send: function($url, $callbackPath, $callbackFunction) {
            $http({
                method: "GET",
                crossDomain: true,
                url: $url
            }).success(function (response) {
                console.log(response);

                if($callbackPath)
                    $location.path($callbackPath);

                if($callbackFunction)
                    $callbackFunction(response);

            })
                .error(function (data) {
                    console.log('Error: ' + response);
                });
        }
    }
})

.factory('postReq', function ($http, $location) {

    return {
        send: function($url, $data, $callbackPath, $callbackFunction) {
            $http({
                url: $url,
                method: "POST",
                data: $data
            }).success(function (data) {
                console.log(data);

                if($callbackPath)
                    $location.path($callbackPath);

                if($callbackFunction)
                    $callbackFunction(data);

            })
                .error(function (data) {
                    console.log('Error: ' + data);
                });
        }
    }
})


.controller('menuController', function($scope, getReq, postReq, $log, $filter, $timeout)
{


    $scope.commandItems = [];

    $scope.delete2 = function (item) {

            $factureItem = $('#factureItem'+item.id);

            /*$factureItem.slideUp('slow', function(){*/
        $scope.commandClient[$scope.bigCurrentPage].commandItems.splice($scope.commandClient[$scope.bigCurrentPage].commandItems.indexOf(item), 1);
                /*
                $scope.updateBill();*/
            /*});*/


        $scope.updateBill();
    };


    $scope.increase = function(item){

        item.quantity = item.quantity+1;


        $scope.updateBill();

    };

    $scope.decrease = function(item){
        if(item.quantity  > 0){
            item.quantity = item.quantity-1


            $scope.updateBill();
        }
    }


    $url = 'http://pos.mirageflow.com/api/table-plan/1';
    var $callbackFunction = function(response){

        $scope.plan = response;

        $scope.currentTable = $scope.plan.table[0];

    }
    getReq.send($url, null ,$callbackFunction);



    $scope.filters = { };

    $scope.menuItemTypes = [];

    $url = 'http://pos.mirageflow.com/itemtypes/list';
    $callbackFunction = function(response){

        console.log("Itemtype list received inside response");

        $scope.menuItemTypes = response;





        $url = 'http://pos.mirageflow.com/items/liste';
        var $callbackFunction = function(response){

            console.log("Item list received inside response");

            $scope.menuItems = response;


            $scope.menuItemsExtended = [];

            for(var i = 0; i < $scope.menuItemTypes.length; i++){
/*
                console.log($scope.menuItemTypes[i].type);*/

                $scope.menuItemsExtended[i] =  $filter("filter")($scope.menuItems, {itemtype : {type: $scope.menuItemTypes[i].type}});


                var size_name_array_now = $scope.menuItemTypes[i].size_names.split(",");

                var size_array = []



                var sizeMainColor = [];


                for(var x = 0; x < size_name_array_now.length; x++){

                    size_array[x] = {};



                    var sizeColorForName = [15,15,15,15,15,15];


                    var sizeColorText = [0,0,0,0,0,0];


                    function getRandomColor(string) {
                        var letters = '0123456789ABCDEF'.split('');
                        var color = '#';
                        var textColor = '#';

                        var name = string.split('');

                        var count = 0;
                        for(var k = 0; k < name.length; k++){

                            if(count > 6)
                            {
                                count = 0
                            }

                            var currentColor = name[k].charCodeAt(0);

                            while(currentColor > 15){
                                currentColor = currentColor - 16;
                            }


                            var invertedColor = 15 - currentColor;


                            while(invertedColor > 7){
                                invertedColor = invertedColor - 2;
                            }


                            console.log(currentColor + " - Inverted to : " + invertedColor);

                            sizeColorForName[count] = currentColor;
                            sizeColorText[count] = invertedColor;



                            count++
                        }


                        for(var o = 0; o < sizeColorForName.length; o++){
                            color += letters[sizeColorForName[o]];
                            textColor += letters[sizeColorText[o]];
                        }

/*

                        if(x == 0){
                            var currentColor
                            for (var h = 0; h < 4; h++ ) {
                                currentColor = letters[Math.floor(Math.random() * 16)];

                                if(currentColor >)

                                color += currentColor;
                                sizeMainColor[h] = currentColor;
                            }
                        }else{
                            for (h = 0; h < 4; h++ ) {
                                color += sizeMainColor[h];
                            }
                        }

                        for (h = 4; h < 6; h++ ) {
                            color += letters[Math.floor(Math.random() * 16)];
                        }

*/

                        var object = {
                            boxColor: color,
                            textColor: textColor
                        }


                        return object;
                    }




                    size_array[x].name = size_name_array_now[x];


                    size_array[x].color = getRandomColor(size_name_array_now[x]);

                    console.log(size_array[x].color);
                }


                $scope.menuItemsExtended[i].sizes = size_array;

            }
/*
            console.log($scope.menuItemsExtended);*/

            /*No longer automaticly load command*/
/*
            $scope.getCommand();*/

            /*End of loading screen*/
            window.loading_screen.finish();


            $scope.numPadMsg = "Entrez votre numeros d'employe"
            $scope.authenticateEmployee();

            var modalChangeEmployee = $('#changeEmployee');
            modalChangeEmployee.prepend('<div id="windowModalBlocker" style=" background-color: #fff; opacity:0; width: 100%; height: 100%; position: absolute;"></div>');
            /* modalChangeEmployee.find('#closeModal');*/


            /*$('#changeEmployee').on('click',function(){
                alert('test')});
*/
        };

        getReq.send($url, null ,$callbackFunction);

    };



    getReq.send($url, null ,$callbackFunction);



    Array.prototype.filterObjects = function(key, value) {
        return this.filter(function(x) { return x[key] === value; })
    };

    $scope.closeFoot = function(){
     /*   $('#footPanel').height(1);*/
        $('#footPanel').css('padding', '0');
        $('#footPanel').css('height', '0');
        $('#footPanel').css('border-width', '0');
    };


    $scope.totalBill = 0;

    $scope.selectSize = function(size) {
        $scope.sizeProp.value = size;
    };

    $scope.toggleCommandTime = function(){
        $scope.commandItemTimeToggle = !$scope.commandItemTimeToggle;
    }


    $scope.noteSuggestions = ['Sans gluten', 'Ne pas faire', 'OPC'];

    $scope.addNote = function (note, item) {

        if(note != "" && note != undefined){
            if(typeof item != 'undefined' && item != null){
                item.notes.push({note: note});
            }
            else{
                if(typeof $scope.commandClient[$scope.bigCurrentPage].notes === 'undefined' || $scope.commandClient[$scope.bigCurrentPage].notes === null || $scope.commandClient[$scope.bigCurrentPage].notes === "")
                $scope.commandClient[$scope.bigCurrentPage].notes = [];

                $scope.commandClient[$scope.bigCurrentPage].notes.push({note: note})
            }

            $scope.noteDynamicPopover.note = '';

            $scope.updateBill();
        }
/*
        console.log(note);*/
    }

    $scope.deleteItemNote = function(note, item) {
        var index
        if(typeof item != 'undefined' && item != null){
            index = item.indexOf(note);
            item.splice(index, 1);
        }
        else
        {
            index = $scope.commandClient[$scope.bigCurrentPage].notes.indexOf(note);
            $scope.commandClient[$scope.bigCurrentPage].notes.splice(index, 1);
        }
        $scope.delayedUpdateTable();

    }



    $scope.addItem = function() {

        $scope.selectedItemForSize['quantity'] = 1;

        $scope.selectedItemForSize['notes'] = [];

        //Eventually selected size
        $scope.selectedItemForSize['size'] = angular.copy($scope.sizeProp.value);

        var time = new Date();
        $scope.selectedItemForSize['time']= time.getHours()+"H"+((time.getMinutes().toString().length < 2) ? "0" : "") + time.getMinutes();


        var result = "";

        if($scope.commandClient[$scope.bigCurrentPage] != null && typeof $scope.commandClient[$scope.bigCurrentPage].commandItems != 'undefined' && $scope.commandClient[$scope.bigCurrentPage].commandItems != null )
        result = $.grep($scope.commandClient[$scope.bigCurrentPage].commandItems, function(e){return e.id == $scope.selectedItemForSize.id && e.size.value == $scope.selectedItemForSize.size.value; });

        if(result != ""){
            result[0]['quantity'] = result[0]['quantity']+1;
        }
        else
        {
            /*$scope.commandItems.push(angular.copy($scope.selectedItemForSize));
*/

            if(typeof $scope.commandClient[$scope.bigCurrentPage] === 'undefined' || $scope.commandClient[$scope.bigCurrentPage] === null )
            $scope.commandClient[$scope.bigCurrentPage] = {};

            if(typeof $scope.commandClient[$scope.bigCurrentPage].commandItems === 'undefined' || $scope.commandClient[$scope.bigCurrentPage].commandItems === null )
            $scope.commandClient[$scope.bigCurrentPage].commandItems = [];

            $scope.commandClient[$scope.bigCurrentPage].commandItems.push(angular.copy($scope.selectedItemForSize));
        }





        $scope.updateBill();
    };



    $scope.updateBill = function(){

        $scope.delayedUpdateTable();

        $scope.updateTotal();

    };

    $scope.updateTotal = function(){
        var total = 0;

        if(typeof $scope.commandClient[$scope.bigCurrentPage] === 'undefined' || $scope.commandClient[$scope.bigCurrentPage] === null ){

            $scope.commandClient[$scope.bigCurrentPage] = {};
            $scope.commandClient[$scope.bigCurrentPage].commandItems = [];

        }

        if($scope.commandClient[$scope.bigCurrentPage].commandItems.length > 0){
            for(i = 0; i < $scope.commandClient[$scope.bigCurrentPage].commandItems.length; i++){
                total +=  $scope.commandClient[$scope.bigCurrentPage].commandItems[i].quantity *  $scope.commandClient[$scope.bigCurrentPage].commandItems[i].size.price
            }

            $scope.totalBill = total;
        }
        else
        {
            $scope.totalBill = 0
        }
    };


    $scope.selectedItem = function(item, sizeSelected) {

/*
        $('#footPanel').css('padding', '20');
        $('#footPanel').css('height', '300');
        $('#footPanel').css('border-width', '8');*/
     /*   $('#footPanel').height(300);*/


        var size_prices_array = JSON.parse(item['size_prices_array']);

        var size_names = item['itemtype']['size_names'];

        var size_name_array = size_names.split(",");


        //For each

        var sizes = [];

        var size_value = Math.floor((Math.random() * 100) + 1);

        for (var i = 0, len = size_name_array.length; i < len; i++) {

            sizes.push(
                {
                    name: size_name_array[i],
                    price: size_prices_array[i],
                    value: i + size_prices_array[i]
                }
            )
        }
/*
        item['size'] = sizes;*/

        $scope.sizeProp = {
            "name": size_name_array[0],
            price: size_prices_array[0],
            "value": $.grep(sizes, function(e){ return e.name == sizeSelected; })[0],
            "values": sizes
        };

        $scope.selectedItemForSize = item;



    };

/*
    $scope.payNow = function () {

        $url = 'http://pos.mirageflow.com/menu/payer';
        $data = $scope.commandClient[$scope.bigCurrentPage].commandItems;

        var $callbackFunction = function(response){

            console.log("Paying confirmation received inside response");

            $scope.commandClient[$scope.bigCurrentPage].commandItems = [];
            $scope.updateBill();
        };

        postReq.send($url, $data, null, $callbackFunction);

    }
*/

    var timeoutHandle;

    $scope.delayedUpdateTable = function(){

       /* $timeout(function(){
            $scope.progressValue = 0;
        }, 200);*/
        $scope.savingMessage = "Sauvegarde automatique.."

        $timeout(function(){
            $scope.progressValue = 50;

            $('.progress-bar').removeClass('progress-bar-success');/*
            $('#progressBar').addClass('progress-bar-info');*/

        }, 0);

  /*      // in the example above, assign the result
                timeoutHandle = window.setTimeout(function() {
                    $scope.savingMessage = "Updating "
                    $scope.updateTable();
                }, 5000);*/

        // in your click function, call clearTimeout
                window.clearTimeout(timeoutHandle);

        // then call setTimeout again to reset the timer
                timeoutHandle = window.setTimeout(function() {
                    $scope.updateTable();

                }, 5000);
    }


    $scope.updateTable = function ($updateTableCallBack) {

        $url = 'http://pos.mirageflow.com/menu/command';/*
        $data = $scope.commandClient[$scope.bigCurrentPage].commandItems;*/
        $data = {
            commands : $scope.commandClient,
            table : $scope.currentTable,
            employee : $scope.currentEmploye
        };

/*        console.log('Data to save :');
        console.log($data);*/

        var $callbackFunction = function(response){

            for(var f = 0; f < response.commands.length; f++){
                $scope.commandClient[f+1].command_number = response.commands[f].command_number;
                console.log($scope.commandClient[f+1]);
            }


            $timeout(function(){
                $scope.progressValue = 100;
                $('.progress-bar').addClass('progress-bar-success');
                $scope.savingMessage = "Sauvegardé!"
            }, 0);

            console.log("The command as been saved and confirmation received inside response - Success or Not ?");


            if($updateTableCallBack != null)
            $updateTableCallBack();

        };/*
         $scope.commandClient[$scope.bigCurrentPage].commandItems = [];
         $scope.updateBill();*/

        postReq.send($url, $data, null, $callbackFunction);

    }

    $scope.setPage = function (pageNo) {
        $scope.bigCurrentPage = pageNo;
    };

    $scope.pageChanged = function() {
        console.log('Changed to client #' + $scope.bigCurrentPage);
        $scope.updateTotal();
    };

    $scope.showEmployeeModal = false;
    $scope.toggleEmployeeModal = function(){
        $scope.showEmployeeModal = !$scope.showEmployeeModal;
    };


    $scope.showTableModal = false;
    $scope.toggleTableModal = function(){
        $scope.showTableModal = !$scope.showTableModal;
    };

    $scope.showPlanModal = false;
    $scope.togglePlanModal = function(){
        $scope.showPlanModal = !$scope.showPlanModal;
    };


    $scope.showDivideBillModal = false;
    $scope.toggleDivideBillModal = function(){
        $scope.showDivideBillModal = !$scope.showDivideBillModal;
    };

    $scope.authenticateEmployee = function(){

        $url = 'http://pos.mirageflow.com/employee/authenticate/'+ $scope.newUserId;
        $data = {password: $scope.newUserPassword };

        var $callbackFunction = function(response){

            if(!response.hasOwnProperty('error')){
                console.log("User is valid :");
                console.log(response);
                $scope.currentEmploye = response;
                $scope.getCommand();
            }
            else{
                console.log("User is invalid :");
                console.log(response.error);
            }


            $scope.toggleEmployeeModal();
        };

        postReq.send($url, $data, null, $callbackFunction);
    }

    $scope.changeEmployee = function() {
        $scope.toggleEmployeeModal();

        $scope.numPadMsg = "Entrez votre numero d'employee";
        $scope.mainText = '';
        $scope.validation = false;
    }

    $scope.mainText ="";
    $scope.padClick = function($value) {
        //$scope.mainText = $scope.mainText.val + $value;

        switch ($value) {
            case 'dl':
                $scope.mainText = $scope.mainText.slice(0, -1);
                break;
            case 'cl':
                $scope.mainText = "";
                break;
            case 'clk':
                punchEmployee();
                break;
            case 'ent':
                if($scope.validation){
                    $scope.newUserPassword = $scope.mainText;

                    $scope.authenticateEmployee();

                    $('#windowModalBlocker').remove();

                }
                else{
                    $scope.newUserId = $scope.mainText;
                    $scope.numPadMsg = "Entrez votre mot de passe";

                    /*We need to validate*/
                    $scope.validation = true;

                    /*Empty the field*/
                    $scope.mainText = '';
                }

                /* window.location.replace("menu");*/

                break;
            case 'pt':
                $scope.mainText = $scope.mainText + ".";
                break;
            default:
                $scope.mainText = $scope.mainText + $value;

        }

    }

    $scope.divideBill = function(){
        $scope.toggleDivideBillModal();

        $('#billWindow').slideUp(0);
        $('#billWindow').css('visibility', 'visible')
        $scope.openBill();
    };




    $scope.oneBill = function(){
        $scope.toggleDivideBillModal();

        $scope.bills = [];
        var bill = [];
        var total = 0;

        for(var f = 0; f < $scope.commandClient.length; f++){
                if(typeof $scope.commandClient[f+1] != 'undefined' && $scope.commandClient[f+1] != null){
                    for(var p = 0; p < $scope.commandClient[f+1].commandItems.length; p++){
                        var item = angular.copy($scope.commandClient[f+1].commandItems[p])
                        item.checked = false
                        bill.push(item);
                        total +=  item.size.price*item.quantity
                    }
                }
        }

        $scope.bills[0] = bill;
        $scope.bills[0].number = 1;
        $scope.bills[0].total = total;
        total = 0;

        console.log('Bills')
        console.log($scope.bills[0])

        $('#billWindow').slideUp(0);
        $('#billWindow').css('visibility', 'visible')
        $scope.openBill();
    };


    $scope.perClientBill = function(){
        $scope.toggleDivideBillModal();

        $scope.bills = [];
        var bill = [];
        var total = 0;

        for(var f = 0; f < $scope.commandClient.length; f++){
            if(typeof $scope.commandClient[f+1] != 'undefined' && $scope.commandClient[f+1] != null){
                for(var p = 0; p < $scope.commandClient[f+1].commandItems.length; p++){

                    var item = angular.copy($scope.commandClient[f+1].commandItems[p])
                    item.checked = false;
                    bill.push(item);
                    total +=  item.size.price*item.quantity
                }
            }
            $scope.bills[f] = bill;
            $scope.bills[f].number = f+1;
            $scope.bills[f].total = total;
            total = 0;
            bill = [];
        }


        console.log('Bills')
        console.log($scope.bills[0])

        $('#billWindow').slideUp(0);
        $('#billWindow').css('visibility', 'visible')
        $scope.openBill();
    };


    $scope.checkBillItem = function(commandItem){

        commandItem.checked = !commandItem.checked;


        if(commandItem.checked){
            $scope.movingBillItem = true;
        }
        else{

            var checkedItems =  $filter("filter")($scope.bills, {checked:  "true"})[0];

            if(typeof checkedItems == "undefined" || checkedItems == null || checkedItems.length == 0)
            $scope.movingBillItem = false;
        }

        /*
        var checkBox = $(this).find('.move-bill-item')
        checkBox.addClass('glyphicon-checked')
        checkBox.removeClass('glyphicon-checked')*/

    }

    $scope.openBill = function(){
        console.log($scope.bills )
        if(typeof $scope.bills != 'undefined' && $scope.bills != null && $scope.bills[0].length == 0)
        $scope.toggleDivideBillModal();


        $('#billWindow').slideDown(400);
    }

    $scope.closeBill = function(){
        $('#billWindow').slideUp(250);
    }



    $scope.noteDynamicPopover = {
        content: '',
        templateUrl: 'notePopover.html',
        title: 'Notes sur la commande'
    };


    $scope.placement = {
        options: [
            'top',
            'top-left',
            'top-right',
            'bottom',
            'bottom-left',
            'bottom-right',
            'left',
            'left-top',
            'left-bottom',
            'right',
            'right-top',
            'right-bottom'
        ],
        selected: 'bottom-right'
    };
/*
    $scope.htmlPopover = $sce.trustAsHtml('<b style="color: red">I can</b> have <div class="label label-success">HTML</div> content');*/


    $scope.maxSize = 3;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;

    $scope.commandClient = [];
    $scope.commandClient[$scope.bigCurrentPage] = {};
    $scope.commandClient[$scope.bigCurrentPage].commandItems = [];


    $scope.bills = [];
    $scope.bills[0] = [];
    $scope.movingBillItem = false;

    $scope.currentEmploye = {};
    /*$scope.currentEmploye = {
        firstName: "Jean",
        lastName: "Fortin-Moreau",
        id: 2
        };*/

    var amt = 100;

    $scope.countTo = amt;
    $scope.countFrom = 0;
    $scope.savingMessage = "Pret!";

    $timeout(function(){
        $scope.progressValue = amt;
    }, 200);


    $scope.changeTable = function(table){
/*
        console.log('Table command status');
        console.log($scope.commandClient);*/

        var $callbackFunction = function(response){
            $scope.currentTable = table;
            $('#closeModal').click();

            $scope.commandClient = [];
            $scope.getCommand();
        }

        $scope.updateTable($callbackFunction);






    };

    var elem = document.body; // Make the body go full screen.
    var fullscreenFlag = false;
    var splashFullScreen = $('#splashFullScreen');
    $scope.toogleFullscreen = function () {
        fullscreenFlag = !fullscreenFlag;
        if(fullscreenFlag){
            fullscreen();
        }else {
            console.log('etst')
            cancelFullScreen();
        }

    }
    
    function fullscreen(){
        splashFullScreen.fadeTo( 0, 800, function() {
            splashFullScreen.css("visibility","visible");
            splashFullScreen.css("font-size","50px");
        });

        requestFullScreen();
        splashFullScreen.delay(300).fadeTo( 800, 0, function() {
            splashFullScreen.css("visibility","hidden");
            splashFullScreen.css("font-size","30px");
        });

    }

    function requestFullScreen() {
        // Supports most browsers and their versions.
        var requestMethod = elem.requestFullScreen || elem.webkitRequestFullScreen || elem.mozRequestFullScreen || elem.msRequestFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(elem);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    function cancelFullScreen() {
        // Supports most browsers and their versions.
        var requestMethod = document.cancelFullScreen || document.webkitCancelFullScreen || document.mozCancelFullScreen || document.msCancelFullscreen;

        if (requestMethod) { // Native full screen.
            requestMethod.call(document);
        } else if (typeof window.ActiveXObject !== "undefined") { // Older IE.
            var wscript = new ActiveXObject("WScript.Shell");
            if (wscript !== null) {
                wscript.SendKeys("{F11}");
            }
        }
    }

    $scope.getCommand = function(){
        $url = 'http://pos.mirageflow.com/menu/getCommand';/*
         $data = $scope.commandClient[$scope.bigCurrentPage].commandItems;*/
        $data = {
            table : $scope.currentTable,
            employee : $scope.currentEmploye
        };
/*
        console.log('Data to save :');
        console.log($data);*/

        var $callbackFunction = function(response){
            console.log('GetCommand');
            console.log(response);


            $scope.bigCurrentPage = 1;

            if(response.commands.length > 0)
            {

                for(var f = 0; f < response.commands.length; f++){
                    $scope.commandClient[f+1] = response.commands[f];


                    if($scope.commandClient[f+1].notes != "")
                    $scope.commandClient[f+1].notes = JSON.parse($scope.commandClient[f+1].notes)

                    $scope.commandClient[f+1].commandItems = response.commands[f]['commandline'];

                    /*
                     console.log('Command line');
                     console.log($scope.commandClient[f+1].commandItems);*/
                    var time;
                    for(var p = 0; p < $scope.commandClient[f+1].commandItems.length; p++){



                        /*   console.log('menuItems');
                         console.log($scope.menuItems);*/

                        time = new Date($scope.commandClient[f+1].commandItems[p].created_at);


                        var size = $scope.commandClient[f+1].commandItems[p].size;
                        var quantity = $scope.commandClient[f+1].commandItems[p].quantity;


                        console.log('Notes')
                        console.log($scope.commandClient[f+1].commandItems[p].notes);

                        var notes = [];

                        if($scope.commandClient[f+1].commandItems[p].notes != ""){
                            try {
                                notes = JSON.parse($scope.commandClient[f+1].commandItems[p].notes);
                            }
                            catch(err) {
                                //There was an error we flush the notes
                                notes = [];
                            }
                        }

                        /*
                         console.log(angular.copy($.grep($scope.menuItems, function(e){return e.id == $scope.commandClient[f+1].commandItems[p].item_id})[0]));*/

                        $scope.commandClient[f+1].commandItems[p] = angular.copy($.grep($scope.menuItems, function(e){return e.id == $scope.commandClient[f+1].commandItems[p].item_id})[0]);

                        var size_prices_array = JSON.parse($scope.commandClient[f+1].commandItems[p]['size_prices_array']);

                        var size_names = $scope.commandClient[f+1].commandItems[p]['itemtype']['size_names'];

                        var size_name_array = size_names.split(",");

                        //For each
                        var sizes = [];

                        for (var i = 0, len = size_name_array.length; i < len; i++) {

                            sizes.push(
                                {
                                    name: size_name_array[i],
                                    price: size_prices_array[i],
                                    value: i + size_prices_array[i]
                                }
                            )
                        }


                        $scope.commandClient[f+1].commandItems[p].size = $.grep(sizes, function(e){return e.name == size})[0];
                        $scope.commandClient[f+1].commandItems[p].quantity = parseInt(quantity);
                        $scope.commandClient[f+1].commandItems[p].notes = notes;

                        $scope.commandClient[f+1].commandItems[p].time = time.getHours()+"H"+((time.getMinutes().toString().length < 2) ? "0" : "") + time.getMinutes();

                        /*
                         console.log('commandline size')
                         console.log($scope.commandClient[f+1].commandItems[p].size.value);*/


                        /*
                         $result = $.grep($scope.menuItems, function(e){return e.id == response.commands[f].commandline[p].item_id});*/

                    }

                    $scope.commandClient[f+1].status = "1";




                    console.log($scope.commandClient[f+1]);
                }

            }
            else
            {

                $scope.commandClient = [];
                $scope.commandClient[$scope.bigCurrentPage] = {};
                $scope.commandClient[$scope.bigCurrentPage].commandItems = [];

            }

            $scope.updateTotal();


            $timeout(function(){
                $scope.progressValue = 100;
                $('.progress-bar').addClass('progress-bar-success');
                $scope.savingMessage = "Pret!!!"
            }, 0);

            console.log("The command as been loaded and confirmation received inside response - Success or Not ?");


            /*/!*End of loading screen*!/
            window.loading_screen.finish();*/
/*
            $scope.numPadMsg = "Entrez votre numeros d'employe"
            $scope.authenticateEmployee();*/

        };

        /*
         $scope.commandClient[$scope.bigCurrentPage].commandItems = [];
         $scope.updateBill();*/

        postReq.send($url, $data, null, $callbackFunction);

    }




})


.directive('modal', function () {
    return {
        template: '<div class="modal fade">' +
        '<div class="modal-dialog">' +
        '<div class="modal-content">' +/*
        '<div class="modal-header">' +*/
        '<button id="closeModal" type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>' +/*
        '<h4 class="modal-title">{{ title }}</h4>' +
        '</div>' +*/
        '<div class="" ng-transclude></div>' +
        '</div>' +
        '</div>' +
        '</div>',
        restrict: 'E',
        transclude: true,
        replace:true,
        scope:true,
        link: function postLink(scope, element, attrs) {
            scope.title = attrs.title;

            scope.$watch(attrs.visible, function(value){
                if(value == true)
                    $(element).modal('show');
                else
                    $(element).modal('hide');
            });

            $(element).on('shown.bs.modal', function(){
                scope.$apply(function(){
                    scope.$parent[attrs.visible] = true;
                });
            });

            $(element).on('hidden.bs.modal', function(){
                scope.$apply(function(){
                    scope.$parent[attrs.visible] = false;
                });
            });
        }
    }})


 /*   .controller('PaginationDemoCtrl', function ($scope, $log) {

    });
*/

