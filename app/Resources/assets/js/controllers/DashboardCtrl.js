/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('DashboardCtrl', function ($scope, $state, $resource, Employee) {

        var currentUser = Employee.get({employeeId: "current"}, function (employee) {
            $scope.employee = employee;
            currentUser.getBusiness().get({}, function (business) {
                $scope.business = business;
            });
        });
        $scope.$state = $state;


    });
