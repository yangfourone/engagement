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
        <script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>

        <!--Data Table Responsive-->
        <script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">

        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
        <link rel="stylesheet" href="css/myStyle.css">
        <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.7.0/css/all.css' integrity='sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ' crossorigin='anonymous'>

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
            getQuantity();

            $('#guestTable').DataTable({
                "responsive": true,
                "paging":   false,
                "ordering": true,
                "info":     true,
                "filter":   true,
                "columnDefs": [
                    {"className": "dt-center", "targets": "_all"}
                ]
            });

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
                    LoadGuestDataToTable(result);
                },
                error: function(jqXHR) {
                    if(jqXHR.status=='601'){
                        $("#guestTable").hide();
                    }
                }
            });
        }

        function getQuantity() {
            $.ajax({
                type : "GET",
                url  : "../apiv1/guest/getbyquantity",
                dataType: "json",
                cache: false,
                success :  function(result) {
                    console.log(result[0]['SUM(eatMeat)']);
                    console.log(result[1]['SUM(eatVege)']);
                    document.getElementById('meat_count').innerText = result[0]['SUM(eatMeat)'];
                    document.getElementById('vege_count').innerText = result[1]['SUM(eatVege)'];
                }
            });
        }

        function LoadGuestDataToTable(guestData) {
            let guestDataTable = $("#guestTable").DataTable();
            guestDataTable.clear().draw(false);
            for (let i in guestData){
                if (guestData[i].invitation === 'none') {
                    guestData[i].invitation = '不用';
                } else if (guestData[i].invitation === 'self') {
                    guestData[i].invitation = '另約';
                } else {
                    guestData[i].invitation = '不用';
                }
                guestDataTable.row.add([
                    guestData[i].id,
                    guestData[i].guestName,
                    guestData[i].seat,
                    guestData[i].phoneNumber,
                    guestData[i].invitation,
                    guestData[i].attend,
                    guestData[i].eatMeat,
                    guestData[i].eatVege,
                    guestData[i].comment
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
                    getQuantity();
                    $("#card").hide();
                    $("#seat").hide();
                },
                error: function(jqXHR) {
                    alert("發生錯誤: " + jqXHR.status + ' ' + jqXHR.statusText);
                }
            })
        }

        function post_data($action){
            if (document.getElementById('attend').value === '參加') {

                get_invitation();
                get_meal($action);

            } else {
                $.ajax({
                    type: "POST",
                    url: "../apiv1/guest/" + $action,
                    dataType: "json",
                    data: {
                        id: $("#id").val(),
                        guestName: $("#guestName").val(),
                        phoneNumber: $("#phoneNumber").val(),
                        seat: "---",
                        invitation: "---",
                        invitationAddress: "---",
                        attend: "不參加",
                        eatMeat: "---",
                        eatVege: "---",
                        comment: "",
                    },
                    success: function() {
                        getGuestData();
                        getQuantity();
                        $("#card").hide();
                        $("#seat").hide();
                    },
                    error: function() {
                        alert('請確認資料是否成功填妥')
                    }
                })
            }
        }

        function click_row(row){
            if (document.documentElement.clientWidth > 992) {
                topFunction();
            }
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
                    document.getElementById('comment').value = data.comment;

                    if (data.attend === '參加') {
                        document.getElementById('attend-table').style.display = 'block';
                    } else {
                        document.getElementById('attend-table').style.display = 'none';
                    }

                    if (data.invitation === 'none') {
                        // 不用
                        document.getElementById('none').checked = true;
                        document.getElementById('self').checked = false;
                    } else if (data.invitation === 'self') {
                        // 當面
                        document.getElementById('none').checked = false;
                        document.getElementById('self').checked = true;
                    } else {
                        // 不參加
                        document.getElementById('none').checked = false;
                        document.getElementById('self').checked = false;
                    }
                    document.getElementById('attend').value = data.attend;

                    // check for eatMeat
                    document.getElementById('eatMeat').value = data.eatMeat;

                    // check for eatVege
                    document.getElementById('eatVege').value = data.eatVege;
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
            document.getElementById('attend').value = '參加';
            document.getElementById('eatMeat').value = '0';
            document.getElementById('eatVege').value = '0';
            document.getElementById('comment').value = '';
            document.getElementById('none').checked = false;
            document.getElementById('self').checked = false;
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
                if (invitation_selected === 'none') {
                    // 不用
                    invitation_address = '不用';
                } else {
                    // 當面
                    invitation_address = '另約';
                }
            });
        }

        function get_meal($action){
            if (document.getElementById('eatMeat').value === '0' && document.getElementById('eatVege').value === '0') {
                alert('請填寫葷素用餐人數！')
            } else {
                meat_count = document.getElementById('eatMeat').value;
                vegetable_count = document.getElementById('eatVege').value;

                if ($action === 'update') {
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
                            eatVege: vegetable_count,
                            comment: $("#comment").val()
                        },
                        success: function() {
                            getGuestData();
                            getQuantity();
                            $("#card").hide();
                            $("#seat").hide();
                        },
                        error: function() {
                            $("#post_result").show();
                            $("#post_result").html('錯誤');
                        }
                    })
                } else if ($action === 'add') {
                    $.ajax({
                        type: "POST",
                        url: "../apiv1/guest/" + $action,
                        dataType: "json",
                        data: {
                            id: $("#id").val(),
                            guestName: $("#guestName").val(),
                            phoneNumber: $("#phoneNumber").val(),
                            seat: "尚未安排",
                            invitation: invitation_selected,
                            invitationAddress: invitation_address,
                            attend: $("#attend").val(),
                            eatMeat: meat_count,
                            eatVege: vegetable_count,
                            comment: $("#comment").val()
                        },
                        success: function() {
                            getGuestData();
                            getQuantity();
                            $("#card").hide();
                            $("#seat").hide();
                        },
                        error: function() {
                            $("#post_result").show();
                            $("#post_result").html('錯誤');
                        }
                    })
                }
                topFunction();
            }
        }
    </script>

    <body>

        <!-- Navigation -->
        <?php require('header.php') ?>

        <!-- Body -->
        <section>
            <div class="row top-area">
                <div class="col-md-5 col-lg-3">
                    <div class="w-100" align="center">
                        <button type="button" class="btn btn-danger">葷食: <span class="badge" id="meat_count"></span></button>
                        <button type="button" class="btn btn-success">素食: <span class="badge" id="vege_count"></span></button>
                    </div>
                    <br>
                    <button class="backend-form-button btn-secondary" id="NewGuest" style="width: 100%">新增</button>
                    <br><br>
                    <div class="card" id="card" style="display: none;">
                        <div class="card-header">
                            <i class="fa fa-fw fa-child"></i>&nbsp;&nbsp;來賓詳細資料
                        </div>

                        <div class="card-body" align="left">
                            <label class="backend-form-title" for="id">編號:</label>
                            <input class="backend-form-input" type="text" id="id" disabled> <br>

                            <label class="backend-form-title" for="guestName">您的大名</label>
                            <input class="backend-form-input" type="text" id="guestName"> <br>

                            <label class="backend-form-title" for="phoneNumber">聯絡電話</label>
                            <input class="backend-form-input" type="text" id="phoneNumber"> <br>

                            <label class="backend-form-title" for="attend">請問您是否方便參加?</label>
                            <select id="attend" onchange="displayTable()">
                                <option value="參加">一定到場祝福</option>
                                <option value="不參加">不方便參加</option>
                            </select> <br>

                            <div id="attend-table">

                                <label class="backend-form-title" for="seat">座位:</label>
                                <input class="backend-form-input" type="text" id="seat"><br><br>

                                <label class="backend-form-title" for="invitation">是否需親送喜帖並當面邀請?</label> <br>
                                <input name="invitation" type="radio" value="self" id="self"> 需要, 約一下時間<br>
                                <input name="invitation" type="radio" value="none" id="none"> 不用, 我記得時間會準時出席<br><br>

                                <label class="backend-form-title" for="attendNumber">出席人數及餐食屬性</label><br>
                                葷食:&nbsp;
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
                                </select><br>

                                素食:&nbsp;
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
                                </select><br><br>
                            </div>

                            <label class="backend-form-title" for="comment">備註:</label>
                            <input class="backend-form-input" type="text" id="comment"><br><br>
                        </div>

                        <div class="card-footer" align="right">
                            <text align="text-center" style="color:red" id="post_result"></text>&nbsp;&nbsp;&nbsp;
                            <button class="backend-form-button color-green" id="guest_save">儲存</button>&nbsp;
                            <button class="backend-form-button color-red" id="guest_delete">刪除</button>&nbsp;
                            <button class="backend-form-button color-blue" id="guest_update">更新</button>&nbsp;
                            <button class="backend-form-button color-black" id="guest_close">取消</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-7 col-lg-9">
                    <div class="table" style="width: 100%;">
                        <table id="guestTable" class="display nowrap" cellspacing="0" width="100%" >
                            <thead class="thead-dark">
                                <tr>
                                    <th>編號</th>
                                    <th>名字</th>
                                    <th>座位</th>
                                    <th>電話</th>
                                    <th>邀請函形式</th>
                                    <th>是否參加</th>
                                    <th>葷食人數</th>
                                    <th>素食人數</th>
                                    <th>備註</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
            <br>
        </section>

        <!-- Footer -->
        <?php require('footer.php') ?>

    </body>

</html>

