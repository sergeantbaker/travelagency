<?php

# script generates hotel booking pages and processes booking requests
# author: Raymon Been

include "database.php";
include "generic.php";

session_start();

if(!isset($_SESSION['ID'])){
    header("Location: index.php?content=login");
    die();
}

WritePageHeader();
WriteDefaultPageUpperBody();

$hotelid = null;
$roomid = null;
$action = null;
$failedaction = null;
$exception = null;
$roomsize = null;
$begindate = null;
$enddate = null;
$message = null;

function WritePageHeader(){
    echo '
<!DOCTYPE HTML>
    <HTML>
        <HEAD>
            <TITLE>Hotel Boeken - Reisbureau Groep5</TITLE>
            <LINK rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
        </HEAD>
        <BODY>
';
}

function GetBookingFormHTML($inputhotelid){
    $hotel = DatabaseGetAssoc("SELECT * FROM HOTEL WHERE ID = $inputhotelid")[0];
    $hotel_name = $hotel['HotelNaam'];
    $hotel_city = $hotel['Stad'];
    $hotel_country = $hotel['Land'];
    $hotel_phone = $hotel['Telefoon'];
    $hotel_site = "index.php?content=home&ID=$inputhotelid";
    $availableroomsizes = DatabaseGetAvailableHotelRoomsizes($inputhotelid);
    $availablerooms = DatabaseGetAvailableRooms($inputhotelid);
    $html = '
    <div style="background-color: rgb(0, 193, 255);">
    <h1 align="center" style="margin: 0;">' . $hotel_name . ' (' . $hotel_city . ', ' . $hotel_country . ')</h1>
    <h2 align="center" style="margin: 0;">Kamer boeken</h2>
    </div>
    <hr/>
    <div style="width: 20%; float: right; border: 2px solid black;">
        <h4 align="center" style="margin: 0;">Contactinfo:</h4>
        <hr/>
        <div align="center">
            Telefoon: ' . $hotel_phone . '<br/>
            Website: <a href="' . $hotel_site . '">Klik hier</a>
        </div>
    </div>
    <div style="width: 50%; margin-left: 15%; padding-left: 10%">
        <FORM method="POST" action="bookhotel.php" id="bookingform">
            <SCRIPT type="text/javascript">

                var preferredroomsize = ' . $availableroomsizes[0] . ';
                var selectedroomid = ' . $availablerooms[0]['ID'] . ';

                function PreferredRoomSize_Changed(){
                    var table = document.getElementById("roomstable");
                    var newpreferredroomsize = Number(roomsizeselector.value);
                    var newradioselected = false;
                    for(var i = 0, row; row = table.rows[i]; i++){
                        var skipthisrow = false;
                        var roomsize = 0;
                        var roomid = 0;
                        var roomprice = 0;
                        for(var ii = 0, cell; cell = row.cells[ii]; ii++){
                            var cellcontent = cell.innerHTML;
                            if(cellcontent == "X"){
                                skipthisrow = true;
                                break;
                            }
                            if(ii == 1){
                                roomid = Number(cellcontent);
                            }
                            if(ii == 3){
                                roomsize = Number(cellcontent);
                            }
                        }
                        if(skipthisrow == false){
                            if(roomsize >= newpreferredroomsize){
                                row.hidden = false;
                                if(newradioselected == false){
                                    var newradioname = "room"+roomid+"_radio";
                                    var newradio = document.getElementById(newradioname);
                                    newradio.checked = ' . "'true'" . ';
                                    SelectedRoom_Changed(roomid);
                                    newradioselected = true;
                                }
                            }else{
                                row.hidden = true;
                            }
                        }
                    }
                    preferredroomsize = newpreferredroomsize;
                }

                function SelectedRoom_Changed(newroomid){
                    if(newroomid != selectedroomid){
                        var oldradioname = "room"+selectedroomid+"_radio";
                        var oldradio = document.getElementById(oldradioname);
                        var oldrowname = "room"+selectedroomid+"_row";
                        var oldrow = document.getElementById(oldrowname);
                        oldrow.style.backgroundColor = "white";
                    }
                    var radioname = "room"+newroomid+"_radio";
                    var radio = document.getElementById(radioname);
                    var rowname = "room"+newroomid+"_row";
                    var row = document.getElementById(rowname);
                    row.style.backgroundColor = "limegreen";
                    selectedroomid = newroomid;
                }

                function UpdateTotalPrices(){

                    var spandays = 0;
                    try{
                        var begindate = begindateselector.valueAsDate;
                        var enddate = enddateselector.valueAsDate;
                        var spanms = (enddate.getTime() - begindate.getTime());
                        spandays = spanms / 1000 / 60 / 60 / 24;
                    }catch(ex){

                    }

                    for(var i = 0, row; row = roomstable.rows[i]; i++){
                        if(row.cells[0].innerHTML == "X"){continue;}
                        var roomprice = Number(row.cells[4].innerHTML);
                        var pricetotal = roomprice * spandays;
                        row.cells[5].innerHTML = "&#8364;"+pricetotal+"-";
                    }

                }

                function BookButton_Clicked(){

                    var begindate = begindateselector.valueAsDate;
                    var enddate = enddateselector.valueAsDate;
                    var today = new Date();
                    var stop = false;
                    if(begindate.getTime() == enddate.getTime() || today.getTime() > begindate.getTime() || today.getTime() > enddate.getTime() || begindate.getTime() > enddate.getTime()){
                        stop = true;
                        dateerror.hidden = false;
                    }

                    if(stop == false){
                        bookingform.submit();
                    }

                }

            </SCRIPT>
            <INPUT type="hidden" name="hotelid" value="' . $inputhotelid . '">
            <INPUT type="hidden" name="action" value="dobookhotel">
            Hoeveel slaapplaatsen wilt u minimaal in uw kamer?<br/>
            Slaapplaatsen:
            <SELECT name="roomsize" id="roomsizeselector" onchange="PreferredRoomSize_Changed()">';
            foreach($availableroomsizes as $roomsize){
                $html .= '
                <OPTION value="' . $roomsize . '">' . $roomsize . '</OPTION>';
            }
            $html .= '
            </SELECT>
            <br/><br/>
            Voor welke data wilt u een kamer boeken?<br/>
            <b style="color: red;" id="dateerror" hidden>U heeft ongeldige data opgegeven!<br/></b>
            Begindatum:
            <INPUT type="date" name="begindate" id="begindateselector" onchange="UpdateTotalPrices()"/><br/>
            Einddatum: <INPUT type="date" name="enddate" id="enddateselector" onchange="UpdateTotalPrices()"><br/><br/>
            Welke kamer wilt u?
            <INPUT type="button" value="Boek kamer" onclick="BookButton_Clicked()" style="margin-left: 30%;;"/>
            <br/>
            <TABLE id="roomstable">
                <TR style="background-color: gray;">
                    <TH>X</TH>
                    <TH>Nummer</TH>
                    <TH>Kamers</TH>
                    <TH>Slaapplaatsen</TH>
                    <TH>Prijs per nacht</TH>
                    <TH>Totaalprijs</TH>';
            $room_index = 0;
            foreach($availablerooms as $availableroom){
                $room_size = $availableroom['Slaapplaatsen'];
                $room_rooms = $availableroom['Kamers'];
                $room_id = $availableroom['ID'];
                $room_price = $availableroom['Prijs'];
                $room_rowhidden = null;
                if(!($room_size >= $availableroomsizes[0])){
                    $room_rowhidden = ' hidden';
                }
                $html .= '
                <TR id="room' . $room_id . '_row"' . $room_rowhidden . '>
                    <TD><INPUT type="radio" name="roomid" value="' . $room_id . '" id="room' . $room_id . '_radio" onclick="SelectedRoom_Changed(' . $room_id . ')"' . '/></TD>
                    <TD>' . $room_id . '</TD>
                    <TD>' . $room_rooms . '</TD>
                    <TD>' . $room_size . '</TD>
                    <TD>' . $room_price . '</TD>
                    <TD>&#8364;' . ($room_price * 8) . '-</TD>';
                $room_index++;
            }
            $html .= '
            </TABLE>
            <SCRIPT type="text/javascript">
                var today = new Date();
                var tomorrow = new Date(today.getTime() + 24 * 60 * 60 * 1000);
                var tomorrownextweek = new Date(tomorrow.getTime() + 7 * 24 * 60 * 60 * 1000);
                begindateselector.valueAsDate = today;
                begindateselector.min = begindateselector.value;
                begindateselector.valueAsDate = tomorrow;
                enddateselector.valueAsDate = today;
                enddateselector.min = enddateselector.value;
                enddateselector.valueAsDate = tomorrownextweek;
                document.getElementById(' . '"room' . $availablerooms[0]['ID'] . '_radio").checked = ' . "'true';" . '
                SelectedRoom_Changed(' . $availablerooms[0]['ID'] .');
            </SCRIPT>
        </FORM>
    </div>';
    return $html;
}

