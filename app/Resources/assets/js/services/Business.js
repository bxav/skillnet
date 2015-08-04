'use strict';

angular.module('beauty')
    .factory('Business', ['$resource', function BusinessFactory($resource) {
        return $resource('/api/businesses/:businessId', {businessId:'@id'});
    }]);