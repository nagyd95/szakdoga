<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];
include('phpcodes/rating.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css"> 
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

  <title>Szakdoga</title>
  <link rel="stylesheet" type="text/css" href="css/index.css">
  <link rel="stylesheet" type="text/css" href="css/kereses.css">
  <script type="text/javascript">


</script>
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
				    <a href="kodjaim.php"> Kódjaim </a>
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
<form method="POST" action="">
<?php
if (isset($_POST["keres"]) ){
  echo'<input type="text" name="ker" id="ker" value='. $_POST["ker"].' ><br>';
}elseif(isset($_GET["k"])){
  echo'<input type="text" name="ker" id="ker" value='. $_GET["k"].' ><br>';
}else{
  echo'<input type="text" name="ker" id="ker" ><br>';
}
?>
<input type="radio" name="keresRadio" value="cim">Cimben
<input type="radio" name="keresRadio" value="leirasban">Cimben és leirásban<br>
<input type="submit" name="keres" value="Keres"> 
</form>

<div class="kodjaim">


<?php
$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
$adatbazis->query("SET NAMES 'utf8'");
$adatbazis->query("SET CHARACTER SET UTF8");

if (isset($_POST["keres"])){
  $limit=6;
  $hol=$_POST['keresRadio'];
  if(isset($_GET['k'])){
    $mit=$_GET['k'];
  }else{
   $mit=$_POST['ker'];
  }
  if($hol =="cim"){
    $sql="select count(id) FROM code where name like '%$mit%' order by id DESC ;";
    $c = (mysqli_fetch_row(mysqli_query($adatbazis,$sql)));
  }else{
    $sql="select count(id) FROM code where name like '%$mit%' or leiras like '%$mit%'  order by id DESC ;";
    $c = (mysqli_fetch_row(mysqli_query($adatbazis,$sql)));
  }
  
  $c=$c[0];
  $maxpage = ceil($c / $limit); 
  $page = isset($_GET['page']) ? abs((int)$_GET['page']) : 1;
  $offset = ($page-1) * $limit;
  if($hol =="cim"){
    $sql="select id,name,kod,user_id FROM code where name like '%$mit%' order by id DESC limit $offset, $limit;";
  }else{
    $sql="select id,name,kod,user_id FROM code where name like '%$mit%' or leiras like '%$mit%' order by id DESC limit $offset, $limit;";
  }
  $result=mysqli_query($adatbazis,$sql);
  
}else{
  $limit=6;
  $sql="select count(id) FROM code order by id DESC ;";
  $c = (mysqli_fetch_row(mysqli_query($adatbazis,$sql)));
  $c=$c[0];
  $maxpage = ceil($c / $limit); 
  $page = isset($_GET['page']) ? abs((int)$_GET['page']) : 1;
  $offset = ($page-1) * $limit;

  $sql="select id,name,kod,user_id FROM code order by id DESC limit $offset, $limit;";
  
  $result=mysqli_query($adatbazis,$sql);
}
if ($adatbazis->connect_error) {
  die("Connection failed: " . $adatbazis->connect_error);
}else{

  if(mysqli_num_rows($result)>0)		{
    while ($row = $result->fetch_assoc()) {
      $hossz=strlen($row["kod"]);
      
      print('<div class="felsorol">');
      $id=$row['id'];
      $name=$row['name'];
      $kod=$row['kod'];
      $leiras = substr($kod, 0,100) . '...';
      print('<b><a href=atalakit.php?id='.$id.'>'.$name.'</a></b></br>');
      print('<b>'.$leiras.'</b></br>');
      print('</div>');
      print('<div class="likeolos">');
      ?>
      <i <?php if (userLiked($row['id'],$row['user_id'])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
      	  <?php endif ?>
            data-id="<?php echo $row['id']; ?>"></i>
          <span class="likes"><?php echo getLikes($row['id']); ?></span>

      <i <?php if (userDisLiked($row['id'],$row['user_id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
            data-id="<?php echo $row['id']; ?>"></i>
            <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
      <?php
      print('</div>');
      print('<br>');
    }
    print("<div class=\"lapozas\">");
      if ($maxpage  < $page)
      {
        $linkoffset = $maxpage - $linklimit;
        if ($linkoffset < 0)
        {
          $linkoffset = 0;
        }
        $linkend = $maxpage;
      }				 
      if ($page > 1)
      {
        print "<a href='?page=".($page-1)."&k=".$mit."'>Előző</a>   ";
      }
      if ($page < $maxpage)
      {
        print "<a href='?page=".($page+1)."&k=".$mit."'>Következő</a>";
      }
      print("</div>");

  }else{
    echo'Még nincs kód elmentve az oldalon.';
  }
  
}



?>
</div>

<script type="text/javascript">
$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});
</script>
<script src="js/rating.js"></script>


    
</body>
</html>