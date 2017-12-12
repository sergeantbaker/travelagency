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


//mail($mailaddress, $subject, $text);
//mail("renebakker150@gmail.com","homeo","kut homeo");
//echo "dit zou moeten werken";

//$x = date('Y-m-d', strtotime($x . ' +1 day'));

$sql= "
	SELECT BOEKING.ID, BOEKING.Startdatum, BOEKING.Einddatum, BOEKING.Prijs,
	BOEKING_STATUS.Naam, GEBRUIKER.ID, KAMER.ID, HOTEL.ID,
	HOTEL.HotelNaam   
	FROM BOEKING, BOEKING_STATUS, GEBRUIKER, KAMER, HOTEL
	WHERE KAMER.HOTEL_ID = HOTEL.ID
	AND BOEKING.KAMER_ID = KAMER.ID 
	AND BOEKING.GEBRUIKER_ID = GEBRUIKER.ID 
	AND BOEKING.STATUS_ID = BOEKING_STATUS.ID
	ORDER BY BOEKING.ID;";
	
$result= mysql_query($sql);
$count = mysql_num_rows($result);

// Code voor het deleten van de geselecteerde rows
if (isset($_POST['delete'])) {
	$delete = $_COOKIE['delete'];
	if ($delete == 0) {
	for($i=0;$i<$count;$i++){
		if (isset($_POST["checkbox$i"])){
			$del = $_POST["checkbox$i"];
			$query= "DELETE FROM BOEKING WHERE ID = $del;";
			$result= mysql_query($query) or die ("FOUT:". mysql_error());
			echo "$del";
		}
	}
	header("Location: admin.php?content=Kamer_ov");
	}
}
?>


<h2>Boekingen</h2>
<form name="form1" method="post" action="">
<div class="input-group"> <span class="input-group-addon">Filter</span>
<input id="filter" type="text" class="form-control" placeholder="Type here...">
</div>

<table id="myTable" class= 'table table-bordered'>
<thead>
<tr>
	<th></th>
	<th>ID</th>
	<th>Gebruiker ID</th>
	<th>Hotel naam</th>
	<th>Kamer ID</th>
	<th>Start datum</th>
	<th>Eind datum</th>
	<th>Prijs</th>
	<th>Status</th>
</tr>
    </thead>
    <tbody id="myTablex" class="searchable">
<?php
$i=0;
while($row=mysql_fetch_array($result)){
?>
	<tr><td width="20px" ><input name="checkbox<?php echo"$i"?>" type="checkbox" id="checkbox[]" value="<? echo $row[0]; ?>"></td>
	<td><?php echo $row[0];?></td>
	<td onclick="location.href='admin.php?content=Gebruiker_ov&ID=<?php echo $row[5]; ?>'"><?php echo $row[5];?></td>
	<td><?php echo $row[8];?></td>
	<td><?php echo $row[6];?></td>
	<td><?php echo $row[1];?></td>
	<td><?php echo $row[2];?></td>
	<td><?php echo $row[3];?></td>
	<td><?php echo $row[4];?></td></tr>

		  
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
<?php //
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
