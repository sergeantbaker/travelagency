<style>

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.columnx {
  float: left;
}

.column {
  float: left;
  width: 9.8%;
}


/* The Modal (background) */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  padding-top: 100px;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow: auto;
  background-color: black;
}

/* Modal Content */
.modal-content {
  position: relative;
  background-color: #fefefe;
  margin: auto;
  padding: 0;
  width: 90%;
  max-width: 70%;
}

/* The Close Button */
.close {
  color: white;
  position: absolute;
  top: 10%;
  right: 10%;
  font-size: 70px;
  font-weight: bold;
}

.close:hover,
.close:focus {
  color: #999;
  text-decoration: none;
  cursor: pointer;
}

.mySlides {
  display: none;
}

/* Next & previous buttons */
.prev,
.next {
  cursor: pointer;
  position: absolute;
  top: 50%;
  width: auto;
  padding: 16px;
  margin-top: -50px;
  color: white;
  font-weight: bold;
  font-size: 20px;
  transition: 0.6s ease;
  border-radius: 0 3px 3px 0;
  user-select: none;
  -webkit-user-select: none;
}

/* Position the "next button" to the right */
.next {
  right: 0;
  border-radius: 3px 0 0 3px;
}

/* On hover, add a black background color with a little bit see-through */
.prev:hover,
.next:hover {
  background-color: rgba(0, 0, 0, 0.8);
}

/* Number text (1/3 etc) */
.numbertext {
  color: #f2f2f2;
  font-size: 12px;
  padding: 8px 12px;
  position: absolute;
  top: 0;
}

.caption-container {
  text-align: center;
  background-color: black;
  padding: 2px 16px;
  color: white;
}

img.demo {
  opacity: 0.6;
}

.active,
.demo:hover {
  opacity: 1;
}

img.hover-shadow {
  transition: 0.3s
}

.hover-shadow:hover {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19)
}

.center {
margin-top: 10%;
margin-left: 15%;
margin-right: 15%;

}



h1, h2, h3 {
    display: inline;
}
<?php if(!isset($_GET['ID'])) {
?>
table:hover{
	background-color: hsl(0,0%,80%);
		cursor: pointer;
}
<?php } ?>
</style>
<?php
$and = "";

if(isset($_GET['ID'])){
$ID = $_GET['ID'];
$and = "AND HOTEL_ID = $ID";
}

$sql = "SELECT HOTEL.rating, HOTEL.centrum, HOTEL.HotelNaam, HOTEL.Land, HOTEL.Stad, HOTEL_IMG.Img, HOTEL.ID
 FROM HOTEL, HOTEL_IMG 
 WHERE HOTEL.ID = HOTEL_IMG.HOTEL_ID 
 AND HOTEL_IMG.Head = 1 
 AND (SELECT COUNT(ID) FROM KAMER WHERE HOTEL_ID = HOTEL.ID AND STATUS_ID = 2) > 1 
	$and
	$BND
	$CND
	ORDER BY HOTEL.ID;";
	$result= mysql_query($sql);


