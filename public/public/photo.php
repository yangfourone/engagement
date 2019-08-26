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

    </head>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/JavaScript" src="js/jquery-1.11.3.min.js"></script>
    <script type="text/JavaScript">
        let index;
        let total=12;

        function photoClick(no) {
            index = no;
            topFunction();
            document.getElementById('main-photo').src = 'pic/set/' + no + '.jpg';
            document.getElementById('main-card').style.display = 'block';
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function left() {
            if (index == 1) {
                photoClick(total);
            } else {
                photoClick(index-1);
            }
        }

        function right() {
            if (index == total) {
                photoClick(1);
            } else {
                photoClick(index+1);
            }
        }
    </script>

    <body>
    <!-- Navigation -->
    <?php require('header.php') ?>

    <!-- main photo -->
    <br>
    <div class="row" id="main-card" style="display: none;" align="center">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <div class="card">
                <div class="card-body" align="center">
                    <input class="main-photo-left-button" type="image" src="pic/left.png" id="left-button" onclick="left();">
                    <img class="main-photo" src="" id="main-photo">
                    <input class="main-photo-right-button" type="image" src="pic/right.png" id="right-button" onclick="right();">
                </div>
            </div>
        </div>
        <div class="col-lg-1"></div>
        <hr/>
    </div>

    <!-- photo set -->
    <section class="py-5">
        <div class="row photo-set-row">
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/1.jpg" onclick="photoClick(1)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/2.jpg" onclick="photoClick(2)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/3.jpg" onclick="photoClick(3)">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- photo -->
    <section class="py-5">
        <div class="row photo-set-row">
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/4.jpg" onclick="photoClick(4)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/5.jpg" onclick="photoClick(5)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/6.jpg" onclick="photoClick(6)">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- photo -->
    <section class="py-5">
        <div class="row photo-set-row">
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/7.jpg" onclick="photoClick(7)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/8.jpg" onclick="photoClick(8)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/9.jpg" onclick="photoClick(9)">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- photo set -->
    <section class="py-5">
        <div class="row photo-set-row">
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/10.jpg" onclick="photoClick(1)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/11.jpg" onclick="photoClick(2)">
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card" id="card">
                    <div class="card-body" align="left">
                        <input type="image" src="pic/set/12.jpg" onclick="photoClick(3)">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <?php require('footer.php') ?>

    </body>

</html>
