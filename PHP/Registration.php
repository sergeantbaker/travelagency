<!DOCTYPE HTML>  
<html>
<head>
<style>
.error {color: #FF0000;}
tr:hover {
		background-color: hsl(0,0%,80%);
}
</style>
</head>
<body>  


<?php

// define variables and set to empty values
$insert = 0;
$Voornaam = $Achternaam = $Geboortedatum = $Geslacht = $Telefoon = $Mail = $Land = $Stad = $Straat = $StraatNr = $Postcode = "";
$Gebruikersnaam = $Wachtwoord = $Wachtwoord2 = "";
$Voornaame = $Achternaame = $Geboortedatume = $Geslachte = $Telefoone = $Maile = $Lande = $Stade = $Straate = $StraatNre = $Postcodee = "";
$Gebruikersnaame = $Wachtwoorde = $Wachtwoord2e = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (empty($_POST["Voornaam"])) {
    $Voornaame = "Voornaam is required";
  } else {
    $Voornaam = test_input($_POST["Voornaam"]);
	$insert++;
  }
  
  if (empty($_POST["Achternaam"])) {
    $Achternaame = "Achternaam is required";
  } else {
    $Achternaam = test_input($_POST["Achternaam"]);
	$insert++;
  }
  
    if (empty($_POST["Geboortedatum"])) {
    $Geboortedatume = "Geboorte datum is required";
  } else {
    $Geboortedatum = test_input($_POST["Geboortedatum"]);
	$insert++;
  }
  
    if (empty($_POST["Geslacht"])) {
    $Geslachte = "Geslacht is required";
  } else {
    $Geslacht = test_input($_POST["Geslacht"]);
	$insert++;
  }
  
    if (empty($_POST["Telefoon"])) {
    $Telefoone = "Telefoon is required";
  } else {
    $Telefoon = test_input($_POST["Telefoon"]);
	$insert++;
  }
  
    if (empty($_POST["Mail"])) {
    $Maile = "E-mail is required";
  } else {
    $Mail = test_input($_POST["Mail"]);
	$check = mysql_query("SELECT Mail FROM KLANT WHERE Mail = '$Mail'") 
	or die(mysql_error());
	$check2 = mysql_num_rows($check);
	if ($check2 != 0) {
		echo "Sorry de E-mail: $Mail is al gebruikt";
	}
	$insert++;
  }
    
  if (empty($_POST["Land"])) {
	$Lande = "Land is required";
  } else {
    $Land = test_input($_POST["Land"]);
	$insert++;
  }

  if (empty($_POST["Stad"])) {
    $Stade = "Land is required";
  } else {
    $Stad = test_input($_POST["Stad"]);
	$insert++;
  }
  
    if (empty($_POST["Straat"])) {
    $Straate = "Land is required";
  } else {
    $Straat = test_input($_POST["Straat"]);
	$insert++;
  }
  
    if (empty($_POST["StraatNr"])) {
    $StraatNre = "Land is required";
  } else {
    $StraatNr = test_input($_POST["StraatNr"]);
	$insert++;
  }
  
    if (empty($_POST["Postcode"])) {
    $Postcodee = "Land is required";
  } else {
    $Postcode = test_input($_POST["Postcode"]);
	$insert++;
  }
  
    if (empty($_POST["Gebruikersnaam"])) {
    $Gebruikersnaame = "Gebruikersnaam is required";
  } else {
	    $Gebruikersnaam = test_input($_POST["Gebruikersnaam"]);
		$check = mysql_query("SELECT Gebruikersnaam FROM GEBRUIKER WHERE Gebruikersnaam = '$Gebruikersnaam'") 
		or die(mysql_error());
		$check2 = mysql_num_rows($check);
		if ($check2 != 0) {
			$Gebruikersnaame = "De gebruikersnaam $Gebruikersnaam is al in gebruik.";
		}
		$insert++;
  }
  
    if (empty($_POST["Wachtwoord"])) {
    $Wachtwoorde = "Wachtwoord is vereist";
  } else {
    $Wachtwoord = test_input($_POST["Wachtwoord"]);
	$insert++;
  }
  
    if (empty($_POST["Wachtwoord2"])) {
    $Wachtwoord2e = "Wachtwoord moet je 2 keer invullen";
  } else {
    $Wachtwoord2 = test_input($_POST["Wachtwoord2"]);
	If ($Wachtwoord != $Wachtwoord2){
		$Wachtwoord2e = "Je wachtwoorden komen niet overeen";
		$insert = 1;
	} else {
		$enc = md5($Wachtwoord);		
	}
	$insert++;
  }
}


