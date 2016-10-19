<?php
ini_set('max_execution_time', 300);

// $fileUrl = $_GET["url"];
$fileUrl = "http://www.betexplorer.com/soccer/england/premier-league-2014-2015/results/";

$sPage = GetPageContent ( $fileUrl );
$sTable = StrFind($sPage, "<table class=\"result-table", "</table>", 1, true);
// echo $sTable;
$sTable = str_replace ( "&nbsp;", "", $sTable );

$doc = new DOMDocument();
$doc->loadXML($sTable);

$xpath = new DOMXPath($doc);
$entries = $xpath->query("/table/tbody/tr");

$con = mysql_connect("127.0.0.1", "root", "") or die(mysql_error());
mysql_select_db("SoccerDB", $con);

foreach ($entries as $entry) {
	$td = $xpath->query("td[1]/a", $entry);
	$teams = $td->item(0)->nodeValue;
	$HomeTeam = trim(strtok($teams, "-"));
	$AwayTeam = trim(strtok("-"));
	if ($HomeTeam == "")
		continue;

	$td = $xpath->query("td[2]/a", $entry);
	$Goals = $td->item(0)->nodeValue;
	$AwayFT = strtok($Goals, ":");
	$HomeFT = strtok(":");
	
	$attr = $xpath->query("td[3]/@data-odd", $entry);
	$HomeOdds = $attr->item(0)->nodeValue;
	$attr = $xpath->query("td[4]/@data-odd", $entry);
	$DrawOdds = $attr->item(0)->nodeValue;
	$attr = $xpath->query("td[5]/@data-odd", $entry);
	$AwayOdds = $attr->item(0)->nodeValue;
	
	$td = $xpath->query("td[6]", $entry);
	$GameDate = $td->item(0)->nodeValue;
	$GameDate = substr($GameDate, 6, 4) . '-' .
	            substr($GameDate, 3, 2) . '-' . substr($GameDate, 0, 2);
	// 01.34.6789
	//echo sprintf("team: %s @ %s, Goal: %s-%s, HomeOdds: %s, GameDate: %s<br>", 
	//		 $AwayTeam, $HomeTeam, $AwayFT, $HomeFT, $HomeOdds, $GameDate);

	$sql= "INSERT INTO `Game`
	(GameDate, AwayTeam, HomeTeam, AwayFT, HomeFT, AwayOdds, DrawOdds, HomeOdds)
	VALUES('$GameDate','$AwayTeam','$HomeTeam',$AwayFT, $HomeFT, $AwayOdds, $DrawOdds, $HomeOdds)";
	
	//echo $sql;
	mysql_query($sql, $con);
}
echo "--Done--";


function StrFind($sSource, $sBeginWith, $sEndWith, $iTh = 1, $bIncludeBeginEnd = TRUE) {
    $result = "";
    $iStartPosition = - 1;
    for($i = 1; $i <= $iTh; $i ++) {
        $iStartPosition = strpos ( $sSource, $sBeginWith, $iStartPosition + 1 );
    }
    if ($iStartPosition < 0)
        return $result;
    $iEndPosition = strpos ( $sSource, $sEndWith, $iStartPosition );
    if ($iEndPosition < 0)
        return $result;

    $debugstr = '';
    $testNested = $sBeginWith . substr ($sSource, $iStartPosition + strlen ( $sBeginWith ), $iEndPosition - $iStartPosition - strlen ( $sBeginWith ) ) . $sEndWith;
    while (substr_count($testNested, $sBeginWith) != substr_count($testNested, $sEndWith)) {
        $iEndPosition = strpos ( $sSource, $sEndWith, $iEndPosition + 1 );
        if ($iEndPosition < 0)
            return "Nested Error!";
        $testNested = $sBeginWith . substr ($sSource, $iStartPosition + strlen ( $sBeginWith ), $iEndPosition - $iStartPosition - strlen ( $sBeginWith ) ) . $sEndWith;
    }
    
    if ($bIncludeBeginEnd) {
        $result = $sBeginWith . substr ($sSource, $iStartPosition + strlen ( $sBeginWith ), $iEndPosition - $iStartPosition - strlen ( $sBeginWith ) ) . $sEndWith;
    } 
    else
        $result = substr ( $sSource, $iStartPosition + strlen ( $sBeginWith ), $iEndPosition - $iStartPosition - strlen ( $sBeginWith ) );
    return $result;
}

function GetPageContent($url) {
	$result = "";
	$file = fopen ( $url, "rb" );
	if (! $file)
		return $result;
	while ( ! feof ( $file ) ) {
		$result .= fread ( $file, 1024 * 8 );
	}

	fclose ( $file );
	return $result;
}

/*
create database SoccerDB;

use SoccerDB;

create table Game 
(
  GameDate varchar(10),
  AwayTeam varchar(50),
  HomeTeam varchar(50),
  AwayFT int,
  HomeFT int,
  AwayOdds decimal(5, 2),
  DrawOdds decimal(5, 2),
  HomeOdds decimal(5, 2)
);

*/

?>