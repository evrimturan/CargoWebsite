<html>
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
</style>
<body>
  <title>
    Flammenwerfer Cargo
  </title>
<br>
<hr>
<center><strong><h1>Flammenwerfer Cargo Login Page</h1></strong></center>
<hr>
<center><form action="authorization.php" method="post">
Name: <input type="text" name="name" required><br>
Password: <input type="password" name="psw" required><br>
<button type="submit">Log-in</button>
</form></center>
<center>
  <?php
  if($_GET["login"] == "failed"){
    echo "<strong>"."<p style=\"color:red\">"."Login Failed !"."</p>"."</strong>\n";
  }else if($_GET["query"] == "failed"){
    echo "<strong>"."<p style=\"color:red\">"."Database Connection Failed !"."</p>"."</strong>\n";
  }
  ?>
  <!-- PHP Ninja !!! -->
</center>
</body>
</html>
