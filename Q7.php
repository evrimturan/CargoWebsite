
<?php
/*   Find the customer who has shipped the most packages in the last year.
*/

require "connectdb.php";
$recent_sql = "SELECT count(*) AS Maximum, userName
FROM send, (SELECT packageID FROM include,(SELECT dateOfShipment, trackingNum
FROM shipment WHERE dateOfShipment LIKE '2016%') AS myTable
WHERE myTable.trackingNum = include.trackingNum) AS myTable2
WHERE myTable2.packageID = send.packageID
GROUP BY userName
HAVING count(*) =
  (SELECT max(Maximum)
   FROM
     (SELECT count(*) AS Maximum,
             userName
      FROM send,
        (SELECT packageID
         FROM include,
           (SELECT dateOfShipment,
                   trackingNum
            FROM shipment
            WHERE dateOfShipment LIKE '2016%')AS myTable
         WHERE myTable.trackingNum = include.trackingNum) AS myTable2
      WHERE myTable2.packageID = send.packageID
      GROUP BY userName) send);
";

if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "Username: " . $row["userName"]. "<br>". " - Amount: " . $row["Maximum"]. "<br>";
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
