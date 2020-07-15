<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/jquery.validate.js"></script>
  <script src="js/jquery.validate.min.js"></script>
  <script src="js/register.js"></script>

  <title>Stable - ビデオ会議</title>
  <?php include './header.php'; ?>
</head>
<body>
  <?php include './nav.php'; ?>

  <div id="index-banner" class="parallax-container">
    <div class="container">
      <div class="section no-pad-bot">
        <br><br>
        <div class="row">
          <div class="col offset-s2 s8 center">
            <div class="card">
              <div class="card-content">
                <form method="post" name="regiser_form" action="register_check.php" id="check" class="pw-form-container">
                    <h2 style="color:black !important;">会員登録</h1><br/>
                    <div class="form_title">
                      <label for="name" class="form_name">お名前</label>
                      <a class="form_required_mark">必須</a>
                    </div>
                    <input type="text" name="name" id="name" size="30" maxlength="20" placeholder="例:たろう" autocomplete="off">
                    <br/>
                    <div class="form_title">
                      <label for="name" class="form_name">パスワード</label>
                      <a class="form_required_mark">必須</a>
                    </div>
                    <input type="password" name="pass" id="pass" size="30" maxlength="30" placeholder="パスワード" autocomplete="off">
                    <input type="password" name="pass2" id="pass2" size="30" maxlength="30" placeholder="パスワード(確認)" autocomplete="off">
                    <br>
                    <div class="form_title">
                      <label for="name" class="form_name">メールアドレス</label>
                      <a class="form_required_mark">必須</a>
                    </div>
                    <input type="email" name="address" id="address" size="30" maxlength="50" placeholder="例:Stable@example.com" autocomplete="off">
                    <a class="waves-effect waves-light btn-large grey darken-1" href="index.php">戻る</a>
                    <a class="waves-effect waves-light btn-large" href="javascript:regiser_form.submit()">確認</a>
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
  <?php include './footer.php'; ?>
  </body>
</html>
