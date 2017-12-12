<style>
.center {
margin-top: 10%;
margin-left: 15%;
margin-right: 15%;

}
tr:hover{
	background-color: hsl(0,0%,80%);

}
</style>
<?php
if (isset($_GET['content'])) {
$and = "";
if (isset($_GET['id'])){
	$id = $_GET['id'];
	$and = "AND HOTEL_ID = '$id'";
}

$sql= "
	SELECT KAMER.ID, HOTEL.HotelNaam, KAMER.Kamers, KAMER.Slaapplaatsen, KAMER.Prijs, KAMER_STATUS.Naam  
	FROM KAMER, HOTEL, KAMER_STATUS
	WHERE KAMER.HOTEL_ID = HOTEL.ID
	AND	KAMER.STATUS_ID = KAMER_STATUS.ID
	AND KAMER.Kamers > 0
	$and
	ORDER BY ID;";
$result= mysql_query($sql);
$count = mysql_num_rows($result);

// Code voor het deleten van de geselecteerde rows
if (isset($_POST['delete'])) {
	$delete = $_COOKIE['delete'];
	if ($delete == 0) {
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$del = $_POST["checkbox$i"];
			$query= "DELETE FROM KAMER WHERE ID = $del;";
			$result= mysql_query($query) or die ("FOUT:". mysql_error());
			echo "$del";
		}
	}
	header("Location: admin.php?content=Kamer_ov");
	}
}
// einde code voor het deleten van de geselecteerde rows

// Code voor het bewerken van de geselecteerde rows
if (isset($_POST['bewerk'])) {
?>		
<h2>Bewerk</h2>
<form name="form1" method="post" action="">
<table class= 'table table-bordered'>
<tr>
<tr>
	<th>ID</th>
	<th>Hotel Naam</th>
	<th>Kamers</th>
	<th>Slaap plaatsen</th>
	<th>Prijs</th>
	<th>Status</th>
</tr>

<?php
	$x = 0;
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$x++;
			$bew = $_POST["checkbox$i"];
			$sql= "
				SELECT KAMER.ID, HOTEL.HotelNaam, KAMER.Kamers, KAMER.Slaapplaatsen, KAMER.Prijs, KAMER_STATUS.Naam  
				FROM KAMER, HOTEL, KAMER_STATUS
				WHERE KAMER.HOTEL_ID = HOTEL.ID
				AND	KAMER.STATUS_ID = KAMER_STATUS.ID
				AND KAMER.Kamers > 0
				AND KAMER.ID = $bew;";
			$query_Hotel = "SELECT * FROM HOTEL";
			$query_Status = "SELECT * FROM KAMER_STATUS";
			
		
$result= mysql_query($sql);
$row=mysql_fetch_array($result);
$result_Hotel = mysql_query($query_Hotel);
$result_Status = mysql_query($query_Status);
$hotelnaam = $row["HotelNaam"];
$naam = $row["Naam"];
$query_hid = "SELECT ID FROM HOTEL WHERE HotelNaam = '$hotelnaam';";
$query_sid = "SELECT ID FROM KAMER_STATUS WHERE Naam = '$naam';";
$result_hid = mysql_query($query_hid);
$result_sid = mysql_query($query_sid);
$hid = mysql_fetch_row($result_hid);
$sid = mysql_fetch_row($result_sid);


?>
	<input type="hidden" name="test<?php echo $x; ?>" value="<?php echo $row["ID"];?>">

	<tr><td width="1%" ><?php echo $row["ID"];?></td> 
		
	<td><select name="HotelNaam<?php echo $x; ?>" value="<? echo $row["HotelNaam"];?>">
		<option value="<?php echo $hid[0]; ?>"><?php echo $hotelnaam;?></option>
		<?php while($hotel = mysql_fetch_row($result_Hotel)){
			echo "<option value='".$hotel['0']."'>" . $hotel[3] . "</option>";}	?> </select></td>
				
	<td width=><input type="number" min="1" name="Kamers<?php echo $x; ?>" value="<?php echo $row["Kamers"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="number" min="1" name="Slaapplaatsen<?php echo $x; ?>" value="<?php echo $row["Slaapplaatsen"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="number" min="1" name="Prijs<?php echo $x; ?>" value="<?php echo $row["Prijs"];?>" style="width: 100%;" /></td>
	
	<td><select name="Naam<?php echo $x; ?>" value="<? echo $row["Naam"];?>">
		<option value="<?php echo $sid[0]; ?>"><?php echo $naam;?></option>
		<?php while($Status = mysql_fetch_row($result_Status)){
			echo "<option value='".$Status['0']."'>" . $Status[1] . "</option>";}	?> </select></td>
<?php

		}
	}
