<?php
header('Content-type: application/json; charset=utf-8');

$dbh = get_DBobj();
$dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

$sql = 'SELECT number FROM account WHERE name=?';
$stmt = $dbh->prepare($sql);
$data[] = filter_input( INPUT_GET, 'id' );
$stmt->execute($data);

$rec = $stmt->fetch(PDO::FETCH_ASSOC);
$param = $rec;
$dbh = null;

echo json_encode( $param ); //JSON形式に変換してから返す
?>
