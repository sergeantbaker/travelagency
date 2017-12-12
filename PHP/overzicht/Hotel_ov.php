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

// query voor het overzicht
$sql= "
	SELECT HOTEL.ID, COUNT(KAMER.ID), HOTEL.HotelNaam, HOTEL.manager, HOTEL.Telefoon, HOTEL.Land, HOTEL.Stad
	FROM HOTEL, KAMER
	WHERE HOTEL.ID = KAMER.HOTEL_ID
	GROUP BY HOTEL.ID;";
$result= mysql_query($sql);
$count = mysql_num_rows($result);


if (isset($_POST['Kamer'])){
	$x = 0;
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$id = $_POST["checkbox$i"];
			$x++;
		}
	}
	if ($x == 1){
		header("Location: admin.php?content=Kamer_ov&id=$id");
	}
	?> <script> alert("Selecteer 1 veld!") </script> <?php	
}

// Code voor het deleten van de geselecteerde rows
if (isset($_POST['delete'])) {
	$delete = $_COOKIE['delete'];
	if ($delete == 0) {
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$del = $_POST["checkbox$i"];
			$query_hotel= "DELETE FROM HOTEL WHERE ID = $del;";
			$query_kamer= "DELETE FROM KAMER WHERE HOTEL_ID =$del;";
			$query_image= "DELETE FROM HOTEL_IMG WHERE HOTEL_ID = $del;";
			$result= mysql_query($query_hotel) or die ("FOUT:". mysql_error());
			$result= mysql_query($query_kamer) or die ("FOUT:". mysql_error());
			echo "$del";
		}
	}
	header("Location: admin.php?content=Hotel_ov");
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
	<th>Telefoon</th>
	<th>Manager</th>
	<th>Land</th>
	<th>Stad</th>
	<th>Centrum</th>
</tr>

<?php
	$x = 0;
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$x++;
			$bew = $_POST["checkbox$i"];
			$sql= "
				SELECT ID, HotelNaam, manager, Telefoon, Land, Stad, Centrum
				FROM HOTEL
				WHERE ID = $bew;";
			
		
$result= mysql_query($sql);
$row=mysql_fetch_array($result);

?>
	<input type="hidden" name="test<?php echo $x; ?>" value="<?php echo $row["ID"];?>">

	<tr><td width="1%" ><?php echo $row["ID"];?></td> 
	
	<td width=><input type="text" name="HotelNaam<?php echo $x; ?>" value="<?php echo $row["HotelNaam"];?>" style="width: 100%;" /></td>
		
	<td width=><input type="text" pattern="[0-9]{1,10}" maxlength="10" name="Telefoon<?php echo $x; ?>" value="<?php echo $row["Telefoon"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="text" name="manager<?php echo $x; ?>" value="<?php echo $row["manager"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="text" name="Land<?php echo $x; ?>" value="<?php echo $row["Land"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="text" name="Stad<?php echo $x; ?>" value="<?php echo $row["Stad"];?>" style="width: 100%;" /></td>
	
	<td width=><input type="number" name="Centrum<?php echo $x; ?>" value="<?php echo $row["Centrum"];?>" style="width: 100%;" /></td>
		
<?php

		}
	}
if($x==0){ header("Location: admin.php?content=Hotel_ov");}
?>
<input type="hidden" name="keer" value="<?php echo $x; ?>">
</tr>
</table>
<input name="bewerk2" type="submit" id="bewerk2" value="Bewerk" class= "btn btn-primary" onclick="klikbewerk()">
<?php if($x==1){?><input name="addimg" type="submit" id="addimg" value="Afbeelding" class= "btn btn-primary"> <?php } ?>
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Hotel_ov'">
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
				UPDATE HOTEL SET
				HotelNaam='".$_POST["HotelNaam$i"]."',
				Telefoon='".$_POST["Telefoon$i"]."',
				manager='".$_POST["manager$i"]."',
				Land='".$_POST["Land$i"]."',
				Stad='".$_POST["Stad$i"]."',
				Centrum='".$_POST["Centrum$i"]."'
				WHERE ID = $ID;";
		$result= mysql_query($sql) or die ("FOUT:1". mysql_error());
		}
	
	header("Location: admin.php?content=Hotel_ov");
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
<tr><h2>Hotels toevoegen</h2></tr>
<tr><td width="1%"><h3>Hoeveel&nbsp;Hotels</h3></td>
	<td width="100px"><h3><input type="number" name="keer" style="width: 100%;" min="1" max="99" value="0" /></td>
	<td width="1px"><h1><input name="add2" type="submit" id="add2" value="OK" class="btn btn-primary"></h1></td>
	</table>
	
	<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Hotel_ov'">
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
	<th>Hotel Naam</th>
	<th>Afbeelding</th>
	<th>Manager</th>
	<th>Telefoon</th>
	<th>Land</th>
	<th>Stad</th>
	<th>Centrum</th>
