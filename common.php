<?php

// 安全対策関数
function sanitize($before)
{
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
function call_memberlist()
{
	// 呼び出されるたびにメンバーを追加
	$memberlist[] = "dog";		// dogには会員の名前、ゲストユーザの名前を画面遷移する際に取得
	$memberlist[] = "cat";

	$count = count($memberlist);

	if($count == 1){
		// 部屋を立てたものの名前を先に表示
		print $memberlist[0].'</br>';
	}else{
		// 部屋に入ったものの名前を表示
		print $memberlist[$count-1].'</br>';
	}
	// foreach($memberlist as $value){
		// print $value.'</br>';
	//}

}

?>
