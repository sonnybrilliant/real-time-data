'use strict'

angular.module('prasaMonitor',[
    'ui.router',
    'ngJustGage',
    'btford.socket-io',
    'ngRadialGauge',
    'prasaMonitor.train',
    'prasaMonitor.controllers',
    'prasaMonitor.directives',
    'prasaMonitor.filters',
    'prasaMonitor.services'
]);

angular.module('prasaMonitor').value('version','V1.0');
angular.module('prasaMonitor').value('trainCoaches', g_motorCoaches);

angular.module('prasaMonitor').run(['$state',function($state){
    $state.go('trainMonitor');
}]);