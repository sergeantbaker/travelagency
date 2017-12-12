<?php

#this script supplies our site of database config and functions for getting and changing data


function conect(){
	mysql_connect("localhost", "root","michaelscott16") or die(mysql_error());
	mysql_select_db("TRAVEL") or die(mysql_error());
}

function autho(){
	session_start();
 	if(!isset($_SESSION["ID"])) {
		header ("Location: Logout.php"); 
		exit();
 	}
}

function autho_admin(){
		session_start();
 	if(!isset($_COOKIE["Gebruikersnaam"])) {
		header ("Location: Logout.php"); 
 	}
	if(empty($_SESSION["ID"]) || empty($_SESSION["SOORT"])){
	header ("Location: route.php"); 
	}
	if($_SESSION["SOORT"] == 1){
		header ("Location: index.php");
	}
}

$databaseserver = 'localhost';
$databaseuser = 'root';
$databasepassword = 'michaelscott16';
$databaseschema = 'TRAVEL';
$databaseport = 3306;

function DatabaseGetLink(){
	global $databaseserver,$databaseuser,$databasepassword,$databaseschema,$databaseport;
	return mysqli_connect($databaseserver,$databaseuser,$databasepassword,$databaseschema,$databaseport);
}

function DatabaseGetQuery($query){
	$database = DatabaseGetLink();
	$databasequery = mysqli_query($database,$query);
	mysqli_close($database);
	return $databasequery;
}

# return array with associative arrays from a query
# example: for each product an array with column names and values
function DatabaseGetAssoc($query){
	$databasequery = DatabaseGetQuery($query);
	$output = array();
	$index = 0;
	while($row = mysqli_fetch_assoc($databasequery)) {
		$output[$index] = $row;
		$index++;
	}
	return $output;
}

# get names of columns from table X and put these in array
function DatabaseGetTableColumnNames($tablename){
	global $databaseschema;
	$databasequery = DatabaseGetQuery("SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '" . $databaseschema . "' AND TABLE_NAME = '" . $tablename . "'");
	$output = array();
	$index = 0;
	while($row = mysqli_fetch_assoc($databasequery)) {
		$output[$index] = $row["COLUMN_NAME"];
		$index++;
	}
	return $output;
}

function DatabaseGetBookingsForClient($clientid){
    return DatabaseGetAssoc("SELECT * FROM BOEKING WHERE GEBRUIKER_ID = $clientid ORDER BY ID ASC");
}

function DatabaseGetBookingsForRoom($roomid){
    return DatabaseGetAssoc("SELECT * FROM BOEKING WHERE KAMER_ID = $roomid");
}

function DatabaseIsRoomAvailable($roomid){
    $status = DatabaseGetAssoc("SELECT STATUS_ID FROM KAMER WHERE ID = $roomid")[0]['STATUS_ID'];
    if($status == 2){
        return true;
    }else{
        return false;
    }
}

