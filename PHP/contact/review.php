<?php
if (!isset($_SESSION['ID'])) {
	header("Location: index.php");
}
if (isset($_POST['rev'])){
	$datum= date('Y-m-d');
	$review= $_POST['Review'];
	$rating= $_POST['Rating'];
	$hotel_id= $_POST['ID'];
	$gebruiker_id= $_SESSION['ID'];
	
$query = "INSERT INTO REVIEW(Datum, Review, Rating, HOTEL_ID, GEBRUIKER_ID)
VALUES ('$datum', '$review', '$rating',  '$hotel_id', '$gebruiker_id')";
$add_member= mysql_query($query) or die (mysql_error());

}
else
{
$ID = $_GET['ID'];
?>
<!DOCTYPE html>
<html>
	<body>
		
		<form id="form" action="index.php?content=contact/review" method="post">
			<input type="hidden" name="ID" value="<?php echo $ID;?>">
			<fieldset>
				Rating </br>
				<input type="number" name="Rating" min="0" max="100"> </br>
				Review </br>
				<textarea form="form" name="Review" placeholder="Zet hier je review neer." style="width: 100%" required></textarea></br></br>
				<input name="rev" type="submit" id="bewerk" value="Plaats" class= "btn btn-primary">
			</fieldset>
		</form>
	</body>
</html>
<?php } ?>
