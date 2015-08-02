'use strict';

/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
  .controller('DashboardCtrl', function($scope, $state, booking) {

    $scope.$state = $state;
      booking.all().success(function(data) {
        console.log(data);
      })

  });
