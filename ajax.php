<?php
include("connect.php");

//This is called when a user enters a tipp
if($_GET['fn'] == "tipp") {
	if(isset($_GET['spiel'])) {
		$id = $_GET['spiel'];
		$team = $_GET['team'];
		$uid = $_GET['uid'];
		$tippid = $_GET['tid'];
		if($tippid != 0) {
			$eintrag = "UPDATE tipp SET team='$team' WHERE id = '$tippid'";
			$update = mysql_query($eintrag);
			echo $tippid;
		} else {
			$eintrag = "INSERT INTO tipp (user,id_sp,team) VALUES ('$uid','$id','$team')";
			$update = mysql_query($eintrag);
			$abfrage = "SELECT * FROM tipp WHERE user = '$uid' AND id_sp = '$id'";
			$erg = mysql_query($abfrage) or die(mysql_error());
			while($row = mysql_fetch_array($erg, MYSQL_ASSOC)){
				echo $row['id'];
			}
		}
	}
}
//This is called when the admin enters a winner
if($_GET['fn'] == "win") {
	if(isset($_GET['spiel'])) {
		$id = $_GET['spiel'];
		$team = $_GET['team'];
		$eintrag = "UPDATE spiele SET wt='$team' WHERE id = '$id'";
		$update = mysql_query($eintrag);
	}
}
?>