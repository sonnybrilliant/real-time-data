'use strict'

angular.module('prasaMonitor.motorcoach.controllers',[]).controller('MotorcoachController',
    ['$scope','$timeout','$interval','MotorcoachService','PayloadService','apiUrl',function(
    $scope,$timeout,$interval,MotorcoachService,PayloadService,apiUrl){

        $scope.trainSpeed = 0;
        $scope.upperLimit = 150;
        $scope.lowerLimit = 0;
        $scope.unit = "KM";
        $scope.precision = 0;
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


    $scope.train = MotorcoachService.trainData;
    $scope.motorCoach = MotorcoachService.motorCoachData;

    var payload = null;

    function getData(){
        $scope.loadingMotorCoach = true;
        PayloadService.getPayload(apiUrl).then(function(jsonResponse) {

                if (jsonResponse.statusCode !== 200) {
                    $scope.error = true;
                    $scope.errorMessage = jsonResponse.statusText;
                    console.error($scope.errorMessage);
                } else {
                    PayloadService.payload = jsonResponse.data;
                    payload = PayloadService.payload;

                    $scope.motorCoach = payload.motorCoach;

                    $scope.trainSpeed = $scope.motorCoach.speedo;
                }
                $scope.loadingMotorCoach = false;
            }, function() {
                $scope.error = true;
                $scope.errorMessage = "The service is not available. Please try again later.";
                $scope.loadingTrain = false;
            });
    }

   $timeout(getData,1000);

   $interval(getData,5000);

   $scope.getMotorCoachCondition = function(condition){
        if(condition === 'critical'){
            return 'red';
        }else if(condition === 'warning'){
            return 'yellow';
        }else if(condition === 'good'){
            return 'green';
        }
    };


}]);
