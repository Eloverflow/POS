var app = angular.module('menu', ['ui.bootstrap'], function($interpolateProvider) {
    $interpolateProvider.startSymbol('<%');
    $interpolateProvider.endSymbol('%>');

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

                $scope.menuItemsExtended[i].sizes = size_name_array_now;

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


    $scope.addItem = function() {

        $scope.selectedItemForSize['quantity'] = 1;

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


    $scope.selectedItem = function(item) {


        $('#footPanel').css('padding', '20');
        $('#footPanel').css('height', '300');
        $('#footPanel').css('border-width', '8');
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


        $scope.sizeProp = {
            "name": size_name_array[0],
            price: size_prices_array[0],
            "value": sizes[0],
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






    $scope.dynamicPopover = {
        content: 'Hello, World!',
        templateUrl: 'myPopoverTemplate.html',
        note: ''
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




})

 /*   .controller('PaginationDemoCtrl', function ($scope, $log) {

    });
*/