if($x==0){ header("Location: admin.php?content=Kamer_ov");}
?>
<input type="hidden" name="keer" value="<?php echo $x; ?>">
</tr>
</table>
<input name="bewerk2" type="submit" id="bewerk2" value="Bewerk" class= "btn btn-primary" onclick="klikbewerk()">
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Kamer_ov'">
<?php } 
// einde voor het bewerken van de geselecteerde rows
// vervolg van het bewerken van de geselecteerde rows
if (isset($_POST['bewerk2'])) {
	$bewerk = $_COOKIE['bewerk'];
	if ($bewerk == 0) {
	$x = $_POST['keer'] + 1;
	for ($i=1; $i<$x; $i++){
		$ID = $_POST["test$i"];
		$sql = "
				UPDATE KAMER SET
				HOTEL_ID='".$_POST["HotelNaam$i"]."',
				Kamers='".$_POST["Kamers$i"]."',
				Slaapplaatsen='".$_POST["Slaapplaatsen$i"]."',
				Prijs='".$_POST["Prijs$i"]."',
				STATUS_ID='".$_POST["Naam$i"]."'
				WHERE ID = $ID;";
		$result= mysql_query($sql) or die ("FOUT:1". mysql_error());
		}
	
	header("Location: admin.php?content=Kamer_ov");
}
}
//einde code van het bewerken van de geselecteerde rows

//Code voor het toevoegen van nieuwe rows
//Hier selecteer je hoeveel soorten kamers je wil toevoegen
if (isset($_POST['add'])) {
?>
<div class="center">
<form name="form1" method="post" action="">
<table class= 'table table-bordered'>
<tr><h2>Kamers toevoegen</h2></tr>
<tr><td width="1%"><h3>Hoeveel&nbsp;soorten&nbsp;kamers</h3></td>
	<td width="100px"><h3><input type="number" name="keer" style="width: 100%;" min="1" max="99" value="0" /></td>
	<td width="1px"><h1><input name="add2" type="submit" id="add2" value="OK" class="btn btn-primary"></h1></td>
	</table>
	
	<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Kamer_ov'">
	</form>
</div>
<?php
}
//van het selecteren van de hoeveel soorten rows
//Vervolg van de code voor het toevoegen van nieuwe rows
//Hier geef je de waardes van de velden van de kamers die je wilt toevoegen
if (isset($_POST['add2'])) {
?>
<form name="form1" method="post" action="">
<table class= 'table table-bordered'>
<input type="hidden" name="keer" value="<?php echo $_POST['keer']; ?>">
<thead>
<tr>
	<th>Herhaal</th>
	<th>Hotel Naam</th>
	<th>Kamers</th>
	<th>Slaap plaatsen</th>
	<th>Prijs</th>
</tr>
<?php
	for($i=0;$i<$_POST['keer'];$i++){
$query_hotel = "SELECT * FROM HOTEL";
$result_hotel = mysql_query($query_hotel);
?>
		<tr>
			<td width="1%"><input type="number" name="herhaal<?php echo $i; ?>" value="1" required style="width: 100%;" min="1" /></td>
			<td><select name="HotelNaam<?php echo $i; ?>" required><?php while($row = mysql_fetch_row($result_hotel)) echo "<option value='".$row[0]."'>" . $row[3] . "</option>";?></select></td>
			<td><input type="number" name="Kamers<?php echo $i; ?>" value="1" required style="width: 100%;" min="1" /></td>
			<td><input type="number" name="Slaapplaatsen<?php echo $i; ?>" value="1" required style="width: 100%;" min="1" /></td>
			<td><input type="number" name="Prijs<?php echo $i; ?>" value="1" required style="width: 100%;" min="1" /></td>
		</tr>
<?php
	}
?>
</table>
<input name="add3" type="submit" id="add3" value="Toevoegen" class= "btn btn-primary" onclick="klikadd()">
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Kamer_ov'">
<?php
}
//einde van de code waar je de velden van de nieuwe rows invult
//Vervolg van de code voor het toevoegen van nieuwe rows
//Hier vult het systeem de waardes die je hebt opgegeven in het vorige veld
if (isset($_POST['add3'])) {
	echo $_POST['herhaal0'];
	$add = $_COOKIE['add'];
	if ($add == 0) {	
	for($i=0; $i<$_POST['keer']; $i++){
	$kamer = $_POST["Kamers$i"];
	$slaap = $_POST["Slaapplaatsen$i"];
	$prijs = $_POST["Prijs$i"];
	$hid = $_POST["HotelNaam$i"];
		$insert=   "INSERT INTO KAMER (Kamers, Slaapplaatsen, Prijs, HOTEL_ID, STATUS_ID)
					VALUES ('$kamer', '$slaap', '$prijs', '$hid', 2);";
		for($ii=0; $ii<$_POST["herhaal$i"]; $ii++){
			$add_member = mysql_query($insert) or die (mysql_error());
		}
	}
	header("Location: admin.php?content=Kamer_ov");
	}

}
//einde van de code velden toevoegen.
?>



