
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<body>

    <h1>ijfijeri</h1>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
                $(document).ready(function(){
                    fetchData();
                    function fetchData()
                    {
                        $.ajax({
                            type:"GET",
                            url:"test-points",
                            dataType:"json",
                            success:function(response){
                                console.log(response.data)
                                $.each(response.data,function(key,item){
                                    $('body').append('<h6>'+parseFloat(item.actual_x_distance)/100+'</h6>')
                                });
                            }
                        });
                    }
                })
    </script>

</body>
</html>







{{-- <script type="text/javascript">
   const txt = '<?php echo $data;?>'
   console.log(txt);
//    const obj = JSON.parse(txt);
    // var XMLHttpRequest = require('xhr2');
    // var req=new XMLHTTpRequest();
    // req.open("GET","/test-points",true)
    // req.send();

    // req.onreadystatechange=function(){
    //     if(req.readyState==4&&req.status==200){
    //         var obj=JSON.parse(req.responseText);
    //         console.log(obj);
    //     }
    // };
</script> --}}
