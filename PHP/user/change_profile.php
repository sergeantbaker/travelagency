
<!DOCTYPE html>
<html>
<body>

<h2>Wijzig profiel</h2>

<?php



  $user_id = $_SESSION['ID'];
  $query = "SELECT * FROM KLANT WHERE GEBRUIKER_ID = $user_id;";
  $query_result = mysql_query($query);

  $row = mysql_fetch_assoc($query_result);
  if(!$row)
  {
    die("Could not find user");
  }

  $firstname = $row["Voornaam"];
  $lastname = $row["Achternaam"];
  $birthdate = $row["Geboortedatum"];
  $gender = $row["Geslacht"];
  $phonenumber = $row["Telefoon"];
  $mail = $row["Mail"];
  $country = $row["Land"];
  $city = $row["Stad"];
  $street = $row["Straat"];
  $streetnumber = $row["StraatNr"];
  $postalcode = $row["Postcode"];
  
  if(!empty($_POST))
  {
    $query_a = "UPDATE KLANT SET ";
    $query_b = " WHERE GEBRUIKER_ID=".$user_id;

	$new_firstname = $_POST["firstname"];
	if($firstname != $new_firstname)
	{
		$firstname = $new_firstname;
		$query = $query_a."Voornaam='".$firstname."'".$query_b;
		mysql_query($query);
	}

	$new_lastname = $_POST["lastname"];
	if($lastname != $new_lastname)
	{
		$lastname = $new_lastname;
		$query = $query_a."Achternaam='".$lastname."'".$query_b;
		mysql_query($query);
	}
	
	$new_birthdate = $_POST["birthdate"];
    if($birthdate != $new_birthdate)
    {
      $birthdate = $new_birthdate;
      $query = $query_a."Geboortedatum='".$birthdate."'".$query_b;
      mysql_query($query);
    }

	$new_gender = $_POST["gender"];
	if($gender != $new_gender)
	{
		$gender = $new_gender;
		$query = $query_a."Geslacht='".$gender."'".$query_b;
		mysql_query($query);
	}
		
	$new_phonenumber = $_POST["phonenumber"];
	if($phonenumber != $new_phonenumber)
	{
		$phonenumber = $new_phonenumber;
		$query = $query_a."Telefoon='".$phonenumber."'".$query_b;
		mysql_query($query);
	}
			
	$new_mail = $_POST["mail"];
	if($mail != $new_mail)
	{
		$mail = $new_mail;
		$query = $query_a."Mail='".$mail."'".$query_b;
		mysql_query($query);
	}
				
	$new_country = $_POST["country"];
	if($country != $new_country)
	{
		$country = $new_country;
		$query = $query_a."Land='".$country."'".$query_b;
		mysql_query($query);
	}
				
	$new_city = $_POST["city"];
	if($city != $new_city)
	{
		$city = $new_city;
		$query = $query_a."Stad='".$city."'".$query_b;
		mysql_query($query);
	}
					
	$new_street = $_POST["street"];
	if($street != $new_street)
	{
		$street = $new_street;
		$query = $query_a."Straat='".$street."'".$query_b;
		mysql_query($query);
	}
						
	$new_streetnumber = $_POST["streetnumber"];
	if($streetnumber != $new_streetnumber)
	{
		$streetnumber = $new_streetnumber;
		$query = $query_a."StraatNr='".$streetnumber."'".$query_b;
		mysql_query($query);
	}
						
	$new_postalcode = $_POST["postalcode"];
	if($postalcode != $new_postalcode)
	{
		$postalcode = $new_postalcode;
		$query = $query_a."Postcode='".$postalcode."'".$query_b;
		mysql_query($query);
	}
	
    echo "De wijzigingen zijn succesvol aangebracht<br>";
    echo "<a href='index.php?content=user/profile'>Terug naar profiel</a>";
  }
  else
  {
    echo "<form action='index.php?content=user/change_profile' method='post'>";
    echo "<table>";

	echo "<tr><td><b>Voornaam:</b></td>";
	echo "<td><input type='text' name='firstname' maxlength='60' value='".$firstname."' required></td></tr>";
	
	echo "<tr><td><b>Achternaam:</b></td>";
	echo "<td><input type='text' name='lastname' maxlength='60' value='".$lastname."' required></td></tr>";
	
    echo "<tr><td><b>Geboortedatum:</b></td>";
    echo "<td><input type='text' name='birthdate' pattern='\d{4}-\d{1,2}-\d{1,2}' value='".$birthdate."' required></td></tr>";

	echo "<tr><td><b>Geslacht:</b></td>
	<td><label class=\"radio-inline\"><input type=\"radio\" name=\"gender\" value=\"Man\" "; if(isset($gender) && $gender == 'Man') { echo 'checked';} echo " > Man</label>
    <label class=\"radio-inline\"><input type=\"radio\" name=\"gender\" value=\"Vrouw\" "; if(isset($gender) && $gender == 'Vrouw') { echo 'checked';} echo "> Vrouw</label>
	<label class=\"radio-inline\"><input checked type=\"radio\" name=\"gender\" value=\"Vrouw\" "; if(isset($gender) && $gender == 'Anders') { echo 'checked';} echo "> Anders</label></td></tr>";

	echo "<tr><td><b>Telefoon:</b></td>";
	echo "<td><input type='text' name='phonenumber' pattern='[0-9]{1,10}' maxlength='10' value='".$phonenumber."' required></td></tr>";
	
	echo "<tr><td><b>E-mail:</b></td>";
	echo "<td><input type='email' name='mail' maxlength='60' value='".$mail."' required></td></tr>";

	echo "<tr><td><b>Land:</b></td>";
	echo "<td><input type='text' name='country' maxlength='60' value='".$country."' required></td></tr>";
	
	echo "<tr><td><b>Stad:</b></td>";
	echo "<td><input type='text' name='city' maxlength='60' value='".$city."' required></td></tr>";
	
	echo "<tr><td><b>Straat naam:</b></td>";
	echo "<td><input type='text' name='street' maxlength='60' value='".$street."' required></td></tr>";
	
	echo "<tr><td><b>Straat nummer:</b></td>";
	echo "<td><input type='text' name='streetnumber' min='1' maxlength='5' value='".$streetnumber."' required></td></tr>";
	
	echo "<tr><td><b>Postcode:</b></td>";
    echo "<td><input type='text' name='postalcode' pattern=[1-9][0-9]{3}[a-zA-Z]{2} maxlength='6' value='".$postalcode."' required></td></tr>";
	
    echo "<tr>";
    echo "<td><a href='index.php?content=user/profile'>Terug naar profiel</a></td>";
    echo "<td><input name='bewerk' type='submit' id='bewerk' value='Wijzig' class= 'btn btn-primary'></td>";
    echo "</tr>";
	
    echo "</table>";
    echo "</form>";
  }

?>

</body>
</html>
