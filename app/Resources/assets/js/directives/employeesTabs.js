angular.module('beauty')
    .directive('employeesTabs', function() {
        return {
            restrict: 'E',
            controller: function ($scope, Business) {
                var currentBusiness = Business.get({businessId: $scope.business.slug}, function (business) {
                    currentBusiness.getEmployees().query(null, function (employees) {
                        $scope.employees = employees;
                    });
                });

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
