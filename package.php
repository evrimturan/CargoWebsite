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
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
  <script>
  $(document).ready(function() {
  //set initial state.

  $('#cb').change(function() {
      if(this.checked) {
        $('#receiver').hide();
        $('#time').hide();
        $('#send').hide();
        $('#store').hide();
        $('#inf').hide();
      }else{
        $('#receiver').show();
        $('#time').show();
        $('#send').show();
        $('#store').show();
        $('#inf').show();
      }
  });
});
  </script>
  <title>Create a Package</title>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Package Page</h1></strong>
  <hr style="border-top:1px solid #000";></hr>
  <div class ="w3-row">
    <div class = "w3-col m4 l2">
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "home_employee.php?firstname=<?php echo $_GET["firstname"] ?>" method = "post">
        <br>
        <button class="mystyle" type="submit">Home Page</button>
      </form>
    </div>
    <div class ="w3-col m8 l10">
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="left 15px ;border-top:1px solid #000;">Create a Package</p></strong>
        <?php
          if($_GET["result"] == "true"){
            echo "<strong>"."<p>Package Added Succesfully</p>"."</strong>";
            echo "<strong>"."<p>Tracking Num is : "."<mark>".$_GET["tracknum"]."</mark>"."</p>"."</strong>";
            echo "\n";
          }
          else if($_GET["result"] == "false"){
            echo "<strong>"."<p>Package could not be added !</p>"."</strong>";
            if($_GET["fail"] == "NULL_return_time"){
              echo "<p>"."<mark>"."Time is not selected."."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "NULL_return_type"){
              echo "<p>"."<mark>"."Type is not selected."."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "usernamenotsame"){
              echo "<p>"."<mark>"."Same user must send the packages if they are on the same shipment!"."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "weight_error"){
              echo "<p>"."<mark>"."Weight cannot be less than or equal to 0."."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "receivernamenotsame"){
              echo "<p>"."<mark>"."Receiver name must be same if they are on the same shipment!"."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "infonotsame"){
              echo "<p>"."<mark>"."Infos of the packages must be same if they are on the same shipment!"."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "timenotsame"){
              echo "<p>"."<mark>"."Delivery times of the packages must be same if they are on the same shipment!"."</mark>"."</p>"."\n";
            }
            if($_GET["fail"] == "storenotsame"){
              echo "<p>"."<mark>"."Destination stores must be same if they are on the same shipment!"."</mark>"."</p>"."\n";
            }
          }
        ?>
        <form action = "add_package.php?firstname=<?php echo $_GET["firstname"]?>" method = "post">
          <div id="receiver">Receiver Name
            <input type="text" name="name_receiver" id="receiver" <?php if(!($_GET["result"] == "true")){ echo "required";}?>>
          </div>
          Content: <select name="content">
            <option value="NULL">  --- </option>
            <option value="normal">    Normal   </option>
            <option value="inter">  International </option>
            <option value="hazardous">  Hazardous </option>
          </select>
          <br>
          Weight: <input type="number" step="0.01" name="weight" <?php if(!($_GET["result"] == "true")){ echo "required";}?>>
          <br>
          <div id="time">Timeliness
            <select name="timeliness" id ="time">
              <option value="NULL">  --- </option>
              <option value="overnight">    Overnight   </option>
              <option value="day2">  2-Day </option>
              <option value="day7">  7-Day </option>
            </select>
          </div>
          <div id="send">Sender
          <select name="sender" id="send">
            <option value="NULL"> --- </option>
            <?php
              require "connectdb.php";
              $res = $con->query("SELECT userName FROM customer");
              while($row1 = mysqli_fetch_assoc($res)){
                echo "<option value='".$row1["userName"]."'>".$row1["userName"]."</option>";
              }
            ?>
          </select>
        </div>
          <!-- Recieve Store:-->
          <div id="store">Receive Store
            <select name="address">
              <option value="NULL"> --- </option>
              <?php
                require "connectdb.php";
                $res = $con->query("SELECT sid,city,district FROM store");
                $get_store_id = $con->query("SELECT sid FROM works WHERE userName='".$_GET["firstname"]."'");
                $row2 = mysqli_fetch_assoc($get_store_id);
                while($row1 = mysqli_fetch_assoc($res)){
                  if(($row1["sid"] != $row2["sid"])){
                    echo "<option value='".$row1["sid"]."'>"."Store ID: ".$row1["sid"]." --"." City: ".$row1["city"]." --"." District: ".$row1["district"]."</option>";
                  }
                }
              ?>
            </select>
          </div>
          <div id="inf">Info
            <input id="inf" type="text" name="info">
          </div>
          <?php
          if($_GET["result"] == "true"){
            echo "Same Shipment ?: <input id=\"cb\" type=\"checkbox\" name=\"multi\"".">"."<br>\n";
          }
          ?>
          <button class = "mystyle2" type="submit">Add Package</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
