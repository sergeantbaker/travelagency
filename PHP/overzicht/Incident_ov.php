<style>
.center {
margin-top: 10%;
margin-left: 15%;
margin-right: 15%;

}
tr:hover{
	background-color: hsl(0,0%,80%);

}
td:hover{
	
}
</style>
<?php
$and = "AND INCIDENT.STATUS_ID < 3";
if(isset($_POST['Kennis'])) {
	$and = "AND INCIDENT.STATUS_ID = 3";
}
$sql= "
	SELECT INCIDENT.Beschrijving, INCIDENT.Datum, INCIDENT.ID, INCIDENT_STATUS.Naam, INCIDENT_SOORT.Naam, GEBRUIKER.ID, GEBRUIKER.Gebruikersnaam, KLANT.Voornaam, KLANT.Achternaam, INCIDENT.Melding  
	FROM INCIDENT, GEBRUIKER, KLANT, INCIDENT_STATUS, INCIDENT_SOORT
	WHERE INCIDENT.GEBRUIKER_ID = GEBRUIKER.ID
	AND INCIDENT.SOORT_ID = INCIDENT_SOORT.ID
	AND INCIDENT.STATUS_ID = INCIDENT_STATUS.ID
	AND GEBRUIKER.ID = KLANT.GEBRUIKER_ID
	$and
	ORDER BY INCIDENT.ID;";
$result= mysql_query($sql);
$count = mysql_num_rows($result);



// einde voor het bewerken van de geselecteerde rows
// vervolg van het bewerken van de geselecteerde rows
if (isset($_POST['bewerk2'])) {

	$bewerk = $_COOKIE['bewerk'];
	if ($bewerk == 0) {
	$date = date('Y-m-d');
	$melding = $_POST['Melding'];
	$ID = $_GET['ID'];
	$soort = $_POST['Soort'];
	$status = $_POST['Status'];
	
	if(!empty($melding)){
	$sql_melding = "INSERT INTO INCIDENT_MELDING (INCIDENT_ID, Melding, datum)
					VALUES ('$ID', '$melding', '$date');";
	$result1= mysql_query($sql_melding) or die ("FOUT:1". mysql_error());
	}	
	$sql_inciupd = "UPDATE INCIDENT SET
					SOORT_ID = $soort,
					STATUS_ID = $status
					WHERE ID = $ID;";
	
	$result2= mysql_query($sql_inciupd) or die ("FOUT:2". mysql_error());
	
		}
	
	header("Location: admin.php?content=Incident_ov&ID=$ID");
}

