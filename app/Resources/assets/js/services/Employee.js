'use strict';

angular.module('beauty')
    .factory('Employee', ['$resource', function EmployeeFactory($resource) {
        var Employee = $resource('/api/employees/:employeeId', {employeeId: '@id'});

        Employee.prototype.getBusiness = function () {
            return $resource(this._links.business.href);
        };

        return Employee;

    }]);