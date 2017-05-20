
<?php
/*
Find the cities that ships the most number of the
packages between April 20, 2013 and May 15, 2013.
*/

require "connectdb.php";
$recent_sql = "SELECT count(*) AS cnt, city FROM store,(SELECT sid FROM source,(SELECT packageID,include.trackingNum
FROM include, (SELECT trackingNum FROM shipment WHERE dateOfShipment BETWEEN '2013/04/20' AND '2013/05/15')AS myTable
WHERE myTable.trackingNum = include.trackingNum)AS myTable2
WHERE myTable2.packageID = source.packageID)AS myTable3
WHERE myTable3.sid = store.sid
GROUP BY city
HAVING count(*) = (SELECT max(cnt)from (SELECT count(*) AS cnt,city FROM store, (SELECT sid FROM source,
(SELECT packageID,include.trackingNum FROM include, (SELECT trackingNum FROM shipment
WHERE dateOfShipment BETWEEN '2013/04/20' AND '2013/05/15')AS myTable
Where myTable.trackingNum = include.trackingNum)AS myTable2
WHERE myTable2.packageID = source.packageID)AS myTable3
WHERE myTable3.sid = store.sid
GROUP BY city)city);
";

if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "City: " . $row["city"]. "<br>". " -Maximum Amount: " . $row["cnt"]. "<br>";
    }
  }
  else {
    echo "<br>";
    echo "No cities found !";
    echo "<br>";
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
