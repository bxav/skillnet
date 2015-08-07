/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('EmployeesPlanningCtrl', function($scope, $modal, $log, Restangular) {


        $scope.open = function (size) {
            var modalInstance = $modal.open({
                animation: true,
                templateUrl: 'myModalContent.html',
                controller: 'ModalNewBookingCtrl',
                size: 'lg',
                resolve: {
                    businessSlug: function () {
                        return $scope.business.slug;
                    }
                }
            });

            modalInstance.result.then(function (rawBooking) {

                var newBooking = {
                    start_datetime: rawBooking.date.toISOString(),
                    end_datetime: rawBooking.date.toISOString(),
                    customer_username: rawBooking.customer.username,
                    employee_slug: rawBooking.employee.slug,
                    service_id: angular.isDefined(rawBooking.service) ? rawBooking.service.id : null
                };
                console.log(newBooking);
                Restangular.all('bookings').post(newBooking);

            }, function () {
                $log.info('Modal dismissed at: ' + new Date());
            });
        };
});
/* EOF */