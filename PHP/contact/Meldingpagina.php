<!DOCTYPE html>
<html>
<head>
		<title>
		Meldingen pagina
		</title>
	</head>
	<body>
		<h1>
			Maak een melding.
		</h1>
	</body>
	</html>
		<?php
			$query_Soort = "SELECT * FROM INCIDENT_SOORT";
			$result_Soort = mysql_query($query_Soort);
			
		?>
		<?php
		if(isset($_SESSION["ID"])) {?>
		<!DOCTYPE html>
		<html>
		<body>
		<form id="form" action="index.php?content=contact/Melding"method="post">
		<fieldset> </br>
		<select name="Soort"></html><?php while($row= mysql_fetch_row($result_Soort)) echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";?>
		<html> </select> </br> </br>
		Ondewerp </br>
		<input type="text" name="Beschrijving" required> </br>
		Melding </br>
		<textarea form="form" name="Melding" placeholder="Zet hier je melding neer." style="width: 100%" required></textarea></br></br>
		<input type="submit" value="plaats melding"> </br>
		</fieldset>
		</form>
		<strong>Veelgestelde vragen:</strong>
		<p><a href="http://localhost/~student/Project/FAQ.php">FAQ</a></p>
	</body>
</html>
<?php
		} else {
		?>
		<!DOCTYPE html>
		<html>
		<body>
			<form action="Melding.php"method="post">
		<fieldset> </br>
		<select name="Soort"> </html> <?php $row=mysql_fetch_row($result_Soort); echo "<option value='" . $row[0] . "'>" . $row[1] . "</option>";?>
		<html> </select> </br> </br>
		Beschrijving </br>
		<input type="text" name="Beschrijving" required> </br>
		Melding </br>
		<textarea form="form" name="Melding" placeholder="Zet hier je melding neer." style="width: 100%" required></textarea></br></br>
		<input type="submit" value="plaats melding" </br>
		</fieldset>
		</form>
		<strong>Veelgestelde vragen:</strong>
		<p><a href="http://localhost/~student/Project/FAQ.php">FAQ</a></p>
	</body>
</html>
<?php
		}
?>




