<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>エラー Stable</title>
  <?php include('./header.php'); ?>
</head>
<body>
  <?php include('./nav.php'); ?>
  <main>
    <div class="section no-pad-bot">
      <div class="container">
        <div class="section no-pad-bot">
          <div class="row" style="margin:5vh 0;">
            <div class="col s12 m8 offset-m2 center">
              <h5 style="color:black !important;">ビデオカメラまたは、マイクが接続されていません。</h5>
              <h6 style="color:black !important;">接続されているか確認して再度入室を行ってください。</h6>
              <form method="post" id="join_form" action="./join.php">
                <div class="input-field col s12">
                  <input name="room_id" id="room_id" type="text" class="validate" value="<?php print $_GET["room"]?>">
                  <label for="room_id">Room ID</label>
                </div>
                <div class="input-field col s12"
                <?php
                if(isset($_SESSION['bool']) == true){
                  print 'style="display: none;"';
                }else{
                  print 'style="display: block;"';
                }
               ?>>
                  <input name="guest_name" id="guest_name" type="text" class="validate" >
                  <label for="guest_name">ニックネーム</label>
                </div>
                <a class="waves-effect waves-light2 btn-large" href="javascript:join_form.submit();">入室</a>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>
  <?php include('./footer.php'); ?>
  </body>
</html>
