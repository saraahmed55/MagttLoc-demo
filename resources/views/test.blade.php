
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        #canvas{

            background-image: url("img/layout_emp.png");
            /* background-position: center; */
            background-size: 100% 100%;
        }
    </style>

</head>
<body>
<canvas id="canvas"></canvas>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            fetchData();
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

                // to increase smoothing for numbers with decimal part
                var pointX = x;
                var pointY =y;

                context.beginPath();
                context.fillStyle = color;
                context.arc(pointX, pointY, size, 0 * Math.PI, 2 * Math.PI);
                context.fill();
            }

            function fetchData(){
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
                                console.log(count)
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



                                // if(count==1){
                                //     s=Actual_X_px;
                                //     a=Actual_Y_px;
                                //     ctx.beginPath();
                                //     ctx.moveTo(s,a);
                                // }else if(count>1){
                                //     ctx.quadraticCurveTo(20,10,Actual_X_px,Actual_Y_px);
                                //     ctx.stroke();
                                // }

                                // $('body').append('<h6>'+firstA+" ___________ "+secoundA+'</h6>')
                            });
                    }
                });
            }
        });
    </script>

</body>
</html>


