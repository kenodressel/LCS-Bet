<?php
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
?>