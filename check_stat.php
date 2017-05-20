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
  <title>Status</title>
  <br>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Status of Shipment</h1></strong>
  <hr style="border-top:1px solid #000";></hr>
  <br>
  <div class ="w3-row">
    <div class = "w3-col m2 l1">
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "home_customer.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Home Page</button>
      </form>
    </div>
    <div class ="w3-col m10 l11">
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="left 15px ;border-top:1px solid #000;">Status of Shipment</p></strong>
        <?php
        require "connectdb.php";
        $trackingnumber = $_POST["ship_no"];
        $sql_query = "SELECT myTable2.packageID as ID,myTable2.completeTransaction as Complete,type,content,weight,timeliness,cost from package,(select completeTransaction,myTable.packageID from shipment,(select packageID,trackingNum from include where trackingNum=$trackingnumber) as myTable where myTable.trackingNum = shipment.trackingNum)as myTable2 where myTable2.packageID = package.packageID";
        $res = $con->query($sql_query);
        if($res->num_rows > 0){
          while($row = mysqli_fetch_assoc($res)){
            if($row["Complete"] == "X"){
              $complete = "Delivered.";
            }else{
              $complete = "Not Delivered.";
            }
            echo "<p>"."ID: ".$row["ID"]."<br>"."Status: ".$complete."<br>"."Type: ".$row["type"]."<br>"."Content: ".$row["content"]."<br>"."Weight: ".$row["weight"]."kg."."<br>"."Timeliness: ".$row["timeliness"]."<br>"."Cost: ".$row["cost"]." TL";
            echo "<br>";
          }
        }else{
          echo "<p> No Packages Found !"."</p>";
        }
        ?>
      </div>
    </div>
  </div>
</body
</html>
