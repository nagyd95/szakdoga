<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  
  <title>Szakdoga</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <link rel="stylesheet" href="css/signup.css">
  <script type="text/javascript">
      var http = new XMLHttpRequest();
      function ellenoriz(nev) 
      {
        http.abort();
        http.open("GET", "php/ellenoriz.php?nev="+nev, true);
        http.send();
        http.onreadystatechange=function() 
        {
          if(http.readyState==4 && http.status==200) 
          {
            document.getElementById('felhasznalonev_valasz').innerHTML = http.responseText;
           
          }
        }  
      }

      
      </script>
</head>
<body>
<div class="container">
  <h1>PszeudoKód világa</h1>
    <h2>Regisztráció</h2>
    
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
  <div class="tbox">
    <input type="text" name="name" maxlength="15" minlength="4"  placeholder="Felhasználónév" onchange="ellenoriz(this.value)" ><div id="felhasznalonev_valasz"><?php if($nevUres) { print("<font style=\"color:red\">Név üres!</font>"); } ?> </br></div>
  </div>

  <div class="tbox">
    <input type="email" name="email" maxlength="30" minlength="4"  placeholder="E-mail cím" ><div id="eror"><?php if($emailUres) { print("<font style=\"color:red\">E-mail cím üres!</font>"); } ?></br></div>
  </div>
  
  <div class="tbox">
    <input type="password" name="pass" maxlength="15" minlength="4"  placeholder=" Jelszó" ><div id="eror"><?php if($elsoJelszoUres) { print("<font style=\"color:red\">Jelszó üres!</font>"); } ?></br></div>
  </div>
  <div class="tbox">
      <input type="password" name="passagain" maxlength="15" minlength="4"  placeholder=" Jelszó újra" ><div id="eror"><?php if($masodikJelszoUres) { print("<font style=\"color:red\">Jelszó üres!</font>"); } if($sikeres) { print("<font style=\"color:green\">Sikeres regisztráció!</font>"); } if($sikertelen) { print("<font style=\"color:red\">Sikertelen regisztráció!</font>"); }?></br></div>
  </div>

  <input type="submit" class="btn" value="Regisztráció!" name="reg" >
	<input type="submit" value="Vissza" class="btn2" name="back" />
  <a href="login.php" class="b1">Van felhasználója?</a>
</form>
</div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
</body>
</html>