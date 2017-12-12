<style>

.row > .column {
  padding: 0 8px;
}

.row:after {
  content: "";
  display: table;
  clear: both;
}

.column {
  float: left;
  width: 9.0909090909%;
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
</style>


<?php
if (empty($_GET['ID'])){
	header("Location: admin.php?content=Hotel_ov");
}


$ID= $_GET['ID'];
$sql_rest= "SELECT Img FROM HOTEL_IMG WHERE HOTEL_ID = $ID AND head = 0;";
$sql_head= "SELECT Img FROM HOTEL_IMG WHERE HOTEL_ID = $ID AND head = 1;";
$result_rest= mysql_query($sql_rest);
$result_head= mysql_query($sql_head);
$count = mysql_num_rows($result_rest) + 1;
$head=mysql_fetch_array($result_head);
$x=1;
?>
<div class="row">
	<div class="column">
		<img src="<?php echo $head['Img']; ?>" onclick="openModal();currentSlide(<?php echo $x; ?>)" class="hover-shadow">
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
$i=0;
while($row=mysql_fetch_array($result)){
$i++;
?>
<div class="column">
<img class="demo" src="<?php echo $row['Img']; ?>" onclick="currentSlide(<?php echo $i ?>)" width ="100%" height="9%">
</div>
<?php } ?>
</div>
</div>

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