function VerifyHotelId($inputhotelid){
    if(!DatabaseDoesHotelExist($inputhotelid)){
        echo "Error! The choosen hotel with id $inputhotelid does not exist!";
        die();
    }
}

function VerifyRoomsizeForHotel($inputhotelid,$inputroomsize){
    if(!DatabaseDoesHotelHaveRoomsize($inputhotelid,$inputroomsize)){
        echo "Error! Thoe choosen hotel with id $inputhotelid does not have a room with $inputroomsize beds!";
        die();
    }
}

function VerifyDates($begindatestr,$enddatestr){
	global $action,$hotelid;
	$begindateobj = new DateTime($begindatestr);
	$enddateobj = new DateTime($enddatestr);
	$today = new DateTime();
	$timespan = $enddateobj->diff($begindateobj);
	$timespan2 = $begindateobj->diff($today);
	$numdays = $timespan->days;
	$numdays2 = $timespan2->days;
	if($numdays <= 0){
		header("Location: bookhotel.php?failedaction=$action&hotelid=$hotelid&exception=InvalidDatesException&message=" . htmlentities("De gekozen einddatum is gelijk of kleiner dan de gekozen begindatum!"));
		die();
	}
	if($numdays2 < 0){
		header("Location: bookhotel.php?failedaction=$action&hotelid=$hotelid&exception=InvalidDatesException&message=" . htmlentities("De gekozen begindatum is kleiner dan de huidige datum!"));
		die();
	}
}

