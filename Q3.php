
<?php
/* Find how frequently each store is used by customers for sending

packages. Sort these stores from most to least frequently used store.
*/
require "connectdb.php";
$recent_sql = "SELECT count(*) AS counter, sid
FROM source, (SELECT packageID FROM package)AS myTable
WHERE myTable.packageID = source.packageID
GROUP BY sid
order by count(*) desc
";
if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "Counter: " . $row["counter"]. "<br>". " - Store ID: " . $row["sid"]. "<br>";
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
