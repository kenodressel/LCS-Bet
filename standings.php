<?php
include("connect.php");
include("header.php");
include("login.php");

function draw() {
	//Userid -> username
	$team = array();
	$abfrage = "SELECT * FROM team ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$team[$row['rID']] = $row['name'];
	}
	//Headerline
	echo "<div id='winline' class='titleline'>
			<div id='rank'>Rank</div>
			<div id='winel'>Team</div>
			<div id='winel'>Wins</div>
			<div id='winel'>Losses</div>
			<div id='winel'>Total</div>
		</div>";
	//Scores
	$abfrage = "SELECT * FROM standings ORDER BY win DESC,lose ASC";
	$erg = mysql_query($abfrage) or die(mysql_error());
	$i = 0;
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$i++;
		echo "<div id='winline'>
				<div id='rank'>".$i.".</div>
				<div id='winel'>".$team[$row['team']]."</div>
				<div id='winel'>".$row['win']."</div>
				<div id='winel'>".$row['lose']."</div>
				<div id='winel'>".($row['win']+$row['lose'])."</div>
			</div>";
			
	}
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
		<?php drawHead("standings") ?>
	</div>
    <div id="main">
	<?php draw() ?>
    </div>
</div>
</body>
</html>
<?php mysql_close(); ?>