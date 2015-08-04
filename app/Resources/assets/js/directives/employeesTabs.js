'use strict';

angular.module('beauty')
    .directive('employeesTabs', function() {
        return {
            restrict: 'E',
            controller: function ($scope) {
                $scope.employees = ['Marie','John','Duff'];

                $scope.checkModel = $scope.employees;
                $scope.checkResults = [];

                $scope.$watchCollection('checkModel', function () {
                    $scope.checkResults = [];
                    angular.forEach($scope.checkModel, function (value) {
                        if (value) {
                            $scope.checkResults.push(value);
                        }
                    });
                });
            },
            templateUrl: 'views/dashboard/employees-tabs.html'
        };
    });
