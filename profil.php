<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];
if(empty($bentVan)){
  header("location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Profil</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Szakdoga</title>
  <link rel="stylesheet" type="text/css" href="css/profil.css">
  <link rel="stylesheet" type="text/css" href="css/index.css">
</head>
<body>
<div class="navbar">
<div class="logo">
  <h1>PszeudoKód Világa</h1>
</div>

<?php
   $jelszoModositas=false;
    if(empty($bentVan)){
    print('<div class="menu">'.
    '<a href="login.php">Bejelentkezes</a>'.
    '<a href="signup.php">Regisztráció</a>'.
  '</div>');
    }
    else{?>
     <div class="dropdown">
      <button class="dropbtn"><?php print($bentVan); ?></button>
      <div class="dropdown-content">
				    <a href="profil.php">Profil</a>
            <a href="kodjaim.php">Kódjaim</a>
				    <a href="phpcodes/logout.php">Kilépés</a>
				  </div>
        </div>
        <?php
    }
    if(isset($_POST['fooldal'])){
      header("location:index.php");
    }
    if(isset($_POST['jelszoValt'])){
      $regijelszo=$_POST['regi'];
      $ujjelszo=$_POST['uj'];
      $ujjelszo2=$_POST['uj2'];
     
      if(!empty($regijelszo) && !empty($ujjelszo) && !empty($ujjelszo2) && $ujjelszo==$ujjelszo2){
       
        $md5_regi=md5($regijelszo);
        $md5_uj=md5($ujjelszo);
        $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
	      if ($adatbazis->connect_error) {
						die("Connection failed: " . $adatbazis->connect_error);
				}
				else
				{
					$sql="select password from user where user_name='$bentVan'";
					$result=mysqli_query($adatbazis,$sql);
					$row=mysqli_fetch_row($result);
					if(trim($row[0])==trim($md5_regi)){
						$sql="UPDATE user SET password='$md5_uj' where user_name='$bentVan'";
						$result=mysqli_query($adatbazis,$sql);
						$jelszoModositas=true;
					}
								
					}

      }
    }
    if(isset($_POST['emailValt'])){
      $ujemail=$_POST['ujEmail'];
      if(!empty($ujemail)){
        $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
        if ($adatbazis->connect_error) {
          die("Connection failed: " . $adatbazis->connect_error);
      }
      else
      {
        $sql="UPDATE user SET email='$ujemail' where user_name='$bentVan'";
				$result=mysqli_query($adatbazis,$sql);
					
      }
    }
  }
  
  if(isset($_POST['fooldal'])){
    header("location:index.php");
  }
  if(isset($_POST['atalakitas'])){
    header("location:atalakit.php");
  }
  if(isset($_POST['toplista'])){
    header("location:toplista.php");
  }
  if(isset($_POST['kereses'])){
    header("location:kereses.php");
  }
  if(isset($_POST['kapcsolat'])){
    header("location:kapcsolat.php");
  }
?>

</div>
<div class="header">

</div>
<form method="POST" action="" >
			<div class="foGombok">
				
				<input type="submit" name="fooldal" value="Főoldal">
				
				<input type="submit" name="atalakitas" value="Kód Átalakítás" >
				
				<input type="submit" name="toplista" value="Toplista">
				
				
				<input type="submit" name="kereses" value="Keresés">		

				<input type="submit" name="kapcsolat" value="Kapcsolat">
				
			</div>
</form>
<hr >



<?php
$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
if ($adatbazis->connect_error) {
  die("Connection failed: " . $adatbazis->connect_error);
}
else
{
  $sql="select Email,user_name,password from user where user_name='$bentVan' ";
  $result=mysqli_query($adatbazis,$sql);
  
    $row=mysqli_fetch_assoc($result);	
    
      $email=$row['Email'];
      $jelszo=$row['password'];
      $nev=$row['user_name'];
      
                
}
?>
<div id="page">
	<table  border="1px solid black">
	
		<tr>
		<td>
		<?php
		print("<b>Felhasználónév:</b> ".$nev);

		?>
		</td>
		</tr>
		<tr>
		<td>
			<?php
		print("<b>Email:</b> ".$email);

		?>
		</td>
		</tr>
		</table>
    <hr>
<form method="POST" action="">
	
	
	<table border="1px solid black">
	<tr>
		<td>
		<b>Régi jelszó:</b></td>
		<td>
		<input type="password" name="regi" maxlength="15" minlength="4"/>
		</td>
	</tr>
	<tr>
		<td>
		<b>Új jelszó:</b></td>
		<td>
		<input type="password" name="uj" maxlength="15" minlength="4"/>
		</td>
	</tr>
	<tr>
		<td>
		<b>Új jelszó megint: </b>		</td>
		<td >
			<input type="password" name="uj2" maxlength="15" minlength="4" />
		</td>
  </tr>
  <tr>
    <td colspan="2">
  <input type="submit" name="jelszoValt" value="Jelszó mentése">
  </td>
  </tr>
    <?php
      if($jelszoModositas){
        ?>
        <tr>
        <td colspan="2">
        <span style=color:green>Sikeres jelszocsere!</span>
        </td>
      </tr>
        <?php
      }
    ?>
</tr>

</table>
<hr>
<table border="1px solid black">
	<tr>
		<td>
		<b>Új e-mail cím:</b></td>
    </td>
    <td>
    <input type="text" name="ujEmail">
</td>
</tr>
<tr>
  <td colspan="2">
  <input type="submit" name="emailValt" value="Email mentése">
</td>
</tr>
</form>
</div>
</body>
</html>