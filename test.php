<?php
$ts = 0;
include("connect.php");
$teams = array();
$abfrage = "SELECT * FROM team ORDER BY id";
$erg = mysql_query($abfrage);
while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
	$teams[$row['name']] = $row['rID'];
}

$jYtStr = 'http://gdata.youtube.com/feeds/api/users/Kazawuna/uploads?alt=json&orderby=published&v=2&max-results=1';
$jYtData = file_get_contents($jYtStr);
$jYtArr = json_decode($jYtData,true);
$first = strtotime($jYtArr["feed"]["entry"][0]["published"]['$t']);
if($first != $ts) {
	$jYtStr = 'http://gdata.youtube.com/feeds/api/users/Kazawuna/uploads?alt=json&orderby=published&v=2';
	$jYtData = file_get_contents($jYtStr);
	$jYtArr = json_decode($jYtData,true);
	
	foreach($jYtArr["feed"]["entry"] AS $feedEl) {
		$ergArr = array();
		$str = $feedEl["title"]['$t'];
		echo $str."<br>";
		$pattern = "/^(?!Highlight.*)Full Game - (.*) vs (.*) EU LCS Week (\d) Season \d .* \d{4} .*/s";
		if(preg_match($pattern,$str,$ergArr) == 1) {
			$t1 = $teams[$ergArr[1]];
			$t2 = $teams[$ergArr[2]];
			$week = $ergArr[3];
			$abfrage = "SELECT * FROM spiele WHERE week='$week' AND ((t1='$t1' AND t2='$t2') || (t1='$t2' AND t2='$t1')) ORDER BY id";
			echo $abfrage."<br>";
			$erg = mysql_query($abfrage);
			while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
				$vod = $feedEl["link"][0]["href"];
				$id = $row['id'];
				$eintrag = "UPDATE spiele SET vod='$vod' WHERE id = '$id'";
				echo $eintrag."<br><br>";
				$update = mysql_query($eintrag);
			}
		}
	}
}
?>