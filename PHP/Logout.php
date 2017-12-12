<?php
if(!empty($_COOKIE['Gebruikersnaam'])) {
require_once("database.php");
echo autho();
}
if (isset($_COOKIE['Gebruikersnaam'])) {
$past = time() - 100; 
setcookie(Gebruikersnaam, gone, $past); 
setcookie(Wachtwoord, gone, $past); 
}
if (isset($_SESSION['ID'])) {
session_unset(); 
session_destroy(); 
}
header("Location: index.php"); 
 ?>