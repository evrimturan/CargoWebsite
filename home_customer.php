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
</style>
<body>
  <title>Customer</title>
  <br>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Customer Page</h1></strong>
  <hr style="border-top:1px solid #000";></hr>
  <br>
  <div class ="w3-row">
    <div class = "w3-col m4 l2">
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "status.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Status of a Shipment</button>
      </form>
      <form action = "profile_customer.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Profile Info</button>
      </form>
      <form action = "cust_change_password.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Change Password</button>
      </form>
      <form action = "package_customer.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Send A Package</button>
      </form>
    </div>
    <div class ="w3-col m8 l10">
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="border-top:1px solid #000;"> Welcome <?php echo $_GET["firstname"]."   -   "; echo "Today is " . date("Y/m/d") . "<br>"; ?></p></strong>
        <p>Package Count</p>
        <?php
        require "connectdb.php";
        $sql_query_again = "SELECT count(userName) AS NumOfSent FROM send WHERE userName = '".$_GET["firstname"]."'";
        $res = $con->query($sql_query_again);
        $row = mysqli_fetch_assoc($res);
        echo "You have sent ".$row["NumOfSent"]." packages.";
        ?>
        <form action = "bill_customer.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
          <br>
          <button class="mystyle2" type="submit">Receive a Bill</button>
        </form>
      </div>
      </div>
    </div>
  </div>
</body>
</html>
