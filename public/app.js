var routerApp = angular.module('randomNumberApp', ['ui.router','ui.bootstrap','blockUI', 'ngSanitize','toastr','textAngular']);

routerApp.config(function ($stateProvider, $urlRouterProvider) {

    $urlRouterProvider.otherwise('/home');

    $stateProvider
        .state('home', {
            url: '/home',
            templateUrl: 'template/Content/partial-home.html'
        })
        .state('player', {
            url: '/player',
            templateUrl: 'template/Content/player-list.html'
        })
        .state('action-type', {
            url: '/action-type',
            templateUrl: 'template/Content/action-type-list.html'
        })
        .state('syntax', {
            url: '/syntax',
            templateUrl: 'template/Content/syntax-list.html'
        })
        .state('calculator', {
            url: '/calculator',
            templateUrl: 'template/Content/calculator.html'
        });
});