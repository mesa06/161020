<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>PHP Sample</title>
</head>
<body>
View html souce please: <HR>
<?php
$doc = new DOMDocument();
$doc->load("employees.xml");
echo $doc->c14n();
?>

</body>
</html>
