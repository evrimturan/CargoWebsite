<?php if(empty($_GET["firstname"])){
  header("Location: index.php");
  die();
}
 ?>
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
  <link rel="stylesheet" href = "https://www.w3schools.com/w3css/4/w3.css">
  <title>Register</title>
  <?php if($_GET["complete"] == "true"){
    echo "<strong>"."<center>"."<br>"."Registration Complete"."</br>"."</center>"."</strong>";
  }
  else if($_GET["complete"] == "false"){
    echo "<strong>"."<center>"."<br>"."Error on adding the new user!"."</br>"."</center>"."</strong>";
  }
   ?>
   <br>
   <hr style="border-top:1px solid #000";></hr>
   <strong><h1>Register Page</h1></strong>
   <hr style="border-top:1px solid #000";></hr>
   <br>
  <div class ="w3-row">
    <div class = "w3-col m2 l1">
      <form action = "logout.php" method = "post">
        <br>
        <button class="mystyle" type="submit">Logout</button>
      </form>
      <form action = "home_employee.php?firstname=<?php echo $_GET["firstname"] ?>" method ="post">
        <br>
        <button class="mystyle" type="submit">Home Page</button>
      </form>
    </div>
    <div class ="w3-col m10 l11">
      <div style="border-left:1px solid #000;height:800px;">
          <strong><p style="left 15px ;border-top:1px solid #000;">Register A User</p></strong>
          <?php
          if($_GET["field"] == "empty"){
            echo "<p>"."<mark>"."No field can be left empty !"."</mark>"."</p>";
          }else if($_GET["complete"] == "false"){
            echo "<p>"."<mark>"."Username already exists on the database !"."</mark>"."</p>";
          }
          ?>
          <form action="add_user.php?firstname=<?php echo $_GET["firstname"] ?>" method="post">
            Username: <input type="text" name="name" required><br>
            Password: <input type="text" name="psw" required><br>
            Firstname: <input type="text" name="fname" required><br>
            Midname: <input type="text" name="midName"><br>
            Lastname: <input type="text" name="lastName" required><br>
            Country: <input type="text" name="country" required><br>
            City: <input type="text" name="city" required><br>
            District: <input type="text" name="district" required><br>
            Street: <input type="text" name="street" required><br>
            Phone Number: <input type="text" name="phone" required><br>
            Email: <input type="text" name="email" required><br>
            Contract: <input type="checkbox" name="contract"><br>
            <button class = "mystyle2" type="submit">Register User</button>
          </form>
      </div>
    </div>
  </div>
</body>
</html>
