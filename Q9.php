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
   <?php
   /*  Find the store that has earned the most money from shipping packages.
   */
   require "connectdb.php";
   $recent_sql = "SELECT SumOfEarned,
          sid from
     (SELECT sid,sum(myTable.cost) AS SumOfEarned
      FROM source,
        (SELECT packageID,cost
         FROM package) AS myTable
      WHERE myTable.packageID = source.packageID
      GROUP BY sid) AS myTable3
   WHERE SumOfEarned =
       (SELECT max(SumOfEarned)
        FROM
          (SELECT sid,
                  sum(myTable.cost) AS SumOfEarned
           FROM source,
             (SELECT packageID,
                     cost
              FROM package) AS myTable
           WHERE myTable.packageID = source.packageID
           GROUP BY sid)myTable2);";

   if(mysqli_query($con,$recent_sql)){
     $res_table = $con->query($recent_sql);
     if($res_table->num_rows > 0)
     {
       while($row = mysqli_fetch_assoc($res_table))
       {
         echo "<br>";
         echo "Store ID: " . $row["sid"]. "<br>". " - Total Amount " . $row["SumOfEarned"]. "<br>";
       }
       echo "\n";
     }
   }
   else{
     header("Location:bill.php");
     die("Failed to query from the server.");
   }
    ?>
 </body>
 </html>
