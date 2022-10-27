
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
        height: 350px;
       }
    </style>

</head>
<body>
    <div>
        <div class="row position-relative">
            <div class="col-11" ><canvas id="canvas"></canvas></div>
            <div class="col-1 position-absolute top-0 end-0" id="box">
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-secondary" id="points" style="width: 100%" type="button">Points</button>
                    <button class="btn btn-outline-success" id="trace" style="width: 100%" type="button">Trace</button>
                </div>
            </div>
        </div>
    </div>



    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){

            var btnPoints = document.getElementById("points");
            btnPoints.addEventListener("click",   fetchDataPoints);

            var btnTrace = document.getElementById("trace");
            btnTrace.addEventListener("click",   fetchDataTrace);


            const canvas=document.querySelector("#canvas");
            const ctx=canvas.getContext("2d");

            canvas.setAttribute("width", 1398.4251969);
            canvas.setAttribute("height", 642.51968504);

            document.body.appendChild(canvas);
            ctx.clearRect( 0, 0, ctx.canvas.width, ctx.canvas.height);

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
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){

                            var count=0;
                            var arrActualX=[];
                            var arrActualY=[];

                            $.each(response.data,function(key,item){

                                ++count;
                                var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                                var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                                var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                                var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                                var Actual_X_px=(96 * Actual_X_cm)/2.54;
                                var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                                var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                                var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                                setTimeout(function() {
                                    drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                                    drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'red', 4);
                                }, 2000);

                                AX=Actual_X_px;
                                AY=Actual_Y_px;
                                PX=Predicted_X_px;
                                PY=Predicted_Y_px;
                                // $('body').append('<h6>'+firstA+" ___________ "+secoundA+'</h6>')
                            });

                    }
                });
            }

            function fetchDataTrace(){
                $.ajax({
                    type:"GET",
                    url:"test-points",
                    dataType:"json",
                    success:function(response){
                            var count=0;
                            var arrActualX=[];
                            var arrActualY=[];
                            $.each(response.data,function(key,item){

                                ++count;
                                var Actual_X_cm=parseFloat(item.actual_x_distance)/100;
                                var Actual_Y_cm=parseFloat(item.actual_y_distance)/100;

                                var Predicted_X_cm=parseFloat(item.predicted_x_distance)/100;
                                var Predicted_Y_cm=parseFloat(item.predicted_y_distance)/100;

                                var Actual_X_px=(96 * Actual_X_cm)/2.54;
                                var Actual_Y_px=(96 * Actual_Y_cm)/2.54;

                                var Predicted_X_px=(96 * Predicted_X_cm)/2.54;
                                var Predicted_Y_px=(96 * Predicted_Y_cm)/2.54;

                                    if( count == 1){
                                        AX=Actual_X_px;
                                        AY=Actual_Y_px;

                                        PX=Predicted_X_px;
                                        PY=Predicted_Y_px;
                                    }else{
                                        ctx.beginPath();
                                        ctx.lineWidth = 5;
                                        ctx.strokeStyle = 'blue';
                                        ctx.moveTo(AX,AY);
                                        ctx.lineTo(Actual_X_px,Actual_Y_px);
                                        ctx.stroke();
                                        ctx.beginPath();
                                        ctx.lineWidth = 7;
                                        ctx.strokeStyle = 'red';
                                        ctx.moveTo(PX,PY);
                                        ctx.lineTo(Predicted_X_px,Predicted_Y_px);
                                        ctx.stroke();

                                    }

                                setTimeout(function() {
                                    drawPoint(ctx, Actual_X_px,Actual_Y_px, 'blue', 4);
                                    drawPoint(ctx, Predicted_X_px,Predicted_Y_px, 'red', 4);
                                }, 2000);

                                AX=Actual_X_px;
                                AY=Actual_Y_px;
                                PX=Predicted_X_px;
                                PY=Predicted_Y_px;
                                // $('body').append('<h6>'+firstA+" ___________ "+secoundA+'</h6>')
                            });
                    }
                });
            }
        });
    </script>

</body>
</html>


