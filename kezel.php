<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];
if(empty($bentVan) || $bentVan!="admin"){
  header("location:index.php");
}
$listaz="felhasznalok";
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
  <title>Szakdoga</title>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  
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
      <a class="dropbtn"><?php print($bentVan); ?></a>
      <div class="dropdown-content">
        <?php
        if($bentVan=="admin"){
          echo'<a href="kezel.php">Kezelés</a>';
        }
        ?>
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

<a href="kezel.php?mit=felhasznalok">Felhasználok</a>
<a href="kezel.php?mit=kodok">Kódok</a>
<a href="kezel.php?mit=uzenetek">Üzenetek</a> 
<?php

if(isset($_GET['mit'])){
  $listaz=$_GET['mit'];
  
}
print($listaz);

$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
$adatbazis->query("SET NAMES 'utf8'");
$adatbazis->query("SET CHARACTER SET UTF8");
if($listaz=="felhasznalok"){
$sql="select * from user";
$result=mysqli_query($adatbazis,$sql);
while ($row = $result->fetch_assoc()) {
  print($row['ID']);
  print($row['Email']);
  print($row['user_name']);
  
}
}
else if($listaz=="kodok"){

}
else if($listaz=="uzenetek"){
  
}
?>

</body>
</html>
