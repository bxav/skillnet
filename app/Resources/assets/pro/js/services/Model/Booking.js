angular.module('beauty')
    .factory('Booking', function () {


        function Booking(employee, customer, service, startDatetime, endDatetime) {
            this.employee = employee;
            this.customer = customer;
            this.service = service;
            this.startDate = startDatetime;
            this.endDatetime = endDatetime;
            console.log('Booking instantiated');
        };

        return Booking;
    });