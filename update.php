<?php
include("connect.php");

function update() {
	$abfrage = "SELECT * FROM `update` ORDER BY id";
	$erg = mysql_query($abfrage);
	$done = false;
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){ 
		if($row['name'] == "winner" && $row['ts']+300 < time()) {
			updateWinner($row['tID']);
			$done = true;
		} elseif($row['name'] == "highscore" && $row['ts']+300 < time()) {
			updateHighscore();
			$done = true;
		} elseif($row['name'] == "vod" && $row['ts']+900 < time()) {
			updateVod($row['tID']);
			$done = true;
		} elseif($row['name'] == "standings" && $row['ts']+900 < time()) {
			updateStandings();
			$done = true;
		}
	}
	
	if($done) {
		return 1;
	} else {
		return 0;
	}
}

function updateWinner($start) {
	while($start < 1912) {
		$jGameStr = 'http://na.lolesports.com/api/match/'.$start.'.json';
		$jGameData = file_get_contents($jGameStr);
		$jGameArr = json_decode($jGameData,true);
		if($jGameArr["winnerId"] != "") {
			$team = $jGameArr["winnerId"];
			$id = $jGameArr["winnerId"];
			$eintrag = "UPDATE spiele SET wt='$team' WHERE id = '$start'";
			$update = mysql_query($eintrag);
		} else {
			break;
		}
		$start++;
	}
	
	$ts = time();
	$eintrag = "UPDATE `update` SET ts='$ts', tID='$start' WHERE name = 'winner'";
	$update = mysql_query($eintrag);
}

function updateHighscore() {
	/* 
	 * This function updates the database,
	 * for a few users its totally legit to call it every time
	 * but it seems a bit unnecessary to call it that often
	 * feel free to implement a better solution :)
	*/ 
	$spiele = array();
	$abfrage = "SELECT * FROM spiele ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){ //Get the winner team
		$spiele[$row['id']] = $row['wt'];
	}
	
	$abfrage = "SELECT * FROM user WHERE id > '1'"; //Do not list the admin
	
	$erg = mysql_query($abfrage) or die(mysql_error());
	while($urow = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$uid = $urow['id'];
		$abfrage = "SELECT * FROM tipp WHERE user = '$uid' ORDER BY id";
		$erg2 = mysql_query($abfrage);
		//reset
		$winscore = 0;
		$losescore = 0;
		$rest = 0;
		while($row = mysql_fetch_array($erg2, MYSQL_ASSOC)){ //Calculate the data
			if($spiele[$row['id_sp']] == $row['team']) {
				$winscore++;
			} elseif($spiele[$row['id_sp']] != 0) {
				$losescore++;
			} else {
				$rest++;
			}
		}
		$score = $winscore + $losescore + $rest;
		//Update the database
		$eintrag = "UPDATE score SET win='$winscore', lose='$losescore', ges='$score' WHERE user = '$uid'";
		$update = mysql_query($eintrag);
		
	}
	$ts = time();
	$eintrag = "UPDATE `update` SET ts='$ts' WHERE name = 'highscore'";
	$update = mysql_query($eintrag);
}

function updateVod($ts) {
	
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
			$pattern = "/^(?!Highlight.*)(.*) vs (.*) EU LCS Week (\d) Season \d .* \d{4} .*/s";
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
	$ts = time();
	$eintrag = "UPDATE `update` SET ts='$ts', tID='$first' WHERE name = 'vod'";
	$update = mysql_query($eintrag);
}

function updateStandings() {
	$abfrage = "SELECT * FROM team ORDER BY id";
	$erg = mysql_query($abfrage);
	while($Trow = mysql_fetch_array($erg, MYSQL_ASSOC)){ //Get the teams
		$id = $Trow['rID'];
		$winscore = 0;
		$losescore = 0;
		$abfrage2 = "SELECT * FROM spiele WHERE ((t1='$id') || (t2='$id')) AND wt <> 0"; //Get all games where the team played
		$erg2 = mysql_query($abfrage2) or die(mysql_error());
		while($Grow = mysql_fetch_array($erg2, MYSQL_ASSOC)){
			if($id == $Grow['wt']) {
				$winscore++;
			} else {
				$losescore++;
			}
			//Update the database
			$eintrag = "UPDATE standings SET win='$winscore', lose='$losescore' WHERE team = '$id'";
			$update = mysql_query($eintrag);
			
		}
	}
	
	$ts = time();
	$eintrag = "UPDATE `update` SET ts='$ts' WHERE name = 'standings'";
	$update = mysql_query($eintrag);
}
