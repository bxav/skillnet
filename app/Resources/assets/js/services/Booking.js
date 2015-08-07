angular.module('beauty')
    .factory('BookingsService', function ($resource) {
        return $resource('/api/bookings/:bookingId', {bookingId:'@id'});
    });