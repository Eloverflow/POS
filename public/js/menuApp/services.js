angular.module('starter.services', [])
.factory('getReq', function ($http, $location) {
    return {
        send: function ($url, $callbackPath, $callbackFunction) {
            $http({
                method: "GET",
                crossDomain: true,
                url: $url
            }).success(function (response) {
                    console.log(response);

                    if ($callbackPath)
                        $location.path($callbackPath);

                    if ($callbackFunction)
                        $callbackFunction(response);

                })
                .error(function (data) {
                    console.log('Error: ' + response);
                });
        }
    }
})

/*Allow you to make a quick post request with callbackFunction*/
.factory('postReq', function ($http, $location) {

    return {
        send: function ($url, $data, $callbackPath, $callbackFunction) {
            $http({
                url: $url,
                method: "POST",
                data: $data
            }).success(function (data) {
                    /*console.log(data);*/

                    if ($callbackPath)
                        $location.path($callbackPath);

                    if ($callbackFunction)
                        $callbackFunction(data);

                })
                .error(function (data) {
                    console.log('Error: ' + data);
                });
        }
    }
})