<?php
require 'connectdb.php';
$name = $_POST['name'];
$pass = sha1($_POST['psw']);
$name = mysqli_real_escape_string($con,$name);
$sql = "SELECT userName,password,fName FROM employee WHERE userName = '$name' AND password = '$pass';";
$sql2 = "SELECT userName,password,fName FROM customer WHERE userName = '$name' AND password = '$pass';";
if(mysqli_query($con,$sql)){
  $result = $con->query($sql);
  if ($result->num_rows > 0) {
    $row = mysqli_fetch_assoc($result);
    header('Location: home_employee.php?firstname='.$row["userName"]);
  } else {
    $result2 = $con->query($sql2);
    if($result2->num_rows > 0)
    {
      $row2 = mysqli_fetch_assoc($result2);
      header('Location: home_customer.php?firstname='.$row2["userName"]);
    }
    else
    {
      header("Location: index.php?login=failed");
      die();
    }
  }
}
else {
  header("Location: index.php?query=failed");
  die();
}
?>
