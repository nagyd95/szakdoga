<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Bejelentkezés</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" type="text/css" href="css/login.css" />

</head>
<body>
<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$hibasAdatok=false;
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
		$sql="select ID,user_name,password FROM user where user_name='$nev';";
		$result=mysqli_query($adatbazis,$sql);
		if(mysqli_num_rows($result)>0)		{
			while(($row=mysqli_fetch_assoc($result)))
			{		
						if($jelszo_md5==$row['password'])
						{
              $_SESSION['user_name']=$nev;
              $_SESSION['id']=$row['ID'];
							header("location:index.php");

						}
						elseif($nev!=$row['user_name'] || ($nev==$row['user_name'] && $jelszo_md5!=$row['password'])){
           $hibasAdatok=true;
          }	
			}
    }else{
      $hibasAdatok=true;
    }
  }
}
?>
      
      
  
  <div class="container">
  <h1>PszeudoKód világa</h1>
    <h2>Bejelentkezés</h2>
    <?php
    if($hibasAdatok){
      print("<font style=\"color:red\">Hibás adatok!</font>");
    }
    ?>
    <form action="" method="post">
      <div class="tbox">
        <input type="text" name="username" id="" placeholder="Felhasználónév">
      </div>
      <div class="tbox">
        <input type="password" name="password" id="" placeholder="Jelszó">
      </div>

      <input class="btn" type="submit" value="Bejelentkezés" name="login">
      <input class="btn2" type="submit" value="Vissza" name="back">
    <form>
      
      <a href="signup.php" class="b2">Új felhasználó</a>
  </div>
</body>
</html>