


<?php
if (isset($_POST['date'])) {
	exit();
	for ($i=0;$i<7;$i++){
		$date = $_POST['test'] + 1;
		echo $date;
	}
}

?>
<form>
<form name="form1" method="post" action="admin.php?content=Tab_ov">
<input type="date" name="Geboortedatum" placeholder="yyyy-mm-dd" required>
<input name="date" type="submit" id="date" value="test" class= "btn btn-primary">
</form>


