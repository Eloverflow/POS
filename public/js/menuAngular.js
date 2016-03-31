var app = angular.module('menu', ['ui.bootstrap'], function($interpolateProvider, uibPaginationConfig) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');
    uibPaginationConfig.previousText='Précédent';
    uibPaginationConfig.nextText='Suivant';

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


.controller('menuController', function($scope, getReq, postReq, $log, $filter)
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



    $scope.filters = { };

    $scope.menuItemTypes = [];

    $url = 'http://pos.mirageflow.com/itemtypes/list';
    var $callbackFunction = function(response){

        console.log("Itemtype list received inside response");

        $scope.menuItemTypes = response;





        $url = 'http://pos.mirageflow.com/items/liste';
        var $callbackFunction = function(response){

            console.log("Item list received inside response");

            $scope.menuItems = response;

            $scope.menuItemsExtended = [];

            for(var i = 0; i < $scope.menuItemTypes.length; i++){

                console.log($scope.menuItemTypes[i].type);

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

            console.log($scope.menuItemsExtended);

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



    $scope.noteSuggestions = ['Sans gluten', 'Ne pas faire', 'OPC'];

    $scope.addNote = function (note, item) {

        if(note != "" && note != undefined){
            if(typeof item != 'undefined' && item != null){
                item.notes.push({note: note});
            }
            else{
                if(typeof $scope.commandClient[$scope.bigCurrentPage].notes === 'undefined' || $scope.commandClient[$scope.bigCurrentPage].notes === null )
                    $scope.commandClient[$scope.bigCurrentPage].notes = [];

                $scope.commandClient[$scope.bigCurrentPage].notes.push({note: note})
            }

            $scope.dynamicPopover.note = '';
        }

        console.log(note);
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

    }



    $scope.addItem = function() {

        $scope.selectedItemForSize['quantity'] = 1;

        $scope.selectedItemForSize['notes'] = [];

        //Eventually selected size
        $scope.selectedItemForSize['size'] = angular.copy($scope.sizeProp.value);


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
            $scope.commandClient[$scope.bigCurrentPage] = [];

            if(typeof $scope.commandClient[$scope.bigCurrentPage].commandItems === 'undefined' || $scope.commandClient[$scope.bigCurrentPage].commandItems === null )
            $scope.commandClient[$scope.bigCurrentPage].commandItems = [];

            $scope.commandClient[$scope.bigCurrentPage].commandItems.push(angular.copy($scope.selectedItemForSize));
        }





        $scope.updateBill();
    };


    $scope.commandClient = [];

    $scope.updateBill = function(){

        var total = 0;

        if(typeof $scope.commandClient[$scope.bigCurrentPage] === 'undefined' || $scope.commandClient[$scope.bigCurrentPage] === null ){

            $scope.commandClient[$scope.bigCurrentPage] = [];
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


        var size_prices_array = unserialize(item['size_prices_array']);

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


        console.log($.grep(sizes, function(e){ return e.name == sizeSelected; })[0].name)

        $scope.sizeProp = {
            "name": size_name_array[0],
            price: size_prices_array[0],
            "value": $.grep(sizes, function(e){ return e.name == sizeSelected; })[0],
            "values": sizes
        };

        $scope.selectedItemForSize = item;



    };

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

    $scope.setPage = function (pageNo) {
        $scope.bigCurrentPage = pageNo;
    };

    $scope.pageChanged = function() {
        console.log('Page changed to: ' + $scope.bigCurrentPage);
        $scope.updateBill();
    };

    $scope.maxSize = 3;
    $scope.bigTotalItems = 175;
    $scope.bigCurrentPage = 1;


    $scope.commandClient[$scope.bigCurrentPage] = [];
    $scope.commandClient[$scope.bigCurrentPage].commandItems = [];


    $scope.currentTable = 22;
    $scope.currentEmploye = 2;

    $scope.dynamicPopover = {
        content: '',
        templateUrl: 'myPopoverTemplate.html',
        title: 'Notes sur la commande'
    };

/*
    $scope.dynamicPopoverItems = {
        content: '',
        templateUrl: 'myPopoverTemplate.html',
        title: 'Notes sur l\'item'
    };
*/

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




})


 /*   .controller('PaginationDemoCtrl', function ($scope, $log) {

    });
*/

