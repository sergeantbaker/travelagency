<?php

# script generates mybookings page and processes booking payments and cancellation requests
# author: Raymon Been

require "database.php";
require "generic.php";

function WritePageHeader(){
    echo '
<!DOCTYPE HTML>
<HTML>
    <HEAD>
        <TITLE>Mijn boekingen - Reisbureau Groep5</TITLE>
        <LINK rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
    </HEAD>
    <BODY>
';
}

#get html for bookingtable
function GetBookingsTableHTML(){

    $showbuttonsintable = true;

	#get all bookings via sql
	$bookings = DatabaseGetBookingsForClient(getClientID());

	#declare html and add table headers
	$html = '
            <SCRIPT type="text/javascript">

                var lastexpandedrow = 0;

                function collapsetablerow(rownum){
                    var row = document.getElementById("tablesubrow"+rownum);
                    var link = document.getElementById("tableexpansionlink"+rownum);
                    var icon = document.getElementById("tableexpansionlinkicon"+rownum);
                    icon.textContent = "keyboard_arrow_down";
                    row.hidden = true;
                    link.onclick = function(){expandtablerow(rownum);};
                }

                function expandtablerow(rownum){
                    var row = document.getElementById("tablesubrow"+rownum);
                    var link = document.getElementById("tableexpansionlink"+rownum);
                    var icon = document.getElementById("tableexpansionlinkicon"+rownum);
                    row.hidden = false;
                    icon.textContent = "keyboard_arrow_up";
                    link.onclick = function(){collapsetablerow(rownum);};
                    if(lastexpandedrow != 0 && lastexpandedrow != rownum){
                    collapsetablerow(lastexpandedrow);
                    }
                    lastexpandedrow = rownum;
                }

            </SCRIPT>
            <TABLE style="width: 1300px;">
			    <CAPTION>
                    <div style="width: 100%; border:1px solid black; background-color: rgb(0, 193, 255);">
                        <h1 style="margin: 10; color: white;"><u>Mijn boekingen</u></h1>
                    </div>
                </CAPTION>
			    <TR style="background-color: black; color: white;">
                    <TH>Nummer</TH>
                    <TH>Begindatum</TH>
                    <TH>Einddatum</TH>
                    <TH>Stad</TH>
                    <TH>Hotel</TH>
                    <TH>Kamer</TH>
                    <TH>Prijs</TH>
                    <TH>Betaalstatus</TH>';
                    if($showbuttonsintable == true){
                        $html .= "
                    <TH>Annuleren</TH>
                    <TH>Betalen</TH>";
                    }
                $html .= "
                    <TH><i style=" . '"' . "align=right;" . '" class="material-icons">keyboard_arrow_down</i></TH>' . "
                </TR>\n";

	#add table data
    $tablerow = 1; #tablerow starts at 1 since tablerow 0 is the header
    $rowbackcolor = '#f2f2f2';
	foreach($bookings as $booking){ #foreach booking add a row <TR> and end row </TR>

        $startdate = $booking['Startdatum'];
        $enddate = $booking['Einddatum'];
        $price = $booking['Prijs'];
        $userid = $booking['GEBRUIKER_ID'];
        $roomid = $booking['KAMER_ID'];
        $bookingid = $booking['ID'];

        $hotel = DatabaseGetHotelForBooking($bookingid);
        $hotel_city = $hotel['Stad'];
        $hotel_id = $hotel['ID'];
        $hotel_country = $hotel['Land'];
        $hotel_name = $hotel['HotelNaam'];
        $hotel_phone = $hotel['Telefoon'];
        $hotel_site = "index.php?content=home&ID=$hotel_id";

        $status = DatabaseGetStatusForBooking($bookingid);

        $room = DatabaseGetRoomForBooking($bookingid);
        $numbeds = $room['Slaapplaatsen'];

        $bookingpaid = DatabaseHasBookingBeenPaid($bookingid);

        $rowcolor = 'black'; # this is for the row itself (which can be red or black but not green)
        $statecolor = 'limegreen'; # this is for objects that no matter what should be green or red
        if($bookingpaid == true){
            $rowcolor = 'black';
            $statecolor = 'limegreen';
        }else{
            $rowcolor = 'red';
            $statecolor = 'red';
        }



        $bookingstatustext = $status['Naam'];

        $subrow = $tablerow + 1;

		$html .= "<TR style=" . '"' . "color: $rowcolor; background-color: $rowbackcolor; font-weight: bold;" . '"' . ">
                    <TD>$bookingid</TD>
                    <TD>$startdate</TD>
                    <TD>$enddate</TD>
                    <TD>$hotel_city</TD>
                    <TD>$hotel_name</TD>
                    <TD>$roomid</TD>
                    <TD>&#8364;$price-</TD>
                    <TD>$bookingstatustext</TD>";

                    # render buttons in case this is on
                    if($showbuttonsintable == true){
                        $html .= "
                    <TD>";
                        if(DatabaseHasBookingBeenPaid($bookingid) == false){
                            $html .= '
                        <INPUT type="button"  style="background-color: red;" onclick="window.location.href=' . "'" . 'mybookings.php?action=cancelbooking&bookingid=' . $bookingid . "'" . '" value="Annuleren"/>';
                        }else{
                            $html .= 'N.V.T';
                        }
                        $html .= "
                    </TD>
                    <TD>";
                     if(DatabaseHasBookingBeenPaid($bookingid) == false){
                        $html .= '
                        <INPUT type="button"  style="background-color: limegreen;" onclick="window.location.href=' . "'" . 'mybookings.php?action=paybooking&bookingid=' . $bookingid . "'" . '" value="BETALEN"/>';
                    }else{
                        $html .= 'N.V.T';
                    }
                    $html .= "
                    </TD>";
                    }


                    $html .= "
                    <TD>
                        <a id=" . '"tableexpansionlink' . $subrow . '" href=' . '"' . "#" . '"' . " onclick=" . '"' . "expandtablerow($subrow)" . '"' . "><i id=" . '"' . "tableexpansionlinkicon" . $subrow . '" class="material-icons">keyboard_arrow_down</i></a></TD>' . "
                    </TD>
                </TR>
                <TR hidden id=" . '"tablesubrow' . $subrow . '"' . ">
                    <TD style=" . '"' . "width: 100%;" . '"' . " colspan=" . '"15"' . ">
                        <div style=" . '"' . "width: 100%; background-color: $rowbackcolor; border:2px solid $rowcolor; margin: 0; padding-left: 0%;" . '"' . ">
                            <table style=" . '"width: 100%;"' . ">
                                <tr style=" . '"width: 100%;"' . ">
                                    <td>
                                        <h2 style=" . '"padding-left: 10%; margin: 0;"' . ">$hotel_name ($hotel_city, $hotel_country)</h2>
                                    </td>
                                    <td>
                                        <a href=" . '"#" onclick="' . "collapsetablerow($subrow)" . '" style="float: right;"><i class="material-icons">keyboard_arrow_up</i></a>' . "
                                    </td>
                                </tr>
                            </table>
                            <div style=" . '"padding-left: 10%;"' . ">
                                <div style=" . '"float: right; width: 25%;"' . ">
                                    <br/>
                                    <b style=" . '"color: ' . $statecolor . '"' . ">$bookingstatustext<br/>&#8364;$price</b><br/>
                                    <hr style=" . '"width: 90%;"' . "/>
                                </div>
                                <br/>
                                Belangrijke informatie:<br/>
                                U heeft geboekt van: $startdate tot: $enddate.<br/>
                                U heeft kamer $roomid met $numbeds slaapplaatsen.<br/>";
                                if($bookingpaid == true){
                                    $html .= '
                                <label style="' . 'color: ' . $statecolor . '">U heeft al betaald! Heel veel plezier en een voorspoedige reis gewenst!</label><br/>';
                                }else{
                                    $html .= '
                                <label style="' . "color: " . $statecolor . '">U heeft nog niet betaald!</label><br/>';
                                }
                                $html .= "
                                <br/>
                                Hotelinformatie:<br/>
                                Telefoonnummer: $hotel_phone<br/>
                                Website: <a href=" . '"' . $hotel_site . '"' . ">Klik hier</a><br/>

                            </div>
                        </div>
                    </TD>
                </TR>";

        $tablerow++;
        if($rowbackcolor == '#f2f2f2'){
            $rowbackcolor = 'white';
        }else{
            $rowbackcolor = '#f2f2f2';
        }

	}

	$html .= '
            </TABLE>';

	return $html;

}

