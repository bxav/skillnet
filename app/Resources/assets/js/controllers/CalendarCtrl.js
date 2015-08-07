/**
 * @ngdoc function
 * @name yapp.controller:MainCtrl
 * @description
 * # MainCtrl
 * Controller of yapp
 */
angular.module('beauty')
    .controller('CalendarCtrl', function($scope,$compile, $modal, uiCalendarConfig, Restangular) {
        var date = new Date();
        var d = date.getDate();
        var m = date.getMonth();
        var y = date.getFullYear();
        var bookings;

        var events_b = [];


        Restangular.all('bookings').getList({employee: $scope.employee.slug}).then(function (bookings) {
            bookings.forEach(function(element, index, array) {
                events_b.push({
                    title: "Client: " + element._embedded.customer.username + "|| Pour:" + element._embedded.employee.firstname,
                    start: new Date(element.start_datetime),
                    end: new Date(element.end_datetime)
                });
            });
        });

        $scope.showEditVisitDialog = function (event) {
            var modalInstance = $modal.open({
                animation: true,
                templateUrl: 'views/addEditVisitDialog.html',
                controller: function () {

                },
                size: 'lg',
                resolve: {
                    title: function () {
                        return event.title;
                    }
                }
            });
        };
        /* config object */
        $scope.uiConfig = {
            calendar:{
                lang: 'fr',
                minTime: "06:00:00",
                maxTime: "19:00:00",
                slotDuration: "00:15:00",
                contentHeight: "auto",
                editable: false,
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
                events: events_b,
                eventClick: $scope.showEditVisitDialog
            }
        };
});
/* EOF */