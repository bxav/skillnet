'use strict';

angular.module('beauty')
    .factory('booking', ['$http', '$base64', function bookingFactory($http, $base64) {
        return {
            all: function() {
                return $http({method: 'GET', url: '/api/bookings'});
            }
        };
    }]);