function TryCancelBooking($bookingid){
    $clientowned= DatabaseIsBookingClientOwned($bookingid);
    $bookingpaid = DatabaseHasBookingBeenPaid($bookingid);
    if($clientowned == true && $bookingpaid == false){
        return CancelBooking($bookingid);
    }else{
        return false;
    }
}

function CancelBooking($bookingid){

    $roomid = DatabaseGetRoomForBooking($bookingid)['ID'];
    DatabaseGetQuery("DELETE FROM BOEKING WHERE ID = $bookingid"); #delete from boeking
    $check = DatabaseGetAssoc("SELECT * FROM BOEKING WHERE ID = $bookingid");

    if(count($check) == 0){ #boeking deletion was succesfull. set room state and let user know

        DatabaseGetQuery("UPDATE KAMER SET STATUS_ID = 2 WHERE ID = $roomid"); #set new room state
        return true;

    }else{ #boeking deletion was NOT succesfull

        return false;

    }
}

session_start();

if(!isset($_SESSION['ID'])){
    header("Location: index.php?content=login");
    die();
}


WritePageHeader();
WriteDefaultPageUpperBody();

#temp variables
$clientid = getClientID();
$bookingowned = false;
$bookingexists = false;
$bookingpaid = false;
$clientinfo = null;
$clientmail = null;
$logmessages = array();

