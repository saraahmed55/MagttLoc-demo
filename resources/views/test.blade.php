
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/app.js"></script>
    <style>
        #canvas{
            background-image: url("img/layout_emp.png");
            background-size: 100% 100%;
        }
       #box{
        margin-top: 20px;
        box-shadow: 5px 10px 18px #888888;
        padding-top: 20px;
        padding-right: 25px;
        height: 650px;
        width: 200px;
       }
       .dotBlue {
        height: 22px;
        width: 22px;
        background-color: blue;
        border-radius: 50%;
        display: inline-block;
        }
        .dotGreen {
        height: 22px;
        width: 22px;
        background-color: green;
        border-radius: 50%;
        display: inline-block;
        }
        .slidecontainer {
        width: 100%;
        }

        .slider {
        -webkit-appearance: none;
        width: 100%;
        height: 15px;
        border-radius: 5px;
        background: #d3d3d3;
        outline: none;
        opacity: 0.7;
        -webkit-transition: .2s;
        transition: opacity .2s;
        }

        .slider:hover {
        opacity: 1;
        }

        .slider::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #04AA6D;
        cursor: pointer;
        }

        .slider::-moz-range-thumb {
        width: 25px;
        height: 25px;
        border-radius: 50%;
        background: #04AA6D;
        cursor: pointer;
        }
    </style>