<?php  	if (empty($_POST['bewerk'])) { 
		if (empty($_POST['add'])) {
		if (empty($_POST['add2'])) {  	
?>

<h2>Kamers</h2>
<form name="form1" method="post" action="">
<div class="input-group"> <span class="input-group-addon">Filter</span>
<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>

<table id="myTable" class= 'table table-bordered'>
<thead>
<tr>
	<th></th>
	<th>ID</th>
	<th>Hotel Naam</th>
	<th>Kamers</th>
	<th>Slaap plaatsen</th>
	<th>Prijs</th>
	<th>Status</th>
</tr>
    </thead>
    <tbody id="myTablex" class="searchable">
<?php
$i=0;
while($row=mysql_fetch_array($result)){
?>
	<tr><td width="20px" ><input name="checkbox<?php echo"$i"?>" type="checkbox" id="checkbox[]" value="<? echo $row['ID']; ?>"></td>
	<td><?php echo $row["ID"];?></td>
	<td><?php echo $row["HotelNaam"];?></td>
	<td><?php echo $row["Kamers"];?></td>
	<td><?php echo $row["Slaapplaatsen"];?></td>
	<td><?php echo $row["Prijs"];?></td>
	<td><?php echo $row["Naam"];?></td></tr>

		  
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
<input name="delete" type="submit" id="delete" value="Delete" class= "btn btn-primary" onclick="klikverwijder()">
<input name="bewerk" type="submit" id="bewerk" value="Bewerk" class= "btn btn-primary">
<input name="add" type="submit" id="bewerk" value="Toevoegen" class= "btn btn-primary">
<p class="clearfix">&nbsp;</p>
</tr>
</div>
<?php }}}
} else {header("Location: ../route.php");} ?>

<script>
    function klikverwijder() {
    var r = confirm("Wil je deze velden verwijderen?");
    if (r == true) {
        document.cookie = "delete=0";
    } else {
        document.cookie = "delete=1";
    }
    }
    
    function klikbewerk() {
    var r = confirm("Wil je deze velden bewerken?");
    if (r == true) {
        document.cookie = "bewerk=0";
    } else {
        document.cookie = "bewerk=1";
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
