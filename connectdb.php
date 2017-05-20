<?php
$host = "localhost";
$user = "group11";
$password = "1491484841458554584";
$dp = "group11";
$con = mysqli_connect($host,$user,$password,$dp);
if(!$con){
	die("Error". mysqli_connect_error());
}
?>
