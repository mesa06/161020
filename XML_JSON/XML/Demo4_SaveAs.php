<?php
$doc = new DOMDocument();
$doc->load("employees.xml");
$doc->save("/tmp/employees_bak.xml");
echo "<br>-- Done --";
?>
