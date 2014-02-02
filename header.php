<?php
function drawHead($src) {
	if($src == "main") { //Which page is it called from?
		$backlink = "<a href='highscore.php'>Highscore</a>";
	} elseif($src == "score") {
		$backlink = "<a href='index.php'>Homepage</a>";
	}

	if(isset($_SESSION['login']) && $_SESSION['login']) { //user is logged in
		echo '<form name="logout" action="'.$_SERVER['PHP_SELF'].'" method="post">';
			echo "<span>Hello ".$_SESSION['name']." - ".$backlink." - </span>";
			echo '<input type="submit" class="logout" name="logout" value="Logout" /> 
			</form>';
		echo "<br>";
	} else  { //login
	  echo '<form name="login" action="'.$_SERVER['PHP_SELF'].'" method="post">
				<div class="login-border-bottom"><input class="logininput" placeholder="Username" name="user" type="text" /></div>
				<div class="login-border-bottom"><input class="logininput" placeholder="Password" name="pw" type="password" /></div>
				<input type="submit" class="logout login" value="Login" /> 
			</form>
			<br>';
	}
}
?>