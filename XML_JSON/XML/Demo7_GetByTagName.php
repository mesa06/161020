<!DOCTYPE HTML>
<html lang="zh-TW">
<head>
<meta charset="utf-8">
<title>PHP Sample</title>
</head>
<body>
<?php
$doc = new DOMDocument();
$doc->preserveWhiteSpace=false;
$doc->load("employees.xml");

// 找出標籤名稱為 employee 的元素
$employeeNodeList = $doc->getElementsByTagName("employee");
foreach ($employeeNodeList as $node)
{
	echo $node->getAttribute("EmpType") .  "<br>";
	echo $node->firstChild->nodeName . " : " .
	$node->firstChild->nodeValue .  "<br>";
	echo $node->lastChild->nodeName . " : " .
	$node->lastChild->nodeValue .  "<HR>";
}
?>

</body>
</html>