#declare GET variables
$action = 'showtravels'; #default action should be display travels
$bookingid = null;
$roomid = null;
$hotelid = null;
$confirmaction = false;
$completedaction = null;
$failedaction = null;
$exception = null;
$exceptionmessage = null;

#declare POST variables
$paymentmethod = null;
$idealprovider = null;
$creditcardtype = null;
$creditcardnumber = null;
$creditcardexpirationmonth = null;
$creditcardexpirationyear = null;
$creditcardname = null;
$acceptterms = false;

function VerifyBookingDefault(){
    global $bookingid,$bookingexists,$bookingowned,$action;
    if(!$bookingexists){
            header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=BookingNotFoundException");
     }elseif(!$bookingowned){
            header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=BookingNotOwnedException");
    }
    return true;
}

function VerifyBookingNotPaid(){
    global $action,$bookingid,$bookingpaid;
    if($bookingpaid){
        header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=BookingAlreadyPaidException");
    }
    return true;
}

function VerifyTermsAccepted(){
    global $acceptterms,$action,$bookingid;
    if(!$acceptterms){
        header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=TermsNotAcceptedException");
    }
    return true;
}

# we received a GET request. This can be anything
# let's validate
if($_SERVER['REQUEST_METHOD'] == 'GET'){

    if(!empty($_GET['action'])){
        $action = validateinput($_GET['action']);
    }
    if(!empty($_GET['bookingid'])){
        $bookingid = validateinput($_GET['bookingid']);
        $bookingexists = DatabaseDoesBookingExist($bookingid);
        if($bookingexists == true){
             $bookingowned = DatabaseIsBookingClientOwned($bookingid);
        $bookingpaid = DatabaseHasBookingBeenPaid($bookingid);
        }
    }
    if(!empty($_GET['confirmaction'])){
        $tempconfirmaction = strtolower(validateinput($_GET['confirmaction']));
        if($tempconfirmaction == 'true'){
            $confirmaction = true;
        }elseif($tempconfirmaction == 'false'){
            $confirmaction = false;
        }
    }
    if(!empty($_GET['completedaction'])){
        $completedaction = validateinput($_GET['completedaction']);
    }
    if(!empty($_GET['failedaction'])){
        $failedaction = validateinput($_GET['failedaction']);
    }
    if(!empty($_GET['exception'])){
        $exception = validateinput($_GET['exception']);
    }
    if(!empty($_GET['message'])){
        $exceptionmessage = validateinput($_GET['message']);
    }
    if(!empty($_GET['roomid'])){
        $roomid = validateinput($_GET['roomid']);
    }
    if(!empty($_GET['hotelid'])){
        $hotelid = validateinput($_GET['hotelid']);
    }

    # we received a POST request. This is most likely a payment.
    # let's validate
}elseif($_SERVER['REQUEST_METHOD'] == 'POST'){

    if(!empty($_POST['action'])){
        $action = validateinput($_POST['action']);
    }
    if(!empty($_POST['bookingid'])){
        $bookingid = validateinput($_POST['bookingid']);
        $bookingexists = DatabaseDoesBookingExist($bookingid);
        if($bookingexists == true){
            $bookingowned = DatabaseIsBookingClientOwned($bookingid);
            $bookingpaid = DatabaseHasBookingBeenPaid($bookingid);
        }
    }
    if(!empty($_POST['paymentmethod'])){
        $paymentmethod = validateinput($_POST['paymentmethod']);
    }
    if(!empty($_POST['idealprovider'])){
        $idealprovider = validateinput($_POST['idealprovider']);
    }
    if(!empty($_POST['creditcardtype]'])){
        $creditcardtype = validateinput($_POST['creditcardtype']);
    }
    if(!empty($_POST['creditcardnumber'])){
        $creditcardnumber = validateinput($_POST['creditcardnumber']);
    }
    if(!empty($_POST['creditcardexpirationmonth'])){
        $creditcardexpirationmonth = validateinput($_POST['creditcardexpirationmonth']);
    }
    if(!empty($_POST['creditcardexpirationyear'])){
        $creditcardexpirationyear = validateinput($_POST['creditcardexpirationyear']);
    }
    if(!empty($_POST['accept'])){
        $accepttermsstring = validateinput($_POST['accept']);
        if(strtolower($accepttermsstring) == "on"){
            $acceptterms = true;
        }else{
            $acceptterms = false;
        }
    }

}

