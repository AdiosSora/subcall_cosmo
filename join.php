<!DOCTYPE html>
<html lang="ja">
  <head>
    <?php
      session_start();
      session_regenerate_id(true);
      // require_once('./common.php');
      // $post = sanitize($_POST);
      if (isset($_POST['room_id']) && $_POST['room_id'] != '') {
          $roomID = $_POST['room_id'];
      }
      else if(isset($_GET['room_ID'])){
          $roomID=$_GET['room_ID'];
      }

      else{
          header('Location: ./index.php');
          exit;
      }
      $login_flg = isset($_SESSION['bool']);

      if ($login_flg == 'true') {
          //ログインチェック
      //ログイン中にて、peerIDは accountテーブルのnumberから取得した値を使用する。
        $regist_name = $_SESSION['regist_name'];
          include './account/db/dbConnecter.php';//peerIDをaccountの主キーと紐づける用のSQL発行・
        $dbh = get_DBobj();
          $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
          $sql = 'select number from account where name=?';
          $data[] = $regist_name;
          $stmt = $dbh->prepare($sql);
          $stmt->execute($data);
          $dbh = null;
          $rec = $stmt->fetch(PDO::FETCH_ASSOC);
          $memberPeer = $rec['number'];

          print '<input type="hidden" id="memberPeer" value="'.$memberPeer.'">';
          print '<input type="hidden" id="name" value="'.$regist_name.'">';
          print '<input type="hidden" id="login_FLG" value="true">';
          print '<input type="hidden" id="room__name" value="'.$roomID.'">';
      } else {
          //ゲストのためpeerIDをどうするか用検討。

        $guestName = $_POST['guest_name'];
          print '<input type="hidden" id="memberPeer" value="">';
          print '<input type="hidden" id="name" value="'.$guestName.'">';
          print '<input type="hidden" id="login_FLG" value="false">';
          print '<input type="hidden" id="room__name" value="'.$roomID.'">';
          if (isset($_POST['guest_name']) == false || $_POST['guest_name'] == '') {
              header('Location: ./index.php');
              exit;
          }
      }
    ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/join.min.css">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script type="text/javascript" src="js/script.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.esm.js"></script>
    <!--- favicon --->
    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#ffc40d">
    <meta name="theme-color" content="#ffffff">

    <title>会議室 - Stable</title>
  </head>
  <body>
  <!---ローディングアニメーション用 --->
    <div id="loading">
      <div class="sk-cube-grid">
        <div class="sk-cube sk-cube1">S</div>
        <div class="sk-cube sk-cube2"></div>
        <div class="sk-cube sk-cube3"></div>
        <div class="sk-cube sk-cube4">T</div>
        <div class="sk-cube sk-cube5"></div>
        <div class="sk-cube sk-cube6">E</div>
        <div class="sk-cube sk-cube7">A</div>
        <div class="sk-cube sk-cube8">B</div>
        <div class="sk-cube sk-cube9">L</div>
      </div>
    </div>
    <div id="main">
      <div id="local_video">
        <video id="my-video" muted="true" autoplay playsinline></video>
        <div id="button_group">
          <!-- <a class="menu-button" id="local_none_button">
            <p>
              <ion-icon name="caret-down-outline"/>
            </p>
          </a> -->
          <div id="setting">
            <a class="menu-button" v-on:click="openModal">
              <p>
                <ion-icon name="code-slash-outline" v-pre></icon-icon>
              </p>
            </a>
            <open-modal v-show="showContent" v-on:from-child="closeModal">
            </open-modal>
          </div>
          <div id="setting2">
            <a class="menu-button" v-on:click="openModal">
              <p>
                <ion-icon name="people-circle-outline" v-pre></ion-icon>
              </p>
            </a>
            <open-modal v-show="showContent" v-on:from-child="closeModal">
                <?php
                if (isset($regist_name)) {
                    print '<iframe id="inlineFrameExample"
                      width="100%"
                      height="100%"
                      src="invitation.php?ROOMname='.$roomID.'&hostname='.$regist_name.'&usernum='.$memberPeer.'">
                  </iframe>';
                } else {
                    print 'ログインすることでフレンド招待機能が解放されます';
                }
                  ?>
            </open-modal>
          </div>
          <div id="setting3">
            <a class="menu-button" v-on:click="openModal">
              <p>
                <ion-icon name="build-outline" v-pre></ion-icon>
              </p>
            </a>
            <open-modal v-show="showContent" v-on:from-child="closeModal">
              <h2>設定</h2>
              <p>Your id: <span id="my-id">...</span></p>
              <div class="select">
                <label for="audioSource">Audio input source: </label><select id="audioSource"></select>
              </div>
              <div class="select">
                <label for="videoSource">Video source: </label><select id="videoSource"></select>
              </div>
              <!-- Get local audio/video stream -->
              <div id="step1">
                <p>Please click `allow` on the top of the screen so we can access your webcam and microphone for calls.</p>
                <div id="step1-error">
                  <p>Failed to access the webcam and microphone. Make sure to run this demo on an http server and click allow when asked for permission by the browser.</p>
                  <a href="#" class="pure-button pure-button-error" id="step1-retry">Try again</a>
                </div>
              </div>
              <!-- Make calls to others -->
              <div id="step2">
                <h3>Make a call</h3>
                <form id="make-call" class="pure-form">
                  <input type="text" value="<?php print $roomID ?>" id="join-room">
                  <button id="btn" class="pure-button pure-button-success" type="submit">Join</button>
                </form>
              </div>
              <!-- Call in progress -->
              <div id="step3">
                <p>Currently in room <span id="room-id">...</span></p>
                <p><a href="#" class="pure-button pure-button-error" id="end-call">End call</a></p>
                <button id="dlSpeechLog" class="" type="submit">音声ログダウンロード</button>
              </div>
            </open-modal>
            </div>
          </div>
        </div>
      <div class="remote-streams" id="their-videos"></div>
      <div id="main_button">
        <a href="#" id="mic_mute_button"><ion-icon name="mic-outline" v-pre><ion-icon name="close-outline"></ion-icon></ion-icon></a>
        <a href="#" id="video_mute_button"><ion-icon name="videocam-outline" v-pre></ion-icon></a>
        <a href="/index.php"><ion-icon name="log-out-outline" v-pre></ion-icon></a>
      </div>
    </div>

    <div id="sub">
      <div id="text-content">
        <div id="chat-content">
          <div id="chat-title">チャット</div>
          <div id="chat-text" class="msg-content"></div>
        </div>
        <div id="voicechat-content">
          <div id="voicechat-title">ボイスチャット</div>
          <div id="sub-text" class="msg-content"></div>
        </div>
      </div>
      <div id="text_input">
        <input type="text" id="chat-textarea">
        <button id="btn-send" class="pure-button pure-button-success" type="submit">送信</button>
      </div>
    </div>

  <script>
    window.setTimeout(() => {
        const loading = document.getElementById('loading');
        loading.classList.add('loaded');
    },1000);
    Vue.component('open-modal',{
      template : `
        <div id="overlay" v-on:click="clickEvent">
            <div id="content" v-on:click="stopEvent">
              <p><slot></slot></p>
              <button v-on:click="clickEvent">close</button>
            </div>
        </div>
        `,
      methods :{
        clickEvent: function(){
          this.$emit('from-child')
        },
        stopEvent: function(){
         event.stopPropagation()
       }
      }
    });
    new Vue({
      el: '#setting',
      data: {
        showContent: false
      },
      methods:{
        openModal: function(){
          this.showContent = true
        },
        closeModal: function(){
          this.showContent = false
        }
      }
    });
    new Vue({
      el: '#setting2',
      data: {
        showContent: false
      },
      methods:{
        openModal: function(){
          this.showContent = true
        },
        closeModal: function(){
          this.showContent = false
        }
      }
    });
    new Vue({
      el: '#setting3',
      data: {
        showContent: false
      },
      methods:{
        openModal: function(){
          this.showContent = true
        },
        closeModal: function(){
          this.showContent = false
        }
      }
    });
    </script>
  </body>
</html>
