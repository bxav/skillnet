/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('DashboardCtrl', function ($scope, $state, Restangular) {
        var current = Restangular.one('employees', 'current').get();
        current.then(function (employee) {
            $scope.employee = employee;
            $scope.business = employee._embedded.business;
        });
        $scope.$state = $state;


    });
