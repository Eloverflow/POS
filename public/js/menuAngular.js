var app = angular.module('menu', [], function($interpolateProvider) {
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

.controller('menuController', function($scope, getReq)
{
    var facture1 = [{
            id: 1,
            name: 'Alexander Keith',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1},
        {
            id: 2,
            name: 'Labatt Blue',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 3,
            name: 'Molsen Dry',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 4,
            name: 'Blue Ribbon',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        }];

    $scope.factureItems = [];


    $scope.delete2 = function (item) {
            $factureItem = $('#factureItem'+item.id);

            $factureItem.slideUp('slow', function(){
                $scope.factureItems.splice($scope.factureItems.indexOf(item), 1);
            });
    };

    $scope.delete = function(id){
        $factureItem = $('#factureItem'+id);

        $factureItem.slideUp('slow', function(){
            $factureItem.remove();
        })
    };

    $scope.increase = function(item){

        item.quantity = item.quantity+1

    };

    $scope.decrease = function(item){
        if(item.quantity  > 0){
            item.quantity = item.quantity-1
        }
    }

    var menu = [{
            id: 1,
            name: 'Alexander Keith',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1,
            size:[{
                name: 'Baril',
                price: 345.34
            },{
                name: 'Pichet',
                price: 15.18
            },{
                name: 'Pinte',
                price: 8.42
            }
        ]},
        {
            id: 2,
            name: 'Labatt Blue',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1,
            size:[{
                name: 'Baril',
                price: 345.34
            },{
                name: 'Pichet',
                price: 15.18
            },{
                name: 'Pinte',
                price: 8.42
            }
            ]
        },
        {
            id: 3,
            name: 'Molson Dry',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1,
            size:[{
                name: 'Baril',
                price: 345.34
            },{
                name: 'Pichet',
                price: 15.18
            },{
                name: 'Pinte',
                price: 8.42
            }
            ]
        },
        {
            id: 4,
            name: 'Blue Ribbon',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1,
            size:[{
                name: 'Baril',
                price: 345.34
            },{
                name: 'Pichet',
                price: 15.18
            },{
                name: 'Pinte',
                price: 8.42
            }
            ]
        },
        {
            id: 5,
            name: 'beer1',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1,
            size:[{
                name: 'big',
                price: 345
            },{
                name: 'normal',
                price: 125
            }
            ]
        },
        {
            id: 6,
            name: 'beer2',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 7,
            name: 'beer3',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 8,
            name: 'beer4',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 9,
            name: 'beer4',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 10,
            name: 'beer4',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 11,
            name: 'beer4',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        },
        {
            id: 12,
            name: 'beer4',
            description: "Some gems have hidden qualities beyond their luster, beyond their shine... Azurite is one of those gems.",
            quantity: 1
        }];

    $url = 'http://pos.mirageflow.com/items/liste';
    var $callbackFunction = function(response){


            $scope.menuItems = response;
    };

    getReq.send($url, null ,$callbackFunction);


/*
    $scope.menuItems = menu;*/

    Array.prototype.filterObjects = function(key, value) {
        return this.filter(function(x) { return x[key] === value; })
    };

    $scope.closeFoot = function(){
     /*   $('#footPanel').height(1);*/
        $('#footPanel').css('padding', '0');
        $('#footPanel').css('height', '0');
        $('#footPanel').css('border-width', '0');
    };

/*

    $scope.updateSize = function(size) {
        $scope.selectedSize = size
    }
*/
    /*$scope.selectSize = function(item) {
        $scope.selectedSize = item.size[0];
    };*/

    $scope.addItem = function() {

        $scope.selectedItemForSize['quantity'] = 1;

        //Eventually selected size
        $scope.selectedItemForSize['size'] = 1;

        $scope.factureItems.push($scope.selectedItemForSize);
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

        for (var i = 0, len = size_name_array.length; i < len; i++) {
            sizes.push(
                {
                    name: size_name_array[i],
                    price: size_prices_array[i]
                }
            )
        }

        item['size'] = sizes;

        $scope.selectedItemForSize = item;

        /*$scope.selectedSize = item.size[0];*/



        /*var result = $scope.factureItems.filterObjects("id", item.id);*/


     /*   if(result != "")
        {
            result[0].quantity = result[0].quantity +1;

            console.log(result);
        }
*/

/*
        var result = $.grep($scope.factureItems, function(e){ return e.id == item.id; });*/
/*
        $scope.factureItems.splice($scope.factureItems.indexOf(result), 1);*/
    }
});