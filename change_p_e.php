<?php
require "connectdb.php";
$old = sha1($_POST["old_pass"]);
$new = sha1($_POST["new_pass"]);
$new_again = sha1($_POST["new_pass_again"]);

if($new != $new_again){
  header("Location: emp_change_password.php?firstname=".$_GET["firstname"]."&error=notequal");
  die("Error");
}
$sql_check_pass = "SELECT userName,password FROM employee WHERE userName ='".$_GET["firstname"]."' AND password='".$old."';";
$res = $con->query($sql_check_pass);
$row = mysqli_fetch_assoc($res);
$sql_update_password = "UPDATE `employee` SET `password`='$new' WHERE `userName`='".$row["userName"]."';";
echo "";
//header("Location: emp_change_password.php?firstname=".$_GET["firstname"]);
if(mysqli_query($con,$sql_update_password)){
  header("Location: emp_change_password.php?firstname=".$_GET["firstname"]."&error=NULL");
}else{
  header("Location: emp_change_password.php?firstname=".$_GET["firstname"]."&error=query");
  die("Error");
}
?>
