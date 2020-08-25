<?php

  function get_DBobj(){
    $dsn = 'mysql:dbname=subcall;host=localhost;charset=utf8';
  	$user = 'root';
  	$password = 'kcsf';
  	return new PDO($dsn,$user,$password);
  }
?>