</head>
<body>
    <div>
        <div class="row position-relative">

            <div id="alert" style="width:600px;margin-left:550px"></div>
            <div class="col-11" ><canvas id="canvas"></canvas></div>

            <div class="col-1 position-absolute top-0 end-0" id="box">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="trace1">
                    <label class="form-check-label" for="trace1">Trace 1</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="trace2">
                    <label class="form-check-label" for="trace2">Trace 2</label>
                </div>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rtt1">
                    <label class="form-check-label" for="rtt1">RTT Trace1</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="rtt2">
                    <label class="form-check-label" for="rtt2">RTT Trace2</label>
                </div>
                <hr>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="points">
                    <label class="form-check-label" for="points">Points</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="trace">
                    <label class="form-check-label" for="trace">Trace</label>
                </div>
                <button class="btn btn-outline-success"id="start" style="width: 100%;margin-top:20px;" type="button">Trajectory</button>
                <button class="btn btn-outline-primary"id="startAnimation" style="width: 100%;margin-top:20px;" type="button">RealTime Trail</button>
                <div class="slidecontainer" style="margin-top:10px">
                    <input type="range" min="1" max="25" value="10" class="slider" id="myRange">
                    <p>Speed Value: <span id="demo"></span></p>
                </div>
                <hr>
                <div style="margin-top:20px;">
                    <div><span class="dotBlue"></span><span style="padding-left: 7px">Real Points</span></div>
                    <div><span class="dotGreen"></span><span style="padding-left: 7px">Predicted </span></div>
                </div>
            </div>
        </div>
    </div>



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){

            var points=document.getElementById("points");
            var trace=document.getElementById("trace");
            var trace1=document.getElementById("trace1");
            var trace2=document.getElementById("trace2");
            var RTT1 = document.getElementById('rtt1');
            var RTT2 = document.getElementById('rtt2');


            var slider = document.getElementById("myRange");
            var output = document.getElementById("demo");
            output.innerHTML = slider.value;

            slider.oninput = function() {
            output.innerHTML = this.value;
            }

            var btnStart = document.getElementById("start");
            btnStart.addEventListener("click",   Start);

            var btnStartAnimation = document.getElementById("startAnimation");
            btnStartAnimation.addEventListener("click",   StartAnimation);

            const canvas=document.querySelector("#canvas");
            const ctx=canvas.getContext("2d");

            canvas.setAttribute("width", 1398.4251969);
            canvas.setAttribute("height", 642.51968504);

            document.body.appendChild(canvas);
            ctx.clearRect( 0, 0, ctx.canvas.width, ctx.canvas.height);

            function Start(){

                if(trace1.checked==true &&points.checked==true ){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataPoints();
                }
                else if(trace1.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTrace();
                }
                else if(trace2.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTrace2Points();
                }
                else if(trace2.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTrace2();
                }
                else if(rtt1.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT1Trace();
                }
                else if(rtt1.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT1Points();
                }
                else if(rtt2.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT2Trace();
                }
                else if(rtt2.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT2Points();
                }
                else{
                    var a='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>'
                    $('#alert').append('<div class="alert alert-warning text-center"id="success-alert">'+a+'Choose a checkbox '+'<button type="button" style="margin-left: 50%" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+'</div>')
                    $('div.alert').delay(1500).slideUp(300);
                }
            }

            function StartAnimation(){

                if(trace1.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTraceAnimation();
                }
                else if(trace2.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTrace2Animation();
                }
                else if(trace1.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTraceAnimationPoints();
                }
                else if(trace2.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchDataTrace2AnimationPoints();
                }
                else if(RTT1.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT1TraceAnimationPoints();
                }
                else if(RTT1.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT1TraceAnimation();
                }
                else if(RTT2.checked==true && points.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT2TraceAnimationPoints();
                }
                else if(RTT2.checked==true && trace.checked==true){
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                    fetchRTT2TraceAnimation();
                }
                else{
                    var a='<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:"><path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/></svg>'
                    $('#alert').append('<div class="alert alert-warning text-center"id="success-alert">'+a+'Choose a checkbox '+'<button type="button" style="margin-left: 50%" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'+'</div>')
                    $('div.alert').delay(1500).slideUp(300);

                }
            }


            function drawPoint(context, x, y, color, size) {

                if (color == null) {
                    color = '#000';
                }
                if (size == null) {
                    size = 5;
                }

                var pointX = x;
                var pointY =y;

                context.beginPath();
                context.fillStyle = color;
                context.arc(pointX, pointY, size, 0 * Math.PI, 2 * Math.PI);
                context.fill();
            }

            function fetchDataPoints(){
                const arrActualX=[];
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){

                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                            drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'green', 4);

                            AX=Actual_X_px;
                            AY=Actual_Y_px;
                            PX=Predicted_X_px;
                            PY=Predicted_Y_px;
                        });
                    }
                });

                var waypoints=[];
                for(var i=1;i<arrActualX.length;i++){
                    var pt0=arrActualX[i-1];
                    var pt1=vertices[i];
                    var dx=pt1.x-pt0.x;
                    var dy=pt1.y-pt0.y;
                    for(var j=0;j<100;j++){
                        var x=pt0.x+dx*j/100;
                        var y=pt0.y+dy*j/100;
                        waypoints.push({x:x,y:y});
                    }
                }
            }
            function fetchDataTrace2Points(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                            $.each(response.data,function(key,item){
                                console.log(item.actual_x_distance);
                                var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                                var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                                var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                                var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                                var Actual_X_px=(96 * Actual_X_cm)/2.54;
                                var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                                var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                                var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                                drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                                drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'green', 4);
                            });
                    }
                });
            }

            function fetchRTT1Points(){
                const arrRTTX=[];
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){

                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                            drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'green', 4);

                            AX=Actual_X_px;
                            AY=Actual_Y_px;
                            PX=Predicted_X_px;
                            PY=Predicted_Y_px;
                        });
                    }
                });

                var waypoints=[];
                for(var i=1;i<arrRTTX.length;i++){
                    var pt0=arrActualX[i-1];
                    var pt1=vertices[i];
                    var dx=pt1.x-pt0.x;
                    var dy=pt1.y-pt0.y;
                    for(var j=0;j<100;j++){
                        var x=pt0.x+dx*j/100;
                        var y=pt0.y+dy*j/100;
                        waypoints.push({x:x,y:y});
                    }
                }
            }

            function fetchRTT2Points(){
                const arrRTTX=[];
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){

                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                            drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'green', 4);

                            AX=Actual_X_px;
                            AY=Actual_Y_px;
                            PX=Predicted_X_px;
                            PY=Predicted_Y_px;
                        });
                    }
                });

                var waypoints=[];
                for(var i=1;i<arrRTTX.length;i++){
                    var pt0=arrActualX[i-1];
                    var pt1=vertices[i];
                    var dx=pt1.x-pt0.x;
                    var dy=pt1.y-pt0.y;
                    for(var j=0;j<100;j++){
                        var x=pt0.x+dx*j/100;
                        var y=pt0.y+dy*j/100;
                        waypoints.push({x:x,y:y});
                    }
                }
            }


            const RTT2TraceA=[];
            const RTT2TraceP=[]
            function fetchRTT2Trace(){
                var arrActualX=[];
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActualX.push({x:Actual_X_px,y:Actual_Y_px});

                            RTT2TraceA[count]={x:Actual_X_px,y:Actual_Y_px};
                            RTT2TraceP[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;

                        });
                    }
                });
                smothingfetchRTT2Trace();
            }
            function smothingfetchRTT2Trace(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<RTT2TraceA.length;i++){
                            var at0=RTT2TraceA[i-2];
                            var at1=RTT2TraceA[i-1];
                            var at2=RTT2TraceA[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=RTT2TraceP[i-2];
                            var pt1=RTT2TraceP[i-1];
                            var pt2=RTT2TraceP[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            RTT2TraceA[i-1]={x:ax,y:ay};
                            RTT2TraceP[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        for(var t=1;t<RTT2TraceA.length;t++){
                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'blue';
                            ctx.lineCap = "round";
                            ctx.moveTo(RTT2TraceA[t-1].x,RTT2TraceA[t-1].y);
                            ctx.lineTo(RTT2TraceA[t].x,RTT2TraceA[t].y);
                            ctx.stroke();

                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'green';
                            ctx.lineCap = "round";
                            ctx.moveTo(RTT2TraceP[t-1].x,RTT2TraceP[t-1].y);
                            ctx.lineTo(RTT2TraceP[t].x,RTT2TraceP[t].y);
                            ctx.stroke();
                        }
                    }
                });
            }


            const RTT1TraceA=[];
            const RTT1TraceP=[]
            function fetchRTT1Trace(){
                var arrActualX=[];
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActualX.push({x:Actual_X_px,y:Actual_Y_px});

                            RTT1TraceA[count]={x:Actual_X_px,y:Actual_Y_px};
                            RTT1TraceP[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;

                        });
                    }
                });
                smothingfetchRTT1Trace();
            }
            function smothingfetchRTT1Trace(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<RTT1TraceA.length;i++){
                            var at0=RTT1TraceA[i-2];
                            var at1=RTT1TraceA[i-1];
                            var at2=RTT1TraceA[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=RTT1TraceP[i-2];
                            var pt1=RTT1TraceP[i-1];
                            var pt2=RTT1TraceP[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            RTT1TraceA[i-1]={x:ax,y:ay};
                            RTT1TraceP[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        for(var t=1;t<RTT1TraceA.length;t++){
                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'blue';
                            ctx.lineCap = "round";
                            ctx.moveTo(RTT1TraceA[t-1].x,RTT1TraceA[t-1].y);
                            ctx.lineTo(RTT1TraceA[t].x,RTT1TraceA[t].y);
                            ctx.stroke();

                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'green';
                            ctx.lineCap = "round";
                            ctx.moveTo(RTT1TraceP[t-1].x,RTT1TraceP[t-1].y);
                            ctx.lineTo(RTT1TraceP[t].x,RTT1TraceP[t].y);
                            ctx.stroke();
                        }
                    }
                });
            }


            const dataTraceA=[];
            const dataTraceP=[]
            function fetchDataTrace(){
                var arrActualX=[];
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActualX.push({x:Actual_X_px,y:Actual_Y_px});

                            dataTraceA[count]={x:Actual_X_px,y:Actual_Y_px};
                            dataTraceP[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;

                            // setTimeout(function() {
                            //     drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 2);
                            //     drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'green', 2);
                            // }, 1000);

                        });
                    }
                });
                smothingfetchDataTrace();
            }
            function smothingfetchDataTrace(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<dataTraceA.length;i++){
                            var at0=dataTraceA[i-2];
                            var at1=dataTraceA[i-1];
                            var at2=dataTraceA[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=dataTraceP[i-2];
                            var pt1=dataTraceP[i-1];
                            var pt2=dataTraceP[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            dataTraceA[i-1]={x:ax,y:ay};
                            dataTraceP[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        for(var t=1;t<dataTraceA.length;t++){
                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'blue';
                            ctx.lineCap = "round";
                            ctx.moveTo(dataTraceA[t-1].x,dataTraceA[t-1].y);
                            ctx.lineTo(dataTraceA[t].x,dataTraceA[t].y);
                            ctx.stroke();

                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'green';
                            ctx.lineCap = "round";
                            ctx.moveTo(dataTraceP[t-1].x,dataTraceP[t-1].y);
                            ctx.lineTo(dataTraceP[t].x,dataTraceP[t].y);
                            ctx.stroke();
                        }
                    }
                });
            }



            const dataTrace2A=[];
            const dataTrace2P=[]
            function fetchDataTrace2(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            dataTrace2A[count]={x:Actual_X_px,y:Actual_Y_px};
                            dataTrace2P[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;

                        });
                    }
                });
                smothingfetchDataTrace2();
            }
            function smothingfetchDataTrace2(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<dataTrace2A.length;i++){
                            var at0=dataTrace2A[i-2];
                            var at1=dataTrace2A[i-1];
                            var at2=dataTrace2A[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=dataTrace2P[i-2];
                            var pt1=dataTrace2P[i-1];
                            var pt2=dataTrace2P[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            dataTrace2A[i-1]={x:ax,y:ay};
                            dataTrace2P[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        for(var t=1;t<dataTrace2A.length;t++){
                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'blue';
                            ctx.lineCap = "round";
                            ctx.moveTo(dataTrace2A[t-1].x,dataTrace2A[t-1].y);
                            ctx.lineTo(dataTrace2A[t].x,dataTrace2A[t].y);
                            ctx.stroke();

                            ctx.beginPath();
                            ctx.lineWidth = 3;
                            ctx.strokeStyle = 'green';
                            ctx.lineCap = "round";
                            ctx.moveTo(dataTrace2P[t-1].x,dataTrace2P[t-1].y);
                            ctx.lineTo(dataTrace2P[t].x,dataTrace2P[t].y);
                            ctx.stroke();
                        }
                    }
                });
            }


            const RTT1A=[];
            const RTT1P=[];
            function fetchRTT1TraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            RTT1A[count]={x:Actual_X_px,y:Actual_Y_px};
                            RTT1P[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingRTT1TraceAnimation();

            }
            function smothingRTT1TraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<RTT1A.length;i++){
                            var at0=RTT1A[i-2];
                            var at1=RTT1A[i-1];
                            var at2=RTT1A[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=RTT1P[i-2];
                            var pt1=RTT1P[i-1];
                            var pt2=RTT1P[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            RTT1A[i-1]={x:ax,y:ay};
                            RTT1P[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        animateRTT1Actual();
                        animateRTT1predicted();
                    }
                });
            }

            const RTT2A=[];
            const RTT2P=[];
            function fetchRTT2TraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            RTT2A[count]={x:Actual_X_px,y:Actual_Y_px};
                            RTT2P[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingRTT2TraceAnimation();

            }
            function smothingRTT2TraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<RTT2A.length;i++){
                            var at0=RTT2A[i-2];
                            var at1=RTT2A[i-1];
                            var at2=RTT2A[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=RTT2P[i-2];
                            var pt1=RTT2P[i-1];
                            var pt2=RTT2P[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            RTT2A[i-1]={x:ax,y:ay};
                            RTT2P[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        animateRTT2Actual();
                        animateRTT2predicted();
                    }
                });
            }


            const arrRTT1PointsA=[];
            const arrRTT1PointsP=[];
            function fetchRTT1TraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrRTT1PointsA[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrRTT1PointsP[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingfetchRTT1TraceAnimationPoints();
            }
            function smothingfetchRTT1TraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrRTT1PointsA.length;i++){
                            var at0=arrRTT1PointsA[i-2];
                            var at1=arrRTT1PointsA[i-1];
                            var at2=arrRTT1PointsA[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrRTT1PointsP[i-2];
                            var pt1=arrRTT1PointsP[i-1];
                            var pt2=arrRTT1PointsP[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrRTT1PointsA[i-1]={x:ax,y:ay};
                            arrRTT1PointsP[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        animateRTT1ActualPoint();
                        animateRTT1predictedPoint();
                    }
                });
            }


            const arrRTT2PointsA=[];
            const arrRTT2PointsP=[];
            function fetchRTT2TraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrRTT2PointsA[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrRTT2PointsP[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingfetchRTT2TraceAnimationPoints();
            }
            function smothingfetchRTT2TraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrRTT2PointsA.length;i++){
                            var at0=arrRTT2PointsA[i-2];
                            var at1=arrRTT2PointsA[i-1];
                            var at2=arrRTT2PointsA[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrRTT2PointsP[i-2];
                            var pt1=arrRTT2PointsP[i-1];
                            var pt2=arrRTT2PointsP[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrRTT2PointsA[i-1]={x:ax,y:ay};
                            arrRTT2PointsP[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        animateRTT2ActualPoint();
                        animateRTT2predictedPoint();
                    }
                });
            }



            const arrActualX=[];
            const arrPredicted=[];
            function fetchDataTraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActualX[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrPredicted[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingTraceAnimation();

            }
            function smothingTraceAnimation(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrActualX.length;i++){
                            var at0=arrActualX[i-2];
                            var at1=arrActualX[i-1];
                            var at2=arrActualX[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrPredicted[i-2];
                            var pt1=arrPredicted[i-1];
                            var pt2=arrPredicted[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrActualX[i-1]={x:ax,y:ay};
                            arrPredicted[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        animateActual();
                        animatepredicted();
                    }
                });
            }



            const arrActual2=[];
            const arrPredicted2=[];
            function fetchDataTrace2Animation(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActual2[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrPredicted2[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingfetchDataTrace2Animation();
            }
            function smothingfetchDataTrace2Animation(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrActual2.length;i++){
                            var at0=arrActual2[i-2];
                            var at1=arrActual2[i-1];
                            var at2=arrActual2[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrPredicted2[i-2];
                            var pt1=arrPredicted2[i-1];
                            var pt2=arrPredicted2[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrActual2[i-1]={x:ax,y:ay};
                            arrPredicted2[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        animateActual2();
                        animatepredicted2();
                    }
                });
            }


            const arrActualPoints=[];
            const arrPredictedPoints=[];
            function fetchDataTraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActualPoints[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrPredictedPoints[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingfetchDataTraceAnimationPoints();
            }
            function smothingfetchDataTraceAnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrActualPoints.length;i++){
                            var at0=arrActualPoints[i-2];
                            var at1=arrActualPoints[i-1];
                            var at2=arrActualPoints[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrPredictedPoints[i-2];
                            var pt1=arrPredictedPoints[i-1];
                            var pt2=arrPredictedPoints[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrActualPoints[i-1]={x:ax,y:ay};
                            arrPredictedPoints[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        animateActualPoint();
                        animatepredictedPoint();
                    }
                });
            }




            const arrActual2Points=[];
            const arrPredicted2Points=[];
            function fetchDataTrace2AnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var count=0;
                        $.each(response.data,function(key,item){

                            var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                            var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                            var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                            var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                            var Actual_X_px=(96 * Actual_X_cm)/2.54;
                            var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                            var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                            var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                            arrActual2Points[count]={x:Actual_X_px,y:Actual_Y_px};
                            arrPredicted2Points[count]={x:Predicted_X_px,y:Predicted_Y_px};
                            ++count;
                        });
                    }
                });
                smothingfetchDataTrace2AnimationPoints();
            }
            function smothingfetchDataTrace2AnimationPoints(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        for(var i=2;i<arrActual2Points.length;i++){
                            var at0=arrActual2Points[i-2];
                            var at1=arrActual2Points[i-1];
                            var at2=arrActual2Points[i];
                            var ax=(at0.x+at1.x+at2.x)/3;
                            var ay=(at0.y+at1.y+at2.y)/3;

                            var pt0=arrPredicted2Points[i-2];
                            var pt1=arrPredicted2Points[i-1];
                            var pt2=arrPredicted2Points[i];
                            var px=(pt0.x+pt1.x+pt2.x)/3;
                            var py=(pt0.y+pt1.y+pt2.y)/3;

                            arrActual2Points[i-1]={x:ax,y:ay};
                            arrPredicted2Points[i-1]={x:px,y:py};
                        }

                    }
                });
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        animateActual2Point();
                        animatepredicted2Point();
                    }
                });
            }




            function calcWaypoints(vertices){
                var waypoints=[];
                for(var i=1;i<vertices.length;i++){
                    var pt0=vertices[i-1];
                    var pt1=vertices[i];
                    var dx=pt1.x-pt0.x;
                    var dy=pt1.y-pt0.y;
                    console.log(slider.value)
                    var s=parseInt(slider.value)
                    for(var j=0;j<100;j+=s){
                        var x=pt0.x+dx*j/100;
                        var y=pt0.y+dy*j/100;
                        waypoints.push({x:x,y:y});
                    }
                }
                return(waypoints);
            }

            var t=1;
            function animateRTT1ActualPoint(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrRTT1PointsA);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT1ActualPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'blue', 4);
                        t++;
                     }
                });

            }
            var t=1;
            function animateRTT1predictedPoint(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrRTT1PointsP);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT1predictedPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'green', 4);
                        t++;
                     }
                });

            }

            var t=1;
            function animateRTT2ActualPoint(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrRTT2PointsA);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT2ActualPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'blue', 4);
                        t++;
                     }
                });

            }
            var t=1;
            function animateRTT2predictedPoint(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrRTT2PointsP);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT2predictedPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'green', 4);
                        t++;
                     }
                });

            }

            var t=1;
            function animateRTT1Actual(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(RTT1A);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT1Actual); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'blue';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });

            }
            var t=1
            function animateRTT1predicted(){
                $.ajax({
                    type:"GET",
                    url:"RTT",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(RTT1P);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT1predicted); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'green';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });
            }

            var t=1;
            function animateRTT2Actual(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(RTT2A);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT2Actual); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'blue';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });

            }
            var t=1
            function animateRTT2predicted(){
                $.ajax({
                    type:"GET",
                    url:"RTT2",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(RTT2P);
                        if(t<points.length-1){ requestAnimationFrame(animateRTT2predicted); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'green';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });
            }

            var t=1;
            function animateActual(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrActualX);
                        if(t<points.length-1){ requestAnimationFrame(animateActual); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'blue';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });

            }
            var t=1
            function animatepredicted(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrPredicted);
                        if(t<points.length-1){ requestAnimationFrame(animatepredicted); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'green';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });
            }
            var t=1;
            function animateActual2(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrActual2);
                        if(t<points.length-1){ requestAnimationFrame(animateActual2); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'blue';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });

            }
            var t=1
            function animatepredicted2(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrPredicted2);
                        if(t<points.length-1){ requestAnimationFrame(animatepredicted2); }
                        ctx.beginPath();
                        ctx.lineWidth = 3;
                        ctx.lineCap = "round";
                        ctx.strokeStyle = 'green';
                        ctx.moveTo(points[t-1].x,points[t-1].y);
                        ctx.lineTo(points[t].x,points[t].y);
                        ctx.stroke();
                        t++;
                     }
                });
            }

            var t=1;
            function animateActualPoint(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrActualPoints);
                        if(t<points.length-1){ requestAnimationFrame(animateActualPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'blue', 4);
                        t++;
                     }
                });

            }
            var t=1;
            function animatepredictedPoint(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrPredictedPoints);
                        if(t<points.length-1){ requestAnimationFrame(animatepredictedPoint); }
                        drawPoint(ctx, points[t].x,points[t].y, 'green', 4);
                        t++;
                     }
                });

            }

            var t=1;
            function animateActual2Point(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrActual2Points);
                        if(t<points.length-1){ requestAnimationFrame(animateActual2Point); }
                        drawPoint(ctx, points[t].x,points[t].y, 'blue', 4);
                        t++;
                     }
                });

            }
            var t=1
            function animatepredicted2Point(){
                $.ajax({
                    type:"GET",
                    url:"test-trace1",
                    dataType:"json",
                    success:function(response){
                        var points=calcWaypoints(arrPredicted2Points);
                        if(t<points.length-1){ requestAnimationFrame(animatepredicted2Point); }
                        drawPoint(ctx, points[t].x,points[t].y, 'green', 4);
                        t++;
                     }
                });
            }

        });
    </script>

</body>
</html>

