'use strict';

angular.module('beauty')
    .factory('Booking', ['$resource', function BookingFactory($resource) {
        return $resource('/api/bookings/:bookingId', {bookingId:'@id'});
    }]);