</tr>
<?php
	for($i=0;$i<$_POST['keer'];$i++){
?>
		<tr>
			<td><input type="text" name="HotelNaam<?php echo $i; ?>" placeholder="Hotel Naam" required style="width: 100%;" /></td>
			<td><input type="text" name="URL<?php echo $i; ?>" placeholder="Afbeelding URL" style="width: 100%;" /></td>
			<td><input type="text" name="manager<?php echo $i; ?>" placeholder="Manager" required style="width: 100%;" /></td>
			<td><input type="text" name="Telefoon<?php echo $i; ?>" placeholder="Telefoon nummer" pattern="[0-9]{1,10}" required style="width: 100%;" /></td>
			<td><input type="text" name="Land<?php echo $i; ?>" placeholder="Land" required style="width: 100%;" /></td>
			<td><input type="text" name="Stad<?php echo $i; ?>" placeholder="Stad" required style="width: 100%;" /></td>
			<td><input type="text" name="Centrum<?php echo $i; ?>" placeholder="Afstand Centrum" required style="width: 100%;" /></td>

		</tr>
<?php
	}
?>
</table>
<input name="add3" type="submit" id="add3" value="Toevoegen" class= "btn btn-primary" onclick="klikadd()">
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Hotel_ov'">
<?php
}
//einde van de code waar je de velden van de nieuwe rows invult
//Vervolg van de code voor het toevoegen van nieuwe rows
//Hier vult het systeem de waardes die je hebt opgegeven in het vorige veld
if (isset($_POST['add3'])) {
	$add = $_COOKIE['add'];
	if ($add == 0) {	
	for($i=0; $i<$_POST['keer']; $i++){
	$hnaam = $_POST["HotelNaam$i"];
	$man = $_POST["manager$i"];
	$tfn = $_POST["Telefoon$i"];
	$std = $_POST["Stad$i"];
	$lnd = $_POST["Land$i"];
	$cnt = $_POST["Centrum$i"];
	$url = $_POST["URL$i"];
	
		$insert_hotel=   "INSERT INTO HOTEL (HotelNaam, manager, Telefoon, Stad, Land, Rating, Centrum)
					VALUES ('$hnaam', '$man', '$tfn', '$std', '$lnd','100', '$cnt');";
		$add_member_hotel = mysql_query($insert_hotel) or die (mysql_error());
		$sql = "SELECT ID FROM HOTEL WHERE HotelNaam = '$hnaam' AND Stad = '$std';";
		$result= mysql_query($sql);
		$row=mysql_fetch_array($result);
		$ID=$row["0"];
		echo $ID;
		if(!empty($url)) {
		$insert_img= "INSERT INTO HOTEL_IMG (HOTEL_ID, Img, head)
					VALUES('$ID', '$url', '1');";
		$add_member_img = mysql_query($insert_img) or die (mysql_error());
		}
		
		$insert_kamer ="INSERT INTO KAMER (Kamers, Slaapplaatsen, Prijs, HOTEL_ID, STATUS_ID)
					VALUES ('0', '0', '0', $ID, 1);";
		
		$add_member_kamer = mysql_query($insert_kamer) or die (mysql_error());
		
	}
	header("Location: admin.php?content=Hotel_ov");
	}

}
//einde van de code velden toevoegen.

if (isset($_POST['addimg'])) {
	?>
<div class="center">
<form name="form1" method="post" action="">
<table class= 'table table-bordered'>
<tr><h2>Afbeeldingen Toevoegen</h2></tr>
<tr><td width="1%"><h3>Hoeveel&nbsp;Afbeeldingen</h3></td>
	<input type="hidden" name="ID" value="<?php echo $_POST['test1']; ?>">
	<td width="100px"><h3><input type="number" name="keer" style="width: 100%;" min="1" max="99" value="0" /></td>
	<td width="1px"><h1><input name="addimg2" type="submit" id="addimg2" value="OK" class="btn btn-primary"></h1></td>
	</table>
	
	<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Hotel_ov'">
	</form>
</div>
<?php
}
//van het selecteren van de hoeveel soorten rows
//Vervolg van de code voor het toevoegen van nieuwe rows
//Hier geef je de waardes van de velden van de kamers die je wilt toevoegen
if (isset($_POST['addimg2'])) {
?>
<form name="form1" method="post" action="">
<table class= 'table table-bordered'>
<input type="hidden" name="keer" value="<?php echo $_POST['keer']; ?>">
<input type="hidden" name="ID" value="<?php echo $_POST['ID']; ?>">
<thead>
<tr>
	<th>Afbeelding URL</th>
</tr>
<?php
	for($i=0;$i<$_POST['keer'];$i++){
?>
		<tr>
			<td><input type="text" name="URL<?php echo $i; ?>" placeholder="Afbeelding URL" style="width: 100%;" /></td>
		</tr>
<?php
	}
?>
</table>
<input name="addimg3" type="submit" id="addimg3" value="Toevoegen" class= "btn btn-primary" onclick="klikadd()">
<INPUT TYPE="button" value="Terug" class= "btn btn-primary" onClick="parent.location='admin.php?content=Hotel_ov'">
<?php
}
//einde van de code waar je de velden van de nieuwe rows invult
//Vervolg van de code voor het toevoegen van nieuwe rows
//Hier vult het systeem de waardes die je hebt opgegeven in het vorige veld
if (isset($_POST['addimg3'])) {
	$add = $_COOKIE['add'];
	if ($add == 0) {	
	for($i=0; $i<$_POST['keer']; $i++){
	$ID = $_POST["ID"];
	$url = $_POST["URL$i"];
	
		$insert_img= "INSERT INTO HOTEL_IMG (HOTEL_ID, Img, head)
					VALUES('$ID', '$url', '0');";
		$add_member_img = mysql_query($insert_img) or die (mysql_error());
		
	}
	header("Location: admin.php?content=Hotel_ov");
	}

}

