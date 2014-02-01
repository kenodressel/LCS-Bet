<?php
include("connect.php");

function draw() {

	//Userid -> username
	$user = array();
	$abfrage = "SELECT * FROM user ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$user[$row['id']] = $row['name'];
	}
	//Headerline
	echo "<div id='winline'>
			<div id='winel'>User</div>
			<div id='winel'>Richtig</div>
			<div id='winel'>Falsch</div>
			<div id='winel'>Gesamt</div>
		</div>";
	//Scores
	$abfrage = "SELECT * FROM score ORDER BY win DESC";
	$erg = mysql_query($abfrage) or die(mysql_error());
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		echo "<div id='winline'>
				<div id='winel'>".$user[$row['user']]."</div>
				<div id='winel'>".$row['win']."</div>
				<div id='winel'>".$row['lose']."</div>
				<div id='winel'>".$row['ges']."</div>
			</div>";
			
	}
}


function update() {
	/* 
	 * This function updates the database,
	 * for a few users its totally legit to call it every time
	 * but it seems a bit unnecessary to call it that often
	 * feel free to implement a better solution :)
	*/ 
	$spiele = array();
	$abfrage = "SELECT * FROM spiele ORDER BY id";
	$erg = mysql_query($abfrage);
	while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$spiele[$row['id']] = $row['wt'];
	}
	
	$abfrage = "SELECT * FROM user WHERE id > '1'"; //Do not list the admin
	
	$erg = mysql_query($abfrage) or die(mysql_error());
	while($urow = mysql_fetch_array($erg, MYSQL_ASSOC)){
		$uid = $urow['id'];
		$abfrage = "SELECT * FROM tipp WHERE user = '$uid' ORDER BY id";
		$erg2 = mysql_query($abfrage);
		$winscore = 0;
		$losescore = 0;
		while($row = mysql_fetch_array($erg2, MYSQL_ASSOC)){ //Calculate the data
			if($spiele[$row['id_sp']] == $row['team']) {
				$winscore++;
			} else {
				$losescore++;
			}
		}
		$score = $winscore + $losescore;
		//Update the database
		$eintrag = "UPDATE score SET win='$winscore', lose='$losescore', ges='$score' WHERE user = '$uid'";
		$update = mysql_query($eintrag);
	}
}
//Do the update
update();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="style.css" type="text/css">
<link rel="shortcut icon" href="http://ardobras.de/wp/wp-content/themes/ArdobrasBlogDesign/images/favicon.ico">
<link href="https://fonts.googleapis.com/css?family=Roboto:700,500,400,300,100" rel="stylesheet" type="text/css">
<script src="js.js" type="text/javascript"></script>
<title>LCS TippSpiel</title>
</head>
<body>
<div id="wrapper">
	<div id="header">
<?php 
if($_SESSION['login']) {
	//logged in - logout
	echo "<span>Hello ".$_SESSION['name']."</span>";
	echo '<form name="logout" action="'.$_SERVER['PHP_SELF'].'" method="post">
			<input type="submit" name="logout" value="Ausloggen" /> 
		</form>';
	echo "<br>";
} else  {
	//login
	echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">
			<input name="user" type="text" />
			<input name="pw" type="password" />
			<input type="submit" value="Einloggen" /> 
		</form>';
} ?>
	</div>
    <div id="main">
	<?php draw() ?>
    </div>
</div>
</body>
</html>
<?php mysql_close(); ?>