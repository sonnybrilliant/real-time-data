
'use strict'

angular.module('prasaMonitor.train',['prasaMonitor.train.controllers','prasaMonitor.train.directives','prasaMonitor.train.services','prasaMonitor.train.filters']);

angular.module('prasaMonitor.train').config(['$stateProvider','$locationProvider',function($stateProvider,$locationProvider){
    $stateProvider.state('trainMonitor',{
        url:'/',
        templateUrl: g_templatePath,
        controller: 'TrainController'
    }).state('trainNoDataMonitor',{
        url:'/no-train-data',
        templateUrl: g_templatePathNoData,
        controller: 'TrainNoDataController'
    });
}]);




