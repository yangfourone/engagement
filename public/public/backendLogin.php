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
        <link href="css/myStyle.css" rel="stylesheet">

    </head>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/JavaScript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/JavaScript">
        $(document).ready(function(){
            $("#login").on('click', () => {
                $.ajax({
                    type: "POST",
                    url: "../apiv1/admin/login",
                    dataType: "json",
                    data: {
                        account: $("#account").val(),
                        pwd: $("#password").val()
                    },
                    success: function(data) {
                        if(data === "loginSuccess"){
                            window.location = 'backend.php';
                        } else{
                            alert('請確認帳號或密碼是否輸入正確！');
                        }
                    },
                    error: function() {
                        alert('請確認帳號或密碼是否輸入正確！');
                    }
                })
            })
        });
    </script>

    <style>
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
    </style>

    <body>

        <!-- Navigation -->
        <?php require('header.php') ?>

        <section class="py-5">
            <div class="card card-login mx-auto mt-3 backend-login-form">
                <div class="card-header">後台登入</div>
                <div class="card-body">
                    <label for="account">帳號</label>
                    <input class="form-control" id="account" type="text"><br>
                    <label for="password">密碼</label>
                    <input class="form-control" id="password" type="password"><br>
                    <button class="button2" id="login">登入</button>
                </div>
        </section>

        <!-- Footer -->
        <?php require('footer.php') ?>

    </body>

</html>