if(isset($_GET['ID'])) {
	
$sql_rest= "SELECT Img FROM HOTEL_IMG WHERE HOTEL_ID = $ID AND head = 0;";
$sql_head= "SELECT Img FROM HOTEL_IMG WHERE HOTEL_ID = $ID AND head = 1;";
$result_rest= mysql_query($sql_rest);
$result_head= mysql_query($sql_head);
$count = mysql_num_rows($result_rest)+1;
$head=mysql_fetch_array($result_head);
$x=1;

$reviewq = "SELECT REVIEW.Datum, REVIEW.Review, REVIEW.Rating, KLANT.Voornaam, KLANT.Achternaam
FROM REVIEW, HOTEL, KLANT, GEBRUIKER
WHERE REVIEW.HOTEL_ID = HOTEL.ID 
AND REVIEW.GEBRUIKER_ID = GEBRUIKER.ID
AND KLANT.GEBRUIKER_ID = GEBRUIKER.ID 
AND HOTEL.ID = $ID";
$review = mysql_query($reviewq);

$prijsq = "SELECT MIN(Prijs) FROM KAMER WHERE HOTEL_ID = $ID";
$prijsu = mysql_query($prijsq);
$prijs = mysql_fetch_array($prijsu);
$row=mysql_fetch_array($result);
?>
<div style="width=100%; float:right;">
<table style="margin-top:1%; margin-right:2%;">
<td width="30%">
	<div class="row">
	<div class="columnx">
	<img style=" margin-left:2%; width:95%; " style="width:100%" src="<?php if (empty($row['Img'])){echo "https://openclipart.org/image/2400px/svg_to_png/194077/Placeholder.png";} else {echo $row['Img'];} ?>"
	 onclick="openModal();currentSlide(<?php echo $x; ?>)" class="hover-shadow">
</div>
</div>
	 </td>
	<td style="vertical-align:top;"><h2>&nbsp;Rating:</br><strong>&nbsp;<?php echo $row['rating']; ?>/100&nbsp;&nbsp;</strong></h2>
	</br></br>
	<h2>&nbsp;Vanaf:</br>
	<strong>&nbsp;<?php echo $prijs[0]; ?></strong></br></h2>&nbsp;&nbsp;EURO per nacht	
	</td>
	<td style="vertical-align:top; text-align: left;"><h1><?php echo $row[2] ?></h1></br><?php echo bstext2(); ?></td>
</tr>
</table>

</br></br></br>
<div style="float:left;">
<INPUT TYPE="button" value="Boek hotel" class= "btn btn-primary" onClick="parent.location='bookhotel.php?hotelid=<?php echo $ID; ?>'">
</div>
<div style="width:60%; float:right;">
<?php
while($rev=mysql_fetch_array($review)){
?>
<table "id="myTable" class= 'table table-bordered'>
	<tr>
	<th>Naam: <?php echo $rev[3] . " " . $rev[4] . " | Datum: " . $rev[0] . " | Rating: " . $rev[2] . "/100";?></th>
	</tr><tr>
	<td><?php echo $rev[1]; ?> </td>
	</tr>
</table>

<?php } ?>
</div>
</div>

<div id="myModal" class="modal">
  <span class="close cursor" onclick="closeModal()">&times;</span>
  <div class="modal-content">
	
<div class="mySlides">
<div class="numbertext"><?php echo $x++ . ' / ' . $count;?></div>
<img src="<?php echo $head['Img']; ?>" style="width:100%"; >
</div>
<?php

while($row=mysql_fetch_array($result_rest)){
?>
<div class="mySlides">
<div class="numbertext"><?php echo $x++ . ' / ' . $count;?></div>
<img src="<?php echo $row['Img']; ?>" style="width:100%">
</div>
<?php } ?>

<a class="prev" onclick="plusSlides(-1)">&#10094;</a>
<a class="next" onclick="plusSlides(1)">&#10095;</a>

<div class="caption-container">
<p id="caption"></p>
</div>

<?php
$sql= "SELECT Img FROM HOTEL_IMG WHERE HOTEL_ID = $ID;";
$result= mysql_query($sql);
$i=1;
while($row=mysql_fetch_array($result)){
$i++;
?>
<div class="column">
<img class="demo" src="<?php echo $row['Img']; ?>" onclick="currentSlide(<?php echo $i ?>)" width ="100%" height="9%">
</div>
<?php } ?>
</div>
</div>
<?php
}
?>

<?php
if(!isset($_GET['ID'])){
while($row=mysql_fetch_array($result)){
	?>
	
	<table style="float:right;" id="myTable" class= 'table table-bordered'>
	<tr onclick="location.href='index.php?content=home&ID=<?php echo $row["ID"]; ?>'">
	<td style="width:10%;"><img src="<?php if (empty($row['Img'])){echo "https://openclipart.org/image/2400px/svg_to_png/194077/Placeholder.png";
	} else {echo $row['Img'];} ?>" style="width:100%;"></td>
	<td width="20%"><h2><strong>Hotel&nbsp;Naam:</strong> <?php echo $row[2]; ?></h2></br>
		<h3><strong>Land:</strong> <?php echo $row[3]; ?></h3> </br>
		<h3><strong>Stad:</strong> <?php echo $row[4]; ?> </h3></br>
		<h3><strong>centrum: </strong> <?php echo $row['1']?>KM</h3>
	</td>
	<td style="height:10%; overflow:scroll;"><?php echo bstext(); ?>
	</br><div style="margin-bottom: 0%;"><h2>Rating:<strong> <?php echo $row['rating']; ?>/100</strong></h2></div>
	</td>
	</tr>
	</table>

<?php }} ?>


<script>
function openModal() {
  document.getElementById('myModal').style.display = "block";
}

function closeModal() {
  document.getElementById('myModal').style.display = "none";
}

var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("demo");
  var captionText = document.getElementById("caption");
  if (n > slides.length) {slideIndex = 1}
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";
  dots[slideIndex-1].className += " active";
  captionText.innerHTML = dots[slideIndex-1].alt;
}
</script>

