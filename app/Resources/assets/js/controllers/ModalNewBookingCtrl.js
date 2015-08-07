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
        $scope.mstep = 15;

        $scope.changed = function () {
            $scope.booking.endTime = $scope.booking.startTime;
        };

        $scope.update = function (booking) {
            console.log("Updated settings ", booking);

            $modalInstance.close(booking);
        };
        $scope.cancel = function () {
            $modalInstance.dismiss('cancel');
        };
    });