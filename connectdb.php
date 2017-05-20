<?php
$host = "localhost";
$user = "**********";
$password = "**************";
$dp = "**********";
$con = mysqli_connect($host,$user,$password,$dp);
if(!$con){
	die("Error". mysqli_connect_error());
}
?>
