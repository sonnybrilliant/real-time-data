
'use strict'

angular.module('prasaMonitor.motorcoach',['prasaMonitor.motorcoach.controllers','prasaMonitor.motorcoach.directives','prasaMonitor.motorcoach.services','prasaMonitor.motorcoach.filters']);

angular.module('prasaMonitor.motorcoach').config(['$stateProvider','$locationProvider',function($stateProvider,$locationProvider){
    $stateProvider.state('MotorcoachMonitor',{
        url:'/',
        templateUrl: g_templatePath,
        controller: 'MotorcoachController'
    });
}]);




