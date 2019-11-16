<?php
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