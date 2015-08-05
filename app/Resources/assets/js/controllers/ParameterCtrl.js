/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
  .controller('ParameterCtrl', function($scope, Business) {
      Business.get({businessId:"haircut-master"}, function(business){
          $scope.name = business.name;
      });
  });
