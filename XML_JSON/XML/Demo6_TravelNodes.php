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

$root = $doc->documentElement; // 根元素
$nodes = $root->childNodes;    // 取得根元素的子元素
// 遍歷節點列表
foreach ($nodes as $node)
{
	if ($node->nodeType == XML_ELEMENT_NODE)
	{
		if($node->tagName == "employee")
		{
			echo "EmpType : " . $node->getAttribute("EmpType") .  "<br>";
			echo $node->firstChild->nodeName . " : " .
			$node->firstChild->nodeValue .  "<br>";
			echo $node->lastChild->nodeName . " : " .
			$node->lastChild->nodeValue .  "<HR>";
			
		}
	}
}
?>

</body>
</html>
