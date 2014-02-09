<?php
include("connect.php");
include("header.php");
include("login.php");

function draw() {
	//Userid -> username
	$user = array();
	$abfrage = "SELECT * FROM user ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$user[$row['id']] = $row['name'];
	}
	//Headerline
	echo "<div id='winline' class='titleline'>
			<div id='rank'>Rank</div>
			<div id='winel'>User</div>
			<div id='winel'>Correct</div>
			<div id='winel'>Wrong</div>
			<div id='winel'>Total</div>
		</div>";
	//Scores
	$abfrage = "SELECT * FROM score ORDER BY win DESC,lose ASC";
	$erg = mysql_query($abfrage) or die(mysql_error());
	$i = 0;
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$i++;
		echo "<div id='winline' class='$class'>
				<div id='rank'>".$i.".</div>
				<div id='winel'>".$user[$row['user']]."</div>
				<div id='winel'>".$row['win']."</div>
				<div id='winel'>".$row['lose']."</div>
				<div id='winel'>".$row['ges']."</div>
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
		<?php drawHead("score") ?>
	</div>
    <div id="main">
	<?php draw() ?>
    </div>
</div>
</body>
</html>
<?php mysql_close(); ?>