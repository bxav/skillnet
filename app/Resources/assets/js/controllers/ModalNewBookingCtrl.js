angular.module('beauty')
    .controller('ModalNewBookingCtrl', function ($scope, $modalInstance, Booking) {
        $scope.customers = ["John", "Bob"];
        $scope.services = ["John", "Bob"];

        $scope.hstep = 1;
        $scope.mstep = 15;

        $scope.changed = function () {
            $scope.booking.endTime = $scope.booking.startTime;
        };

        $scope.update = function (booking) {
            console.log("Updated settings ", booking);

            var retBook = new Booking($scope.booking.employee, $scope.booking.customer, $scope.booking.service, $scope.booking.startTime, $scope.booking.endTime);
            $modalInstance.close(retBook);
        };
        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });