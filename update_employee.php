<?php
require "connectdb.php";
$first = mysqli_real_escape_string($con,$_POST["fname"]);
$second = mysqli_real_escape_string($con,$_POST["midName"]);
$third = mysqli_real_escape_string($con,$_POST["lastName"]);
$country = mysqli_real_escape_string($con,$_POST["country"]);
$city = mysqli_real_escape_string($con,$_POST["city"]);
$district = mysqli_real_escape_string($con,$_POST["district"]);
$street = mysqli_real_escape_string($con,$_POST["street"]);
$phone = mysqli_real_escape_string($con,$_POST["phone"]);
$email = mysqli_real_escape_string($con,$_POST["email"]);
$sql_update = "UPDATE `employee`
SET `fName`='$first',`midName`='$second',`lastName`='$third',`country`='$country',`city`='$city',`district`='$district',`street`='$street',`phone`='$phone',`email`='$email'
WHERE `userName`='".$_GET["firstname"]."'";
if(mysqli_query($con,$sql_update)){
  header("Location: profile_employee.php?firstname=".$_GET["firstname"]."&complete=true");
}else{
  header("Location: profile_employee.php?firstname=".$_GET["firstname"]."&complete=false");
  die("Error on updating profile");
}
?>
