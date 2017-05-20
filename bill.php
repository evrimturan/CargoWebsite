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
  <title>Bill a Customer</title>
  <hr style="border-top:1px solid #000";></hr>
  <strong><h1>Bill Page</h1></strong>
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
      <div style="border-left:1px solid #000;height:800px;">
        <strong><p style="left 15px ;border-top:1px solid #000;">Bill a Customer</p></strong>
        <p>Select the User</p>
        <form action = "bill_generate.php?firstname=<?php echo $_GET["firstname"]?>" method = "post">
          Tracking Number: <input type="number" name="ship_no">
          <br>
          <button class = "mystyle2" type="submit">Generate Bill</button>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
