/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
  .controller('ParameterCtrl', function($scope, Restangular) {

        Restangular.one('businesses', $scope.business.slug).get().then(function (business) {
            $scope.name = business.name;
        });
  });
