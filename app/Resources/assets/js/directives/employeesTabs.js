angular.module('beauty')
    .directive('employeesTabs', function() {
        return {
            restrict: 'E',
            controller: function ($scope, Restangular) {
                Restangular.one('businesses', $scope.business.slug).getList('employees').then(function (employees) {
                    $scope.employees = employees;
                });
            },
            templateUrl: 'views/dashboard/employees-tabs.html'
        };
    });
