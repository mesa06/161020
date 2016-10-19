<?php
$doc = new DOMDocument("1.0", "utf-8");
$root = $doc->createElement("HTML");
$root2 = $doc->createElement("CSS");
$doc->appendChild($root);
$root->appendChild($root2);
echo htmlspecialchars($doc->c14n());
?>
