'use strict';

/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('CalendarCtrl', function($scope,$compile,uiCalendarConfig, Booking) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var bookings;

        var events_b = [];

        Booking.query({}, function(data){
            bookings = data;
            data.forEach(function(element, index, array) {
                events_b.push({
                    title: element.id,
                    start: new Date(element.start_datetime),
                    end: new Date(element.end_datetime)
                });
            });
        });

        /* config object */
        $scope.uiConfig = {
            calendar:{
                height: 450,
                editable: true,
                header:{
                    left: 'agendaWeek agendaDay',
                    center: 'title',
                    right: 'today prev,next'
                },
                firstDay: 1,
                businessHours: {
                    start: '8:00', // a start time (10am in this example)
                    end: '20:00', // an end time (6pm in this example)

                    dow: [ 1, 2, 3, 4, 5, 6 ]
                    // days of week. an array of zero-based day of week integers (0=Sunday)
                    // (Monday-Thursday in this example)
                },
                allDaySlot: false,
                defaultView: 'agendaDay',
                events: events_b
            }
        };
});
/* EOF */