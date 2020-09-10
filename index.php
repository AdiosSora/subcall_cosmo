<!DOCTYPE html>

<html lang="ja">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>Stable - ビデオ会議</title>
  <?php include('./header.php'); ?>
</head>
<body>
  <?php include('./nav.php'); ?>
  <main>
    <div id="index-banner" class="parallax-container">
      <div class="section no-pad-bot">
        <div class="container">
          <div class="section no-pad-bot">
            <div class="row">
              <div class="col s12 m6 offset-m6 center">
                <h2 style="color:black !important;">会議へ参加する</h2>
                <form method="post" id="join_form" action="./join.php">
                  <div class="input-field col s12">
                    <input name="room_id" id="room_id" type="text" class="validate">
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
        <div class="parallax"><img src="images/background_top.png" alt="topimage"></div>
      </div>
    </div>
    <div class="container">
      <div class="section">
        <div class="row">
          <div class="col s12 m6">
            <div class="icon-block">
              <h2 class="center brown-text"><i class="material-icons">accessibility</i></h2>
              <h5 class="center">利便性</h5>

              <p class="light" style="text-align:center;">Stableは登録せずともWeb上でテレビ会議を行うことができます。</p>
            </div>
          </div>
          <div class="col s12 m6">
            <div class="icon-block">
              <h2 class="center brown-text"><i class="material-icons">textsms</i></h2>
              <h5 class="center">字幕</h5>

              <p class="light" style="text-align:center;">どれだけ会議システムの質を上げても、ネットワーク回線が不安定な環境はあります。そこで字幕機能を使えば発言の聞き逃すことはなくなります。</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="parallax-container valign-wrapper">
      <div class="section no-pad-bot">
        <div class="container">
          <div class="row center">
            <h5 class="header col s12 light">快適なリモートワークをあなたに</h5>
          </div>
        </div>
      </div>
      <div class="parallax blue-grey lighten-3"></div>
    </div>
  </main>
  <?php include('./footer.php'); ?>
  </body>
  <script>
    $(document).ready(function(){
      $('.modal').modal();
    });
  </script>
</html>
