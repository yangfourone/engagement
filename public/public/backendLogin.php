<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Allen & Sharon Backend</title>

        <!-- Bootstrap core CSS -->
        <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/full-width-pics.css" rel="stylesheet">

    </head>

    <script type="text/JavaScript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/JavaScript">
        function login() {
            $.ajax({
                type: 'POST',
                url: '../apiv1/admin/login',
                dataType: "json",
                data: {
                    account: $("#account").val(),
                    pwd: $("#password").val()
                },
                success: function(data) {
                    if(data=='loginSuccess'){
                        window.location = 'backend.php';
                    }
                    else{
                        alert('請確認帳號或密碼是否輸入正確！');
                    }
                },
                error: function(jqXHR) {
                    alert("發生錯誤: " + jqXHR.status);
                }
            })
        }
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
            <div class="container">
                <div class="card card-login mx-auto mt-3" style="width: 50%;">
                    <div class="card-header">後台登入</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="account">帳號</label>
                                <input class="form-control" id="account" type="text">
                            </div>
                            <div class="form-group">
                                <label for="password">密碼</label>
                                <input class="form-control" id="password" type="password">
                            </div>
                            <button class="button2" onclick="login()">登入</button>
                        </form>
                    </div>
            </div>
        </section>

        <!-- Bootstrap core JavaScript -->
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>