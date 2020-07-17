
let localStream;

// カメラ映像取得
navigator.mediaDevices.getUserMedia({video: true, audio: true})
  .then( stream => {
  // 成功時にvideo要素にカメラ映像をセットし、再生
  const videoElm = document.getElementById('my-video')
  videoElm.srcObject = stream;
  videoElm.play();
  // 着信時に相手にカメラ映像を返せるように、グローバル変数に保存しておく
  localStream = stream;
}).catch( error => {
  // 失敗時にはエラーログを出力
  console.error('mediaDevice.getUserMedia() error:', error);
  return;
});
//Peer作成
const peer = new Peer({
  key: '766085bc-041a-4889-ba90-b8fda1a4615f',
  debug: 3
});
//自身のperrIDを取得
peer.on('open', () => {
    document.getElementById('my-id').textContent = peer.id;
});
// 発信処理
document.getElementById('make-call').onclick = () => {
  const theirID = document.getElementById('their-id').value;
  const mediaConnection = peer.call(theirID, localStream);
  setEventListener(mediaConnection);
};
// イベントリスナを設置する関数
const setEventListener = mediaConnection => {
  mediaConnection.on('stream', stream => {
    // video要素にカメラ映像をセットして再生
    const videoElm = document.getElementById('their-video')
    videoElm.srcObject = stream;
    videoElm.play();
    window.alert('通信に成功');
  });
}
//着信処理
peer.on('call', mediaConnection => {
  mediaConnection.answer(localStream);
  setEventListener(mediaConnection);
  window.alert('通信に成功');
});
peer.on(Peer.EVENTS.close, () => {
  window.alert('通信が切断しました。');
});
