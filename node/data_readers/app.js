'use strict';


var csv = require("fast-csv");
var request = require('request');


csv.fromPath("jhb_5M13226.csv").on("data", function(data){

    var str = "";
    var tmp = data[4].split(' ');

    str += data[2]+","; //coachName
    str += data[7]+","; //line Voltage
    str += "2015/11/14 13:52:50,"; //gps time date
    str += data[5]+","; //gps speed
    str += tmp[0]+","; //lat
    str += tmp[1]+","; //long
    str += data[11]+",";//Boogie 1 Current
    str += data[12]+","; //Boogie 2 Current
    str += data[10]+","; //Brake Valve
    str += data[8]+","; //Supply 100
    str += data[9]+","; //Speedo
    str += data[13]+","; //shaftEncode 1
    str += data[14]+","; //shaftEncode 2
    str += data[15]+","; //shaftEncode 3
    str += data[16]+","; //shaftEncode 4

    post(str);

    }).on("end", function(){
        console.log("done");
    });

function post(str)
{
    request.post(
        "http://10.0.0.147/proxy/web/app.php?val="+encodeURIComponent(str),
        { form: { val: str } },
        function (error, response, body) {
            if (!error && response.statusCode == 200) {
                console.log(body)
            }
        }
    );
}