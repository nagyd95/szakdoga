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
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script type='text/javascript' src='js/site.js'></script>
  <title>Átalakit</title>
  <script type='text/javascript' src='js/jquery.modal.js'></script>
  <link rel="stylesheet" type="text/css" href="css/atalakit.css">
  <link rel="stylesheet" type="text/css" href="css/pop.css" />
  

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
			
  <!-- <div class="jumbotron text-center">
      <h1>PszeudoKód világa</h1>
      <p>Resize this responsive page to see the effect!</p> 
  </div> -->
  <div class="container">
    <div class="row">
      <div class="col-xs-4" style="margin:inherit">
        <h3>Pszeudokód</h3>
        <form action="" method="POST" >
        <?php
        if(isset($_POST['mentes'])){
            $cim=$_POST['cim'];
            $leiras=$_POST['leiras'];
            $kod=htmlspecialchars($_POST['text']);
            
            $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
            $adatbazis->query("SET NAMES 'utf8'");
            $adatbazis->query("SET CHARACTER SET UTF8");
            if ($adatbazis->connect_error) {
              die("Connection failed: " . $adatbazis->connect_error);
            }else{
            
            $sql="INSERT INTO `szakdoga`.`code` (`id`, `name`,`leiras`,`kod`, `user_id`) VALUES (NULL,'$cim','$leiras','$kod','$user_id');";
            
            $result=mysqli_query($adatbazis,$sql);
            
            }
        }
        if(isset($_GET['id'])){
          $i=$_GET['id'];
          $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
          $adatbazis->query("SET NAMES 'utf8'");
          $adatbazis->query("SET CHARACTER SET UTF8");
          $sql="select kod FROM code where id=$i;";
          $result=mysqli_query($adatbazis,$sql);
          $row = $result->fetch_assoc();
          echo'<textarea rows="10" cols="70" id="textarea" name="text" title="Ide ird" class="textArea">'.$row['kod'].' </textarea><br>';
        }else{

        ?>
        <form method="POST" action="">
        <textarea rows="10" cols="50" id="textarea" name="text" title="Ide ird" class="textArea">be: A,B,C&#13;ciklus amíg A&lt;B &#13; A++&#13;ciklus vége &#13;ciklus nein = 0..10&#13; B++&#13;ciklus vége&#13;tombicsekelftars:=1,3,4,5,61&#13;ha B=A&#13; A=10&#13;ha különben B=C &#13; A=1&#13;különben&#13;A=0&#13;elágazás vége&#13;szoveg:=Hello World</textarea><br>
        
        <?php
        }
        ?>
        <input type="submit" value="Átalakit" id='ok'>
        <input type="submit" value="Futtat" id='futtat' disabled>
        <a class=modalLink id="ment" href=#modal style="display: none;" >Mentés</a>
        <div class="overlay"></div>
        <div id="modal" class="modal"  >
          <label for="cim">Cim</label>
          <input type="text" name="cim"><br>
          <label for="leiras">Leirás</label>
          <input type="text" name="leiras" class="leiras"><br>
          <input type="submit" name="mentes" value="Mentés">
          <input type="button" class="closeBtn" value="Mégse">
        </form>
       
				</div>

        
        </form>
    </div>
    <div class="col-xs-6" style="padding-left: 40px" >
        <h3>JavaScript kód</h3>
        
        <p id="valtozok"><?php
        if(isset($_POST['valtozok'])){
          print('hajaja');
        }
        ?></p>
        <p id="valtozokBe"></p>
        <p id="eredmeny"></p>
        
      </div>
      <div id="col-sx-4">
        <p id="futtatas" style="padding-left: 40px"></p>
      </div>
  </div>
  
    <script src="app.js"></script>
    <script src="js/futtat.js"></script>
    <script type="text/javascript">

$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});


</script>
</body>
</html>