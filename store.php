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
  <title>Store Transactions</title>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Store Page</h1></strong>
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
    <div class ="w3-col m2 l11">
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="left 15px ;border-top:1px solid #000;">Store Transactions -
          <?php
            require "connectdb.php";
            $sql_store = "SELECT sid FROM works WHERE userName ='".$_GET["firstname"]."'";
            $res = $con->query($sql_store);
            $row = mysqli_fetch_assoc($res);
            echo "Store ID is: ".$row["sid"];
          ?>
      </p>
     </strong>
        <strong><p> Outgoing Packages </p></strong>
        <?php
          require "connectdb.php";
          $sql_name_worker = "SELECT
                            type,
                            content,
                            weight,
                            package.packageID AS ID
                            FROM package,  (SELECT packageID FROM source,(SELECT sid FROM works WHERE userName ='".$_GET["firstname"]."') AS myTable
                              WHERE myTable.sid = source.sid) AS myTable2
                              WHERE myTable2.packageID = package.packageID";
          if(mysqli_query($con,$sql_name_worker)){
            $res = $con->query($sql_name_worker);
            if($res->num_rows > 0){
              while($row = mysqli_fetch_assoc($res))
              {
                echo "<p>"."Package ID : ".$row["ID"]."<br>"."Type: " . $row["type"]. "<br>". "Content: " . $row["content"]."<br>". "Weight: " . $row["weight"]. "</p>";
              }
            }
          }else{
            echo "<p>Error getting the data from the database"."</p>";
          }
        ?>
        <hr></hr>
        <strong><p> Incoming Packages </p></strong>
        <?php
          require "connectdb.php";
          $sql_name_worker = "SELECT
                            type,
                            content,
                            weight,
                            package.packageID AS ID
                            FROM package,  (SELECT packageID FROM destination,(SELECT sid FROM works WHERE userName ='".$_GET["firstname"]."') AS myTable
                              WHERE myTable.sid = destination.sid) AS myTable2
                              WHERE myTable2.packageID = package.packageID";
          if(mysqli_query($con,$sql_name_worker)){
            $res = $con->query($sql_name_worker);
            if($res->num_rows > 0){
              while($row = mysqli_fetch_assoc($res))
              {
                echo "<p>"."Package ID : ".$row["ID"]."<br>"."Type: " . $row["type"]. "<br>". "Content: " . $row["content"]."<br>". "Weight: " . $row["weight"]. "</p>";
              }
            }
          }else{
            echo "<p>Error getting the data from the database"."</p>";
          }
        ?>
      </div>
    </div>
  </div>
</body>
</html>
