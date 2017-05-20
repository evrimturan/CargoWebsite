
<?php
/*  Sort the customers with a contract according to the money that
they have spent on shipping last year.
*/
require "connectdb.php";
$recent_sql = "SELECT myTable5.SumOfCost, customer.userName from customer,
(SELECT SumOfCost, userName FROM  (SELECT userName, sum(myTable3.cost) AS SumOfCost
FROM send, (SELECT cost, package.packageID FROM package, (SELECT packageID, include.trackingNum FROM include,
(SELECT trackingNum FROM shipment WHERE dateOfShipment LIKE '2016%') AS myTable
WHERE include.trackingNum = myTable.trackingNum)AS myTable2
WHERE myTable2.packageID = package.packageID) AS myTable3
WHERE send.packageID = myTable3.packageID
GROUP BY userName) AS myTable4) as myTable5
where myTable5.userName= customer.userName and contract = 'X' order by myTable5.SumOfCost desc
";

if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "Username: " . $row["userName"]. "<br>". " - Total Amount: " . $row["SumOfCost"]. "<br>";
    }
  }
}
else{
  header("Location:index.php");
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
