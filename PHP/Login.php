<?php 
 if(isset($_COOKIE['Gebriukersnaam']))
 { 
 	$Gebruikersnaam = $_COOKIE['Gebruikersnaam']; 
 	$Wachtwoord = $_COOKIE['Wachtwoord'];

 	 	$check = mysql_query("SELECT * FROM GEBRUIKER WHERE Gebruikersnaam = '$Gebruikersnaam'")or die(mysql_error());
 	while($info = mysql_fetch_array( $check )) 	{
 		if ($Wachtwoord != $info['Wachtwoord']) {}

 		else{
			header("Location: route.php");} 	
				

 		}
 }


 if (isset($_POST['submit'])) { 
 	if(!$_POST['Gebruikersnaam'] | !$_POST['Wachtwoord']) {
 		die('Je hebt 1 van de velden niet ingevuld');
 	}
 	if (!get_magic_quotes_gpc()) {
  	}
 	$check = mysql_query("SELECT * FROM GEBRUIKER WHERE Gebruikersnaam = '".$_POST['Gebruikersnaam']."'")or die(mysql_error());
 $check2 = mysql_num_rows($check);
 if ($check2 == 0) {
 		die('To get an account ask the administrator. <a href=Login.php>Click Here to go back to loginscreen.</a>');
	}
 while($info = mysql_fetch_array( $check )) {
 $_POST['Wachtwoord'] = stripslashes($_POST['Wachtwoord']);
 	$info['Wachtwoord'] = stripslashes($info['Wachtwoord']);
 	$_POST['Wachtwoord'] = md5($_POST['Wachtwoord']);

 	if ($_POST['Wachtwoord'] != $info['Wachtwoord']) {
 		die('Incorrect password, please try again.');
 	}
 else { 
 	 $_POST['Gebruikersnaam'] = stripslashes($_POST['Gebruikersnaam']); 
 $hour = time() + 3600; 
 setcookie(Gebruikersnaam, $_POST['Gebruikersnaam'], $hour);
 setcookie(Wachtwoord, $_POST['Wachtwoord'], $hour);
 	
	$username = $_POST['Gebruikersnaam'];
	$idu = mysql_query("SELECT ID FROM GEBRUIKER WHERE Gebruikersnaam = '$username';"); 
	$row = mysql_fetch_row($idu);
	$ids = mysql_query("SELECT SOORT_ID FROM GEBRUIKER WHERE Gebruikersnaam = '$username';"); 
	$row2 = mysql_fetch_row($ids);

 session_start();
$_SESSION["ID"] = $row[0];
$_SESSION["SOORT"] = $row2[0];
   
 header("Location: route.php"); 
 } 
 } 
 }
 else {	 
 ?> 
<section id="main-content">
	<section class="wrapper">



 <form action="index.php?content=Login" method="post"> 
 <div style='width: 500px'>
 <table class= 'table table-bordered'>
 <tr><td colspan=2><h1>Login</h1></td></tr> 
 <tr><td>Gebruikersnaam:</td><td> 
 <input type="text" name="Gebruikersnaam" maxlength="40"> 
 </td></tr> 
 
 <tr><td>Wachtwoord:</td><td> 
 <input type="password" name="Wachtwoord" maxlength="50"> 
 </td></tr> 
 <tr><td colspan="2" align="right"> 

 <input type="submit" name="submit" class= "btn btn-primary" value="Login"> 
</td></tr> 
 </table> 
</div> 
 </form> 
 

</section>
</section>

 <?php 
 } 
 ?>
 