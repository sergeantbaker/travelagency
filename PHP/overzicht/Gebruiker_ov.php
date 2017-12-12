<style>
.center {
margin-top: 10%;
margin-left: 15%;
margin-right: 15%;
}

tr:hover{
	background-color: hsl(0,0%,80%);
	cursor: pointer;
}

</style>
<?php 
if (isset($_GET['content'])) {
$sql= "
	SELECT GEBRUIKER.ID, KLANT.Voornaam, KLANT.Achternaam, KLANT.Geboortedatum, GEBRUIKER.Gebruikersnaam   
	FROM GEBRUIKER, KLANT
	WHERE GEBRUIKER.SOORT_ID = 1
	AND	GEBRUIKER.ID = KLANT.GEBRUIKER_ID
	ORDER BY GEBRUIKER.ID;";
$result= mysql_query($sql);
$count = mysql_num_rows($result);

if (isset($_GET['ID'])){
	$ID = $_GET['ID'];
	$info = "SELECT * FROM KLANT, GEBRUIKER WHERE KLANT.GEBRUIKER_ID = GEBRUIKER.ID AND GEBRUIKER.ID = $ID";
	$result_info = mysql_query($info);
	$row=mysql_fetch_array($result_info);
	?>
	<h2>Gebruikers Informatie</h2>
	<form name="form1" method="post" action="">
	<table id="myTable" class= 'table table-bordered'>
	<tr><th width="20%">INFO</th><th>DATA</th></tr>
	<tr><td>USER_ID</td><td><?php echo $row['ID'] ?></td>
	<tr><td>Gebruikersnaam</td><td><?php echo $row['Gebruikersnaam'] ?></td>
	<tr><td>Voornaam</td><td><?php echo $row['Voornaam'] ?></td>
	<tr><td>Achternaam</td><td><?php echo $row['Achternaam'] ?></td>
	<tr><td>Geboorte Datum</td><td><?php echo $row['Geboortedatum'] ?></td>
	<tr><td>Geslacht</td><td><?php echo $row['Geslacht'] ?></td>
	<tr><td>Telefoon</td><td><?php echo $row['Telefoon'] ?></td>
	<tr><td>Mail</td><td><?php echo $row['Mail'] ?></td>
	<tr><td>Land</td><td><?php echo $row['Land'] ?></td>
	<tr><td>Stad</td><td><?php echo $row['Stad'] ?></td>
	<tr><td>Straat</td><td><?php echo $row['Straat'] ?></td>
	<tr><td>StraatNr</td><td><?php echo $row['StraatNr'] ?></td>
	<tr><td>Postcode</td><td><?php echo $row['Postcode'] ?></td>
	
	</table>
	<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Gebruiker_ov'">
	
			
<?php	
}

// Code voor het deleten van de geselecteerde rows
if (isset($_POST['delete'])) {
	$delete = $_COOKIE['delete'];
	if ($delete == 0) {
	if ($_SESSION["SOORT"] == 3){
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$del = $_POST["checkbox$i"];
			$query= "DELETE FROM GEBRUIKER WHERE ID = $del;";
			$result= mysql_query($query) or die ("FOUT:". mysql_error());
			echo "$del";
		}
	}
	}
	header("Location: admin.php?content=Gebruiker_ov");
	
	}
}
// einde code voor het deleten van de geselecteerde rows
if (empty($_GET['ID'])) {
	
		
?>

<h2>Gebruikers</h2>
<form name="form1" method="post" action="">
<div class="input-group"> <span class="input-group-addon">Filter</span>
<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>

<table id="myTable" class= 'table table-bordered'>
<thead>
<tr>
	<th></th>
	<th>ID</th>
	<th>Voornaam</th>
	<th>Achternaam</th>
	<th>Geboortedatum</th>
	<th>Gebruikersnaam</th>
</tr>
    </thead>
    <tbody id="myTablex" class="searchable">
<?php
$i=0;
while($row=mysql_fetch_array($result)){
?>
	<tr>
	<td width="20px" ><input name="checkbox<?php echo"$i"?>" type="checkbox" id="checkbox[]" value="<? echo $row['ID']; ?>"></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["ID"];?></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["Voornaam"];?></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["Achternaam"];?></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["Geboortedatum"];?></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["Gebruikersnaam"];?></td>
	</tr>

		  
<?php		  
$i++;}
?>


</tbody>
</table>
      <div class="col-md-12 text-center">
      <ul class="pagination pagination-lg pager" id="myPager"></ul>
</div>
<input name="delete" type="submit" id="delete" value="Delete" class= "btn btn-primary" onclick="klikverwijder()">
<p class="clearfix">&nbsp;</p>
</tr>
</div>

<?php } 

} else {header("Location: ../route.php");}
?>
<script>
    function klikverwijder() {
    var r = confirm("Wil je deze velden verwijderen?");
    if (r == true) {
        document.cookie = "delete=0";
    } else {
        document.cookie = "delete=1";
    }
    }
    
    
        function klikadd() {
    var r = confirm("Wil je deze velden toevoegen?");
    if (r == true) {
        document.cookie = "add=0";
    } else {
        document.cookie = "add=1";
    }
    }
    
</script>
