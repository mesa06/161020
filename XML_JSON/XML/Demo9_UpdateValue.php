<?php
$xmlString = '<employees>
                   <employee EmpType="SalesManager">
                     <lastName>Cashman</lastName>
                     <firstName>Briant</firstName>
                   </employee>
                 </employees>';
$doc = new DOMDocument();
$doc->preserveWhiteSpace=false;
$doc->loadXML($xmlString);
$root = $doc->documentElement;
$root->setAttribute("id", "001");

header("Content-type: text/xml", true);
echo $doc->saveXML();
?>
