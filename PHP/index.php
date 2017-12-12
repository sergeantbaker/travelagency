<style>
/* Style The Dropdown Button */
.dropbtn {
    background-color: #4CAF50;
    color: white;
    padding: 16px;
    font-size: 16px;
    border: none;
    cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
}

.dropdown-content a {
    color: black;
    padding: 12px 16px;
    text-decoration: none;
    display: block;
}

.dropdown-content a:hover {background-color: #f1f1f1}

.dropdown:hover .dropdown-content {
    display: block;
}

.dropdown:hover .dropbtn {
    background-color: #3e8e41;
}

h1 a:link, h1 a:visited {
    color:#055830;
    font-weight:100;
}
</style>

  <head>
    <title>Travel</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    
  </head>
<?php
include ("database.php");    
echo conect();
$content = 'home';
session_start();

if(isset($_SESSION['ID'])) {
	$ID = $_SESSION['ID'];
	$quser = 
	"SELECT GEBRUIKER.ID, KLANT.Voornaam, KLANT.Achternaam
	FROM GEBRUIKER, KLANT
	WHERE GEBRUIKER.ID = KLANT.GEBRUIKER_ID
	AND GEBRUIKER.ID = $ID ;";
		$result_quser = mysql_query($quser);
		$user = mysql_fetch_row($result_quser);
}
$sql_land = 
"SELECT DISTINCT Land
FROM HOTEL";
$result_land= mysql_query($sql_land);
$gLID = mysql_query("SELECT ID FROM LAND");
$LID = mysql_fetch_row($gLID);

$sql_stad = 
"SELECT DISTINCT Stad
FROM HOTEL";
$result_stad= mysql_query($sql_stad);
?>


<div style="border: solid #000 2px; width:100%; height:20%; background-image: url('athene.jpg');background-size: 100%; background-repeat:no-repeat; float:left;">
<div style="float: right; margin-top:0%;">
<?php if(!isset($_SESSION['ID'])){?>
<INPUT TYPE="button" value="Registreer" class= "btn btn-primary" onClick="parent.location='index.php?content=Registration'">
<?php } else {?>

<div class="dropdown">
	  <button class= "btn btn-primary"><?php echo $user['1'] . ' ' . $user['2'];?></button>
	<div class="dropdown-content">
    <a href="index.php?content=contact/melding_ov">Melding</a>
    <a href="mybookings.php">Boekingen</a>
    <a href="index.php?content=user/profile">Profiel</a>
  </div>
</div>
		 
<?php		 
} if(!isset($_SESSION['ID'])){?>
<INPUT TYPE="button" value="Inloggen" class= "btn btn-primary" onClick="parent.location='index.php?content=Login'">
<?php } else { ?>
<INPUT TYPE="button" value="Uitloggen" class= "btn btn-primary" onClick="parent.location='index.php?content=Logout'">	
<?php } ?>
<INPUT TYPE="button" value="Contact" class= "btn btn-primary" onClick="parent.location='index.php?content=contact/Contactpagina'">
</div>
<a href="index.php"><h1 style="text-shadow: 2px 2px yellow; font-size: 500%; color:#000; font-weight:100;">TRAVEL AGENCY</h1></a>


   
</div>



<?php if(!isset($_GET['content'])) {?>
<div style="width: 99%; float:right; margin-top:1%; margin-left:1%;">
<form name="form1" method="post" action="">
<select name="Land"><option value = ""></option><?php while($row = mysql_fetch_row($result_land)) echo "<option value='".$row[0]."'>" . $row[0] . "</option>";?></select>
<select name="Stad"><option value = ""></option><?php while($row = mysql_fetch_row($result_stad)) echo "<option value='".$row[0]."'>" . $row[0] . "</option>";?></select>
<input name="zoek" type="submit" id="zoek" value="Zoek">
</div>
<?php } ?>
<section id="main-contentx">
	<section class="wrapper">

<?php
$BND = "";
$CND = "";
if (isset($_POST['zoek'])){
if (!empty($_POST['Stad'])){ $stad = $_POST['Stad']; $BND = "AND HOTEL.Stad = '$stad'"; }	
if (!empty($_POST['Land'])){ $land = $_POST['Land']; $CND = "AND HOTEL.Land = '$land'"; }	
}

	if(isset($_GET['content'])){
		$content = $_GET['content'];
	} 
	include("".$content .".php");
?>


	</section>
</section>	
    <script src="assets/js/jquery.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/common-scripts.js"></script>
</body>
</html>