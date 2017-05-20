<?php if(empty($_GET["firstname"])){
  header("Location: index.php");
  die();
}
 ?>
<html>
<link rel="stylesheet" href = "https://www.w3schools.com/w3css/4/w3.css">
<head>
  <!-- Chrome -->
  <link rel="icon" type="jpeg" href="flamethrower.jpg" sizes="16x16">

  <!-- Internet Explorer -->
  <link rel="icon" type="image/x-icon" href="flamethrower.jpg" >
</head>
<style>
body{
  background-color: lightblue;
}
button.mystyle{
  position: absolute;
  left:10px;
  border: 3px solid #8AC007;
}
button.mystyle2{
  position: relative;
  left:10px;
  border: 3px solid #8AC007;
}
table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
}
th, td {
    padding: 15px;
}

</style>
<body>
  <title>Bill</title>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Generated Bill</h1></strong>
  <hr style="border-top:1px solid #000";></hr>
  <div class ="w3-row">
    <div class = "w3-col m2 l1">
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "home_employee.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Home Page</button>
      </form>
    </div>
    <div class ="w3-col m10 l11">
      <div style="border-left:1px solid #000;height:1000px;">
        <strong><p style="border-top:1px solid #000;"></p></strong>
        <?php
        require "connectdb.php";
        $track_num = $_POST["ship_no"];
        $year = date("Y");
        $month = date("m");
        $num_day = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $dateofmonthend= "".$year."/".$month."/".$num_day;
        $dateofmonth = "".$year."/".$month."/"."01";
        $sql_contract_control = "SELECT contract,customer.userName AS user_name,fName,country,city,district,street,phone FROM customer,(SELECT userName from send,(SELECT min(packageID) as ID FROM include WHERE trackingNum = $track_num)AS mytable WHERE send.packageID = mytable.ID)AS mytable2 WHERE mytable2.userName = customer.userName;";
        $res_table = $con->query($sql_contract_control);
        $row_new = mysqli_fetch_assoc($res_table);
        $auser = $row_new["user_name"];
        $usrname = $row_new["fName"];
        $address_info = $row_new["country"]."--".$row_new["city"]."--".$row_new["district"]."--".$row_new["street"];
        $phone_num = $row_new["phone"];
        $total_cost = 0;
        if($row_new["contract"] == "X"){
          $i = 1;
          $sql_main = "SELECT shipment.trackingNum FROM shipment,(SELECT DISTINCT trackingNum FROM include,(SELECT packageID FROM send WHERE userName = '$auser') as mytable WHERE mytable.packageID = include.packageID) AS mytable2 WHERE mytable2.trackingNum = shipment.trackingNum AND dateOfShipment BETWEEN '$dateofmonth' AND '$dateofmonthend';";
          $main = $con->query($sql_main);
          echo "<table style=\"width:80%\">";
          echo "<tr>";
          echo "<th>"."Customer Name: "."<mark>".$usrname."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."Billing Date: ".date("Y/m/d")."</th>";
          echo "</tr>";
          echo "<tr>";
          echo "<th>"."Customer Address: "."<mark>".$address_info."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."Contracted Customer"."</th>";
          echo "</tr>";
          echo "<tr>";
          echo "<th>"."Customer Phone Number: "."<mark>".$phone_num."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "</tr>";
          echo "<th>";
          echo "<tr>";
          echo "<th>"."Item Number"."</th>";
          echo "<th>"."Tracking Number"."</th>";
          echo "<th>"."Number of packages"."</th>";
          echo "<th>"."Shipment Date"."</th>";
          echo "<th>"."Shipped From"."</th>";
          echo "<th>"."Price"."</th>";
          echo "</tr>";
          while($row_main = mysqli_fetch_assoc($main)){
            $temp_cost = 0;
            $will_be_added = $row_main["trackingNum"];
            $sql_shipped_from = "SELECT country,city,district FROM store,(SELECT sid FROM source,(SELECT min(packageID) as ID FROM include WHERE trackingNum = $will_be_added)AS mytable WHERE mytable.ID = source.packageID)AS mytable2 WHERE store.sid = mytable2.sid;";
            $sql_ship_date ="SELECT dateOfShipment FROM shipment WHERE trackingNum = $will_be_added;";
            $sql_packages_tracking_num ="SELECT count(include.packageID) AS PackageCount FROM include,(SELECT packageID FROM send WHERE userName = '$auser')AS mytable WHERE mytable.packageID = include.packageID AND include.trackingNum = $will_be_added";
            $sql_cost = "SELECT cost FROM package,(
              SELECT send.packageID FROM send,(
                SELECT packageID FROM include WHERE trackingNum = $will_be_added
              )AS mytable WHERE send.packageID = mytable.packageID AND userName = '$auser')AS mytable2 WHERE mytable2.packageID = package.packageID;";
            $from = $con->query($sql_shipped_from);
            $row_from = mysqli_fetch_assoc($from);
            $date = $con->query($sql_ship_date);
            $row_date = mysqli_fetch_assoc($date);
            $track_package_count = $con->query($sql_packages_tracking_num);
            $row_track = mysqli_fetch_assoc($track_package_count);
            $cost = $con->query($sql_cost);
            while($row_cost = mysqli_fetch_assoc($cost)){
              $temp_cost = $temp_cost + $row_cost["cost"];
            }
            $addr_from = "".$row_from["district"].",".$row_from["city"].",".$row_from["country"]."";
            echo "<tr>";
            echo "<th>".$i."</th>";
            echo "<th>".$will_be_added."</th>";
            echo "<th>".$row_track["PackageCount"]."</th>";
            echo "<th>".$row_date["dateOfShipment"]."</th>";
            echo "<th>".$addr_from."</th>";
            echo "<th>".$temp_cost." TL"."</th>";
            echo "</tr>";
            $i = $i + 1;
            $total_cost = $total_cost + $temp_cost;
          }
          echo "<tr>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."<strong>"."Total"."</strong>"."</th>";
          echo "<th>";
          echo "<th>"."<mark>".$total_cost." TL"."</mark>"."</th>";
          echo "</tr>";
          echo "</table>";
        }else if($row_new["contract"] == "-"){
          $i = 1;
          echo "<table style=\"width:80%\">";
          echo "<tr>";
          echo "<th>"."Customer Name: "."<mark>".$usrname."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."Billing Date: ".date("Y/m/d")."</th>";
          echo "</tr>";
          echo "<tr>";
          echo "<th>"."Customer Address: "."<mark>".$address_info."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."No contract Available"."</th>";
          echo "</tr>";
          echo "<tr>";
          echo "<th>"."Customer Phone Number: "."<mark>".$phone_num."</mark>"."</th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "</tr>";
          echo "<th>";
          echo "<tr>";
          echo "<th>"."Item Number"."</th>";
          echo "<th>"."Tracking Number"."</th>";
          echo "<th>"."Number of packages"."</th>";
          echo "<th>"."Shipment Date"."</th>";
          echo "<th>"."Shipped From"."</th>";
          echo "<th>"."Price"."</th>";
          echo "</tr>";
          //$row_main = mysqli_fetch_assoc($main);
          $will_be_added = $_POST["ship_no"];
          $sql_shipped_from = "SELECT district,city,country FROM store,(SELECT sid FROM source,(SELECT min(include.packageID) AS ID FROM include,(SELECT packageID FROM send WHERE userName = '$auser')AS mytable WHERE trackingnum = $will_be_added AND include.packageID = mytable.packageID) AS mytable2 WHERE mytable2.ID = source.packageID)AS mytable3 WHERE mytable3.sid = store.sid;";
          $sql_ship_date ="SELECT dateOfShipment FROM shipment WHERE trackingNum = $will_be_added;";
          $sql_packages_tracking_num ="SELECT count(include.packageID) AS HowMany FROM include,(SELECT packageID FROM send WHERE userName = '$auser')AS mytable WHERE trackingnum = $will_be_added AND include.packageID = mytable.packageID;";
          $sql_cost = "SELECT sum(cost) AS Total FROM package,(SELECT include.packageID FROM include,(SELECT packageID FROM send WHERE userName = '$auser')AS mytable WHERE trackingnum = $will_be_added AND include.packageID = mytable.packageID)AS mytable2 WHERE mytable2.packageID = package.packageID;";
          $from = $con->query($sql_shipped_from);
          $row_from = mysqli_fetch_assoc($from);
          $date = $con->query($sql_ship_date);
          $row_date = mysqli_fetch_assoc($date);
          $track_package_count = $con->query($sql_packages_tracking_num);
          $row_track = mysqli_fetch_assoc($track_package_count);
          $cost = $con->query($sql_cost);
          $row_cost = mysqli_fetch_assoc($cost);
          $temp_cost =  $row_cost["Total"];
          $addr_from = "".$row_from["district"].",".$row_from["city"].",".$row_from["country"]."";
          echo "<tr>";
          echo "<th>".$i."</th>";
          echo "<th>".$will_be_added."</th>";
          echo "<th>".$row_track["HowMany"]."</th>";
          echo "<th>".$row_date["dateOfShipment"]."</th>";
          echo "<th>".$addr_from."</th>";
          echo "<th>".$temp_cost." TL"."</th>";
          echo "</tr>";
          $total_cost = $total_cost + $temp_cost;
          echo "<tr>";
          echo "<th>";
          echo "<th>";
          echo "<th>";
          echo "<th>"."<strong>"."Total"."</strong>"."</th>";
          echo "<th>";
          echo "<th>"."<mark>".$total_cost." TL"."</mark>"."</th>";
          echo "</tr>";
          echo "</table>";
        }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
