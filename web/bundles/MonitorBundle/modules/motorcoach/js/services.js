'use strict'

angular.module('prasaMonitor.motorcoach.services',[]).factory('MotorcoachService', function(){
    return {
        motorCoachData: {
            id: null,
            name: null,
            type: null,
            gpsDate: null,
            gpsTime: 0,
            latitude: 0,
            longitude: 0,
            evNo: 0,
            lineVoltage: 0,
            maOutPutVoltage: 0,
            speedo: 0,
            brakeVacuum: 0,
            boggie1Current: 0,
            boggie2Current: 0,
            shaftEncoder1Speed: 0,
            shaftEncoder2Speed: 0,
            shaftEncoder3Speed: 0,
            shaftEncoder4Speed: 0,
            error: null,
            statusName: null,
            statusCode: null,
            conditionName: null
        }
    }
}).factory('PayloadService', function($log,$http,$q,$timeout){
    var serverInstance = {};

    serverInstance.hasError = false;
    serverInstance.errorMessage = null;

    serverInstance.payload = {};

    serverInstance.getPayload = function(apiUrl){
        $log.info("connecting to restful api on "+apiUrl);
        var deferred = $q.defer();
        $http({
            method : 'GET',
            url : apiUrl

        }).success(function(response){
            if(response.statusCode !== 200){
                $log.error("OnError: response->1->"+response.statusText);
                serverInstance.hasError = true;
                serverInstance.errorMessage = response.statusText;
            } else {
                serverInstance.payload = response.data;
                deferred.resolve(response);
            }
        }).error(function(response){
            $log.error("OnError: response->2->"+response.statusText);
            serverInstance.hasError = true;
            serverInstance.errorMessage = response.statusText;
            deferred.reject();
        });
        $log.info("connection closed .....");
        return deferred.promise;
    };

    return serverInstance;
});;
