
<!DOCTYPE html>
<html>
<body>

<h2>Wijzig wachtwoord</h2>

<?php

  $display_form = 1;

  if(isset($_POST['bewerk']))
  {
    $old_password = md5($_POST["old_password"]);
    $new_password_1 = $_POST["new_password_1"];
    $new_password_2 = $_POST["new_password_2"];

    if(strlen($new_password_1) < 4)
    {
      echo "Het wachtwoord moet minimaal vier karakters lang zijn<br>";
    }
    else
    {
      if($new_password_1 != $new_password_2)
      {
        echo "Wachtwoorden komen niet overeen<br>";
      }
      else
      {

        $user_id = $_SESSION['ID'];
        $query = "SELECT Wachtwoord FROM GEBRUIKER WHERE ID = $user_id;";
        $query_result = mysql_query($query);

        $row = mysql_fetch_assoc($query_result);
        if(!$row)
        {
          die("Ongeldige gebruiker!");
        }

        if($old_password != $row["Wachtwoord"])
        {
          echo "Onjuist wachtwoord<br>";
        }
        else
        {
          $newpas = md5($new_password_1);	
          $query = "UPDATE GEBRUIKER SET Wachtwoord = '$newpas' WHERE ID= $user_id";
          mysql_query($query);
          echo "Het wachtwoord is met success veranderd.<br>";
          echo "<td><a href='index.php?content=user/profile'>Terug naar profiel</a></td>";

          $display_form = 0;
        }
      }
    }
  }

  if($display_form)
  {
  	?>
    <form action='index.php?content=user/change_password' method='post'>
    <table>
    <tr>
    <td><b>Oud wachtwoord:</b></td>
    <td><input type='password' name='old_password'  maxlength='50' required><br></td>
    </tr>
    <tr>
    <td><b>Nieuw wachtwoord:</b></td>
    <td><input type='password' name='new_password_1' maxlength='50' required><br></td>
    </tr>
    <tr>
    <td><b>Nieuw wachtwood bevestigen:</b></td>
    <td><input type='password' name='new_password_2' maxlength='50' required><br></td>
    </tr>
    <tr>
	<td><a href='profile.php'>Terug naar profiel</a></td>
    <td><input name="bewerk" type="submit" id="bewerk" value="Wijzig" class= "btn btn-primary"></td>
    </tr>
    </form>
    <?php
  }
?>

</body>
</html>
