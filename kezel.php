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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
  <title>Szakdoga</title>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/kezel.css">
  
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
      <a href="index.php">Főoldal</a>
      <a href="atalakit.php">Kód Átalakítás</a>
        <a href="toplista.php">Toplista</a>
        <a href="kereses.php">Keresés</a>
        <a href="kapcsolat.php">Kapcsolat</a>
				
			</div>
</form>
<hr >
<div class="mitKezel">
<a href="kezel.php?mit=felhasznalok">Felhasználok</a>
<a href="kezel.php?mit=kodok">Kódok</a>
<a href="kezel.php?mit=uzenetek">Üzenetek</a> 
  </div>
<?php

if(isset($_GET['mit'])){
  $listaz=$_GET['mit'];
  
}


$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
$adatbazis->query("SET NAMES 'utf8'");
$adatbazis->query("SET CHARACTER SET UTF8");
if($listaz=="felhasznalok"){
 echo' <table border="0px" align="center"> <tr align="center"><td><b>ID<b> </td><td><b>Felhasználó név<b></td><td><b>E-mail<b></td><td><b>Törlés<b></td>';
        
        
$sql="select * from user";
$result=mysqli_query($adatbazis,$sql);
while ($row = $result->fetch_assoc()) {
  echo'<tr align="center">';
  echo'<td>'.$row["ID"].'</td>';
  echo'<td>'.$row["user_name"].'</td>';
  echo'<td>'.$row["Email"].'</td>';
  echo'<td><i class="fa fa-close"></i></td>';
  echo'</tr>';
  
}
echo '</table>';
}
else if($listaz=="kodok"){
  echo' <table border="0px" align="center"> <tr align="center"><td><b>ID<b> </td><td><b>Név<b></td><td><b>Leírás<b></td><td><b>Kód<b></td><td><b>Feltöltő<b></td><td><b>Törlés<b></td>';
  $sql="select * from code";
  $result=mysqli_query($adatbazis,$sql);
  while ($row = $result->fetch_assoc()) {
    echo'<tr align="center">';
    echo'<td>'.$row["id"].'</td>';
    echo'<td>'.$row["name"].'</td>';
    echo'<td>'.$row["leiras"].'</td>';
    $kod=$row['kod'];
    if(strlen($kod)>100){
        $kod2 = substr($kod, 0,100) . '...';
        echo'<td>'.$kod2.'</td>';
    }else{
      echo'<td>'.$kod.'</td>';
    }
    
    echo'<td>'.$row["user_id"].'</td>';
    echo'<td><i class="fa fa-close"></i></td>';
    echo'</tr>';
    
  }
  echo '</table>';
}
else if($listaz=="uzenetek"){
  echo' <table border="0px" align="center"> <tr align="center"><td><b>ID<b> </td><td><b>Tárgy<b></td><td><b>Üzenet<b></td><td><b>Felhasználó<b></td><td><b>Dátum<b></td><td><b>Törlés<b></td>';
  $sql="select * from uzenetek";
  $result=mysqli_query($adatbazis,$sql);
  while ($row = $result->fetch_assoc()) {
    echo'<tr align="center">';
    echo'<td>'.$row["id"].'</td>';
    echo'<td>'.$row["targy"].'</td>';
    echo'<td>'.$row["uzenet"].'</td>';
    echo'<td>'.$row["user_name"].'</td>';
    echo'<td>'.$row["date"].'</td>';
    echo'<td><i class="fa fa-close"></i></td>';
    echo'</tr>';
    
  }
  echo '</table>';
}
?>

</body>
</html>