if(isset($_GET['IMG'])) {
	$ID = $_GET['IDmg'];
	$IMG = $_GET['IMG'];
	$clear = "UPDATE HOTEL_IMG SET 
			head = 0
			WHERE HOTEL_ID = $ID;";
	$result_clear = mysql_query($clear) or die ("FOUT:1". mysql_error());
	$head = "UPDATE HOTEL_IMG SET 
			head = 1 
			WHERE HOTEL_ID = $ID
			AND	Img = '$IMG';";
	$result_head = mysql_query($head) or die ("FOUT:1". mysql_error());

header("Location: admin.php?content=Hotel_ov");		
}

if(isset($_GET['IDmg'])) {
	$ID = $_GET['IDmg'];
	$sql = "SELECT * FROM HOTEL_IMG WHERE HOTEL_ID = $ID;";
	$result= mysql_query($sql);	

?>
<h2>Kies een nieuwe head</h2>
<form name="form1" method="post" action="">
<table id="myTable" class= 'table table-bordered'>
<tr>
<tr>
	<th>Hotel Naam</th>
</tr>
<?php
$i=0;
while($row=mysql_fetch_array($result)){
?>
	<tr width="20%" onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $ID ?>&IMG=<?php echo $row['Img'] ?>'">
	<td width="21%"><img src="<?php echo $row['Img']; ?>" style="width:100%"; ></td><td><?php echo $row['Img']; ?></td>
	</tr>
		  
<?php		  
$i++;
}
}



	 	if (empty($_POST['bewerk'])) { 
		if (empty($_POST['add'])) {
		if (empty($_POST['add2'])) {
		if (empty($_POST['addimg'])) {
		if (empty($_POST['addimg2'])) {
		if (empty($_GET['IDmg'])) {
		
?>

<h2>Hotels</h2>
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
	<th>Manager</th>
	<th>Telefoon</th>
	<th>Land</th>
	<th>Stad</th>
</tr>
    </thead>
    <tbody id="myTablex" class="searchable">
<?php
$i=0;
while($row=mysql_fetch_array($result)){
$kamers = $row['1'] - 1;
?>
	<tr>
	<td width="20px" ><input name="checkbox<?php echo"$i"?>" type="checkbox" id="checkbox[]" value="<? echo $row['ID']; ?>"></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $row["ID"];?></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $row["HotelNaam"];?></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $kamers;?></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $row["manager"];?></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $row["Telefoon"];?></td>
	<td onclick="location.href='admin.php?content=Hotel_ov&IDmg=<?php echo $row["ID"]; ?>'"><?php echo $row["Land"];?></td>
	<td onclick="location.href='admin.php?content=style&ID=<?php echo $row["ID"]; ?>'"><?php echo $row["Stad"];?></td>
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
<input name="delete" type="submit" id="delete" value="Delete" class= "btn btn-primary" onclick="klikverwijder()">
<input name="bewerk" type="submit" id="bewerk" value="Bewerk" class= "btn btn-primary">
<input name="add" type="submit" id="add" value="Toevoegen" class= "btn btn-primary">
<input name="Kamer" type="submit" id="Kamer" value="Kamers" class= "btn btn-primary">
<p class="clearfix">&nbsp;</p>
</tr>
</div>
<?php }}}}}} 
} else {header("Location: ..demo/route.php");}?>

<script>
    function klikverwijder() {
    var r = confirm("Wil je deze velden verwijderen?\n Hiermee verwijder je ook alle kamers van dit hotel.");
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
    
    function klikkamer() {
    var r = confirm("Selecteer 1 veld");
    }
    
</script>
