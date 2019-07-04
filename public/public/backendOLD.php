<?php
session_start();
if(empty($_SESSION['account'])){
    header("Location: backendLogin.php");
}
else{
}
?>
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

        <!--Import jQuery before export.js-->
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>

        <!--Data Table-->
        <script type="text/javascript"  src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="css/myStyle.css">
    </head>

    <!-- Bootstrap core JavaScript -->
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script type="text/JavaScript">

        let invitation_address;
        let invitation_selected;
        let meat_count;
        let vegetable_count;

        $(document).ready(function(){
            getGuestData();
            $("#NewGuest").click(function(){
                clear_add_table();
            })
            $("#guest_close").click(function(){
                $("#card").hide();
                $("#seat").hide();
            })
            $("#guest_save").click(function() {
                post_data('add');
            })
            $("#guest_update").click(function() {
                post_data('update');
            })
            $("#guest_delete").click(function() {
                if(confirm("確定要刪除嗎？")){
                    delete_data();
                }
            })
            $('#guestTable').on('click', 'tr', function(){
                var row = $(this).children('td:first-child').text();
                row==''? '':click_row(row);
            });
        });

        function displayTable() {
            if (document.getElementById('attend').value === '參加') {
                document.getElementById('attend-table').style.display = 'block';
            } else {
                document.getElementById('attend-table').style.display = 'none';
            }
        }

        function getGuestData() {
            $.ajax({
                type : "GET",
                url  : "../apiv1/guest/getall",
                dataType: "json",
                cache: false,
                success :  function(result) {
                    console.log(result);
                    LoadGuestDataToTable(result);
                },
                error: function(jqXHR) {
                    if(jqXHR.status=='601'){
                        $("#guestTable").hide();
                    }
                }
            });
        }

        function LoadGuestDataToTable(guestData) {
            let guestDataTable = $("#guestTable").DataTable();
            guestDataTable.clear().draw(false);
            for (let i in guestData){
                if (guestData[i].invitation === 'post') {
                    guestData[i].invitation = '郵寄';
                } else if (guestData[i].invitation === 'mail') {
                    guestData[i].invitation = 'E-mail';
                } else if (guestData[i].invitation === 'self') {
                    guestData[i].invitation = '另約';
                } else {
                    guestData[i].invitation = '不參加';
                }
                guestDataTable.row.add([
                    guestData[i].id,
                    guestData[i].guestName,
                    guestData[i].seat,
                    guestData[i].phoneNumber,
                    guestData[i].invitation,
                    guestData[i].attend,
                    guestData[i].eatMeat,
                    guestData[i].eatVege
                ]).draw(false);
            }
            guestDataTable.columns.adjust().draw();
        }

        function delete_data() {
            $.ajax({
                type: "POST",
                url: "../apiv1/guest/delete/" + $("#id").val(),
                dataType: "json",
                data: {
                },
                success: function() {
                    getGuestData();
                    $("#card").hide();
                    $("#seat").hide();
                },
                error: function(jqXHR) {
                    alert("發生錯誤: " + jqXHR.status + ' ' + jqXHR.statusText);
                }
            })
        }

        function post_data($action){

            get_meal();
            get_invitation();

            $.ajax({
                type: "POST",
                url: "../apiv1/guest/" + $action,
                dataType: "json",
                data: {
                    id: $("#id").val(),
                    guestName: $("#guestName").val(),
                    phoneNumber: $("#phoneNumber").val(),
                    seat: $("#seat").val(),
                    invitation: invitation_selected,
                    invitationAddress: invitation_address,
                    attend: $("#attend").val(),
                    eatMeat: meat_count,
                    eatVege: vegetable_count
                },
                success: function() {
                    getGuestData();
                    $("#card").hide();
                    $("#seat").hide();
                },
                error: function() {
                    $("#post_result").show();
                    $("#post_result").html('錯誤');
                }
            })
        }

        function click_row(row){
            topFunction();
            clear_add_table();
            $.ajax({
                type: "GET",
                url: "../apiv1/guest/getbyid/" + row,
                dataType: "json",
                data: {
                },
                success: function(data) {
                    document.getElementById('id').value = data.id;
                    document.getElementById('guestName').value = data.guestName;
                    document.getElementById('phoneNumber').value = data.phoneNumber;
                    document.getElementById('seat').value = data.seat;
                    if (data.invitation === 'post') {
                        // 郵寄
                        document.getElementById('attend-table').style.display = 'block';
                        document.getElementById('invitationAddress').value = data.invitationAddress;
                        document.getElementById('post').checked = true;
                        document.getElementById('mail').checked = false;
                        document.getElementById('self').checked = false;
                    } else if (data.invitation === 'mail') {
                        // E-mail
                        document.getElementById('attend-table').style.display = 'block';
                        document.getElementById('invitationEmail').value = data.invitationAddress;
                        document.getElementById('post').checked = false;
                        document.getElementById('mail').checked = true;
                        document.getElementById('self').checked = false;
                    } else if (data.invitation === 'self') {
                        // 當面
                        document.getElementById('attend-table').style.display = 'block';
                        document.getElementById('post').checked = false;
                        document.getElementById('mail').checked = false;
                        document.getElementById('self').checked = true;
                    } else {
                        // 不參加
                        document.getElementById('attend-table').style.display = 'none';
                        document.getElementById('post').checked = false;
                        document.getElementById('mail').checked = false;
                        document.getElementById('self').checked = false;
                    }
                    document.getElementById('attend').value = data.attend;

                    // check for eatMeat
                    if (data.eatMeat === '0') {
                        document.getElementById('checkbox_meat').checked = false;
                    } else {
                        document.getElementById('checkbox_meat').checked = true;
                        document.getElementById('eatMeat').value = data.eatMeat;
                    }
                    // check for eatVege
                    if (data.eatVege === '0') {
                        document.getElementById('checkbox_vege').checked = false;
                    } else {
                        document.getElementById('checkbox_vege').checked = true;
                        document.getElementById('eatVege').value = data.eatVege;
                    }
                },
                error: function(jqXHR) {
                    alert("發生錯誤: " + jqXHR.status + ' ' + jqXHR.statusText);
                }
            })
            $("#guest_delete").show();
            $("#guest_update").show();
            $("#guest_save").hide();
            $("#guest_close").show();
            $("#post_result").hide();
            $("#card").show();
            $("#seat").show();
        }

        function clear_add_table(){
            document.getElementById('id').value = '';
            document.getElementById('guestName').value = '';
            document.getElementById('phoneNumber').value = '';
            document.getElementById('seat').value = '';
            document.getElementById('invitationAddress').value = '';
            document.getElementById('invitationEmail').value = '';
            document.getElementById('attend').value = '';
            document.getElementById('eatMeat').value = '';
            document.getElementById('eatVege').value = '';
            document.getElementById('checkbox_vege').checked = false;
            document.getElementById('checkbox_meat').checked = false;
            document.getElementById('post').checked = false;
            document.getElementById('self').checked = false;
            document.getElementById('mail').checked = false;
            $("#guest_delete").hide();
            $("#guest_update").hide();
            $("#guest_save").show();
            $("#guest_close").show();
            $("#post_result").hide();
            $("#card").show();
            $("#seat").show();
        }

        function topFunction() {
            document.body.scrollTop = 0;
            document.documentElement.scrollTop = 0;
        }

        function get_invitation(){
            $("[name=invitation]:radio:checked").each(function(){
                invitation_selected = $(this).val();
                if (invitation_selected === 'post') {
                    // 郵寄
                    invitation_address = document.getElementById('invitationAddress').value;
                } else if (invitation_selected === 'mail') {
                    // E-mail
                    invitation_address = document.getElementById('invitationEmail').value;
                } else {
                    // 當面
                    invitation_address = '另約';
                }
            });
        }

        function get_meal(){
            if (document.getElementById('eatMeat').value === '0' && document.getElementById('eatVege').value === '0') {
                alert('請填寫葷素用餐人數！')
            } else {
                if (document.getElementById('checkbox_meat').checked === true) {
                    meat_count = document.getElementById('eatMeat').value;
                } else {
                    meat_count = 0;
                }
                if (document.getElementById('checkbox_vege').checked === true) {
                    vegetable_count = document.getElementById('eatVege').value;
                } else {
                    vegetable_count = 0;
                }
            }
        }
    </script>

    <body>

    <!-- Navigation -->
    <?php require('header.php') ?>

    <!-- Body -->
    <section>
        <div class="row top-area" style="margin: 3px;">
            <div class="col-lg-12">
                <br>
                <button class="button2" id="NewGuest">新增</button>
            </div>
            <div class="col-lg-4">
                <br>
                <div class="card" id="card" style="display: none;">
                    <div class="card-header">
                        <i class="fa fa-fw fa-child"></i>&nbsp;&nbsp;來賓詳細資料
                    </div>

                    <div class="card-body" align="left">
                        <label for="id">編號:</label>
                        <input type="text" id="id" disabled> <br>

                        <label for="guestName">您的大名</label>
                        <input type="text" id="guestName"> <br>

                        <label for="phoneNumber">聯絡電話</label>
                        <input type="text" id="phoneNumber"> <br>

                        <label for="attend">請問您是否方便參加?</label>
                        <select id="attend" onchange="displayTable()">
                            <option value="參加">一定到場祝福</option>
                            <option value="不參加">不方便參加</option>
                        </select> <br>

                        <div id="attend-table">

                            <label for="seat">座位:</label>
                            <input type="text" id="seat"> <br>

                            <label for="invitation">是否需親送喜帖並當面邀請?</label> <br>
                            <input name="invitation" type="radio" value="self" id="self"> 需要, 約一下時間 <br>

                            <input name="invitation" type="radio" value="post" id="post"> 不用, 郵寄紙本喜帖即可, 我記得時間會準時出席
                            <input type="text" id="invitationAddress" placeholder="聯絡地址"> <br>

                            <input name="invitation" type="radio" value="mail" id="mail"> 不用, 網路時代來臨, 用 e-mail 寄送即可, 我記得時間會準時出席
                            <input type="text" id="invitationEmail" placeholder="電子郵件信箱"> <br><br>

                            <label for="attendNumber">出席人數及餐食屬性</label><br>
                            <input id="checkbox_meat" type="checkbox" value="meat"> 葷食,&nbsp;&nbsp;
                            <select id="eatMeat"  style="width: 80%;">
                                <option value="0">0 位</option>
                                <option value="1">1 位</option>
                                <option value="2">2 位</option>
                                <option value="3">3 位</option>
                                <option value="4">4 位</option>
                                <option value="5">5 位</option>
                                <option value="6">6 位</option>
                                <option value="7">7 位</option>
                                <option value="8">8 位</option>
                                <option value="9">9 位</option>
                                <option value="10">10 位</option>
                            </select> <br>

                            <input id="checkbox_vege" type="checkbox" value="vege"> 素食,&nbsp;&nbsp;
                            <select id="eatVege" style="width: 80%;">
                                <option value="0">0 位</option>
                                <option value="1">1 位</option>
                                <option value="2">2 位</option>
                                <option value="3">3 位</option>
                                <option value="4">4 位</option>
                                <option value="5">5 位</option>
                                <option value="6">6 位</option>
                                <option value="7">7 位</option>
                                <option value="8">8 位</option>
                                <option value="9">9 位</option>
                                <option value="10">10 位</option>
                            </select> <br><br>
                        </div>
                    </div>

                    <div class="card-footer" align="right">
                        <text align="text-center" style="color:red" id="post_result"></text>&nbsp;&nbsp;&nbsp;
                        <button class="button2" id="guest_save">儲存</button>&nbsp;
                        <button class="button2" id="guest_delete" style="background-color: #ea0000;">刪除</button>&nbsp;
                        <button class="button2" id="guest_update" style="background-color: #0072e3;">更新</button>&nbsp;
                        <button class="button2" id="guest_close" style="background-color: #000000;">取消</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="table" style="width: 100%; margin: auto;">
                    <table id="guestTable" class="display" cellspacing="0" width="100%" >
                        <thead>
                        <tr>
                            <th>編號</th>
                            <th>名字</th>
                            <th>座位</th>
                            <th>電話</th>
                            <th>邀請函形式</th>
                            <th>是否參加</th>
                            <th>葷食人數</th>
                            <th>素食人數</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <br>
    </section>

    <section>
        <br>
        <div class="seat" id="seat" style="width: 90%; height: 90%; margin: auto;">
            <br><br>
            <img src="pic/seat.jpg">
        </div>

        <br>
    </section>

    <!-- Footer -->
    <?php require('footer.php') ?>

    </body>

</html>