function DatabaseIsBookingClientOwned($bookingid){
    $travelquery = DatabaseGetAssoc("SELECT * FROM BOEKING WHERE ID = $bookingid");
    if(count($travelquery) != 0){
        $travel = $travelquery[0];
        $travelclientid = $travel['GEBRUIKER_ID'];
        $clientid = getClientID();
        if($travelclientid == $clientid){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function DatabaseDoesBookingExist($bookingid){
    $travelquery = DatabaseGetAssoc("SELECT * FROM BOEKING WHERE ID = $bookingid");
    if(count($travelquery) != 0){
        return true;
    }else{
        return false;
    }
}

function DatabaseDoesHotelHaveRoomsize($hotelid, $roomsize){
    $roomsizequery = DatabaseGetAssoc("SELECT * FROM KAMER WHERE HOTEL_ID = $hotelid AND SLAAPPLAATSEN = $roomsize");
    if(count($roomsizequery) > 0){
        return true;
    }else{
        return false;
    }
}

function DatabaseGetClientByUser($userid){
    return DatabaseGetAssoc("SELECT * FROM KLANT WHERE GEBRUIKER_ID = $userid")[0];
}

function DatabaseGetClientForBooking($bookingid){
    return DatabaseGetAssoc("SELECT * FROM KLANT WHERE GEBRUIKER_ID = (SELECT GEBRUIKER_ID FROM BOEKING WHERE ID = $bookingid)")[0];
}

function DatabaseGetStatusForBooking($bookingid){
    return DatabaseGetAssoc("SELECT * FROM BOEKING_STATUS WHERE ID = (SELECT STATUS_ID FROM BOEKING WHERE ID = $bookingid)")[0];
}

function DatabaseGetRoomForBooking($bookingid){
    return DatabaseGetAssoc("SELECT * FROM KAMER WHERE ID = (SELECT KAMER_ID FROM BOEKING WHERE ID = $bookingid)")[0];
}

function DatabaseGetHotelForBooking($bookingid){
    return DatabaseGetAssoc("SELECT * FROM HOTEL WHERE ID = (SELECT HOTEL_ID FROM KAMER WHERE ID = (SELECT KAMER_ID FROM BOEKING WHERE ID = $bookingid))")[0];
}

function DatabaseGetAvailableRooms($hotelid,$roomsize = 1){
    return DatabaseGetAssoc("SELECT * FROM KAMER WHERE HOTEL_ID = $hotelid AND SLAAPPLAATSEN >= $roomsize AND STATUS_ID = 2");
}

function DatabaseSetRoomAvailable($roomid,$available){
    $statusid = 2;
    if($available == true){
        $statusid = 2;
    }else{
        $statusid = 1;
    }
    DatabaseGetQuery("UPDATE KAMER SET STATUS_ID = $statusid WHERE ID = $roomid");
}

function DatabaseAddBooking($roomid,$begindatestr,$enddatestr){
    $room = DatabaseGetAssoc("SELECT * FROM KAMER WHERE ID = $roomid")[0];
    $roomprice = $room['Prijs'];
    $begindate = new DateTime($begindatestr);
    $enddate = new DateTime($enddatestr);
    $timespan = $enddate->diff($begindate);
    $bookingprice = $roomprice * $timespan->days;
    $userid = getClientID();
    $lastbookingid = DatabaseGetAssoc("SELECT MAX(ID) MAX FROM BOEKING")[0]['MAX'];
    $newbookingid = $lastbookingid + 1;
    $insertquery = "INSERT INTO BOEKING(ID,Startdatum,Einddatum,Prijs,GEBRUIKER_ID,KAMER_ID,STATUS_ID) VALUES($newbookingid,STR_TO_DATE('" . $begindatestr . "','%Y-%m-%d'),STR_TO_DATE('" . $enddatestr . "','%Y-%m-%d'),$bookingprice,$userid,$roomid,2)";
    DatabaseGetQuery($insertquery);
    return DatabaseDoesBookingExist($newbookingid);
}

function DatabaseGetClientMostRecentBooking($clientid){
    return DatabaseGetAssoc("SELECT * FROM BOEKING WHERE ID = (SELECT MAX(ID) FROM BOEKING WHERE GEBRUIKER_ID = $clientid)")[0];
}

function DatabaseGetNumClientBookings($clientid){
    $query = DatabaseGetAssoc("SELECT COUNT(ID) COUNT FROM BOEKING WHERE GEBRUIKER_ID = $clientid");
    return $query[0]['COUNT'];
}

function DatabaseHasBookingBeenPaid($bookingid){
    $databasequery = DatabaseGetAssoc("SELECT STATUS_ID FROM BOEKING WHERE ID = $bookingid");
    $statusid = $databasequery[0]['STATUS_ID'];
    if($statusid == 2){ #onbetaald
        return false;
    }else{ #betaald
        return true;
    }
}

function DatabaseSetBookingPaid($bookingid){
    DatabaseGetQuery("UPDATE BOEKING SET STATUS_ID = 1 WHERE ID = $bookingid");
    return DatabaseHasBookingBeenPaid($bookingid);
}

function DatabaseGetRoomByHotelNumSpaces($hotelid,$minnumbeds){
    return DatabaseGetAssoc("SELECT * FROM KAMER WHERE HOTEL_ID = $hotelid AND Slaapplaatsen >= $minnumbeds");
}

function DatabaseDoesHotelExist($hotelid){
    $hotels = DatabaseGetAssoc("SELECT * FROM HOTEL WHERE ID = $hotelid");
    if(count($hotels) > 0){
        return true;
    }else{
        return false;
    }
}

function DatabaseGetHotelRoomsizes($hotelid){
    $hotelroomsizes = DatabaseGetAssoc("SELECT DISTINCT Slaapplaatsen FROM kamer WHERE HOTEL_ID = $hotelid");
    $outputroomsizes = array();
    for($i = 0;$i <= count($hotelroomsizes) - 1;$i++){
        $outputroomsizes[$i] = $hotelroomsizes[$i]['Slaapplaatsen'];
    }
    return $outputroomsizes;
}

function DatabaseGetAvailableHotelRoomsizes($hotelid){
    $hotelroomsizes = DatabaseGetAssoc("SELECT DISTINCT Slaapplaatsen FROM KAMER WHERE HOTEL_ID = $hotelid AND STATUS_ID = 2");
    $outputroomsizes = array();
    for($i = 0;$i <= count($hotelroomsizes) - 1;$i++){
        $outputroomsizes[$i] = $hotelroomsizes[$i]['Slaapplaatsen'];
    }
    return $outputroomsizes;
}

function DatabaseReplaceTextBooking($htmlfile,$bookingid, $additionalparams = array()){

    $text = file_get_contents($htmlfile);

    $bookingrow = DatabaseGetAssoc("SELECT * FROM BOEKING WHERE ID = $bookingid")[0];
    $bookingstatusrow = DatabaseGetAssoc("SELECT * FROM BOEKING_STATUS WHERE ID = " . $bookingrow['STATUS_ID'])[0];
    $clientrow = DatabaseGetAssoc("SELECT * FROM KLANT WHERE GEBRUIKER_ID = " . $bookingrow['GEBRUIKER_ID'])[0];
    $roomrow = DatabaseGetAssoc("SELECT * FROM KAMER WHERE ID = " . $bookingrow['KAMER_ID'])[0];
    $hotelrow = DatabaseGetAssoc("SELECT * FROM HOTEL WHERE ID = " . $roomrow["HOTEL_ID"])[0];

    $curdatetime = new DateTime();
    $curdatestr = str_replace('-',chr(92),$curdatetime->format('d-m-Y'));
    $curtimestr = $curdatetime->format("H:i");
    $text = str_replace('$curdate',$curdatestr,$text);
    $text = str_replace('$curtime',$curtimestr,$text);

    foreach($bookingrow as $column => $value){
        $text = str_replace('$boeking_'.$column,$value,$text);
    }

    foreach($bookingstatusrow as $column => $value){
        $text = str_replace('$boeking_status_'.$column,$value,$text);
    }

    foreach($clientrow as $column => $value){
        $text = str_replace('$klant_'.$column,$value,$text);
    }
    $clientprefix = 'Mr.';
    $clientgender = strtolower($clientrow['Geslacht']);
    if($clientgender == 'male'){
        $clientprefix = 'Mr.';
    }elseif($clientgender == 'female'){
        $clientprefix = 'Ms.';
    }
    $text = str_replace('$klant_genderprefix',$clientprefix,$text);

    foreach($roomrow as $column => $value){
        $text = str_replace('$kamer_'.$column,$value,$text);
    }

    foreach($hotelrow as $column => $value){
        $text = str_replace('$hotel_'.$column,$value,$text);
    }

    foreach($additionalparams as $key => $value){
        $text = str_replace('$' . $key,$value,$text);
    }

    return $text;

}

function bstext(){
	echo "Lorem ipsum dolor sit amet, consectetur adipiscing elit,
	sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.
	 Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris
	  nisi ut aliquip ex ea commodo consequat.";
}
function bstext2(){
	echo "Lorem ipsum dolor sit amet, consectetuer adipiscing elit. 
	Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque
	 penatibus et magnis dis parturient montes, nascetur ridiculus mus.
	  Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. 
	  Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet 
	  nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis
	   vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt.
	    Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus.
	     Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. 
	     Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. 
	     Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum.
	      Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi.
	       Nam eget dui.Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, 
	       sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc,
	        blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt ";
}
?>