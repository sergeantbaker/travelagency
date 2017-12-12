<?php

function validateinput($input){
    return htmlspecialchars(stripslashes(trim($input)));
}

function getClientID(){
    return $_SESSION['ID'];
}

function setClientID($ID){
    $_SESSION['ID'] = $ID;
}

function GetNotificationSpanHTML($text,$backcolor,$forecolor){
    return '<span style="color: ' . $forecolor . '; background-color: ' . $backcolor . '; font-weight: bold;">' . $text . '</span>';
}

function SendMail($mailaddress,$subject,$text){
    $headers = array("Content-Type: text/html", "From: Reisbureau Groep5 <travelagencygroep5@gmail.com>","Reply-To: travelagencygroep5@gmail.com","X-Mailer: PHP/" . PHP_VERSION);
    $headers = implode("\r\n", $headers);
    mail($mailaddress,$subject,$text,$headers);
}

function WriteDefaultPageUpperBody(){
	echo '<div style="background-color:#b5dcb3; width:1300px; height:100px; margin-left:25px; margin-right: 40px">
     
      <a href="index.php"> 
   
   <img src="athene.jpg" style="width: 1300px;height:100px;position: relative;"> </a>
    <!-- login registreren contact balk -->
  <div style="background-color:white; border: 1px solid black; color: black; position: relative;
  width: 257px; height: 20px; left: 80%; right: -40%; top:-100%;">
  <div style="text-align: center;">';
  
  if(isset($_SESSION['ID'])){
  	echo '
  	Ingelogd als ' . DatabaseGetClientByUser(getClientID())['Voornaam']
  	. '<a href="Logout.php">Uitloggen</a>';
  }else{
  	echo '
  	<a href="login.php"> Inloggen </a> <a href="registreren.php"> Registreren </a>';
  }
  
  echo '
  <a href="contact.php"> Contact </a>  </div> 
  
  </div> 
  </div> 
 <!-- alle divs hierboven afgesloten -->
 
 <div style="width: 1300px;">';
}

function WritePageEnd(){
	echo '
		</div>
	</body>
</HTML>';
}

function WriteFilterMenu(){
	echo '<!-- dit is de code voor het filtermenu-->
  <div style="background-color:#aaa; height:400px;width:120px; margin-left:25px; float:left; text-align: center;">
       <b>Zoekresultaten filteren</b>
  <ol>
  <a href="<?php echo "index.php?content=registratie"?>"</a>
  <li>Filter 2</li>	
  <li>Filter 3</li>
  <li>Filter 4</li>
  <li>Filter 5</li>
  <li>Filter 6</li>
  </ol>
  </div>';	
}

?>