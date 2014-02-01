<?
//includes
session_start();
include("connect.php");

//Make sure, the only user that can access the page is the admin
if(!(isset($_SESSION["uid"])) && !($_SESSION["uid"] == 1)) {
	header("Location: index.php");
	die();
}

//Draw the table
function draw() {
	//Teams
	$teams = array();
	$abfrage = "SELECT * FROM team ORDER BY id";
	$erg = mysql_query($abfrage);
	//Create array to associate team names with ids
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$teams[$row['id']] = $row['name'];
	}
	
	//Header
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
	
	
	
	//Zeit
	$TS = strtotime("last Sunday");
	$zeitraum = strtotime("next Sunday");
	//is a week selected?
	if(isset($_GET['w'])) {
		$woche = $_GET['w'];
		$abfrage = "SELECT * FROM zeit WHERE week = '$woche' ORDER BY timestamp";
	} else {
		$abfrage = "SELECT * FROM zeit WHERE timestamp BETWEEN ".$TS." AND ".$zeitraum." ORDER BY timestamp";
	}
	$erg = mysql_query($abfrage);
	$spiele = false; //are there any games happening this week?
	
	while($timerow = mysql_fetch_array($erg, MYSQL_ASSOC)) {
		
		for($i = 1; $i <= $timerow['tage']; $i++) {
			//Head of the Week
			echo '<div id="headlist">
				<div class="weekhead">Week '.$timerow['week'].' Tag '.$i.' ('.date("d.m.Y",$timerow['timestamp']+86400*($i-1)).')</div>
				<div class="team locked">Team 1</div>
				<div class="vs">&nbsp;</div>
				<div class="team locked">Team 2</div>
				<div class="zeit">Uhrzeit</div>
			</div>';
			$week = $timerow['week']; //Get the current week
			$day = $i; //Get the current day
			$abfrage2 = "SELECT * FROM spiele WHERE week = '$week' AND day = '$day' ORDER BY timestamp";
			$erg2 = mysql_query($abfrage2);
			$x = 0;
			echo "<div id='weekgames'>";
			while($row = mysql_fetch_array($erg2, MYSQL_ASSOC)) { //Games
				$spiele = true; //A game happend
				//Resets
				$tippT = 0;
				$aktiv1 = 0;
				$aktiv2 = 0;
				$class1 = "";
				$class2 = "";
				//is a winner selected?
				if($row['t1'] == $row["wt"]) {
					$aktiv1 = 1;
					$class1 = "derTipp";
				} elseif($row['t2'] == $row["wt"]) {
					$aktiv2 = 1;
					$class2 = "derTipp";
				}
				echo "<div id='gamewrap'>";
				echo "<div class='team ".$class1."' id='".$row["id"].".".$row["t1"]."' onclick='win(".$row["id"].",".$row["t1"].",".$row["t2"].",".$aktiv1.")'>".$teams[$row["t1"]]."</div>";
				echo "<div class='vs'>vs</div>";
				echo "<div class='team ".$class2."' id='".$row["id"].".".$row["t2"]."' onclick='win(".$row["id"].",".$row["t2"].",".$row["t1"].",".$aktiv2.")'>".$teams[$row["t2"]]."</div>";
				echo "<div class='zeit'>".date("H:i",$timerow['timestamp']+3600*$x)."</div>";
				echo "</div>";
				$x++;
			}
			echo "</div>";
		}
	}
	if(!$spiele) { //No games this week?
			echo "<div class='fullspan'>\n";
			echo "<span style='font-size:16px; color:#707070'>Diese Woche keine Spiele</span>\n";
			echo "</div>";
	}
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Roboto:700,500,400,300,100" rel="stylesheet" type="text/css">
<script src="js.js" type="text/javascript"></script>
<title>LCS TippSpiel</title>
</head>
<body>
<div id="wrapper">
	<div id="header">
	</div>
    <div id="main">
	<?php draw() ?>
    </div>
</div>
</body>
</html>
<?php mysql_close(); ?>