function test_input($data) {
  $data = addslashes($data);
  return $data;
}
?>
<h2>Registratie</h2>
<form method="post" action="index.php?content=Registration">  
 <div style='width: 600px'>
 <table class= 'table table-bordered'>
 
<tr><td>Voornaam:</td><td>
 <input type="text" name="Voornaam" maxlength="60" required>
 <span class="error"> <?php echo $Voornaame;?></span>
 </td></tr>
 
 <tr><td>Achternaam:</td><td>
 <input type="text" name="Achternaam" maxlength="60" required>
  <span class="error"> <?php echo $Achternaame;?></span>
 </td></tr>
 
 <tr><td>Geboorte datum:</td><td>
 <input type="date" name="Geboortedatum" placeholder="yyyy-mm-dd" required>
 <span class="error"> <?php echo $Geboortedatume;?></span > 
 </td></tr> 
 
 <tr><td>Geslacht:</td><td>
  <input type="radio" name="Geslacht" value="male" checked> Man
  <input type="radio" name="Geslacht" value="female"> Vrouw
  <input type="radio" name="Geslacht" value="other"> Anders
  <span class="error"> <?php echo $Geslachte;?></span>
</td></tr>

 <tr><td>Telefoon:</td><td>
 <input type="text" name="Telefoon"  pattern="[0-9]{1,10}" maxlength="10">
 <span class="error"> <?php echo $Telefoone;?></span>
 </td></tr>
 
 <tr><td>E-mail:</td><td>
 <input type="email" name="Mail" maxlength="60" required>
 <span class="error"> <?php echo $Maile;?></span>
 </td></tr>
 
 <tr><td>Land:</td><td>
 <input type="text" name="Land" maxlength="60" required>
 <span class="error"> <?php echo $Lande;?></span>
 </td></tr>
 
 <tr><td>Stad:</td><td>
 <input type="text" name="Stad" maxlength="60" required>
 <span class="error"> <?php echo $Stade;?></span>
 </td></tr>
 
 <tr><td>Straat naam:</td><td>
 <input type="text" name="Straat" maxlength="60" required>
 <span class="error"> <?php echo $Straate;?></span>
 </td></tr>
 
 <tr><td>Straat Nummer:</td><td>
 <input type="number" name="StraatNr" min="1" maxlength="5" required>
 <span class="error"> <?php echo $StraatNre;?></span>
 </td></tr>
 
 <tr><td>PostCode:</td><td>
 <input type="text" name="Postcode" maxlength="6" pattern="[0-9]{4}[a-zA-Z]{2}" required>
 <span class="error"> <?php echo $Postcodee;?></span>
 </td></tr>
 
  <tr><td>Gebruikersnaam:</td><td>
 <input type="text" name="Gebruikersnaam" maxlength="50" required>
 <span class="error"> <?php echo $Gebruikersnaame;?></span>
 </td></tr>
 
  <tr><td>Wachtwoord:</td><td>
 <input type="password" name="Wachtwoord" maxlength="50" required>
 <span class="error"> <?php echo $Wachtwoorde;?></span>
 </td></tr>
 
  <tr><td>Bevestig Wachtwoord:</td><td>
 <input type="password" name="Wachtwoord2" maxlength="50" required>
 <span class="error"> <?php echo $Wachtwoord2e;?></span>
 </td></tr>

<tr><td colspan="2" align="right">
  <input type="submit" name="submit" class= "btn btn-primary" value="Register"></th>
  <INPUT TYPE="button" value="Terug naar Login" class= "btn btn-primary" onClick="parent.location='index.php?content=Login'">
  </td></tr> 
  </table>
</form>

<?php

if ($insert == 14){
 	$insert1 = "INSERT INTO GEBRUIKER (Gebruikersnaam, Wachtwoord, SOORT_ID)
 	VALUES ('$Gebruikersnaam', '$enc', '1');";
	$add_member = mysql_query($insert1);	
	$idu = mysql_query("SELECT ID FROM GEBRUIKER WHERE Gebruikersnaam = '$Gebruikersnaam';"); 
	$row = mysql_fetch_row($idu);
	
	$insert2 = "INSERT INTO KLANT (Voornaam, Achternaam, Geboortedatum, Geslacht, Telefoon, Mail, Land, Stad, Straat, StraatNr, Postcode, GEBRUIKER_ID)
				VALUES ('$Voornaam', '$Achternaam', '$Geboortedatum', '$Geslacht', '$Telefoon'
				, '$Mail', '$Land', '$Stad', '$Straat', '$StraatNr', '$Postcode', $row[0] );";
	$add_member2 = mysql_query($insert2);	
	$insert = 0;
} elseif($insert >= 1) {
	echo "je hebt niet alles ingevuld";
}
?>