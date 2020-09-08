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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css" charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../../js/register_update.js"></script>
    <script src="../../js/cropper.js"></script>
    <title>プロフィール更新 - Stable </title>
    <?php include '../../header.php'; ?>
    <style>
           /* 下記は円形にするなら必須です。 */
           .cropper-view-box,
           .cropper-face {
               border-radius: 50%;
           }
           /* 下記はできれば必要なスタイルかと思います。（厳密にはスタイルなど必要ありませんが、最低現のスタイルとしてという意味です。） */
           .cropper-container{
               width: 100%;
           }
           /* 下記は必須ではありません。 Sampleを見やすくするために作成しました。 */
           main{
               width: 50%;
               margin: 0 auto;
           }
           main .triming-image{
               width: 100%;
               height: 100px;
               border: dashed #000 1px;
               cursor: pointer;
           }
           main #trimed_image{
               height: 500px;
           }
     </style>
  </head>

  <body>
    <div class="container">
    <div class="section no-pad-bot"></br></br>
    <div class="row">
    <div class="col col s10 offset-m1 m8 offset-m2 center">
    <h2 style="color:black !important;">プロフィール編集</h2><br/>

    <form method='POST' action="register_update_done.php" enctype="multipart/form-data">
      <main>
        <!-- <div class="cropper-container"> -->
        <!-- トリミング用 -->
        <input type="file" id="triming_image" name="triming_image">
        <img src="" alt="トリミング画像" id="trimed_image" style="display: none;"></br>
        <label for="avatar">アップロードする画像を選択してください</label>
        <!-- <p><input type="button" id="crop_btn" value="画像をトリミングして送信" /></p> -->
        <!-- トリミング時の高さ・幅を取得 -->
        <input type="hidden" id="upload-image-x" name="image_x" value="0">
        <input type="hidden" id="upload-image-y" name="image_y" value="0">
        <input type="hidden" id="upload-image-w" name="image_w" value="0">
        <input type="hidden" id="upload-image-h" name="image_h" value="0">
      </main>

      <!-- ユーザフォーム -->
      <div class="form_title">
      <label for="name" class="form_name">ユーザ名</label>
      <a class="form_required_mark">必須</a>
      <input type="text" id="name" name="name" contentEditable="true" autocomplete="off" value="<?php print $_SESSION['regist_name'];?>">
      </div>

      <!--メールアドレスフォーム-->
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

        <div class="form_title">
          <label for="name" class="form_name">生年月日</label>
        </div>
        <!--生年月日（年）-->
        <div class="input-field col s12">
            <div>
              <select class="browser-default" name="year" id="year">
                <option value="<?php print $year; ?>" checked><?php print $year; ?></option>
                <?php
                  for($i= 1950; $i < 2021; $i++){
                    print'<option value='.$i.'>'.$i.'</option>';
                  }
                ?>
              </select>
            </div>
          <div>年</div>
        </div>

        <!-- 生年月日（月） -->
        <div class="input-field col s12">
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
          </select>月
        </div>

        <!-- 生年月日（日） -->
        <div class="input-field col s12">
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
          </select>日
        </div>


        <?php
          if(!empty($_SESSION['regist_country'])){
          $country = $_SESSION['regist_country'];
          }else{
          $country = '―';
          }
        ?>

        <!-- 居住国 -->
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

        <!--性別-->
        <div class="form_title"><label for="name" class="form_name">性別</label></div>

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
          }
        ?>
        </div>

      <!--戻る・完了ボタン-->
      <div>
      <a class="waves-effect waves-light btn-large grey darken-1" href="../profile/profile.php">戻る</a>
      <button class="btn waves-effect waves-light" type="submit" name="action" style="width:86px; height:54px">完了</button>
      </div>
    </form>
    <div class="parallax" style="background:white;"></div>
  </body>
</html>
