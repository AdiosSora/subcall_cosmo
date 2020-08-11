<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <link href="/css/join.css" type="text/css" rel="stylesheet">
      <?php
      $room = $_POST['room_id'];
      $guestName=$_POST['guest_name'];
      if($room!=null && $guestName!=null){
      }else{
        header('Location: index.php');
      }
      ?>
      <title>会議室 - Stable</title>
      <!--- favicon --->
      <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
      <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
      <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
      <link rel="manifest" href="/favicon/site.webmanifest">
      <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
      <meta name="msapplication-TileColor" content="#ffc40d">
      <meta name="theme-color" content="#ffffff">
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
        <video id="js-local-stream"></video>
        <div class="remote-streams" id="js-remote-streams"></div>

    </div>
    <div id="sub">
      <div id="chatbox">
        <h1 class="heading">
          <?php print $room;?>
        </h1>
        <p class="note">
          Change Room mode (before join in a room):
          <a href="#">mesh</a> / <a href="#sfu">sfu</a>
        </p>
        <div>
          <span id="js-room-mode"></span>:
          <?php
            print '<input type="text" placeholder="Room Name" id="js-room-id" value="'.$room.'">';
            print '<div id="js-guest-name">'.$guestName.'</div>';
          ?>
        </div>
        <pre class="messages" id="js-messages"></pre>

        </div>
        <input type="text" id="js-local-text">
        <button id="js-send-trigger">Send</button>
        <button id="js-leave-trigger">Leave</button>
      </div>

      <p class="meta" id="js-meta" ></p>
      <div id="test"></div>
    </div>
    <script>
    // window.setTimeout(async () => {
    //     console.log('1');
    //     const speech = new webkitSpeechRecognition();
    //     speech.lang = 'ja-JP';
    //     // 音声認識をスタート
    //     speech.start();
    //     console.log('2');
    //
    //     //音声自動文字起こし機能
    //     speech.onresult = function (e) {
    //         speech.stop();
    //         console.log('4');
    //         if (e.results[0].isFinal) {
    //           console.log('4');
    //           var autotext = e.results[0][0].transcript
    //           console.log(autotext);
    //         }
    //     }
    //
    //     speech.onend = () =>
    //     {
    //         speech.start()
    //         console.log('スピーチ再起動')
    //     };
    //   },4000);

    </script>
    <script>
    window.setTimeout(() => {
        const loading = document.getElementById('loading');
        loading.classList.add('loaded');
      },2000);
    </script>
  </body>
  <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
  <script src="/js/script.js"></script>
  </html>
