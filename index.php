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
    '<a href="login.php">Bejelentkezés</a>'.
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
				    <a href="php/logout.php">Kilépés</a>
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

<div class="szoveg">
<p >A pszeudokód az algoritmusok és általában az eljárások leírására használt olyan mesterséges formális nyelv, mely változókból és néhány állandó jelentésű szóból („foglalt” konstansok) áll, és (szándékosan) hasonlít a számítógépes programozási nyelvekre.<br><br>

Az algoritmusok egy-egy elmélet, ismeretterület egy-egy problémakörének kezelésére, megoldására használt olyan utasítássorozatok, melyekben véges sokféle (általában előre megadott, vagy az elmélet által implicite meghatározott) elemi lépés fordulhat csak elő. A pszeudokódok minden elemi lépésnek egy-egy szót, jelet, elnevezést feleltetnek meg, ezáltal alkalmasak az elemi lépések és így az egész algoritmus leírására.<br><br>

A pszeudokódokat alkalmazzák például a számításelméletben vagy a matematika egyéb ágában, a mesterséges intelligencia kutatásában, és általában mindenhol, ahol bizonyos értelemben „programozni” kell, de az algoritmus megadására nem egy konkrét programozási nyelven van szükség.<br><br>

Pszeudokód = „álkód”, mivel ez a leírási mód nagyon közel van a magas szintű programozási nyelvek által használt kódhoz, de egyetlen programozási nyelvvel sem azonos a formája. Mondhatjuk, hogy átmenetet képez a mondatszerű leírás és a kód (=programszöveg, forrásprogram) között. Tehát ez az emberi nyelvhez közel álló, szabályokkal kötött mondatszerű leírást jelent.</p>

</div>
  
  
   
    <script type="text/javascript">

$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});


</script>
  
    
</body>
</html>