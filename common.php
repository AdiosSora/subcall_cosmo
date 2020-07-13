<?php
<<<<<<< HEAD

// 安全対策関数
=======
>>>>>>> 881bfa53084d72f62bf878e8682019184be9c8eb
function sanitize($before)
{
	foreach($before as $key=>$value)
	{
		$after[$key] = htmlspecialchars($value,ENT_QUOTES,'UTF-8');
	}
	return $after;
}
<<<<<<< HEAD

// 言語選択
function pulldown_language()
{
	print '<select name="langiage">';
	print '<option value="ja">日本語</option>';
	print '<option value="english">英語</option>';
	print '</select>';
}



=======
>>>>>>> 881bfa53084d72f62bf878e8682019184be9c8eb
?>
