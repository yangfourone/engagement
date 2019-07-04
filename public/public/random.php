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
        .random-animation {
            width: 100px;
            height: 100px;
            background-color: red;
            position: relative;
            -webkit-animation-name: example; /* Safari 4.0 - 8.0 */
            -webkit-animation-duration: 4s; /* Safari 4.0 - 8.0 */
            -webkit-animation-iteration-count: 3; /* Safari 4.0 - 8.0 */
            animation-name: example;
            animation-duration: 1s;
            animation-iteration-count: 3;
        }

        /* Safari 4.0 - 8.0 */
        @-webkit-keyframes example {
            0%   {background-color:red; left:0px; top:0px;}
            25%  {background-color:yellow; left:450px; top:0px;}
            50%  {background-color:blue; left:450px; top:450px;}
            75%  {background-color:green; left:0px; top:450px;}
            100% {background-color:red; left:0px; top:0px;}
        }

        /* Standard syntax */
        @keyframes example {
            0%   {background-color:red; left:0px; top:0px;}
            25%  {background-color:yellow; left:450px; top:0px;}
            50%  {background-color:blue; left:450px; top:450px;}
            75%  {background-color:green; left:0px; top:450px;}
            100% {background-color:red; left:0px; top:0px;}
        }
    </style>

    <script type="text/JavaScript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/JavaScript">
        $(document).ready(function(){

            $.ajax({
                type: "GET",
                url: "../apiv1/guest/getbyrandom",
                dataType: "json",
                success: function(data) {
                    document.getElementById('theName').innerText = data.guestName;
                }
            })

            $("#play").click(function() {
                window.location = 'random.php';
            })
        });
    </script>

    <body>
    <!-- Navigation -->
    <?php require('header.php') ?>

    <!-- Button Section -->
    <section>
        <br><br>
        <div class="col-lg-12" align="center">
            <button class="button2" id="play" style="width: 30%;">抽獎</button>
        </div>
        <br><br>
    </section>
    <section>
        <div class="row">
            <div class="col-lg-4"></div>
            <div class="col-lg-4">
                <div class="random-animation"></div>
            </div>
            <div class="col-lg-4"></div>
        </div>
    </section>
    <section>
        <div class="col-lg-12" align="center">
            <br><br><br><br><br><br>
            <h1 id="theName"></h1>
        </div>
    </section>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>