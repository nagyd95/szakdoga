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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <script type='text/javascript' src='js/site.js'></script>
  <script src="js/autoresize.js"></script>
    <script type="text/javascript">
  $('textarea').autoResize();
  </script>
  <title>Átalakit</title>
  <script type='text/javascript' src='js/jquery.modal.js'></script>
  <link rel="stylesheet" type="text/css" href="css/atalakit.css">
  
  <link rel="stylesheet" type="text/css" href="css/index.css" />
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
  
  <div class="container">
    <div class="row">
      <div class="col-xs-6"  style="margin:inherit">
        <h2 > Pszeudokód </h2><a href="" id='ok'> Átalakít</a> 
        <div class="dropdown">
        <i class="fa fa-question-circle" style="font-size:30px;color:blue" ></i>
          <div class="dropdown-content" style="width:550px;margin-top:-200px;margin-right:-300px;padding:5px;"> 
            <b>Segítség a szintaxishoz:</b><br>
            <u>Értékadás:</u><br>
            <i>Változó neve:= változó értéke</i> <b>valtozo:=10</b><br>
            <u>Változó bekérése:</u><br>
            <i>be:</i> majd változak felsorolni vesszővel elválasztva  <b>be: valtozo1,valtozo2</b><br>
            <u>while ciklus</u><br>
            <i>ciklus amíg feltéltel</i> majd új sorokba a ciklus belsejét,lezárása új sorba <i>ciklus vége</i><br><b>ciklus amíg valtozo1< valtozo2<br>&#8195;valtozo1++<br>ciklus vége</b><br> 
            <u>For ciklus: </u><br>
            <i> ciklus segedváltozó = kezdeti érték<b>..</b>medig</i>lezárása új sorba <i>ciklus vége</i><br><b>ciklus valtozo = 0..10<br>&#8195;valt+=5<br>ciklus vége</b><br>
            <u>Feltétel:</u><br>
            <i>ha feltéltel </i> majd új sorokba a feltétel belsejét, <i>ha különben feltétel</i> új sorokba a feltétel belsejét, <i>különben</i> új sorokba a feltétel belsejét majd <i>elágazás vége</i><br>
            <b>ha valt1=valt2 <br>&#8195;valt1=10 <br> ha különben valt1< valt2<br>&#8195;valt2=100<br>különben<br>&#8195;valt1=valt2</b>
				  </div>
        </div>
        <?php
            if(!empty($bentVan)){
              echo'<a class=modalLink id="ment" href=#modal style="display: none;" >Mentés</a>';
            }else{
              echo'<a id="ment"></a>';
            }
          ?>
        
        
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
          echo'<textarea rows="10" cols="50" id="textarea" name="text" title="Ide ird" class="textArea">'.$row['kod'].' </textarea><br>';
        }else{

        ?>
        <form method="POST" action="">
        <textarea rows="10" cols="50" id="textarea" name="text" title="Ide ird" class="textArea">be: Első,Második,Harmadik&#13;ciklus amíg Első&lt;Második &#13; Első++&#13;ciklus vége &#13;ciklus i = 0..10&#13; Második++&#13;ciklus vége&#13;tömb:=1,3,4,5,61&#13;ha Második=Első&#13; Első=10&#13;ha különben Második=Harmadik &#13; Első=1&#13;különben&#13;Harmadik=0&#13;elágazás vége&#13;szöveg:=Első szöveges változóm</textarea><br>
        
        <?php
        }
        ?>
        
        
        
        <div class="overlay"></div>
        <div id="modal" class="modal"  >
          <label for="cim">Cím:</label>
          <input type="text" name="cim"><br>
          <label for="leiras">Leírás:</label>
          <input type="text" name="leiras" class="leiras"><br>
          
          <input type="submit" name="mentes" value="Mentés" style="
          margin-top: 25px;
          color:green;
          ">
          <input type="button" class="closeBtn" name="megse" value="Mégse"style="
          margin-top: 25px;
          color:red;
          ">
        </form>
       
				</div>

        
        </form>
    </div>
    <div class="col-xs-6" style="padding-left: 80px" >
        <h2>JavaScript kód</h2>
        <a href="" id='futtat' style="display: none;">Futtat</a>
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
  
    <script src="js/atalakit.js"></script>
    <script src="js/futtat.js"></script>
    <script src="js/autoresize.js"></script>
    <script type="text/javascript">
  $('textarea').autoResize();
  $(".btn").on("click",function(){
    $('.menu').toggleClass("show");
  });
  a=document.getElementById("textarea").innerHTML;
  if(a!==""){
    document.getElementById("textarea").focus();
    document.createEvent('KeyboardEvent')
    let keyupEvent = new Event('keyup');
    document.getElementById("textarea").dispatchEvent(keyupEvent)
  }

</script>
</body>
</html>