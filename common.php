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



?>
