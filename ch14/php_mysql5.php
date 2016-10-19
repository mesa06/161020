<?php
	header("Content-Type: text/html; charset=utf-8");
	include("connMysql.inc");
	$seldb = "class";
	$sql_query = "SELECT * FROM `students`";
	$result = mysql_db_query($seldb,$sql_query);
?>