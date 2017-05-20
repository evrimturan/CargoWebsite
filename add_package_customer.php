<?php
//echo "<p>"."Cost is :".$cost."</p>";
//echo "<p>"."Package type is :".$package_type."</p>";
$mult_choice = $_POST["multi"];
require "connectdb.php";
if($mult_choice== on){
  $sql_receiver_name = "SELECT receiver_name FROM shipment WHERE trackingNum = (SELECT max(trackingNum) as Track_max  FROM shipment)";
  $sql_ship_details = "SELECT shipDetails FROM shipment WHERE trackingNum = (SELECT max(trackingNum) as Track_max  FROM shipment)";
  $sql_timeliness = "SELECT timeliness FROM package WHERE packageID = (SELECT max(packageID) as Pid_max  FROM package)";
  $sql_store_dest = "SELECT sid FROM destination WHERE packageID = (SELECT max(packageID) as Pid_max FROM package)";
  $sql_store_src = "SELECT sid FROM source WHERE packageID = (SELECT max(packageID) as Pid_max FROM package)";
  $res01 = $con->query($sql_receiver_name);
  $test_row1 = mysqli_fetch_assoc($res01);
  $res02 = $con->query($sql_ship_details);
  $test_row2 = mysqli_fetch_assoc($res02);
  $res03 = $con->query($sql_timeliness);
  $test_row3 = mysqli_fetch_assoc($res03);
  $res04 = $con->query($sql_store_dest);
  $test_row4= mysqli_fetch_assoc($res04);
  $res05 = $con->query($sql_store_src);
  $test_row5= mysqli_fetch_assoc($res05);

  $from_store = $test_row5["sid"];
  $addr = $test_row4["sid"];
  $info = $test_row2["shipDetails"];
  $content = $_POST["content"];//
  $weight = $_POST["weight"];//
  $timeliness = $test_row3["timeliness"];
  $receiver = $test_row1["receiver_name"];

  $cost = 0.00;
  $package_type = "";
  if($addr == $from_store){
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=samestore");
    die("Error!");
  }
  if($weight <= 0){
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=weight_error");
    die("Error!");
  }
  if($weight <= 1){
    $cost = $cost + 1;
    $package_type = "Flat";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 5)){
    $cost = $cost + 5;
    $package_type = "Small box";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 7)){
    $cost = $cost + 10;
    $package_type = "Mid-sized box";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 10)){
    //echo "<p>"."entered here"."</p>";
    $cost = $cost + 20;
    $package_type = "Large box";
  }else if($weight > 10){
    $cost = $cost + 20 + ($weight - 10);
    $package_type = "Large box";
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=weight_error");
    die("Error!");
  }
  if($timeliness == "Overnight"){
    $cost = $cost + 25;
  }else if($timeliness == "2-Day"){
    $cost = $cost + 10;
  }else if ($timeliness == "7-Day"){
    $cost = $cost + 0;
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=NULL_return_time");
    die("Error!");
  }
  if($content == "normal"){
    $cost = $cost + 0;
    $content = "normal";
  }else if($content == "hazardous"){
    $cost = $cost + 10;
    $content = "hazardous";
  }else if($content == "inter"){
    $cost = $cost + 10*$cost/100;
    $content = "international";
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=NULL_return_type");
    die("Error!");
  }
  $sql_package = "INSERT INTO package (`type`,`content`,`weight`,`timeliness`,`cost`) VALUES ('$package_type','$content','$weight','$timeliness','$cost');";
  $cur_time = date("Y/m/d");
  $today_time = new DateTime(date("Y/m/d"));
  if($timeliness == "Overnight"){
    $today_time->modify('+1 day');
    $ship_date = $today_time->format("Y/m/d");
  }else if($timeliness == "2-Day"){
    $today_time->modify('+2 day');
    $ship_date = $today_time->format("Y/m/d");
  }else if ($timeliness == "7-Day"){
    $today_time->modify('+7 day');
    $ship_date = $today_time->format("Y/m/d");
  }
  if(mysqli_query($con,$sql_package)){
      $table_packID = $con->query("SELECT MAX(packageID) AS NewPackage FROM package");
      $table_ship_num = $con->query("SELECT MAX(trackingNum) AS NewEntry FROM shipment;");
      $row1 = mysqli_fetch_assoc($table_packID);
      $row2 = mysqli_fetch_assoc($table_ship_num);
      $temp_pack = $row1["NewPackage"];
      $temp_shipment = $row2["NewEntry"];
      $sql_include = "INSERT INTO `include` (`packageID`,`trackingNum`) VALUES ('$temp_pack','$temp_shipment')";
      $sql_user_insert = "INSERT INTO send VALUES('$temp_pack','".$_GET["firstname"]."')";
      $sql_source = "INSERT INTO source (`sid`,`packageID`) VALUES ('".$from_store."','$temp_pack')";
      $src_id = substr($addr,0,5);
      $sql_destination = "INSERT INTO `destination` (`sid`,`packageID`) VALUES ('$src_id','$temp_pack')";
      if(mysqli_query($con,$sql_include)){
        if(mysqli_query($con,$sql_user_insert)){
          if(mysqli_query($con,$sql_source)){
            if(mysqli_query($con,$sql_destination)){
              header("Location: package_customer.php?tracknum=$temp_shipment"."&result=true"."&firstname=".$_GET["firstname"]);
            }else{
              header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
              die("error on destination relation query");
            }
          }else{
            header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
            die("error on send source query");
          }
        }else{
          header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
          die("error on send relation query");
        }
      }else{
        header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
        die("error on include relation query");
      }
  }else{
    header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
    die("error on package query");
  }
}else{
  $from_store = $_POST["from"];
  $addr = $_POST["address"];
  $info = $_POST["info"];
  $content = $_POST["content"];
  $weight = $_POST["weight"];
  $timeliness = $_POST["timeliness"];
  $receiver = $_POST["name_receiver"];
  $cost = 0.00;
  $package_type = "";
  if($addr == $from_store){
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=samestore");
    die("Error!");
  }
  if($weight <= 0){
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=weight_error");
    die("Error!");
  }
  if($weight <= 1){
    $cost = $cost + 1;
    $package_type = "Flat";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 5)){
    $cost = $cost + 5;
    $package_type = "Small box";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 7)){
    $cost = $cost + 10;
    $package_type = "Mid-sized box";
    //echo "<p>"."entered here"."</p>";
  }else if(($weight <= 10)){
    //echo "<p>"."entered here"."</p>";
    $cost = $cost + 20;
    $package_type = "Large box";
  }else if($weight > 10){
    $cost = $cost + 20 + ($weight - 10);
    $package_type = "Large box";
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=weight_error");
    die("Error!");
  }
  if($timeliness == "overnight"){
    $cost = $cost + 25;
    $timeliness = "Overnight";
  }else if($timeliness == "day2"){
    $cost = $cost + 10;
    $timeliness = "2-Day";
  }else if ($timeliness == "day7"){
    $cost = $cost + 0;
    $timeliness = "7-Day";
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=NULL_return_time");
    die("Error!");
  }
  if($content == "normal"){
    $cost = $cost + 0;
    $content = "normal";
  }else if($content == "hazardous"){
    $cost = $cost + 10;
    $content = "hazardous";
  }else if($content == "inter"){
    $cost = $cost + 10*$cost/100;
    $content = "international";
  }else{
    header("Location:package_customer.php?firstname=".$_GET["firstname"]."&result=false"."&fail=NULL_return_type");
    die("Error!");
  }
  $sql_package = "INSERT INTO package (`type`,`content`,`weight`,`timeliness`,`cost`) VALUES ('$package_type','$content','$weight','$timeliness','$cost');";
  $cur_time = date("Y/m/d");
  $today_time = new DateTime(date("Y/m/d"));
  if($timeliness == "Overnight"){
    $today_time->modify('+1 day');
    $ship_date = $today_time->format("Y/m/d");
  }else if($timeliness == "2-Day"){
    $today_time->modify('+2 day');
    $ship_date = $today_time->format("Y/m/d");
  }else if ($timeliness == "7-Day"){
    $today_time->modify('+7 day');
    $ship_date = $today_time->format("Y/m/d");
  }
  $sql_shipment = "INSERT INTO `shipment` (`activeTransaction`,`completeTransaction`,`dateofShipment`,`estDateofArrival`,`shipDetails`,`receiver_name`) VALUES ('X','-','$cur_time','$ship_date','$info','$receiver');";
  if(mysqli_query($con,$sql_package)){
    if(mysqli_query($con,$sql_shipment)){
      $table_packID = $con->query("SELECT MAX(packageID) AS NewPackage FROM package");
      $table_ship_num = $con->query("SELECT MAX(trackingNum) AS NewEntry FROM shipment;");
      $row1 = mysqli_fetch_assoc($table_packID);
      $row2 = mysqli_fetch_assoc($table_ship_num);
      $temp_pack = $row1["NewPackage"];
      $temp_shipment = $row2["NewEntry"];
      $sql_include = "INSERT INTO `include` (`packageID`,`trackingNum`) VALUES ('$temp_pack','$temp_shipment')";
      $sql_user_insert = "INSERT INTO send VALUES('$temp_pack','".$_GET["firstname"]."')";
      if(!empty($from_store)){
        $sql_source = "INSERT INTO source (`sid`,`packageID`) VALUES ('".$from_store."','$temp_pack')";
        $src_id = substr($addr,0,5);
        $sql_destination = "INSERT INTO `destination` (`sid`,`packageID`) VALUES ('$src_id','$temp_pack')";
        if(mysqli_query($con,$sql_include)){
          if(mysqli_query($con,$sql_user_insert)){
            if(mysqli_query($con,$sql_source)){
              if(mysqli_query($con,$sql_destination)){
                header("Location: package_customer.php?tracknum=$temp_shipment"."&result=true"."&firstname=".$_GET["firstname"]);
              }else{
                header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
                die("error on destination relation query");
              }
            }else{
              header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
              die("error on send source query");
            }
          }else{
            header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
            die("error on send relation query");
          }
        }else{
          header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
          die("error on include relation query");
        }
      }else{
        $src_id = substr($addr,0,5);
        $sql_destination = "INSERT INTO `destination` (`sid`,`packageID`) VALUES ('$src_id','$temp_pack')";
        if(mysqli_query($con,$sql_include)){
          if(mysqli_query($con,$sql_user_insert)){
              if(mysqli_query($con,$sql_destination)){
                header("Location: package_customer.php?tracknum=$temp_shipment"."&result=true"."&firstname=".$_GET["firstname"]);
              }else{
                header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
                die("error on destination relation query");
              }
          }else{
            header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
            die("error on send relation query");
          }
        }else{
          header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
          die("error on include relation query");
        }
      }
    }else{
      header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
      die("error on shipment query");
    }
  }else{
    header("Location: package_customer.php?result=false"."&firstname=".$_GET["firstname"]);
    die("error on package query");
  }
}
?>
