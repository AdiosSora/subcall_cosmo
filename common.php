<?php

// 安全対策関数
function sanitize($before)
{
		$after = null;
	foreach($before as $key=>$value)
	{
		$after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
	}
	return $after;
}

// 言語選択
function pulldown_language()
{
	print '<select name="langiage">';
	print '<option value="ja">日本語</option>';
	print '<option value="english">英語</option>';
	print '</select>';
}

// join.phpよりメンバーリスト呼び出し用
function call_memberlist($guestname)
{
	// 呼び出されるたびにメンバーを追加
	$memberlist[] = $guestname;		// dogには会員の名前、ゲストユーザの名前を画面遷移する際に取得

	$count = count($memberlist);
	if($count == 1){
		// 部屋を立てたものの名前を先に表示
		if($memberlist[0] == null){
			// ニックネームなしの場合
			print 'ゲスト様'.$count.'</br>';
		}else{
			// ニックネームありの場合
			print $memberlist[0].'</br>';
		}
	}else{
		// 部屋に入ったものの名前を表示
		if($memberlist[$count-1] == null){
			// ニックネームなし
			print 'ゲスト様'.$count.'</br>';
		}else{
			// ニックネームあり
			print $memberlist[$count-1].'</br>';
		}
	}

}

?>
