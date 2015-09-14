angular.module('beauty')
    .controller('ModalNewBookingCtrl', function ($scope, $modalInstance, Restangular, businessSlug) {
        Restangular.all('customers').getList().then(function (customers) {
            $scope.customers = customers;
        });

        Restangular.one('businesses', businessSlug).getList('employees').then(function (employees) {
            $scope.employees = employees;
        });

        Restangular.one('businesses', businessSlug).getList('services').then(function (services) {
            $scope.services = services;
        });

        $scope.hstep = 1;
        $scope.mstep = 5;

        $scope.changed = function () {
            $scope.booking.endTime = $scope.booking.startTime;
        };

        $scope.update = function (booking) {
            console.log("Updated settings ", booking);
            booking.startTime = new Date(booking.date.getFullYear(), booking.date.getMonth(), booking.date.getDate(),
                booking.startTime.getHours(), booking.startTime.getMinutes(), booking.startTime.getSeconds());
            booking.endTime = new Date(booking.date.getFullYear(), booking.date.getMonth(), booking.date.getDate(),
                booking.endTime.getHours(), booking.endTime.getMinutes(), booking.endTime.getSeconds());
            $modalInstance.close(booking);
        };
        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });