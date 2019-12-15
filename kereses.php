<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];
include('php/rating.php');

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
				    <a href="kodjaim.php"> Kódjaim </a>
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
<div class="keres">
<form method="POST" action="">

<?php

if (isset($_POST["keres"]) ){
  echo'Mit keres: <input type="text" name="ker" id="ker" value='. $_POST["ker"].' ><br>';
}elseif(isset($_GET["k"])){
  echo'Mit keres: <input type="text" name="ker" id="ker" value='. $_GET["k"].' ><br>';
}else{
  echo'Mit keres: <input type="text" name="ker" id="ker" ><br>';
}
?>
<label class="container">Cimben
<input type="radio" name="keresRadio" value="cim" checked>
  <span class="checkmark"></span>
</label>
<label class="container">Cimben és leirásban
<input type="radio" name="keresRadio" value="leirasban">
  <span class="checkmark"></span>
</label>
<!-- <input type="radio" name="keresRadio" value="cim" checked>Cimben -->
<!-- <input type="radio" name="keresRadio" value="leirasban"><br> -->
<input type="submit" name="keres" id="kereses" value="Keresés">
</form>
</div>
<div class="kodjaim">

<hr >
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
    $sql="select id,name,kod,user_id,leiras FROM code where name like '%$mit%' order by id DESC limit $offset, $limit;";
  }else{
    $sql="select id,name,kod,user_id,leiras FROM code where name like '%$mit%' or leiras like '%$mit%' order by id DESC limit $offset, $limit;";
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

  $sql="select id,name,kod,user_id,leiras FROM code order by id DESC limit $offset, $limit;";
  
  $result=mysqli_query($adatbazis,$sql);
}
if ($adatbazis->connect_error) {
  die("Connection failed: " . $adatbazis->connect_error);
}else{

  if(mysqli_num_rows($result)>0)		{
    while ($row = $result->fetch_assoc()) {
      $hossz=strlen($row["leiras"]);
      $ids=$row['user_id'];
        $sql="SELECT user_name from user where ID=$ids";
        $res=mysqli_query($adatbazis,$sql);
        $r = $res->fetch_assoc();
      print('<div class="felsorol">');
      $id=$row['id'];
      $name=$row['name'];
      $leiras=$row['leiras'];
      if($hossz>100){
        $leiras = substr($leiras, 0,100) . '...';
      }
      
      print('Cím: <b><a href=atalakit.php?id='.$id.'>'.$name.'</a></b></br>');
        print('Leírás: <b>'.$leiras.'</b></br>');
        print('Feltöltő: <b>'.$r['user_name'].'</b></br>');
      print('</div>');
      print('<div class="likeolos">');
      if(!empty($bentVan)){
      ?>
      <i <?php if (userLiked($row['id'],$row['user_id'])): ?>
      		  class="fa fa-thumbs-up like-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-up like-btn"
          <?php endif ?>
            data-id="<?php echo $row['id']; ?>"></i>
          <span class="likes"><?php echo getLikes($row['id']); ?></span>

      <i <?php if (userDisLiked($id,$row['user_id'])): ?>
      		  class="fa fa-thumbs-down dislike-btn"
      	  <?php else: ?>
      		  class="fa fa-thumbs-o-down dislike-btn"
      	  <?php endif ?>
            data-id="<?php echo $row['id']; ?>"></i>
            <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
      <?php
      }else{
        ?>
        
        <i class="fa fa-thumbs-o-up" data-id="<?php echo $row['id']; ?>"></i>
        <span class="likes"><?php echo getLikes($row['id']); ?></span>

        <i class="fa fa-thumbs-o-down "
        data-id="<?php echo $row['id']; ?>"></i>
        <span class="dislikes"><?php echo getDislikes($row['id']); ?></span>
        <?php
      }
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
        print "<a href='?page=".($page-1)."'>Előző</a>   ";
      }
      if ($page < $maxpage)
      {
        print "<a href='?page=".($page+1)."'>Következő</a>";
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