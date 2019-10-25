<?php
error_reporting(E_ALL & ~E_NOTICE);
session_start();
$bentVan=$_SESSION['user_name'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" crossorigin="anonymous"> 
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <title>Szakdoga</title>
  <link rel="stylesheet" href="css/index.css">
  
</head>
<body>
  <?php
   
    if(empty($bentVan)){
    print("ures");
    }
    else{
      print("hello ".$asd);
      print('<form action="" method="POST" class="">'. 
      '<input type="submit" value="Kilép" name="kilep">'.
      '</form>');
    }
    if(isset($_POST['kilep'])){
      session_destroy();
      header("location:index.php");
    }
  
?>
<div class="navbar">
<div class="logo">
<h1>PszeudoKód Világa</h1>
</div>
<a class="btn">
  <span></span>
  <span></span>
  <span></span>
</a>
<?php
   
    if(empty($bentVan)){
    print('<div class="menu">'.
    '<a href="login.php">Bejelentkezes</a>'.
    '<a href="signup.php">Regisztráció</a>'.
  '</div>');
    }
    else{
      print("hello ".$bentVan);
      print('<form action="" method="POST" class="">'. 
      '<input type="submit" value="Kilép" name="kilep">'.
      '</form>');
    }
    if(isset($_POST['kilep'])){
      session_destroy();
      header("location:index.php");
    }
  
?>

</div>
<div class="header">
    
<p>Resize this responsive page to see the effect!</p>
</div>
  <!-- <div class="jumbotron text-center">
      <h1>PszeudoKód világa</h1>
      <p>Resize this responsive page to see the effect!</p> 
  </div> -->
  <div class="container">
    <div class="row">
      <div class="col-xs-4" style="margin:inherit">
        <h3>Pszeudokód</h3>
        <textarea rows="10" cols="70" id="textarea" title="Ide ird" class="textArea">be: A,B,C&#13;ciklus amíg A&lt;B &#13; A++&#13;ciklus vége &#13;ciklus nein = 0..10&#13; B++&#13;ciklus vége&#13;tombicsekelftars:=1,3,4,5,61&#13;ha B=A&#13; A=10&#13;ha különben B=C &#13; A=1&#13;különben&#13;A=0&#13;elágazás vége&#13;szoveg:=Hello World</textarea><br>
        <input type="submit" value="Átalakit" id='ok'>
        <input type="submit" value="Futtat" id='futtat'>
        <form action="" method="POST" class="form-reg">
        
        </form>
    </div>
    <div class="col-xs-6" style="padding-left: 40px" >
        <h3>JavaScript kód</h3>
        
        <p id="valtozok"></p>
        <p id="valtozokBe"></p>
        <p id="eredmeny"></p>
        
      </div>
      <div id="col-sx-4">
        <p id="futtatas" style="padding-left: 40px"></p>
      </div>
  </div>
  
  
 
</textarea> 



  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> 
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
    <script src="app.js"></script>
    <script type="text/javascript">

$(".btn").on("click",function(){
  $('.menu').toggleClass("show");
});


</script>
  
    
</body>
</html>