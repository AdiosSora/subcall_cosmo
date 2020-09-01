<?php
try{
  session_start();
  session_regenerate_id(true);
  include('../db/dbConnecter.php');

  if(isset($_SESSION['bool'])==false){
    print'ログインされていません。<br/>';
    print'<a href="../login/login.php">ログイン画面へ</a>';
    exit();
}
}catch (Exception $e) {
  print $e;
}
?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/register_update.js"></script>
    <script src="../../js/jquery.validate.js"></script>
    <script src="../../js/jquery.validate.min.js"></script>
    <script src="../../js/register.js"></script>
    <title>プロフィール更新画面 - Stable </title>
    <?php include '../../header.php'; ?>
  </head>
<body>
  <div class="container">
  <div class="section no-pad-bot">
  <br><br>
  <div class="row">
  <div class="col col s10 offset-m1 m8 offset-m2 center">
  <h2 style="color:black !important;">プロフィール編集</h2><br/>
  <p>
  プレビュー:
  <image id="preview" src="data:image/gif;base64,R0lGODlhAQABAAAAACH5BAEKAAEALAAAAAABAAEAAAICTAEAOw==" style="max-width:200px;">
  </p>


  <form method='POST' action="register_update_done.php" id ="check" enctype="multipart/form-data">

  <input type="hidden" name="MAX_FILE_SIZE" id="size_check" value="5242880">
  <input type="file" name="image" id="image" accept='image/*' onchange="previewImage(this);"><br/><br/>

  <div class="form_title">
    <label for="name" class="form_name">ユーザ名</label>
    <a class="form_required_mark">必須</a>
    <input type="text" id="name" name="name" contentEditable="true" autocomplete="off" value="<?php print $_SESSION['regist_name'];?>">
  </div>

  <div class="form_title">
    <label for="name" class="form_name">E-mail</label>
    <a class="form_required_mark">必須</a>
    <input type="text" id="address" name="mail_address" contentEditable="true" autocomplete="off" value="<?php print $_SESSION['regist_address'];?>">
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
  <div class="form_title"><label for="name" class="form_name">生年月日</label></div>
  <div class="input-field col s12">
    <select class="browser-default" name="year" id="year">
      <option value="<?php print $year; ?>" checked><?php print $year; ?></option>
      <?php
      for($i= 1950; $i < 2021; $i++){
        print'<option value='.$i.'>'.$i.'</option>';
      }
      ?>
    </select>年
  </div>

  <div class="input-field col s12">
    <select class="browser-default" name="month" id="month">
      <option value="<?php print $month; ?>" checked><?php print $month; ?></option>
      <?php
      for($i=1; $i<13; $i++){
        $length = strlen((string)$i);
        if(intval($length) == 1){
          print'<option value='.$i.'>'.$i.'</option>';
        }else{
          print'<option value='.$i.'>'.$i.'</option>';
        }
      }
      ?>
    </select>月
  </div>

  <option value="<?php print $day; ?>" checked><?php print $day; ?></option>
  <div class="input-field col s12">
    <select class="browser-default" name="day" id="day">
      <option value="<?php print $day; ?>" checked><?php print $day; ?></option>
      <?php
      for($i= 1; $i < 32; $i++){
        print'<option value='.$i.'>'.$i.'</option>';
      }
      ?>
    </select>日
  </div>
  <?php
  if(!empty($_SESSION['regist_country'])){
  $country = $_SESSION['regist_country'];
  }else{
  $country = '―';
  }
  ?>
  <div class="form_title"><label for="name" class="form_name">居住国</label></div>
  <div class="input-field col s12">
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

  性別 :&nbsp;
  <div>
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
  case 'その他':
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
  }?>
  </div>
  <div>
  <a class="waves-effect waves-light btn-large grey darken-1" href="../profile/profile.php">戻る</a>
  <a href="register_update_done.php">
    <button class="btn waves-effect waves-light" type="submit" name="action">完了
      <i class="material-icons right">send</i>
    </button>
  </a>
  </div>
  </form>
  <div class="parallax" style="background:white;"></div>

  </div>
  </div>
  </div>
  </div>
  </div>
  </div>
  </body>
</html>
