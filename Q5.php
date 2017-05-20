

  <?php
  /*  Find the store that has recieved the most hazardous packages.
  */

  require "connectdb.php";
  $recent_sql = "SELECT count(*) AS maxval, sid FROM destination, (SELECT packageID FROM package WHERE content = 'hazardous') AS myTable WHERE myTable.packageID = destination.packageID GROUP BY sid HAVING count(*) =(SELECT max(maxval) FROM (SELECT count(*) AS maxval,sid FROM destination, (SELECT packageID FROM package WHERE content = 'hazardous') AS myTable WHERE myTable.packageID = destination.packageID GROUP BY sid) destination); ";

  if(mysqli_query($con,$recent_sql)){
    $res_table = $con->query($recent_sql);
    if($res_table->num_rows > 0)
    {
      while($row = mysqli_fetch_assoc($res_table))
      {
        echo "<br>";
        echo "Store ID: " . $row["sid"]. "<br>". " - Amount: " . $row["maxval"]. "<br>";
      }
    }
  }
  else{
    header("Location:bill.php");
    die("Failed to query from the server.");
  }
   ?>

   <html>
   <style>
   body{
     background-color: lightblue;
   }
   </style>
   <body>
     <title>
       Flammenwerfer Cargo
     </title>
   </body>
   </html>
