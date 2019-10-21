<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Szakdoga</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type="text/javascript">
      var http = new XMLHttpRequest();
      function ellenoriz(nev) 
      {
        http.abort();
        http.open("GET", "ellenoriz.php?nev="+nev, true);
        http.send();
        http.onreadystatechange=function() 
        {
          if(http.readyState==4 && http.status==200) 
          {
            document.getElementById('neves').innerHTML = http.responseText;
           
          }
        }  
      }

      
      </script>
</head>
<body>
<div class="jumbotron text-center">
      <h1>PszeudoKód világa</h1>
      <p>Resize this responsive page to see the effect!</p> 
  </div>
  <form action="" method="POST" class="form-reg">
  
			<div class="regisztraciosfelulet">
			<p>Regisztráció</p>
			</div>
      <?php

$jelszokNemEgyeznek=false;
$nevUres=false;
$emailUres=false;
$elsoJelszoUres=false;
$masodikJelszoUres=false;
$sikeres=false;
$sikertelen=false;
if(isset($_POST['back'])){
	header("location:index.php");
}


if(isset($_POST['reg'])){
 
  $nev=trim($_POST['name']);
  $email=trim($_POST['email']);
  $jelszo=trim($_POST['pass']);
  $jelszo2=trim($_POST['passagain']);
  if ($nev=="") {
    $nevUres=true;
  }
  if (empty($jelszo)) {
    $elsoJelszoUres=true;
  }
  if (empty($jelszo2)) {
    $masodikJelszoUres=true;
  }
  if (empty($email)) {
    $emailUres=true;
  }
  if($jelszo!=$jelszo2){
    $jelszokNemEgyeznek=true;
  }
  if (!$emailUres && !$masodikJelszoUres && !$elsoJelszoUres && !$nevUres && !$jelszokNemEgyeznek) {
    
  
    $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
    if ($adatbazis->connect_error) {
      die("Connection failed: " . $adatbazis->connect_error);
    }
    $sql="SELECT user_name from user";
    $result=mysqli_query($adatbazis,$sql);
      if(mysqli_num_rows($result)>0){
        while(($row=mysqli_fetch_assoc($result)))
        {	
          if($row['user_name']==$nev){
          $sikertelen=true;
          }
        }
      }
    if(!$sikertelen){
    $md5_pass=md5($jelszo);
    $sql="INSERT INTO `szakdoga`.`user` (`ID`, `Email`, `user_name`, `password`) VALUES (NULL, '$email', '$nev', '$md5_pass');";
    $result=mysqli_query($adatbazis,$sql);
    $sikeres=true;
    }
  }
  else{
    $sikertelen=true;
  }
  }
  ?>

<form action="" method="POST" class="form-reg">
  <input type="text" name="name" maxlength="15" minlength="4"  placeholder="Felhasználónév" onchange="ellenoriz(this.value)" <?php if($nevUres) { echo "style=\"border: 2px solid red\"";}?>><div id="neves"><?php if($nevUres) { print("<font style=\"color:red\">Név üres!</font>"); } ?> </br></div>


    <input type="email" name="email" maxlength="30" minlength="4"  placeholder="E-mail cím" <?php if($emailUres) { echo "style=\"border: 2px solid red\"";}?>><div id="eror"><?php if($emailUres) { print("<font style=\"color:red\">E-mail cím üres!</font>"); } ?></br></div>

    <input type="password" name="pass" maxlength="15" minlength="4"  placeholder=" Jelszó" <?php if($elsoJelszoUres) { echo "style=\"border: 2px solid red\"";}?>><div id="eror"><?php if($elsoJelszoUres) { print("<font style=\"color:red\">Jelszó üres!</font>"); } ?></br></div>

    <input type="password" name="passagain" maxlength="15" minlength="4"  placeholder=" Jelszó újra" <?php if($masodikJelszoUres) { echo "style=\"border: 2px solid red\"";}?>><div id="eror"><?php if($masodikJelszoUres) { print("<font style=\"color:red\">Jelszó üres!</font>"); } if($sikeres) { print("<font style=\"color:green\">Sikeres regisztráció!</font>"); } if($sikertelen) { print("<font style=\"color:red\">Sikertelen regisztráció!</font>"); }?></br></div>

  <input type="submit" value="Regisztráció!" name="reg" >
	<input type="submit" value="Vissza" name="back" />
			



 </form>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>