if (isset($_GET['ID'])) {

$bew = $_GET['ID'];
$sql= "
	SELECT INCIDENT.Beschrijving, INCIDENT.Datum, INCIDENT.ID, INCIDENT_STATUS.Naam,
	INCIDENT_SOORT.Naam, GEBRUIKER.ID, GEBRUIKER.Gebruikersnaam, KLANT.Voornaam, KLANT.Achternaam, INCIDENT.Melding, 
	INCIDENT_MELDING.Melding, INCIDENT_MELDING.datum
	FROM INCIDENT, GEBRUIKER, KLANT, INCIDENT_STATUS, INCIDENT_SOORT, INCIDENT_MELDING
	WHERE INCIDENT.GEBRUIKER_ID = GEBRUIKER.ID
	AND INCIDENT.SOORT_ID = INCIDENT_SOORT.ID
	AND INCIDENT.STATUS_ID = INCIDENT_STATUS.ID
	AND GEBRUIKER.ID = KLANT.GEBRUIKER_ID
	AND INCIDENT_MELDING.INCIDENT_ID = INCIDENT_ID
	AND INCIDENT.ID = $bew;";

$query_Soort = "SELECT * FROM INCIDENT_SOORT";
$query_Status = "SELECT * FROM INCIDENT_STATUS";


$result= mysql_query($sql);
$plant= mysql_query($sql);
$row=mysql_fetch_array($result);

$ID = $row[2];
$result_Soort = mysql_query($query_Soort);
$result_Status = mysql_query($query_Status);
$Status = $row[3];
$Soort = $row[4];
$query_stid = "SELECT ID FROM INCIDENT_STATUS WHERE Naam = '$Status';";
$query_soid = "SELECT ID FROM INCIDENT_SOORT WHERE Naam = '$Soort';";
$result_stid = mysql_query($query_stid);
$result_soid = mysql_query($query_soid);
$stid = mysql_fetch_row($result_stid);
$soid = mysql_fetch_row($result_soid);


?>

<h2>MELDING</h2>
<form name="form1" id="form" method="post" action="">
<table class= 'table table-bordered'>
<tr>
<tr><h2><th><?php echo $row[4]; ?></th><th><?php echo $row[0];?></h2></th><th><?php echo $row[1] ?></th></tr>
<tr onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row[5]; ?>'">
	<th>ID: <?php echo $row[5] ?></th>
	<th>Gebruikersnaam: <?php echo $row[6] ?></th>
	<th>Naam: <?php echo $row[7] ?> <?php echo $row[8] ?></th>
<tr>
	<td>Status: <select name="Status" value="<? echo $row[3];?>">
		<option value="<?php echo $stid[0]; ?>"><?php echo $Status;?></option>
		<?php while($Status = mysql_fetch_row($result_Status)){
			echo "<option value='".$Status['0']."'>" . $Status[1] . "</option>";}	?> </select></td> 
	<td>Soort: <select name="Soort" value="<? echo $row[4];?>">
		<option value="<?php echo $soid[0]; ?>"><?php echo $Soort;?></option>
		<?php while($Soort = mysql_fetch_row($result_Soort)){
			echo "<option value='".$Soort['0']."'>" . $Soort[1] . "</option>";}	?> </select></td> 
</tr>
</table>
<table class= 'table table-bordered'>
<tr><th><?php echo $row[4]; ?> van de klant</th></tr>	
<tr><td><?echo $row[9]; ?></td></tr>
</table>
<table class= 'table table-bordered'>
<textarea form="form" style="width: 100%;" rows="5" name="Melding" placeholder="antwoord hier typen...."></textarea>
</table>

<input name="bewerk2" type="submit" id="bewerk2" value="Bewerk" class= "btn btn-primary" onclick="klikbewerk()">
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Incident_ov'">
<br><br>
<?php
$test = "SELECT datum, Melding, INCIDENT_ID
		FROM INCIDENT_MELDING
		WHERE INCIDENT_ID = $bew;";
$test2 = mysql_query($test);
while($rp=mysql_fetch_array($test2)){
?>
<table class= 'table table-bordered'>
<tr><th>UPDATE: DATUM:<?php echo $rp[0]; ?></th></tr>	
<tr><td><?echo $rp[1]; ?></td></tr>
</table>
<?php
}
}


 	if (empty($_GET['ID'])) { 	
?>

<h2>Incidenten overzicht</h2>
<form name="form1" method="post" action="">
<div class="input-group"> <span class="input-group-addon">Filter</span>
<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>

<table id="myTable" class= 'table table-bordered'>
<thead>
<tr>
	<th>ID</th>
	<th>Gebruikersnaam</th>
	<th>Beschrijving</th>
	<th>Datum</th>
	<th>Voornaam</th>
	<th>Achternaam</th>
	<th>Soort</th>
	<th>Status</th>
</tr>
    </thead>
    <tbody id="myTablex" class="searchable">
<?php
$i=0;
while($row=mysql_fetch_array($result)){
?>
	<tr onclick="location.href='admin.php?content=Incident_ov&ID=<?php echo $row[2]; ?>'">
	<td><?php echo $row[2];//INCIDENT.ID?></td>
	<td><?php echo $row["Gebruikersnaam"];?></td>
	<td><?php echo $row["Beschrijving"];?></td>
	<td><?php echo $row["Datum"];?></td>
	<td><?php echo $row["Voornaam"];?></td>
	<td><?php echo $row["Achternaam"];?></td>
	<td><?php echo $row[3];//INCIDENT_SOORT.Naam?></td>
	<td><?php echo $row[4];//INCIDENT_STATUS.Naam?></td>
    </tr>

		  
<?php		  
$i++;}
?>

<?php //
?>
</tbody>
</table>
      <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
</div>
<?php if(isset($_POST['Kennis'])){
?>
<input name="Terug" type="submit" id="bewerk" value="Terug" class= "btn btn-primary">	
<?php } else { ?>
<input name="Kennis" type="submit" id="bewerk" value="Kenis Bank" class= "btn btn-primary">
<?php } ?>
<p class="clearfix">&nbsp;</p>
</tr>
</div>
<?php } 

?>

<script>
    
    function klikbewerk() {
    var r = confirm("Weet je zeker dat je dit wil posten?");
    if (r == true) {
        document.cookie = "bewerk=0";
    } else {
        document.cookie = "bewerk=1";
    }
    }

    
</script>
