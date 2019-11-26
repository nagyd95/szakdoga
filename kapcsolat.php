<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Kapcsolat</title>
  <link rel="stylesheet" type="text/css" href="css/kapcsolat.css">
  
</head>
<body>
  
<div class="navbar">
<div class="logo">
  <h1>PszeudoKód Világa </h1>
</div>
<?php
if(empty($bentVan)){
?>

<a class="btn">
  <span></span>
  <span></span>
  <span></span>
</a>
<?php
}
?>
<?php
   
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
    if(isset($_POST['kilep'])){
      session_destroy();
      header("location:index.php");
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
    
<p></p>
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


<div class="kapcsolat">
  <p>Írja le véleményét!</p>
  <form method="POST" action="">	
    <div id="kapcsos">
      <table border="1px" align="center">
        <tr><td>
          Tárgy:
        </td><td colspan="2" align="center">
          <input type="text" name="targy" >
        </td></tr>
        <tr><td>Üzenet:</td><td>
          <textarea rows="8" cols="50" name="leiras"></textarea>
        </td></tr>
            <tr><td colspan="2">
            <input type="submit" name="kapcs" value="Küldés"></td></tr>
        </table>
      </div>
  </form>
</div>

<?php
if(isset($_POST['kapcs'])){
  $targy=$_POST['targy'];
  $uzenet=$_POST['leiras'];
  $dt = new DateTime();
  $dt=$dt->format('Y-m-d');
  
  if(!empty($targy) && !empty($uzenet)){
    $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga'); 
    if ($adatbazis->connect_error) {
      die("Connection failed: " . $adatbazis->connect_error);
    }
    if(empty($bentVan)){
    $sql="INSERT INTO `szakdoga`.`uzenetek` (`id`, `uzenet`, `targy`, `user_name`,`date`) 
        VALUES (NULL, '$uzenet', '$targy', 'vendeg','$dt');";

    }
    else{
      $sql="INSERT INTO `uzenetek` (`id`, `uzenet`, `targy`, `user_name`, `date`)
        VALUES (NULL, '$uzenet', '$targy', '$bentVan','$dt');";
    
    }
    $result=mysqli_query($adatbazis,$sql);
  }
}
  

?>

<script type="text/javascript">
$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});
</script>
  
</body>
</html>