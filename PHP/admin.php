<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd>
<html xmlns="http://www.w3.org/1999/xhtml">
<?php 
include("database.php");
echo conect();
echo autho_admin();
?>

  <head>
    <title>Admin Panel</title>
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">
    <link href="assets/css/style-responsive.css" rel="stylesheet">
    
  </head>
<body>
<header class="header black-bg">
	<a href="index.php" class="logo"><b>Admin Panel</b></a>
	<div class="top-menu">
		<ul class="nav pull-right top-menu">
			<li><a class="logout" href="Logout.php">Logout</a></li>
		</ul>
	</div>
</header>

<div id="sidebar">
	<ul class="sidebar-menu" style="display: none;">
		<h5 class="centered">TAAK</h5>   
		
<li class="sub-menu">
	<a href="<?php echo "admin.php?content=Incident_ov"?>">
	<i class="fa fa-dashboard"></i>
	<span>Incidenten</span>
	</a>
</li>

		<h5 class="centered">OVERZICHTEN</h5>  
		
<li class="sub-menu">
	<a href="<?php echo "admin.php?content=Boeking_ov"?>">
	<i class="fa fa-desktop" ></i>
	<span>Boekingen</span>
	</a>
</li> 

<li class="sub-menu">
	<a href="<?php echo "admin.php?content=Gebruiker_ov"?>">
	<i class="fa fa-desktop" ></i>
	<span>Gebruikers</span>
	</a>
</li>  

<li class="sub-menu">
	<a href="<?php echo "admin.php?content=Hotel_ov"?>">
	<i class="fa fa-desktop" ></i>
	<span>Hotels</span>
	</a>
</li>

<li class="sub-menu">
	<a href="<?php echo "admin.php?content=Kamer_ov"?>">
	<i class="fa fa-desktop" ></i>
	<span>Kamers</span>
	</a>
</li>
				  
	</ul>
</div>



<section id="main-content">
	<section class="wrapper">
<?php

	$content = 'Incident_ov';
	if(isset($_GET['content'])){
		$content = $_GET['content'];
	} 
	include("overzicht/".$content .".php");
?>

	</section>
</section>	
    <script src="assets/js/jquery.js"></script>
    <script class="include" type="text/javascript" src="assets/js/jquery.dcjqaccordion.2.7.js"></script>
    <script src="assets/js/common-scripts.js"></script>
</body>
</html>