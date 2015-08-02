'use strict';

angular.module('beauty')
    .factory('business', ['$http', '$base64', function businessFactory($http, $base64) {
        return {
            all: function() {
                return $http({method: 'GET', url: '/api/businesses'});
            }
        };
    }]);