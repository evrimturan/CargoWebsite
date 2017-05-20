
<?php
/*   Find the customer who has spent the most money on shipping last year.
*/
require "connectdb.php";
$time = date("Y/m/d");
$time = substr($time,0,4);
$time = (int)$time -1;
$recent_sql = "SELECT SumOfCost, userName
FROM (SELECT userName, sum(myTable3.cost) AS SumOfCost
FROM send,
(SELECT cost, package.packageID
FROM package,
(SELECT packageID,
include.trackingNum
FROM include,
(SELECT trackingNum
FROM shipment
WHERE dateOfShipment LIKE '$time%') AS myTable
WHERE include.trackingNum = myTable.trackingNum)AS myTable2
WHERE myTable2.packageID = package.packageID) AS myTable3
WHERE send.packageID = myTable3.packageID
GROUP BY userName) AS myTable4
WHERE SumOfCost =(SELECT max(SumOfCost) FROM (SELECT userName, sum(myTable3.cost) AS SumOfCost
FROM send,
(SELECT cost,
package.packageID
FROM package,
(SELECT packageID,
include.trackingNum
FROM include,
(SELECT trackingNum
FROM shipment
WHERE dateOfShipment LIKE '$time%') AS myTable
WHERE include.trackingNum = myTable.trackingNum)AS myTable2
WHERE myTable2.packageID = package.packageID) AS myTable3
WHERE send.packageID = myTable3.packageID
GROUP BY userName) myTable4);
";

if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "Username: " . $row["userName"]. "<br>". " - Amount: " . $row["SumOfCost"]. "<br>";
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
