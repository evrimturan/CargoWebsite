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
  <title>Employee Profile</title>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Profile</h1></strong>
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
        <strong><p style="left 15px ;border-top:1px solid #000;">Profile of <?php echo $_GET["firstname"] ?></p></strong>
        <?php
          if($_GET["complete"] == "true"){
            echo "<p>"."<mark>"."Profile Succesfully Updated"."</mark>"."</p>";
          }else if($_GET["complete"] == "false"){
            echo "<p style=\"color:red;\">"."Profile Failed to Update"."</p>";
          }
        ?>
        <?php
        require "connectdb.php";
        $i = 2;
        $sql_user_info = "SELECT fName,midName,lastName,country,city,district,street,phone,email FROM employee WHERE userName ='".$_GET["firstname"]."';";
        $sql_get_phone = "SELECT phoneNumber FROM employee_phone WHERE userName='".$_GET["firstname"]."'";
        $res = $con->query($sql_user_info);
        $res2 = $con->query($sql_get_phone);
        //echo "<p>".$sql_user_info."</p>";
        if($row = mysqli_fetch_assoc($res)){
          echo "<p>"."First Name: "."<mark>".$row["fName"]."</mark>"."</p>";
          if(!($row["midName"] == "")){
            echo "<p>"."Middle Name: "."<mark>".$row["midName"]."</mark>"."</p>";
          }
          echo "<p>"."Last Name: "."<mark>".$row["lastName"]."</mark>"."</p>";
          echo "<p>"."Country: "."<mark>".$row["country"]."</mark>"."</p>";
          echo "<p>"."City: "."<mark>".$row["city"]."</mark>"."</p>";
          echo "<p>"."District: "."<mark>".$row["district"]."</mark>"."</p>";
          echo "<p>"."Street: "."<mark>".$row["street"]."</p>";
          echo "<p>"."Registered Primary Phone Number: "."<mark>".$row["phone"]."</p>";
          while($row_phone = mysqli_fetch_assoc($res2)){
            if($i == 1){
              echo "<p>"."Registered ".$i."st Phone Number: "."<mark>".$row_phone["phoneNumber"]."</mark>"."</p>";
            }else if($i == 2){
              echo "<p>"."Registered ".$i."nd Phone Number: "."<mark>".$row_phone["phoneNumber"]."</mark>"."</p>";
            }else if($i == 3){
              echo "<p>"."Registered ".$i."rd Phone Number: "."<mark>".$row_phone["phoneNumber"]."</mark>"."</p>";
            }else{
              echo "<p>"."Registered ".$i."th Phone Number: "."<mark>".$row_phone["phoneNumber"]."</mark>"."</p>";
            }
            $i = $i + 1;
          }
          echo "<p>"."E-mail: "."<mark>".$row["email"]."</mark>"."</p>";
        }else{
          echo "<strong>"."<p>"."There was an error on the database connection. Try again later!"."</p>"."</strong>";
        }
        ?>
        <div style="border-top:1px solid #000;height:1000px;">
          <strong><p>Update profile</p></strong>
          <form action = "update_employee.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
            First Name: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT fName from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["fName"]."\"";
             ?>
            name="fname" required>
            Middle Name: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT midName from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["midName"]."\"";
             ?>
            name="midName">
            Last Name: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT lastName from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["lastName"]."\"";
             ?>
            name="lastName" required>
            Country: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT country from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["country"]."\"";
             ?>
            name="country" required>
            City: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT city from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["city"]."\"";
             ?>
            name="city" required><br>
            District: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT district from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["district"]."\"";
             ?>
            name="district" required><br>
            Street: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT street from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["street"]."\"";
             ?>
            name="street" required><br>
            Primary Phone Number: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT phone from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["phone"]."\"";
             ?>
            name="phone" required><br>
            Email: <input type="text"
            <?php
            require "connectdb.php";
            $sql_name = "SELECT email from employee WHERE userName='".$_GET["firstname"]."'";
            $res = $con->query($sql_name);
            $row = mysqli_fetch_assoc($res);
            echo "value="."\"".$row["email"]."\"";
             ?>
            name="email" required><br>
            <br>
            <button class="mystyle2" type="submit">Update Profile</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
