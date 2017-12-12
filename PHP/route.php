<?php 
require ( "database.php" );
echo conect();
echo autho();

$username = $_COOKIE['Gebruikersnaam'];
$idu = mysql_query("SELECT ID FROM GEBRUIKER WHERE Gebruikersnaam = '$username';"); 
$row = mysql_fetch_row($idu);
$ids = mysql_query("SELECT SOORT_ID FROM GEBRUIKER WHERE Gebruikersnaam = '$username';"); 
$row2 = mysql_fetch_row($ids);

session_start();
$_SESSION["ID"] = $row[0];
$_SESSION["SOORT"] = $row2[0];


if ($_SESSION['SOORT'] == 1) {
		 header ("Location: index.php"); 
	 }elseif ($_SESSION['SOORT'] == 2) {
		 header ("Location: admin.php"); 
	 }elseif ($_SESSION['SOORT'] == 3) {
		 header ("Location: admin.php"); 
	 }
	 
?>

<br><a href="test2.php">test2</a><br>
<a href="test3.php">test3</a>