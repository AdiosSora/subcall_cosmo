<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="css/join.min.css">
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script type="text/javascript" src="//cdn.webrtc.ecl.ntt.com/skyway-latest.js"></script>
    <script type="text/javascript" src="../key.js"></script>
    <script type="text/javascript" src="js/script.js"></script>

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
      <div id="nav-my-video">メニューバー</div>
      <video id="my-video" muted="true" autoplay playsinline></video>
      <div class="remote-streams" id="their-videos"></div>
    </div>

    </div>
    <div id="sub">
      <h2>SkyWay Video Chat</h2>

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

      <p>Your id: <span id="my-id">...</span></p>
      <!-- Make calls to others -->
      <div id="step2">
        <h3>Make a call</h3>
        <form id="make-call" class="pure-form">
          <input type="text" placeholder="Join room..." id="join-room">
          <button id="btn" class="pure-button pure-button-success" type="submit">Join</button>
        </form>
        <p><strong>Warning:</strong> You may connect with people you don't know if you both use the same room name.</p>
        <p><strong>注意：</strong>同じルーム名を使用した場合、知らない人と接続する可能性があります。</p>
      </div>

      <!-- Call in progress -->
      <div id="step3">
        <p>Currently in room <span id="room-id">...</span></p>
        <p><a href="#" class="pure-button pure-button-error" id="end-call">End call</a></p>
      </div>
    </div>
    <p class="meta" id="js-meta" ></p>
    <div id="test"></div>
    <script>
      const btn = document.getElementById('btn');

      const speech = new webkitSpeechRecognition();
      speech.lang = 'ja-JP';

      btn.addEventListener('click' , function() {
      // 音声認識をスタート
      //speech.start();

      console.log('認識スタート');
      });

      speech.onresult = function (e) {
        console.log('認識完了');
          speech.stop();
          if (e.results[0].isFinal) {
            var autotext = e.results[0][0].transcript

            //文字識別結果
            console.log(e);
            console.log(autotext);
          }
      }

      speech.onend = () => {

        console.log('認識再開');
          speech.start()
      };

      window.setTimeout(() => {
          const loading = document.getElementById('loading');
          loading.classList.add('loaded');
        },1000);
    </script>
  </body>
  </html>
