'use strict'

angular.module('prasaMonitor.train.controllers',[]).controller('TrainController',
    ['$scope','$timeout','$state','$interval','TrainService','trainCoaches','socket',function(
    $scope,$timeout,$state,$interval,TrainService,trainCoaches,socket){


        $scope.train = TrainService.trainData;
        $scope.motorCoachDataOne = TrainService.motorCoachData1;
        $scope.motorCoachDataTwo = TrainService.motorCoachData2;
        $scope.motorCoachDataThree = TrainService.motorCoachData3;
        $scope.MapLatitude  = -25.73;
        $scope.Markerlatitude  = 0;
        $scope.MapLongitude = 28.18;
        $scope.MarkerLongitude = 0;


        $scope.zoomlevel = 4;

        if(trainCoaches.length > 0)
        {
            $scope.motorCoachDataOne.name =  trainCoaches[0];
        }

        if(trainCoaches.length >= 1)
        {
            $scope.motorCoachDataTwo.name =  trainCoaches[1];
        }

        if(trainCoaches.length >= 2)
        {
            $scope.motorCoachDataThree.name =  trainCoaches[2];
        }


        $scope.trainSpeed = 0;
        $scope.upperLimit = 150;
        $scope.lowerLimit = 0;
        $scope.unit = "KM";
        $scope.precision = 0;
        $scope.showTrain = false;
        $scope.isIntervalTriggered = false;
        $scope.showExcellentTrain = false;
        $scope.isLoading = false;
        $scope.ranges = [
            {
                min: 0,
                max: 10,
                color: '#4a8bc2'
            },
            {
                min: 10,
                max: 60,
                color: '#01b218'
            },
            {
                min: 60,
                max: 80,
                color: '#01b218'
            },
            {
                min: 80,
                max: 95,
                color: '#FF7700'
            },
            {
                min: 95,
                max: 150,
                color: '#C50200'
            }
        ];

    var showLoading = function(){
        $scope.isLoading = true;
    }


    var hideLoading = function(){
        $scope.isLoading = false;
    }

    socket.on('connect', function(){
       console.log('connected');
    });

    socket.on('feed', function (data) {
        console.log('data received');
        getData(data.message);
    });



    function getData(data){
        $scope.showTrain = true;

        console.log(data.coachName);
        var totalSpeed = 0;

        var coachData = {
            name: data.coachName,
            gpsTime: new Date(data.gpsTime * 1000),
            latitude: data.lat,
            longitude: data.long,
            evNo: null,
            lineVoltage: data.lineVoltage,
            maOutPutVoltage: data.maOutPutVoltage,
            speedo: data.speedo,
            gpsSpeed: data.gpsSpeed,
            brakeVacuum: data.brakeVacuum,
            boggie1Current: data.boggie1Current,
            boggie2Current: data.boggie2Current,
            shaftEncoder1Speed: data.shaftEncoder1,
            shaftEncoder2Speed: data.shaftEncoder2,
            shaftEncoder3Speed: data.shaftEncoder3,
            shaftEncoder4Speed: data.shaftEncoder4,
            error: data.error,
            statusName: data.status,
            conditionName: data.condition
        };

        if(data.lat !== '' && data.long){
            $scope.MapLatitude  = data.lat;
            $scope.Markerlatitude  = data.lat;
            $scope.MapLongitude = data.long;
            $scope.MarkerLongitude = data.long;
            $scope.zoomlevel = 16;
        }

        totalSpeed = data.speedo;

        if($scope.motorCoachDataOne.name == data.coachName){
            $scope.motorCoachDataOne = coachData;
        }else if($scope.motorCoachDataTwo.name == data.coachName){
            $scope.motorCoachDataTwo = coachData;
        }else if($scope.motorCoachDataThree.name == data.coachName){
            $scope.motorCoachDataThree = coachData;
        }


        //
        if( $scope.motorCoachDataOne.conditionName === "good" &&
            $scope.motorCoachDataTwo.conditionName === "good" &&
            $scope.motorCoachDataThree.conditionName === "good"){
            $scope.showExcellentTrain = true;
        }else{
            $scope.showExcellentTrain = false;
        }


        $scope.trainSpeed = data.speedo;

        if(isNaN($scope.trainSpeed)){
            $scope.trainSpeed = 0;
        }

    }

   //$timeout(getData,1000);

   $scope.getMotorCoachConditionIconColor = function(condition){

        if($scope.showExcellentTrain){
            return 'primary';
        }else{
            if(condition === 'critical'){
                return 'danger';
            }else if(condition === 'warning'){
                return 'warning';
            }else if(condition === 'good'){
                return 'success';
            }
        }
    }


   $scope.getMotorCoachCondition = function(condition){
        if(condition === 'critical'){
            return 'red';
        }else if(condition === 'warning'){
            return 'yellow';
        }else if(condition === 'good'){
            return 'green';
        }
    };

    $scope.getStausClass = function(condition){
        if(condition === 'critical'){
            return 'danger';
        }else if(condition === 'warning'){
            return 'warning';
        }else if(condition === 'good'){
            return 'success';
        }else{
            return 'primary';
        }
    };

    $scope.isBoggieOkay = function(boggie1,boggie2){
        var difference = Math.abs(boggie1 - boggie2);
        if(difference > 5){
            return "NOT OK";
        }else{
            return "OK";
        }
    };

    $scope.getisBoggieOkayClass = function(boggie1,boggie2){
        var difference = Math.abs(boggie1 - boggie2);
        if(difference > 5){
            return "danger";
        }else{
            return "success";
        }
    };

   $scope.formatLineVoltage = function(lineVoltage){
       var voltage = 0;
       var oldVoltage = new String(lineVoltage);
       if(oldVoltage.length > 1){
           voltage = oldVoltage.charAt(0);
           voltage += "."+oldVoltage.substring(1,oldVoltage.length);

       }
       return voltage;
   };

   $scope.getIsLineVoltageClass = function(lineVoltage){

        var voltage = 0;
        var oldVoltage = new String(lineVoltage);
        if(oldVoltage.length > 1){
            voltage = oldVoltage.charAt(0);
            voltage += "."+oldVoltage.substring(1,oldVoltage.length);

        }

        if((parseFloat(voltage) >= 2.8 ) && (parseFloat(voltage) <= 3.8)){
            return "success";
        }else{
            return "danger";
        }
    };

   $scope.getIsMaOutputVoltageClass = function(lineVoltage){
        if((parseInt(lineVoltage) >= 0 ) && (parseInt(lineVoltage) <= 90)){
            return "danger";
        }else if((parseInt(lineVoltage) >= 91 ) && (parseInt(lineVoltage) <= 114)){
            return "success";
        }
    };

    $scope.getIsSpeedGood = function(speed){
        if((speed >= 0) && (speed <= 90)){
            return "success";
        }else if((speed >= 91) && (speed <= 95)){
            return "warning";
        }else if((speed > 96)){
            return "danger";
        }
    };



}]).controller('TrainNoDataController',['$scope',function($scope){

 }]);
