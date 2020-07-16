<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <!--<script src="./js/login.js"></script>-->

  <title>Stable - ビデオ会議</title>
  <?php include 'C:\xampp\htdocs/header.php'; ?>
</head>
<body>

  <?php include 'C:\xampp\htdocs/nav.php'; ?>

  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row">
          <div class="col offset-s2 s8 center">
            <div class="card">
              <div class="card-content">
                <form method="post" name="regiser_form" action="login_check.php" id="check" class="pw-form-container">
                    <h2 style="color:black !important;">ログイン</h2><br/>

                    <div class="form_title">
                      <label for="name" class="form_name">お名前</label>
                    </div>
                    <input type="text" name="name" id="name" size="30" maxlength="20" placeholder="例:たろう" autocomplete="off">
                    <br>
                    <div class="form_title">
                      <label for="name" class="form_name">パスワード</label>
                    </div>
                    <input type="password" name="pass" id="pass" size="30" maxlength="20" placeholder="パスワード" autocomplete="off">
                    <br>
                    <a class="waves-effect waves-light btn-large grey darken-1" href="../index.php">戻る</a>
                    <a class="waves-effect waves-light btn-large grey darken-1" href="register.php">会員登録</a>
                    <a class="waves-effect waves-light btn-large" href="javascript:regiser_form.submit()">ログイン</a>


                </form>
              </div>
            </div>
          </div>
        </div>
        <br><br>
      </div>
    </div>
    <div class="parallax" style="background:#999999;"></div>
  </div>
  <?php include 'C:\xampp\htdocs/footer.php'; ?>
  </body>
</html>
