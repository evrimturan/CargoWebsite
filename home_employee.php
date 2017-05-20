<?php
if(empty($_GET["firstname"])){
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
  <title>Employee</title>
  <br>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Employee Page</h1></strong>
  <hr style="border-top:1px solid #000";></hr>
  <br>
  <div class ="w3-row">
    <div class = "w3-col m4 l2">
      <hr style="border-top:1px solid #000";>
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "register.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Register</button>
      </form>
      <form action = "profile_employee.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Profile Info</button>
      </form>
      <form action = "emp_change_password.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Change Password</button>
      </form>
      <br>
      <hr style="border-top:1px solid #000";> Advanced Queries</hr>
      <form action = "Q1.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query1</button>
      </form>
      <form action = "Q2.1.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query2.1</button>
      </form>
      <form action = "Q2.2.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query2.2</button>
      </form>
      <form action = "Q3.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query3</button>
      </form>
      <form action = "Q4.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query4</button>
      </form>
      <form action = "Q5.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query5</button>
      </form>
      <form action = "Q6.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query6</button>
      </form>
      <form action = "Q7.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query7</button>
      </form>
      <form action = "Q8.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query8</button>
      </form>
      <form action = "Q9.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Query9</button>
      </form>
      <br>
      <hr style="border-top:1px solid #000";>
    </div>
    <div class ="w3-col m8 l10">
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="border-top:1px solid #000;"> Welcome <?php echo $_GET["firstname"]."   -   "; echo "Today is " . date("Y/m/d") . "<br>"; ?></p></strong>
        <div style="border-top:1px solid #000;height:800px;">
          <form action = "bill.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
            <button class="mystyle2" style="top:5px;" type="submit">Bill a customer</button>
          </form>
          <form action = "store.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
            <button class="mystyle2" style="top:5px;" type="submit">See Store Transactions</button>
          </form>
          <form action = "package.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
            <button class="mystyle2" style="top:5px;" type="submit">Create a Package</button>
          </form>
          <form action = "delivered.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
            <select name="track_num">
              <option value="NULL"> --- </option>
              <?php
              require "connectdb.php";
              $res = $con->query("SELECT DISTINCT trackingNum FROM include,(SELECT   type,      content,  weight,
                                  package.packageID AS ID
                                  FROM package,  (SELECT packageID FROM destination,(SELECT sid FROM works WHERE userName ='".$_GET["firstname"]."') AS myTable
                                    WHERE myTable.sid = destination.sid) AS myTable2
                                    WHERE myTable2.packageID = package.packageID) AS mytable3 WHERE mytable3.ID = include.packageID");
              while($row1 = mysqli_fetch_assoc($res)){
                  echo "<option value='".$row1["trackingNum"]."'>"."Tracking Number: ".$row1["trackingNum"]."</option>";
              }
              ?>
            </select>
            <button class="mystyle2" style="top:5px;" type="submit">Mark As Delivered</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  </div>
</body>
</html>
