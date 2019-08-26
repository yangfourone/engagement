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

      let invitation_address;
      let invitation_selected;
      let meat_count;
      let vegetable_count;

      function displayTable() {
          if (document.getElementById('attend').value === '參加') {
              document.getElementById('attend-table').style.display = 'block';
          } else {
              document.getElementById('attend-table').style.display = 'none';
          }
      }

      function submitSheet(){
          if(confirm("確定要提交嗎？")){
              if (document.getElementById('attend').value === '參加') {

                  get_meal();
                  get_invitation();

                  $.ajax({
                      type: "POST",
                      url: "../apiv1/guest/add",
                      dataType: "json",
                      data: {
                          guestName: $("#guestName").val(),
                          phoneNumber: $("#phoneNumber").val(),
                          seat: "尚未安排",
                          invitation: invitation_selected,
                          invitationAddress: invitation_address,
                          attend: $("#attend").val(),
                          eatMeat: meat_count,
                          eatVege: vegetable_count
                      },
                      success: function() {
                          alert('提交成功！');
                          clearSheet();
                          document.getElementById('welcome').innerHTML = '竭誠歡迎您的蒞臨, 謝謝！';
                          document.getElementById('welcome').style.display = 'block';
                      },
                      error: function() {
                          alert('請確認資料是否成功填妥')
                      }
                  })
              } else {
                  $.ajax({
                      type: "POST",
                      url: "../apiv1/guest/add",
                      dataType: "json",
                      data: {
                          guestName: $("#guestName").val(),
                          phoneNumber: $("#phoneNumber").val(),
                          seat: "---",
                          invitation: "---",
                          invitationAddress: "---",
                          attend: "不參加",
                          eatMeat: "---",
                          eatVege: "---",
                      },
                      success: function() {
                          alert('提交成功！');
                          clearSheet();
                          document.getElementById('welcome').innerHTML = '謝謝您幫忙填寫表單！';
                          document.getElementById('welcome').style.display = 'block';
                      },
                      error: function() {
                          alert('請確認資料是否成功填妥')
                      }
                  })
              }
          }
      }

      function clearSheet() {
          document.getElementById('guestName').value = '';
          document.getElementById('phoneNumber').value = '';
          document.getElementById('attend').value = '';
          document.getElementById('eatMeat').value = '';
          document.getElementById('eatVege').value = '';
          document.getElementById('checkbox_vege').checked = false;
          document.getElementById('checkbox_meat').checked = false;
          document.getElementById('none').checked = false;
          document.getElementById('self').checked = false;
          document.getElementById('card').style.display = 'none';
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

    <!-- Header - set the background image for the header in the line below -->
    <header class="py-5 bg-image-full" style="background-image: url('pic/bg1.jpg');">
      <img class="img-thumbnail ml-5" src="pic/logo.jpg" width="300" height="300">
    </header>

    <!-- Content section -->
    <section class="py-5 px-3">
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-8">
                <h1>吾女馥嘉要出閣了</h1><br><br>
                <h2>時間</h2>
                <p></p>
                <p>民國 108 年 9 月 28 日 &nbsp;&nbsp; 18 時 00 分 &nbsp;&nbsp;迎賓入席</p><br>
                <h2>地點</h2>
                <p></p>
                <p>桂田酒店 本館三樓羅馬廳</p>
                <p>台南市永康區永安一街99號 (由永康交流道下)</p>
                <a href="https://www.google.com.tw/maps/dir/Current+Location/710台南市永康區永安一街99號">點我連結 Google Maps 導航</a>
            </div>
            <div class="col-lg-2"></div>
        </div>
    </section>

    <!-- invitation -->
    <div class="row top-area">
        <div class="col-lg-2"></div>
        <div class="col-lg-6">
            <div class="card" id="card">
                <div class="card-header">
                    <i class="fa fa-fw fa-child"></i>出席統計表格( <strong style="color: red;">*</strong> 為必填)
                </div>
                <div class="card-body" align="left">

                    <label class="form-option-title" for="guestName">您的大名 <strong style="color: red;">*</strong></label>
                    <input class="form-input" type="text" id="guestName"><br><br>

                    <label class="form-option-title" for="phoneNumber">聯絡電話 <strong style="color: red;">*</strong></label>
                    <input class="form-input" type="text" id="phoneNumber"><br><br>

                    <label class="form-option-title" for="attend">請問您是否方便參加?</label>
                    <select id="attend" onchange="displayTable()">
                        <option value="參加">一定到場祝福</option>
                        <option value="不參加">不方便參加</option>
                    </select><br><br>

                    <div id="attend-table">
                        <label class="form-option-title" for="invitation">是否需親送喜帖並當面邀請?</label><br>
                        <input name="invitation" type="radio" value="self" id="self"> 需要, 約一下時間 <br><br>
                        <input name="invitation" type="radio" value="none" id="none"> 不用, 我記得時間會準時出席 <br><br>

                        <label class="form-option-title" for="attendNumber">出席人數及餐食屬性</label><br>
                        <div class="form-meal">
                            <input id="checkbox_meat" type="checkbox" value="meat"> 葷食,&nbsp;&nbsp;
                            <select id="eatMeat" style="width: 85%;">
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
                        </div>
                        <div class="form-meal">
                            <input id="checkbox_vege" type="checkbox" value="vege"> 素食,&nbsp;&nbsp;
                            <select id="eatVege" style="width: 85%;">
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
                    </div>
                </div>

                <div class="card-footer" align="center">
                    <button class="form-submit-button" id="guest_save" onclick="submitSheet()">提交</button>
                </div>
            </div>
            <br><br>
        </div>
        <div class="col-lg-4"></div>
    </div>
    <h1 id="welcome" style="display: none;"></h1>

    <div class="py-5 bg-image-full" align="center">
        <img src="pic/bg2.jpg" style="width: 80%; height: auto;">
    </div>

    <!-- Footer -->
    <?php require('footer.php') ?>

  </body>

</html>