# most likely an initiation request
if($_SERVER["REQUEST_METHOD"] == 'GET'){
    if(!empty($_GET['hotelid'])){
        $hotelid = validateinput($_GET['hotelid']);
    }
    if(!empty($_GET['action'])){
        $action = validateinput($_GET['action']);
    }
    if(!empty($_GET['failedaction'])){
        $failedaction = validateinput($_GET['failedaction']);
    }
    if(!empty($_GET['roomid'])){
        $roomid = validateinput($_GET['roomid']);
    }
    if(!empty($_GET['exception'])){
        $exception = validateinput($_GET['exception']);
    }
	if(!empty($_GET['message'])){
		$message = validateinput($_GET['message']);
	}

    # most likely a processing request
}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
    if(!empty($_POST['action'])){
        $action = validateinput($_POST['action']);
    }
    if(!empty($_POST['hotelid'])){
        $hotelid = validateinput($_POST['hotelid']);
    }
    if(!empty($_POST['roomsize'])){
        $roomsize = validateinput($_POST['roomsize']);
    }
    if(!empty($_POST['begindate'])){
        $begindate = validateinput($_POST['begindate']);
    }
    if(!empty($_POST['enddate'])){
        $enddate = validateinput($_POST['enddate']);
    }
    if(!empty($_POST['roomid'])){
        $roomid = validateinput($_POST['roomid']);
    }
}

$logmessages = array();
if($failedaction == 'dobookhotel'){
    $logmessages[] = array("Wij konden uw boeking voor kamer $roomid helaas niet vastleggen!",'red','black');
}elseif($failedaction != ""){
    $logmessages[] = array("Er is iets fout gegaan! $failedaction kon niet zonder fouten worden voltooid!",'red','black');
}

if($exception == 'DatabaseNotUpdatedException'){
    $logmessages[] = array("De boeking kon niet aan onze database worden toegevoegd!",'orange','black');
}elseif($exception == 'RoomNotAvailableException'){
    $logmessages[] = array("De door u gekozen kamer is op dit moment helaas niet meer beschikbaar!",'orange','black');
}elseif($exception == 'InvalidDatesException'){
	$logmessages[] = array("De door u opgegeven data zijn ongeldig!<br/>Gebruik alstublieft het volgende formaat: JJJJ-MM-DD!",'orange','black');
}elseif($exception != ""){
    $logmessages[] = array("De gegeven foutcode is: $exception",'orange','black');
}

if($message != ""){
	$logmessages[] = array($message,'orange','black');
}

if($action == 'dobookhotel'){

    VerifyHotelId($hotelid);
    VerifyRoomsizeForHotel($hotelid,$roomsize);
	VerifyDates($begindate, $enddate);
    $roomavailable = DatabaseIsRoomAvailable($roomid);
    if($roomavailable){
        if(DatabaseAddBooking($roomid,$begindate,$enddate)){
            DatabaseSetRoomAvailable($roomid,false);
            $bookingid = DatabaseGetClientMostRecentBooking(getClientID())['ID'];
            SendMail(DatabaseGetClientForBooking($bookingid)['Mail'],"Boeking bevestigd $bookingid",DatabaseReplaceTextBooking('bookhotel.bookingconfirmation.txt',$bookingid));
            header("Location: mybookings.php?action=paybooking&bookingid=$bookingid");
        }else{
            header("Location: bookhotel.php?hotelid=$hotelid&roomid=$roomid&failedaction=dobookhotel&exception=DatabaseNotUpdatedException");
        }
    }else{
        header("Location: bookhotel.php?hotelid=$hotelid&roomid=$roomid&failedaction=dobookhotel&exception=RoomNotAvailableException");
    }

}else{

    VerifyHotelId($hotelid);
    echo GetBookingFormHTML($hotelid);

}

if(count($logmessages) != 0){
    echo "<br/>Mijn log:<br/>\n";
    foreach($logmessages as $logmessage){
        echo GetNotificationSpanHTML($logmessage[0],$logmessage[1],$logmessage[2]) . "<br/>\n";
    }
}

WritePageEnd();

?>