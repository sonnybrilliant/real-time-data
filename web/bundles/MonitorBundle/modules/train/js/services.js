'use strict'

angular.module('prasaMonitor.train.services',[]).factory('TrainService', function(){
    return {
        trainData: {
            id: 1,
            name: "PC16",
            type: "metro plus",
            statusName: "Active",
            statusCode: 1,
            conditionName: "critical",
            gpsSpeed: "0",
            latitude: "4269511929",
            longitude: "28114182",
            dateTime: ""
        },
        motorCoachData1: {
            name: null,
            gpsTime: null,
            latitude: null,
            longitude: null,
            evNo: null,
            lineVoltage: 0,
            maOutPutVoltage: null,
            speedo: 0,
            gpsSpeed: 0,
            brakeVacuum: 0,
            boggie1Current: null,
            boggie2Current: null,
            shaftEncoder1Speed: null,
            shaftEncoder2Speed: null,
            shaftEncoder3Speed: null,
            shaftEncoder4Speed: null,
            error: null,
            statusName: null,
            statusCode: null,
            conditionName: null
        },
        motorCoachData2: {
            name: null,
            gpsTime: null,
            latitude: null,
            longitude: null,
            evNo: null,
            lineVoltage: 0,
            maOutPutVoltage: null,
            speedo: 0,
            gpsSpeed: 0,
            brakeVacuum: 0,
            boggie1Current: null,
            boggie2Current: null,
            shaftEncoder1Speed: null,
            shaftEncoder2Speed: null,
            shaftEncoder3Speed: null,
            shaftEncoder4Speed: null,
            error: null,
            statusName: null,
            statusCode: null,
            conditionName: null
        },
        motorCoachData3: {
            name: null,
            gpsTime: null,
            latitude: null,
            longitude: null,
            evNo: null,
            lineVoltage: 0,
            maOutPutVoltage: null,
            speedo: 0,
            gpsSpeed: 0,
            brakeVacuum: 0,
            boggie1Current: null,
            boggie2Current: null,
            shaftEncoder1Speed: null,
            shaftEncoder2Speed: null,
            shaftEncoder3Speed: null,
            shaftEncoder4Speed: null,
            error: null,
            statusName: null,
            statusCode: null,
            conditionName: null
        }
    }
}).factory('socket', function(socketFactory){
    var myIoSocket = io.connect('local.mct:3000');

    var socket = socketFactory({
        ioSocket: myIoSocket
    });

    return socket;
});;