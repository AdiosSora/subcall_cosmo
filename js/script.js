/* eslint-disable require-jsdoc */
$(function() {
  // Peer object
  let memPeerid
  let login_FLG=document.getElementById('login_FLG').value;//TODO　起動時にログインセッションfalse の作成


  if(login_FLG=='true'){ //ログイン確認 TODO(PEERIDがundefindになる事象の修正)
    console.log("loginが完了しています.");
    memPeerid = document.getElementById('memberPeer').value;
    console.log(memPeerid)
  }
  else{
    console.log("loginが完了していません");
    var N=16
    memPeerid = Math.random().toString(36).slice(-8);
  }

  const peer = new Peer(memPeerid,{
    key: '766085bc-041a-4889-ba90-b8fda1a4615f',
    debug: 3,
  });
  console.log('peerIDは'+memPeerid);

  const userName=document.getElementById('name');
  const localText = document.getElementById('chat-textarea');
  const messages = document.getElementById('chat-text');
  const sub_messages = document.getElementById('sub-text');
  var bg_chat_color = 0;
  var bg_voicechat_color = 0;

  let localStream;
  let room;

  //peerを確立
  peer.on('open', () => {
    $('#my-id').text(peer.id);
    step1();
  });

  //接続に問題があった場合
  peer.on('error', err => {
    alert(err.message);
    // Return to step 2 if error occurs
    step2();
  });

  //ルーム入室ボタンが押された場合
  setTimeout(function() {
    const roomName = $('#join-room').val();
    room = peer.joinRoom('sfu_video_' + roomName, {
      mode: 'sfu',
      stream: localStream
    });

    $('#room-id').text(roomName);
    step3();
    step4();
  },2000);

  //ルーム退出ボタンが押された場合
  $('#end-call').on('click', () => {
    chatText='3'+userName.value+"<name>が退室しました。";
    room.send(chatText);
    room.close();
    step2();
  });

  //再接続ボタンが押された場合
  $('#step1-retry').on('click', () => {
    $('#step1-error').hide();
    step1();
  });

  //チャット送信ボタンが押された場合
  $('#btn-send').on('click', () => {
    onClickSend();
  });

  //チャット送信関数
  function onClickSend() {
    if(localText.value!=''){
      console.log('チャット送信');

      chatText='1'+userName.value+"<name>"+localText.value;
      room.send(chatText);

      $("#chat-text").prepend($(
        '<div class="msg_content bg-' + bg_chat_color + ' self-chat">' +
        '<div class="msg-icon"><img src="../images/icon2.png"></div>' +
        '<div class="msg-text">' +
        '<div class="msg-name"><strong>' + userName.value + '</strong></div>'+
        '<div class="msg-content">' + localText.value + '</div>' +
        '<div class="msg-date">' + getNow() + '</div>' +
        '</div></div>'));
      (bg_chat_color==0)?bg_chat_color=1:bg_chat_color=0;
      localText.value='';
    }
  }

  //字幕送信関数
  function onSubSend(subtext) {
    // Send message to all of the peers in the room via websocket
  console.log('字幕送信');
        chatText='2'+userName.value+"<name>"+subtext;
        room.send(chatText);

        $("#sub-text").prepend($(
          '<div class="msg_content bg-' + bg_voicechat_color + 'self-chat">' +
          '<div class="msg-icon"><img src="../images/icon1.png"></div>' +
          '<div class="msg-text">' +
          '<div class="msg-name"><ion-icon name="volume-high-outline"></ion-icon><strong>' + userName.value + '</strong></div>'+
          '<div class="msg-content">' + subtext + '</div>' +
          '<div class="msg-date">' + getNow() + '</div>' +
          '</div></div>'));
        (bg_voicechat_color==0)?bg_voicechat_color=1:bg_voicechat_color=0;
  }

  //使用するビデオとオーディオを選択するための定数
  const audioSelect = $('#audioSource');
  const videoSelect = $('#videoSource');
  const selectors = [audioSelect, videoSelect];

  //デバイス選択処理
  navigator.mediaDevices.enumerateDevices()
    .then(deviceInfos => {
      const values = selectors.map(select => select.val() || '');
      selectors.forEach(select => {
        const children = select.children(':first');
        while (children.length) {
          select.remove(children);
        }
      });

      for (let i = 0; i !== deviceInfos.length; ++i) {
        const deviceInfo = deviceInfos[i];
        const option = $('<option>').val(deviceInfo.deviceId);

        if (deviceInfo.kind === 'audioinput') {
          option.text(deviceInfo.label ||
            'Microphone ' + (audioSelect.children().length + 1));
          audioSelect.append(option);
        } else if (deviceInfo.kind === 'videoinput') {
          option.text(deviceInfo.label ||
            'Camera ' + (videoSelect.children().length + 1));
          videoSelect.append(option);
        }
      }

      selectors.forEach((select, selectorIndex) => {
        if (Array.prototype.slice.call(select.children()).some(n => {
            return n.value === values[selectorIndex];
          })) {
          select.val(values[selectorIndex]);
        }
      });

      videoSelect.on('change', step1);
      audioSelect.on('change', step1);
    });

  //デバイスの指定とローカルストリームの取得を行う関数
  function step1() {
    // Get audio/video stream
    const audioSource = $('#audioSource').val();
    const videoSource = $('#videoSource').val();
    const constraints = {
      audio: {deviceId: audioSource ? {exact: audioSource} : undefined},
      video: {deviceId: videoSource ? {exact: videoSource} : undefined},
    };
    navigator.mediaDevices.getUserMedia(constraints).then(stream => {
      $('#my-video').get(0).srcObject = stream;
      localStream = stream;

      if (room) {
        room.replaceStream(stream);
        return;
      }

      step2();
    }).catch(err => {
      $('#step1-error').show();
      console.error(err);
    });
  }

  //ルーム入室時の初期化関数
  function step2() {
    $('#their-videos').empty();
    $('#step1, #step3').hide();
    $('#step2').show();
    $('#join-room').focus();
  }

  //ルーム内のリスナーを設定している関数
  function step3() {
    // Wait for stream on the call, then set peer video display
    room.on('stream', stream => {
      const peerId = stream.peerId;
      const id = 'video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '');

      $('#their-videos').append($(
        '<div class="remoteVideo_div video_' + peerId +'" id="' + id + '">' +
          '<label>' + stream.peerId + ':' + stream.id + '</label>' +
          '<video class="remoteVideos" autoplay playsinline>' +
          '<p class="subtext_field"></p>' +
        '</div>'));
      const el = $('#' + id).find('video').get(0);
      el.srcObject = stream;
      el.play();
    });

    room.on('removeStream', function(stream) {
      const peerId = stream.peerId;
      $('#video_' + peerId + '_' + stream.id.replace('{', '').replace('}', '')).remove();
    });

    // UI stuff
    room.on('close', () => {
      chatText='3'+userName.value+"<name>が退室しました。";
      room.send(chatText);
      step2();
    });

    room.once('open', () => {
      $("#chat-text").prepend($(
        '<div class="msg_content bg-' + bg_chat_color + ' other-chat">' +
        '<div class="msg-icon"><img src="../images/icon_system.png"></div>' +
        '<div class="msg-text">' +
        '<div class="msg-name"><strong>システム</strong></div>'+
        '<div class="msg-content">あなたが入室しました。</div>' +
        '<div class="msg-date">' + getNow() + '</div>' +
        '</div></div>'));
        chatText='3'+userName.value+"<name>が入室しました。";
        room.send(chatText);
    });

    room.on('data', ({ data, src }) => {
      console.log('データ受け取り');
      //チャットor字幕の比較

      var result_num = data.substr( 0, 1 );
      var result_message = data.substr(data.indexOf('<name>'));
      var result_name=data.slice(1,data.indexOf('<name>'));
      //「１」チャットの場合
      if(result_num == '1'){
        console.log('データ受け取り1発火');
        $("#chat-text").prepend($(
          '<div class="msg_content bg-' + bg_chat_color + ' other-chat">' +
          '<div class="msg-icon"><img src="../images/icon1.png"></div>' +
          '<div class="msg-text">' +
          '<div class="msg-name"><strong>' + `${result_name}` + '</strong></div>'+
          '<div class="msg-content">' + `${result_message}\n` + '</div>' +
          '<div class="msg-date">' + getNow() + '</div>' +
          '</div></div>'));
          (bg_chat_color==0)?bg_chat_color=1:bg_chat_color=0;
      }else
      if(result_num == '2'){
        console.log('データ受け取り2発火');
        $("#sub-text").prepend($(
          '<div class="msg_content bg-' + bg_voicechat_color + ' other-chat">' +
          '<div class="msg-icon"><img src="../images/icon1.png"></div>' +
          '<div class="msg-text">' +
          '<div class="msg-name"><ion-icon name="volume-high-outline"></ion-icon><strong>' + `${result_name}` + '</strong></div>'+
          '<div class="msg-content">' + `${result_message}\n` + '</div>' +
          '<div class="msg-date">' + getNow() + '</div>' +
          '</div></div>'));
          (bg_voicechat_color==0)?bg_voicechat_color=1:bg_voicechat_color=0;
      }else
      if(result_num == '3'){
      $("#chat-text").prepend($(
        '<div class="msg_content bg-' + bg_chat_color + ' other-chat">' +
        '<div class="msg-icon"><img src="../images/icon_system.png"></div>' +
        '<div class="msg-text">' +
        '<div class="msg-name"><strong>システム</strong></div>'+
        '<div class="msg-content">' +  `${result_name}` + `${result_message}\n` + '</div>' +
        '<div class="msg-date">' + getNow() + '</div>' +
        '</div></div>'));
      }
    });


    room.on('peerLeave', peerId => {
      $('.video_' + peerId).remove();
    });

    $('#step1, #step2').hide();
    $('#step3').show();
  }

  //音声認識を自動で行う関数
  function step4(){
    const speech = new webkitSpeechRecognition();
    speech.lang = 'ja-JP';
    speech.start();

    console.log('認識スタート');

    speech.onresult = function (e) {
      console.log('認識完了');
        speech.stop();
        if (e.results[0].isFinal) {
          var autotext = e.results[0][0].transcript

          //文字識別結果
          console.log(e);
          console.log(autotext);
          onSubSend(autotext)
        }
    }

    speech.onend = () => {

      console.log('認識再開');
        speech.start()
    };
  }
  //時分を出力する関数
  function getNow() {
  	var now = new Date();
  	var hour = now.getHours();
  	var min = now.getMinutes();
  	var s =hour + ":" + min;
  	return s;
  }

});
