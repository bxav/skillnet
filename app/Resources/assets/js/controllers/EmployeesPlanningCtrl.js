/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('EmployeesPlanningCtrl', function($scope, $modal, $log) {
        $scope.open = function (size) {
            var modalInstance = $modal.open({
                animation: true,
                templateUrl: 'myModalContent.html',
                controller: 'ModalNewBookingCtrl',
                size: 'lg'
            });

            modalInstance.result.then(function (booking) {
                console.log(booking);

            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
});
/* EOF */