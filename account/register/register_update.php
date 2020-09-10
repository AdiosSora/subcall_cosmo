<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/register_update.js"></script>
    <script src="../../js/cropper.js"></script>
    <title>プロフィール更新 - Stable </title>
    <?php include '../../header.php'; ?>
  </head>
  <body>
  <main>
    <?php
      session_start();
      session_regenerate_id(true);
    try{
      if(isset($_SESSION['bool'])==false){
        print'ログインされていません。<br/>';
        print'<a href="../login/login.php">ログイン画面へ</a>';
        exit();
      }
    }catch (Exception $e) {
      print $e;
    }
    ?>
    <div class="container">
      <div class="section no-pad-bot">
      <div class="row">
      <div class="col col s10 offset-s2 center">
      <h2 style="color:black !important;">プロフィール編集</h2><br/>
        <?php

          include('../db/dbConnecter.php');
          $dbh = get_DBobj();
          $dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

          $sql = 'SELECT name FROM account;';
          $stmt = $dbh->query($sql);
          $name_list=array();
          foreach ($stmt as $row) {
            array_push($name_list,$row['name']);
          }
          $php_json_name = json_encode($name_list);

          $sql = 'SELECT mail_address FROM account;';
          $stmt = $dbh->query($sql);
          $email_list=array();
          foreach ($stmt as $row) {
            array_push($email_list,$row['mail_address']);
          }
          $php_json_email = json_encode($email_list);
        ?>
        <form method='POST' name="register_update_form" action="register_update_done.php" enctype="multipart/form-data">
          <!-- ユーザフォーム -->
          <div class="input-field">
          <label for="name">ユーザ名<a class="form_required_mark">必須</a></label>
          <input type="text" id="name" name="name" contentEditable="true" autocomplete="off" value="<?php print $_SESSION['regist_name'];?>">
          <p id="validetion_alart_name" style="display:none;">この名前は既に使用されています。</p>
          </div>

          <!--メールアドレスフォーム-->
          <div class="input-field">
          <label for="mail_address">E-mail
          <a class="form_required_mark">必須</a></label>
          <input type="text" id="address" name="mail_address" contentEditable="true" autocomplete="off" value="<?php print $_SESSION['regist_address'];?>">
          <p id="validetion_alart_email" style="display:none;">このメールアドレスは既に使用されています。</p>
          </div>
          <?php
          if(!empty($_SESSION['regist_bone']) || !strcmp($_SESSION['regist_bone'] , '―/―/―')){
            $bone = $_SESSION['regist_bone'];
            $year = substr($bone , 0 , 4);
            $month = substr($bone , 5 , 2);
            $day = substr($bone , 8 , 2);
          }else{
            $year = '';
            $month = '';
            $day = '';
          }
          ?>

          <!--生年月日（年）-->
          <div style="text-align:left;"><label>生年月日</label></div>
          <div class="input-field col s12 m4">
            <div class="col s10" name="birthday">
              <select class="browser-default" name="year" id="year">
                <option value="<?php print $year; ?>" checked><?php print $year; ?></option>
                <?php
                  for($i= 1950; $i < 2021; $i++){
                    print'<option value='.$i.'>'.$i.'</option>';
                  }
                ?>
              </select>
            </div>
            <div class="col s2">
              <div style="padding:10px 0 0 0;">年</div>
            </div>
          </div>

          <!-- 生年月日（月） -->
          <div class="input-field col s12 m4">
            <div class="col s10">
            <select class="browser-default" name="month" id="month">
              <option value="<?php print $month; ?>" checked><?php print $month; ?></option>
              <?php
              for($i=1; $i<13; $i++){
                $length = strlen((string)$i);
                if(intval($length) == 1){
                  $i = '0'.$i;
                  print'<option value='.$i.'>'.$i.'</option>';
                }else{
                  print'<option value='.$i.'>'.$i.'</option>';
                }
              }
              ?>
            </select>
            </div>
            <div class="col s2">
              <div style="padding:10px 0 0 0;">月</div>
            </div>
          </div>

          <!-- 生年月日（日） -->
          <div class="input-field col s12 m4">
            <div class="col s10">
            <select class="browser-default" name="day" id="day">
              <option value="<?php print $day; ?>" checked><?php print $day; ?></option>
              <?php
              for($i=1; $i<32; $i++){
                $length = strlen((string)$i);
                if(intval($length) == 1){
                  $i = '0'.$i;
                  print'<option value='.$i.'>'.$i.'</option>';
                }else{
                  print'<option value='.$i.'>'.$i.'</option>';
                }
              }
              ?>
            </select>
            </div>
            <div class="col s2">
              <div style="padding:10px 0 0 0;">日</div>
            </div>
          </div>

          <?php
            if(!empty($_SESSION['regist_country'])){
            $country = $_SESSION['regist_country'];
            }else{
            $country = '―';
            }
          ?>

          <!-- 居住国 -->
          <div class="input-field col s12">
            <div class="form_title"><label for="name" class="form_name">居住国</label></div>
            <select class="browser-default" name="country" id="country">
            <option value="<?php print $country; ?>" checked><?php print $country; ?></option>
            <option value="アメリカ">アメリカ</option>
            <option value="イギリス">イギリス</option>
            <option value="イタリア">イタリア</option>
            <option value="インド">インド</option>
            <option value="インドネシア">インドネシア</option>
            <option value="韓国">韓国</option>
            <option value="北アフリカ">北アフリカ</option>
            <option value="サウジアラビア">サウジアラビア</option>
            <option value="中国">中国</option>
            <option value="トルコ">トルコ</option>
            <option value="ドイツ">ドイツ</option>
            <option value="日本">日本</option>
            <option value="フランス">フランス</option>
            <option value="ブラジル">ブラジル</option>
            <option value="南アフリカ">南アフリカ</option>
            <option value="メキシコ">メキシコ</option>
            <option value="ロシア">ロシア</option>
          </select>
          </div>

          <!--性別-->
          <div class="input-field col s12">
            <div class="form_title"><label for="name" class="form_name">性別</label></div>
          <?php
            if(!empty($_SESSION['regist_gender'])){
              switch($_SESSION['regist_gender']){
                  case '男性':
                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="男性" checked>
                            <span>男性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="女性">
                            <span>女性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="無回答">
                            <span>無回答</span>
                        </label>
                      </p>';
                  break;
                  case '女性':
                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="男性">
                            <span>男性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="女性" checked>
                            <span>女性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="無回答">
                            <span>無回答</span>
                        </label>
                      </p>';
                  break;
                  case '無回答':
                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="男性">
                            <span>男性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="女性">
                            <span>女性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="無回答" checked>
                            <span>無回答</span>
                        </label>
                      </p>';
                  break;
                }
              }else{
                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="男性" checked>
                            <span>男性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="女性">
                            <span>女性</span>
                        </label>
                      </p>';

                print'<p>
                        <label>
                          <input class="with-gap" type="radio" id="gender1" name="gender" value="無回答">
                            <span>無回答</span>
                        </label>
                      </p>';
            }
          ?>
          </div>

          <!--戻る・完了ボタン-->
          <div>
          <a class="waves-effect waves-light btn-large grey darken-1" href="../profile/profile.php">戻る</a>
          <a class="waves-effect waves-light btn-large" id="btn" href="javascript:register_update_form.submit()">完了</a>
          </div>
        </form>
      </div>
    </div>
  </main>
  </body>
  <script>

  $(document).ready(function() {

   $('input#name, input#pass, input#pass2, input#address').characterCounter();
  });
  var js_name_array = JSON.parse('<?php echo $php_json_name ?>');
  var js_email_array = JSON.parse('<?php echo $php_json_email ?>');
  var old_name = $("#name")[0].value;
  var old_email = $("#address")[0].value;
  var flag_name = true;
  var flag_email = true;

  $("#name").on("input change", function(){
    js_name_array.indexOf($("#name")[0].value);
    if(js_name_array.indexOf($("#name")[0].value) == -1){
      $('#validetion_alart_name').css('display','none');
      flag_name = true;
    }else{
      if(old_name != $("#name")[0].value){
        $('#validetion_alart_name').css('display','inline');
        flag_name = false;
      }else{
        flag_name = true;
      }
    }
    if(flag_name==true && flag_email==true){
      $("#btn").attr("href", "javascript:register_update_form.submit()");
    }else{
      $("#btn").attr("href", "#");
    }
  });
  $("#address").on("input change", function(){
    js_email_array.indexOf($("#address")[0].value);
    if(js_email_array.indexOf($("#address")[0].value) == -1 && old_email != $("#address")[0].value){
      $('#validetion_alart_email').css('display','none');
      flag_email = true;
    }else{
      if(old_email != $("#address")[0].value){
        $('#validetion_alart_email').css('display','inline');
        flag_email = false;
      }else{
        flag_email = true;
      }
    }
    if(flag_name==true && flag_email==true){
      $("#btn").attr("href", "javascript:register_update_form.submit()");
    }else{
      $("#btn").attr("href", "#");
    }
  });

  </script>
</html>