$clientinfo = DatabaseGetClientByUser($clientid);
$clientmail = $clientinfo['Mail'];

    # Notification system
if($completedaction == 'cancelbooking'){ #a booking was canceled. let's validate
    if($bookingexists == false){ #seems legit
        $logmessages[] = array("Uw boeking met boekingsnummer: $bookingid is succesvol geannuleerd!<br/>Het spijt ons dat u de reis heeft gennuleerd!",'limegreen','black');
    }
}elseif($completedaction == 'dopaybooking'){
    $logmessages[] = array("U heeft uw boeking met boekingsnummer: $bookingid succesvol betaald!<br/>Namens ons team alvast een prettige reis gewenst!",'limegreen','black');
}elseif($completedaction == 'dobookhotel'){
    $logmessages[] = array("Uw boeking met boekingsnummer: $bookingid is succesvol opgeslagen in onze database!", 'limegreen','black');
}elseif($completedaction != ''){
    $logmessages[] = array("Action '$completedaction' has been executed succesfully!",'limegreen','black');
}

if($failedaction == 'cancelbooking'){
    $logmessages[] = array("Wij konden uw boeking met boekingsnummer: $bookingid op dit moment niet annuleren! Het spijt ons!",'red','black');
}elseif($failedaction == 'paybooking'){
    $logmessages[] = array("Wij konden de betaling voor boeking $bookingid niet beginnen!",'red','black');
}elseif($failedaction == 'dopaybooking'){
    $logmessages[] = array("Wij konden uw betaling voor boeking $bookingid helaas niet verwerken! Probeert u het later alstublieft opnieuw!",'red','black');
}elseif($failedaction != ''){
    $logmessages[] = array("Action '$failedaction': action executed with errors!",'red','black');
}

if($exception == 'BookingNotFoundException'){
    $logmessages[] = array("Reason: The specified booking $bookingid could not be found!",'orange','black');
}elseif($exception == 'BookingNotOwnedException'){
    $logmessages[] = array("Reason: The specified booking $bookingid does not belong to you!<br/>For security reasons we aborted the action!",'orange','black');
}elseif($exception == 'BookingAlreadyPaidException'){
    $logmessages[] = array("Reason: The specified booking $bookingid has already been paid!",'orange','black');
}elseif($exception == 'TermsNotAcceptedException'){
    $logmessages[] = array("Reason: You have not accepted our terms!<br/>Or someone manipulated the sent data!",'orange','black');
}elseif($exception == 'IllegalPaymentInfoException'){
    $logmessages[] = array("Reason: Something went wrong while validating your form!",'orange','black');
}elseif($exception == 'DatabaseNotUpdatedException'){
    $logmessages[] = array("Reason: Your payment has been processed succesfully, but your booking could not be updated in our database!<br/>Please contact our team!",'red','black');
}

if(!empty($exceptionmessage)){
    $logmessages[] = array($exceptionmessage,'orange','black');
}


    # this is where the actual stuff happens
