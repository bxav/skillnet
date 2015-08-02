'use strict';

/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
  .controller('ParameterCtrl', function(business) {
      business.all().success(function(data) {
        console.log(data);
      })

  });
