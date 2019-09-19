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
        <link rel="stylesheet" href="css/myStyle.css">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

    </head>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
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
                        let message = '';
                        for (let i in data){
                            message = message.concat('\n' + data[i].guestName+ ', 電話: ' + data[i].phoneNumber) + '\n您的座位在 ' + data[i].seat;
                        }
                        alert(message);
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
        <section class="py-2">
            <div class="row py-3 px-2">
                <div class="col-lg-4">
                    <br>
                    <div class="card">
                        <div class="card-header">
                            <i class="fa fa-question-circle"></i>&nbsp;&nbsp;座位查詢
                        </div>
                        <div class="card-body">
                            <label class="search-seat-name" for="guestName">姓名: </label>
                            <input class="search-seat-name-input" type="text" id="guestName"><br><br>
                            <button class="search-seat-button" id="submit">查詢</button>
                        </div>
                        <div class="card-footer">
                            <p>對於這個網站有興趣的人</p>
                            <p>可以到 Menu 的「開發人員」了解喔！</p>
                            <a href="introduction.php">點我連結到開發人員介紹</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8" align="center">
                    <img src="pic/seat.jpg" style="width: 90%; height: auto;">
                </div>
                <br><br>
            </div>
        </section>
        <br><br>
        <!-- Footer -->
        <?php require('footer.php') ?>

    </body>

</html>