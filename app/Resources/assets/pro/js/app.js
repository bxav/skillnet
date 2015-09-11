/**
 * @ngdoc overview
 * @name yapp
 * @description
 * # yapp
 *
 * Main module of the application.
 */
angular
    .module('beauty', [
        'ui.router',
        'ngAnimate',
        'ui.calendar',
        'ui.bootstrap',
        'base64',
        'restangular'
    ])
    .config(function (RestangularProvider) {
        RestangularProvider.setBaseUrl('/api');

        // In this case we are mapping the id of each element to the _id field.
        // We also change the Restangular route.
        // The default value for parentResource remains the same.

        RestangularProvider.setRestangularFields({
            selfLink: '_links.self.href',
        });

    })
    .config(function ($stateProvider, $urlRouterProvider) {
        $urlRouterProvider.when('/dashboard', '/dashboard/planning');
        $urlRouterProvider.otherwise('/dashboard');

        $stateProvider
            .state('base', {
                abstract: true,
                url: '',
                templateUrl: 'views/base.html'
            })
            .state('login', {
                url: '/login',
                parent: 'base',
                templateUrl: 'views/login.html',
                controller: 'LoginCtrl'
            })
            .state('dashboard', {
                url: '/dashboard',
                parent: 'base',
                templateUrl: 'views/dashboard.html',
                controller: 'DashboardCtrl'
            })
            .state('compte', {
                url: '/compte',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/compte.html',
                controller: 'ParameterCtrl'
            })
            .state('planning', {
                url: '/planning',
                parent: 'dashboard',
                templateUrl: 'views/dashboard/employees-planning.html'
            });

    });
