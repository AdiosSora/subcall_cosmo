const Peer = window.Peer;

(async function () {
  const localVideo = document.getElementById('js-local-stream');
  const joinTrigger = document.getElementById('js-join-trigger');
  const leaveTrigger = document.getElementById('js-leave-trigger');
  const remoteVideos = document.getElementById('js-remote-streams');
  const roomId = document.getElementById('js-room-id');
  const roomMode = document.getElementById('js-room-mode');
  const localText = document.getElementById('js-local-text');
  const sendTrigger = document.getElementById('js-send-trigger');
  const messages = document.getElementById('js-messages');
  const meta = document.getElementById('js-meta');
  const sdkSrc = document.querySelector('script[src*=skyway]');
  const myname = document.getElementById('js-guest-name').innerHTML;
  var remotevideoId = 0;
  //一時的にPeerIDをランダム生成
  var l = 8;
  var c = "abcdefghijklmnopqrstuvwxyz0123456789";
  var cl = c.length;
  var mypeerID = "";
  for(var i=0; i<l; i++){
      mypeerID += c[Math.floor(Math.random()*cl)];
  }
  //ブラウザの情報
  meta.innerText = `
    UA: ${navigator.userAgent}
    SDK: ${sdkSrc ? sdkSrc.src : 'unknown'}
  `.trim();

  //mode指定
  const getRoomModeByHash = () => (location.hash === '#sfu' ? 'sfu' : 'mesh');
  roomMode.textContent = getRoomModeByHash();
  window.addEventListener(
    'hashchange',
    () => (roomMode.textContent = getRoomModeByHash())
  );

  //メディアの接続確認 & 待機
  const localStream = await navigator.mediaDevices
    .getUserMedia({
      audio: true,
      video: true,
    })
    .catch(console.error);

  //ローカルストリームを描画
  localVideo.muted = true;
  localVideo.srcObject = localStream;
  localVideo.playsInline = true;
  await localVideo.play().catch(console.error);

  // eslint-disable-next-line require-atomic-updates
  const peer = (window.peer = new Peer(`${mypeerID}`,{
    key: '766085bc-041a-4889-ba90-b8fda1a4615f',
    debug: 3,
  }));

  // Register join handler
  window.setTimeout(() => {
// before using methods of peer instance.
    if (!peer.open) {
      return;
    }

    const room = peer.joinRoom(roomId.value, {
      mode: getRoomModeByHash(),
      stream: localStream,
    });

    room.once('open', () => {
      messages.textContent += `=== You${mypeerID} joined ===\n`;
    });

    room.on('peerJoin', peerId => {
      messages.textContent += `=== ${peerId} joined ===\n`;
    });

    // Render remote stream for new peer join in the room　
    room.on('stream', async stream => {
      // div要素を生成
      const div = document.createElement('div');
      // classを追加
      div.className = 'remoteVideo_div';
      // 生成したdiv要素を追加する
      remoteVideos.appendChild(div);
      const newVideo = document.createElement('video');
      newVideo.srcObject = stream;
      newVideo.playsInline = true;
      // mark peerId to find it later at peerLeave event
      newVideo.setAttribute('class', 'remoteVideos');
      newVideo.setAttribute('data-peer-id', stream.peerId);
      div.append(newVideo);
      const subdiv = document.createElement('div')
      subdiv.setAttribute('id', stream.peerId);
      subdiv.setAttribute('class', 'videoSub');
      div.append(subdiv);
      await newVideo.play().catch(console.error);
    });

    room.on('data', ({ data, src }) => {
      console.log('データ受け取り');
      //チャットor字幕の比較
      var result_num = data.substr( 0, 1 );
      var result_message = data.substr(1);
      //「１」チャットの場合
      if(result_num == '1'){
        console.log('データ受け取り1発火');
        messages.textContent += `${src}: ${result_message}\n`;
      }else
      if(result_num == '2'){
        console.log('データ受け取り2発火');
        var peerID_length = mypeerID.length;
        console.log(`${peerID_length}`);
        var subtext_area = document.getElementById(`${src}`);
        console.log(`${subtext_area}`);
        subtext_area.innerHTML = '';
        subtext_area.innerHTML += result_message.substring(peerID_length); // かきくけこ

        console.log(result_message.substring(result_message));
        console.log(result_message.substring(peerID_length));
      }
    });

    // for closing room members
    room.on('peerLeave', peerId => {
      const remoteVideo = remoteVideos.querySelector(
        `[data-peer-id="${peerId}"]`
      );
      remoteVideo.remove();

      messages.textContent += `=== ${myname} left ===\n`;
    });

    // for closing myself
    room.once('close', () => {
      sendTrigger.removeEventListener('click', onClickSend);
      messages.textContent += '== You left ===\n';
      Array.from(remoteVideos.children).forEach(remoteVideo => {
        remoteVideo.srcObject.getTracks().forEach(track => track.stop());
        remoteVideo.srcObject = null;
        remoteVideo.remove();
      });
    });

    sendTrigger.addEventListener('click', onClickSend);
    leaveTrigger.addEventListener('click', () => room.close(), { once: true });

    function onClickSend() {
      // Send message to all of the peers in the room via websocket
      room.send('1'+localText.value);
      messages.textContent += `${myname} : ${localText.value}\n`;
      localText.value='';

    }
    function onSubSend(subtext) {
      // Send message to all of the peers in the room via websocket
      room.send('2'+mypeerID+subtext);
      localText.value = '';
    }


//^webspeech^^^^^^^webspeech^^^^^webspeech
      (async function(){
        console.log('webspeechAPI準備');
        const speech = new webkitSpeechRecognition();
        speech.lang = 'ja-JP';
        // 音声認識をスタート
        speech.start();
        console.log('音声入力開始');

        //音声自動文字起こし機能
        speech.onresult = function (e) {
            speech.stop();
            if (e.results[0].isFinal) {
              var autotext = e.results[0][0].transcript
              console.log(autotext);
              var speechflg=true;
            }
        }


        speech.onend = () =>
        {
            speech.start()
            console.log('API再起動')
        };
      })();
//webspeech終了時点

  },1000);

  peer.on('error', console.error);
})();
