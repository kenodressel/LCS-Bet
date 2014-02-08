<?php

include("connect.php");
include("header.php");

if(isset($_POST["user"])) { //user tries to login
	$user = $_POST["user"];
	$abfrage = "SELECT * FROM user WHERE name = '$user'";
	$erg = mysql_query($abfrage);
	
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)) { //only triggers if valid username
		if(md5($_POST["pw"]) == $row["pw"]) {//md5 password
			$_SESSION['login'] = true;
			$_SESSION['name'] = $row['name'];
			$_SESSION['uid'] = $row['id'];
			$_SESSION['spoiler'] = $row['spoiler'];
			$_SESSION['theme'] = $row['theme'];
		} else { //failed login, no notification yet
			$_SESSION['login'] = false;	
		}
	}
}
//logout
if(isset($_POST["logout"])) {
	session_destroy();
}

function draw() {
	//Teams
	$teams = array();
	$abfrage = "SELECT * FROM team ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$teams[$row['rID']] = $row['name'];
	}
	
	//Tipps
	if(isset($_SESSION['uid']) && $_SESSION['uid'] > 1) { //only get tipps, if the user is logged in and is not the admin
		$userid = $_SESSION['uid'];
		$abfrage = "SELECT * FROM tipp WHERE user = '$userid' ORDER BY id";
		$erg = mysql_query($abfrage);
		while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
			$tippteam[$row['id_sp']] = $row['team'];
			$tippid[$row['id_sp']] = $row['id'];
		}
	}
	
	//Time
	$spiele = false; //did a game happen?
	if(date("N",time()) == 7) {
		$TS = time();
	} else {
		$TS = strtotime("last Sunday");
	}
	$zeitraum = strtotime("next Sunday");
	if(isset($_GET['w'])) { //is a week selected
		$woche = $_GET['w'];
		$abfrage = "SELECT * FROM zeit WHERE week = '$woche' ORDER BY timestamp";
	} else {
		$abfrage = "SELECT * FROM zeit WHERE timestamp BETWEEN ".$TS." AND ".$zeitraum." ORDER BY timestamp";
	}
	$erg = mysql_query($abfrage);
	
	$first = 0;
	
	while($timerow = mysql_fetch_array($erg, MYSQL_ASSOC)) {
		if($first == 0) {
			//All Weeks Header
			echo "<div class='weekselect'>
					<form name='ws' action='".$_SERVER['PHP_SELF']."' method='get'>";
						for($a = 1; $a < 12;$a++) {
							if(isset($_GET['w']) && $_GET['w'] == $a) {
								$thisWeek = "dW";
							} elseif($timerow["week"] == $a) {
								$thisWeek = "dW";
							} else {
								$thisWeek = "";
							}
							echo "<input class='weekselectinput ".$thisWeek."' type='submit' value='".$a."' name='w' />";
						}
			echo 		"</form>
				</div>";
			$first++;
		}
		for($i = 1; $i <= $timerow['tage']; $i++) {
			//Weekhead
			echo '<div id="headlist">
				<div class="weekhead">Week '.$timerow['week'].' Day '.$i.' ('.date("d.m.Y",$timerow['timestamp']+86400*($i-1)).')</div>
				<div class="team locked">Team 1</div>
				<div class="vs">&nbsp;</div>
				<div class="team locked">Team 2</div>
				<div class="zeit">Time</div>
				<div class="vod">VoD</div>
			</div>';
			$today = $timerow['timestamp']-15000+86400*($i-1); //-15000 for earlier games
			$tomorrow = $today + 40000;//avoid overlapping game times on the next day
			$abfrage2 = "SELECT * FROM spiele WHERE ts BETWEEN '$today' AND '$tomorrow' ORDER BY ts"; //Get the games of the week
			$erg2 = mysql_query($abfrage2);
			$x = 0;
			echo "<div id='weekgames'>";
			while($row = mysql_fetch_array($erg2, MYSQL_ASSOC)) {
				$spiele = true; //a game happend!
				//reset
				$tippT = 0;
				$aktiv1 = 0;
				$aktiv2 = 0;
				$class1 = "";
				$class2 = "";
				
				if(isset($_SESSION['uid']) && $_SESSION['uid'] != -1) { //user logged in?
					if($tippid[$row['id']] != 0 && $tippteam[$row["id"]] == $row["t1"]) { //is team1 the tipped team?
						$aktiv1 = 1;
						$class1 = "derTipp";
						$tippT = $tippid[$row["id"]]; //give the tippid
					} elseif($tippid[$row['id']] != 0 && $tippteam[$row["id"]] == $row["t2"]) {
						$aktiv2 = 1;
						$class2 = "derTipp";
						$tippT = $tippid[$row["id"]];
					}
					if($row["t1"] == $row["wt"] && $_SESSION['spoiler'] == 0) { //the tip was right
						$class1 .= " win";
						$class2 .= " lose";
					} else if($row["t2"] == $row["wt"] && $_SESSION['spoiler'] == 0) { //the tip was wrong
						$class1 .= " lose";
						$class2 .= " win";
					}
				} else { //user is not logged in
					$_SESSION['uid'] = -1; 
				}
				echo "<div id='gamewrap'>";
				if($row['ts'] < time()) { //Is the game already over? --> deactivate tipp
					echo "<div class='team ".$class1." locked' id='".$row["id"].$row["t1"]."'>".$teams[$row["t1"]]."</div>";
				} else { //the game is still active
					echo "<div class='team hover ".$class1."' id='".$row["id"].".".$row["t1"]."' onclick='tipp(".$row["id"].",".$row["t1"].",".$row["t2"].",".$aktiv1.",".$tippT.",".$_SESSION['uid'].")'>".$teams[$row["t1"]]."</div>";
				}
				echo "<div class='vs'>vs</div>";
				if($row['ts'] < time()){
					echo "<div class='team ".$class2." locked' id='".$row["id"].$row["t2"]."'>".$teams[$row["t2"]]."</div>";
				} else {
					echo "<div class='team hover ".$class2."' id='".$row["id"].".".$row["t2"]."' onclick='tipp(".$row["id"].",".$row["t2"].",".$row["t1"].",".$aktiv2.",".$tippT.",".$_SESSION['uid'].")'>".$teams[$row["t2"]]."</div>";
				}
				//echo time
				echo "<div class='zeit'>".date("H:i",$row['ts'])."</div>";
				echo "<div class='vod'>";
				if($row["vod"] != "") {
					echo "<a target='_blank' href='".$row["vod"]."'>Youtube</a>";
				}
				echo "</div>";
				echo "</div>";
				$x++;
			}
			echo "</div>";
		}
	}
	if(!$spiele) { //no active games
			//All week header
			echo "<div class='weekselect'>
					<form name='login' action='".$_SERVER['PHP_SELF']."' method='get'>";
						for($a = 1; $a < 12;$a++) {
							if(isset($_GET['w']) && $_GET['w'] == $a) {
								$thisWeek = " dW";
							} else {
								$thisWeek = "";
							}
							echo "<input class='weekselectinput".$thisWeek."' type='submit' value='".$a."' name='w' />";
						}
			echo 		"</form>
				</div>";
			echo "<div class='fullspan'>\n";
			echo "<span style='font-size:16px; color:#707070'>Diese Woche keine Spiele</span>\n";
			echo "</div>";
	}
}

if ($_POST) {
	header("Location: " . $_SERVER['REQUEST_URI']);
	exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php include("meta.php"); ?>
</head>
<body onload="runUpdate()">
<div id="wrapper">
	<div id="header">
	<?php drawHead("main"); ?>
	</div>
    <div id="main">
	<?php draw() ?>
    </div>
</div>
<div id="successTip" style="display:none" onclick="display(this)">
	<span class="successTipText">Tipp #<span id="tipnr"></span> gespeichert</span>
</div>
</body>
</html>
<?php mysql_close(); ?>