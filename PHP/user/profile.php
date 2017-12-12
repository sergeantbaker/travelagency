
<!DOCTYPE html>
<html>
<style>
	tr:hover{
	background-color: hsl(0,0%,80%);
}
</style>
<body>
<div style="margin-left:5%;">
<h2>Profiel</h2>

<?php

  if(!isset($_SESSION['ID']))
  {
    die("Could not connect to mysql database: ".mysqli_error());
  }

  $user_id = $_SESSION["ID"];
  $query = "SELECT * FROM KLANT WHERE GEBRUIKER_ID = $user_id;";
  $query_result = mysql_query($query);

  $row = mysql_fetch_assoc($query_result);
  if(!$row)
  {
    die("Ongeldige gebruiker!");
  }

  ?><table style="width:50%;"><?php
  echo "<tr><td><b>Voornaam:</b></td><td>".$row["Voornaam"]."</td></tr>";
  echo "<tr><td><b>Achternaam:</b></td><td>".$row["Achternaam"]."</td></tr>";
  echo "<tr><td><b>Geboortedatum:</b></td><td>".$row["Geboortedatum"]."</td></tr>";
  echo "<tr><td><b>Geslacht:</b></td><td>".$row["Geslacht"]."</td></tr>";
  echo "<tr><td><b>Telefoon:</b></td><td>".$row["Telefoon"]."</td></tr>";
  echo "<tr><td><b>Mail:</b></td><td>".$row["Mail"]."</td></tr>";
  echo "<tr><td><b>Land:</b></td><td>".$row["Land"]."</td></tr>";
  echo "<tr><td><b>Stad:</b></td><td>".$row["Stad"]."</td></tr>";
  echo "<tr><td><b>Straat:</b></td><td>".$row["Straat"]."</td></tr>";
  echo "<tr><td><b>Straatnummer:</b></td><td>".$row["StraatNr"]."</td></tr>";
  echo "<tr><td><b>Postcode:</b></td><td>".$row["Postcode"]."</td></tr>";
  echo "</table>";

?>
</br>

	<td><input type="button" class= "btn btn-primary" value="Wijzig profiel" onClick="parent.location='index.php?content=user/change_profile'"></td>
    <td><input type="button" class= "btn btn-primary"value="Wijzig wachtwoord" onClick="parent.location='index.php?content=user/change_password'"></td>


</div>
</body>
</html>
