
<?php
	$datum= date('Y-m-d');
	$beschrijving= $_POST['Beschrijving'];
	$melding= $_POST['Melding'];
	$gebruiker_id= $_SESSION['ID'];
	$soort_id= $_POST['Soort'];
	$status_id= 1;
	
$query = "INSERT INTO INCIDENT(Mail, Datum, Beschrijving, Melding, GEBRUIKER_ID, SOORT_ID, STATUS_ID)
VALUES ('', '$datum', '$beschrijving', '$melding', '$gebruiker_id', '$soort_id', '$status_id')";
$add_mebmer= mysql_query($query) or die (mysql_error());
header("Location: index.php?content=contact/melding_ov");
?>