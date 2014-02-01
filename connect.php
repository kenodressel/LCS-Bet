<?php
//obligatory session start
session_start();
//connection
$host = "127.0.0.1";
$user = "";
$password = "";
$database = "";
//connect
$verbindung = mysql_connect($host,$user,$password) or die(mysql_error());
//datenbank auswählen
$db_select = mysql_select_db($database) or die(mysql_error());

?>