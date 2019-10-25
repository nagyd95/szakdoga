<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bejelentkezés</title>
  <link rel="stylesheet" type="text/css" href="css/login.css" />
</head>
<body>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
if(isset($_POST['back'])){
    header("location:index.php");
}
if(isset($_POST['login'])){
$nev=trim($_POST['username']);
$jelszo=trim($_POST['password']);
if(empty($nev)){
	print("nev ures");
}
if (empty($jelszo)) {
	print("jelszo ures");
}

$jelszo_md5=md5($jelszo);
$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
	if ($adatbazis->connect_error) {
		die("Connection failed: " . $adatbazis->connect_error);
	}
	else
	{
		$sql="select user_name,password FROM user;";
		$result=mysqli_query($adatbazis,$sql);
		if(mysqli_num_rows($result)>0)		{
			while(($row=mysqli_fetch_assoc($result)))
			{		
						if($nev==$row['user_name'] && $jelszo_md5==$row['password'])
						{
              $_SESSION['user_name']=$nev;
              print($_SESSION['user_name']);
							header("location:index.php");

						}
						elseif($nev!=$row['user_name'] || ($nev==$row['user_name'] && $jelszo_md5!=$row['password'])){
            print("hibas adatok");
          }	
			}
    }
  }
}
?>
      
      
  
  <div class="container">
  <h1>PszeudoKód világa</h1>
    <h2>Bejelentkezés</h2>

    <form action="" method="post">
      <div class="tbox">
        <input type="text" name="username" id="" placeholder="Felhasználónév">
      </div>
      <div class="tbox">
        <input type="text" name="password" id="" placeholder="Jelszó">
      </div>

      <input class="btn" type="submit" value="Bejelentkezés" name="login">
      <input class="btn2" type="submit" value="Vissza" name="back">
    <form>
      <a class="b1" href="#">Elfelejtette jelszavát?</a>
      <a href="signup.php" class="b2">Új felhasználó</a>
  </div>
</body>
</html>