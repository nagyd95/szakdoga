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
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Szakdoga</title>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/kodjaim.css">
  
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
<div class="kodjaim">
<?php
$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
$adatbazis->query("SET NAMES 'utf8'");
$adatbazis->query("SET CHARACTER SET UTF8");
if ($adatbazis->connect_error) {
  die("Connection failed: " . $adatbazis->connect_error);
}else{
  $sql="select name,kod FROM code where user_id='$user_id';";
  $result=mysqli_query($adatbazis,$sql);
  $i=1;
  
  if(mysqli_num_rows($result)>0)		{
    while ($row = $result->fetch_assoc()) {
      $hossz=strlen($row["kod"]);
      
      print('<div class="felsorol">');
      $name=$row['name'];
      $kod=$row['kod'];
      $leiras = substr($kod, 0,100) . '...';
      
      print($i.',&#8195');
      $i+=1;
      print('<b>'.$name.'</b></br>');
      print('<b>'.$leiras.'</b></br>');
      print('</div>');
      print('<div class="likeolos">');
      print('like:   ,dislike:  ');
      print('</div>');
      print('<br>');
    }		
  }else{
    echo'Még nincs saját kódja elmentve.';
  }
}

?>

</div>

  
<script src="app.js"></script>
    <script type="text/javascript">

$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});


</script>
  
    
</body>
</html>