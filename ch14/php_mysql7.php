<?php 
	header("Content-Type: text/html; charset=utf-8");
	include("connMysql.inc");
	$seldb = @mysql_select_db("class");
	if (!$seldb) die("資料庫選擇失敗！");
	$sql_query = "SELECT * FROM `students`";
	$result = mysql_query($sql_query);	
	while($row_result=mysql_fetch_assoc($result)){
		foreach($row_result as $item=>$value){
			echo $item."=".$value."<br />";
		}
		echo "<hr />";
	}
?>