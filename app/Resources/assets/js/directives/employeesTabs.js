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
            },
            templateUrl: 'views/dashboard/employees-tabs.html'
        };
    });
