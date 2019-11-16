<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
$user_id=$_SESSION['id'];

$adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
if ($adatbazis->connect_error) {
  die("Connection failed: " . $adatbazis->connect_error);
}

if (isset($_POST["action"])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['action'];
  
  switch ($action) {
    case 'like':
    if(userDisLiked($post_id,$user_id)){
      $sql="DELETE FROM rating WHERE user_id='$user_id' AND code_id='$post_id'";
      $result=mysqli_query($adatbazis,$sql);
    }
         $sql="INSERT INTO rating(id,user_id, code_id, rating_action) 
         	   VALUES (NULL,'$user_id', '$post_id', 'like')";
         break;
    case 'dislike':
    if(userLiked($post_id,$user_id)){
      $sql="DELETE FROM rating WHERE user_id='$user_id' AND code_id='$post_id'";
      $result=mysqli_query($adatbazis,$sql);
    }
    $sql="INSERT INTO rating(id,user_id, code_id, rating_action) 
         	   VALUES (NULL,'$user_id', '$post_id', 'dislike')";
         break;
  	case 'unlike':
	      $sql="DELETE FROM rating WHERE user_id='$user_id' AND code_id='$post_id'";
	      break;
  	case 'undislike':
    $sql="DELETE FROM rating WHERE user_id='$user_id' AND code_id='$post_id'";
      break;
  	default:
  		break;
  }
  $result=mysqli_query($adatbazis,$sql);
  echo getRating($post_id);
  
}
function getLikes($id)
{
  $adatbazis=new mysqli('localhost', 'root', '', 'szakdoga');
  $sql = "select count(code_id) from rating where code_id = '$id' and rating_action='like'";
  $rs = mysqli_query($adatbazis, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}
function getDisLikes($id)
{
  global $adatbazis;
  $sql = "select count(code_id) from rating where code_id = '$id' and rating_action='dislike'";
  $rs = mysqli_query($adatbazis, $sql);
  $result = mysqli_fetch_array($rs);
  return $result[0];
}

function userLiked($post_id,$id)
{
  global $adatbazis;
  echo $user_id;
  $sql = "select user_id from rating where user_id='$id' and code_id=$post_id and rating_action='like';";
  $result = mysqli_query($adatbazis, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}
function userDisLiked($post_id,$id)
{
  global $adatbazis;

  $sql = "SELECT * FROM rating WHERE user_id='$id' 
  		  AND code_id='$post_id' AND rating_action='dislike'";
  $result = mysqli_query($adatbazis, $sql);
  if (mysqli_num_rows($result) > 0) {
  	return true;
  }else{
  	return false;
  }
}
function getRating($id)
{
  global $adatbazis;
  $rating = array();
  $likes_query = "SELECT COUNT(code_id) FROM rating WHERE code_id = $id AND rating_action='like'";
  $dislikes_query = "SELECT COUNT(code_id) FROM rating WHERE code_id = $id AND rating_action='dislike'";
  $likes_rs = mysqli_query($adatbazis, $likes_query);
  $dislikes_rs = mysqli_query($adatbazis, $dislikes_query);
  $likes = mysqli_fetch_array($likes_rs);
  $dislikes = mysqli_fetch_array($dislikes_rs);
  $rating = [
  	'likes' => $likes[0],
  	'dislikes' => $dislikes[0]
  ];
  return json_encode($rating);
}




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
  $sql="select id,name,kod,user_id FROM code order by id DESC;";
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
<script src="rating.js"></script>

    
</body>
</html>