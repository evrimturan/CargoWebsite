<?php
require 'connectdb.php';
$username = $_POST["name"];
$password = sha1($_POST["psw"]);
$firstname = $_POST["fname"];
$middlename = $_POST["midName"];
$lastname = $_POST["lastName"];
$country = $_POST["country"];
$city = $_POST["city"];
$district = $_POST["district"];
$street = $_POST["street"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$contract = $_POST["contract"];
if($contract == on)
{
  $contract = "X";
}
else
{
    $contract = "-";
}
$sql_check_username_cust = "SELECT userName FROM customer WHERE userName='".$username."'";
$sql_check_username_emp = "SELECT userName FROM employee WHERE userName='".$username."'";
$res1 = $con->query($sql_check_username_cust);
$res2 = $con->query($sql_check_username_emp);
if($res1->num_rows > 0){
  $answer = "false";
  header("Location: register.php?complete=".$answer."&firstname=".$_GET["firstname"]);
  echo mysql_errno();
  die("error");
}else if($res2->num_rows > 0){
  $answer = "false";
  header("Location: register.php?complete=".$answer."&firstname=".$_GET["firstname"]);
  echo mysql_errno();
  die("error");
}
$find_recent = $con->query("SELECT max(ID) AS ID_max FROM customer;");
$res11 = mysqli_fetch_assoc($find_recent);
$maximum = $res11["ID_max"];
$maximum = $maximum + 1;
$sql_customer = "INSERT INTO customer (`userName`,`password`,`fName`,`midName`,`lastName`,`country`,`city`,`district`,`street`,`phone`,`email`,`contract`,`ID`)
VALUES('$username','$password','$firstname','$middlename','$lastname','$country','$city','$district','$street','$phone','$email','$contract','$maximum');";
if(mysqli_query($con,$sql_customer)){
  //echo "Query complete";
  $answer = "true";
  header("Location: register.php?complete=".$answer."&firstname=".$_GET["firstname"]);
}else{
  $answer = "false";
  header("Location: register.php?complete=".$answer."&firstname=".$_GET["firstname"]);
}
?>
