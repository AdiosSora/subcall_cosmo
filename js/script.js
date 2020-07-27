const Peer = window.Peer;

(async function main() {
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
  const guestname = document.getElementById('js-guest-name').innerHTML;
  var remotevideoId = 0
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
  const peer = (window.peer = new Peer({
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
      messages.textContent += '=== You joined ===\n';
    });
    room.on('peerJoin', peerId  => {
      messages.textContent += `=== ${peer.metadata.nickname}  joined ===\n`;
    });

    // Render remote stream for new peer join in the room
    room.on('stream', async stream => {
      // div要素を生成
      const div = document.createElement('div');
      // classを追加
      div.className = 'remoteVideo_div';
      div.setAttribute('data-peer-id', stream.peerId);
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
      subdiv.setAttribute('class', 'videoSub');
      div.append(subdiv);
      await newVideo.play().catch(console.error);
    });

    room.on('data', ({ data, src }) => {
      // Show a message sent to the room and who sent
      messages.textContent += `${src}: ${data}\n`;
    });

    // for closing room members
    room.on('peerLeave', peerId => {
      const remoteVideo = remoteVideos.querySelector(
        `[data-peer-id="${peerId}"]`
      );
      remoteVideo.remove();

      messages.textContent += `=== ${guestname} left ===\n`;
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
      room.send(localText.value);

      messages.textContent += `${peer.nickname}: ${localText.value}\n`;
      localText.value = '';
    }
  },1000);

  peer.on('error', console.error);
})();
