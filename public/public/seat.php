<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Allen & Sharon</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/full-width-pics.css" rel="stylesheet">

    </head>

    <style>
        input[type=text], select {
            width: 100%;
            height: 40px;
            padding: 8px 14px;
            margin: 4px 0;
            display: inline-block;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        img {
            width: 100%;
            height: auto;
        }
    </style>

    <script type="text/JavaScript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/JavaScript">
        $(document).ready(function(){
            $("#submit").click(function() {
                $.ajax({
                    type: "GET",
                    url: "../apiv1/guest/getbyuser",
                    dataType: "json",
                    data: {
                        guestName: $("#guestName").val()
                    },
                    success: function(data) {
                        console.log(data);
                        alert(data.guestName + '的座位在 ' + data.seat + ' 桌, 電話: ' + data.phoneNumber);
                    },
                    error: function() {
                        alert("查無資料！請確認姓名是否輸入正確！");
                    }
                })
            })
        });
    </script>

    <body>
        <!-- Navigation -->
        <?php require('header.php') ?>

        <!-- Search Sheet -->
        <section>
            <div class="row" style="margin: 5px;">
                <div class="col-lg-4">
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-fw fa-child"></i>座位查詢
                        </div>
                        <div class="card-body">
                            <label for="guestName">姓名:</label>
                            <input type="text" id="guestName"> <br><br>

                            <button class="button2" id="submit">查詢</button>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" align="center">
                    <img src="pic/howToGo.JPG" style="width: 90%; height: auto;">
                </div>
                <br><br>
            </div>
        </section>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>