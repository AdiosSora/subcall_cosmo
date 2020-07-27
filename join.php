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
  </head>
  <body>
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
        <input type="text" id="js-local-text">
        <button id="js-send-trigger">Send</button>
      </div>

      <p class="meta" id="js-meta"></p>
<<<<<<< HEAD
      </div>
    音声認識ログ<input type="text" name="speechText">
    </div>
=======
<<<<<<< HEAD
      <div id="test"></div>
    </div>
    音声認識ログ<input type="text" name="speechText">
    <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
    <script src="/js/script.js"></script>
    </div>
=======
      <p><iframe src="/test/speech.html"></iframe></p>
      </div>
>>>>>>> 4e6726ee9f58b565e8dfb528e757fa6018dce763
>>>>>>> 05f5a88d047b13a0cd0fea2d28b19e8c99aca08f
  </body>
  <script src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
  <script src="/js/script.js"></script>
  <script>
      const speech = new webkitSpeechRecognition();
      speech.lang = 'ja-JP';

      const content = document.getElementById('test');

      start_btn.addEventListener('click', function () {
          // 音声認識をスタート
          speech.start();
      });

      //音声自動文字起こし機能
      speech.onresult = function (e) {
          speech.stop();
          if (e.results[0].isFinal) {
              var autotext = e.results[0][0].transcript
              content.innerHTML += '<div>' + autotext + '</div>';
          }
      }

      speech.onend = () =>
      {
          speech.start()
      };

  </script>
</html>
<script>
window.setTimeout(() => {
    const speech = new webkitSpeechRecognition();
    speech.lang = 'ja-JP';

    speech.start();
    const content = document.getElementById('videoSub');

    //音声自動文字起こし機能
    speech.onresult = function (e) {
        speech.stop();
        if (e.results[0].isFinal) {
            var autotext = e.results[0][0].transcript
            content.innerHTML += autotext;
        }
    }

    speech.onend = () =>
    {
        speech.start();
    };
  },3000);

</script>