switch($action){

    # user wants to cancel a booking...
    # sad but true...
    case 'cancelbooking':

        VerifyBookingDefault();

        if(!$confirmaction){
           echo DatabaseReplaceTextBooking('mybookings.confirmremoval.html',$bookingid);
        }else{
            $mailtext = DatabaseReplaceTextBooking('mybookings.bookingcancelationmail.txt',$bookingid);
            if(TryCancelBooking($bookingid)){
                SendMail($clientmail,"Boeking geannuleerd $bookingid",$mailtext);
                header("Location: mybookings.php?completedaction=cancelbooking&bookingid=$bookingid&message=" . htmlentities("Er is een bevestigingsmail verzonden naar: $clientmail"));
            }else{
                header("Location: mybookings.php?failedaction=cancelbooking&bookingid=$bookingid");
            }
        }

        break;

        # user wants to pay... let's make him a form for that
    case "paybooking":

        VerifyBookingDefault();
        VerifyBookingNotPaid();
        echo DatabaseReplaceTextBooking("mybookings.paybooking.html",$bookingid);

        break;

        # so the payment form has been sent after it has been validated by the browser...
        # we are still going to do it again
    case "dopaybooking":

        VerifyBookingDefault(); # prevent paying other people's bookings or unexisting bookings
        VerifyBookingNotPaid(); # prevent paying already paid bookings
        VerifyTermsAccepted(); # make sure user accepted terms

        # now let's validate
        switch($paymentmethod){

            case "ideal":



                break;

            case "creditcard":

                if($creditcardexpirationmonth > 12 || $creditcardexpirationmonth < 1){
                    header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=IllegalPaymentInfoException&message=" . htmlentities("Your creditcard's expirationmonth $creditcardexpirationmonth is incorrect!<br/>This must be between 0 and 13!"));
                }
                if($creditcardexpirationyear < date('Y')){
                    header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=IllegalPaymentInfoException&message=" . htmlentities("Your creditcard's expirationyear $creditcardexpirationyear is incorrect!<br/>This cannot be lower than the current year (" . date('Y') . ')'));
                }
                if(!is_numeric($creditcardnumber) || strlen($creditcardnumber) != 16){
                    header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=IllegalPaymentInfoException&message=" . htmlentities("Your creditcard's number $creditcardnumber is of a bad format!<br/>This must be numeric and 16 characters long!"));
                }

                break;

            case "paypal":



                break;

            default:

                header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=IllegalPaymentInfoException&message=" . htmlentities("Your preferred paymentmethod is incorrect!<br/>Valid options are: Ideal, PayPal and CreditCard."));

                break;

        }

        # set booking paid in database and then send mail
        if(DatabaseSetBookingPaid($bookingid) == true){

            $betalingsmethode = 'Ideal';
            if($paymentmethod == 'ideal'){
                $betalingsmethode = "Ideal";
            }elseif($paymentmethod == 'creditcard'){
                $betalingsmethode = "PayPal";
            }elseif($paymentmethod == 'paypal'){
                $betalingsmethode = "CreditCard";
            }

            $betalingsinstantie = "ING Bank";
            if($paymentmethod == 'ideal'){
                if($idealprovider == 'ing'){
                    $betalingsinstantie = 'ING Bank';
                }elseif($idealprovider == 'sns'){
                    $betalingsinstantie = 'SNS Bank';
                }elseif($idealprovider == 'rabo'){
                    $betalingsinstantie = 'Rabobank';
                }elseif($idealprovider == 'abn'){
                    $betalingsinstantie = 'ABN Amro';
                }
            }elseif($paymentmethod == 'creditcard'){
                if($creditcardtype == 'visa'){
                    $betalingsinstantie = 'VISA';
                }elseif($creditcardtype == 'mastercard'){
                    $betalingsinstantie = 'MasterCard';
                }
            }elseif($paymentmethod == 'paypal'){
                $betalingsinstantie = 'PayPal';
            }

            SendMail($clientmail,"Boeking betaald $bookingid",DatabaseReplaceTextBooking('mybookings.bookingconfirmationmail.txt',$bookingid,array('betalingsmethode' => $betalingsmethode, 'betalingsinstantie' => $betalingsinstantie)));
            header("Location: mybookings.php?completedaction=$action&bookingid=$bookingid&message=" . htmlentities("Een bevestigingsmail is verzonden naar: $clientmail!"));

        }else{
            header("Location: mybookings.php?failedaction=$action&bookingid=$bookingid&exception=DatabaseNotUpdatedException");
        }

        break;

    default:

        echo GetBookingsTableHTML();

        if(count($logmessages) != 0){

            echo "<br/>\n";
            echo "Mijn log:<br/>\n";

            foreach($logmessages as $logmessage){
                echo GetNotificationSpanHTML($logmessage[0],$logmessage[1],$logmessage[2]) . "\n<br/>\n";
            }

        }

        break;

}

WritePageEnd();

?>