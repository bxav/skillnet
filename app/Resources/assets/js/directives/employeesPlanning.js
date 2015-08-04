'use strict';

angular.module('beauty')
    .directive('employeesPlanning', function() {
        return {
            restrict: 'E',
            controller: 'EmployeesPlanningCtrl',
            templateUrl: 'views/dashboard/planning.html'
        };
    });
