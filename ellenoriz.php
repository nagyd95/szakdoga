<?php
@ $kapcsolat = new mysqli("localhost","root","","szakdoga");
$kapcsolat->query("SET NAMES 'utf8_hungarian_ci'");
foreach($_GET as $key=>$value)
{
    $$key=$kapcsolat->real_escape_string($value); 
}
header('Content-Type: text/html; charset=utf-8'); 

if(!isset($nev))
{
    $nev =trim(''); 
}
if($nev == '') 
{
	echo '</br>';
    return '';
}
if(strlen($nev) <4) 
{
    echo '<font style="color:red"><b>Túl rövid a név...</b></font>';
    return "rovid";
}
$sql = "SELECT user_name FROM user WHERE user_name='$nev'";
$eredmeny = $kapcsolat->query($sql);
if ($eredmeny->num_rows>0)
{
    echo '<font style="color:red"><b>Ez a név már foglalt!</b></font>';
    return "foglalt";
}
else
{
    echo '<font style="color:green"><b>A felhasználónév megfelelő.</b></font>';
    return "jo";
}

$kapcsolat->close();

?>