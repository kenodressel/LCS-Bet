<?php
function drawHead($src) {
	if($src == "main") { //Which page is it called from?
		$backlink = "<a href='highscore.php'>Highscore</a> - <a href='standings.php'>Standings</a>";
	} elseif($src == "score") {
		$backlink = "<a href='index.php'>Homepage</a> - <a href='standings.php'>Standings</a>";
	} elseif($src == "standings") {
		$backlink = "<a href='index.php'>Homepage</a> - <a href='highscore.php'>Highscore</a>";
	}
	echo "<div id='headerhalf'>";
	if(isset($_SESSION['login']) && $_SESSION['login']) { //user is logged in
		echo '<form name="logout" action="'.$_SERVER['PHP_SELF'].'" method="post">';
			echo "<span class='welcome'>Hello ".$_SESSION['name']." - ".$backlink." - </span>";
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
	echo "</div>";
	echo "<div id='headerhalf' style='text-align:right'>";
	if(isset($_SESSION['login']) && $_SESSION['login']) {
		echo "<div class='option'>";
		echo "<span class='spoilerTxt'>Theme: </span>";
		echo "<div id='spoiler' onclick='spoilerToggle(".$_SESSION['uid'].",1)'>";
		echo "	<div id='themeChoose' class='spoilerChoose'";
		if($_SESSION['theme'] == 1) {
			echo "style='float:right'>";
			echo "Off";
		} else {
			echo "style='float:left'>";
			echo "On";
		}
		echo "</div></div>";
		echo "</div>";
		echo "<div class='option'>";
		echo "<span class='spoilerTxt'>Spoiler: </span>";
		echo "<div id='spoiler' onclick='spoilerToggle(".$_SESSION['uid'].",0)'>";
		echo "<div id='spoilerChoose' class='spoilerChoose'";
		if($_SESSION['spoiler'] == 1) {
			echo "style='float:right'>";
			echo "Off";
		} else {
			echo "style='float:left'>";
			echo "On";
		}
		echo "</div></div>";
		echo "</div>";
	} else {
		echo "<span>&nbsp;</span>";
	}
	echo "<br>";
	echo "</div>";
}
?>