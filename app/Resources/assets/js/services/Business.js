angular.module('beauty')
    .factory('Business', ['$resource', function BusinessFactory($resource) {
        var Business = $resource('/api/businesses/:businessId', {businessId:'@id'});

        Business.prototype.getEmployees = function () {
            return $resource('/api/businesses/'+this.slug+'/employees');
        };

        return Business;

    }]);