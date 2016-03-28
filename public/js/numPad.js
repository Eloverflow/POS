/**
 * Created by isaelblais on 3/28/2016.
 */
var app = angular.module('myApp', [], function($interpolateProvider) {
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

.controller('myCtrl', function($scope, getReq, postReq) {
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
                alert("Punch");
                break;
            case 'ent':
                window.location.replace("menu");
                break;
            case 'pt':
                $scope.mainText = $scope.mainText + ".";
                break;
            default:
                $scope.mainText = $scope.mainText + $value;

        }

    }
});
