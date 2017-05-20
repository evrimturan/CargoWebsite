<?php
require "connectdb.php";
$tr_num_xD = $_POST["track_num"];

$res101 = $con->query("UPDATE `shipment` SET `activeTransaction`='-',`completeTransaction`='X' WHERE `trackingNum`='$tr_num_xD';");
header("Location: home_employee.php?firstname=".$_GET["firstname"]);
?>
