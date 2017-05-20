
<?php
/*   Find the city that has received the most packages.lllllllllll
*/

require "connectdb.php";
$recent_sql = "SELECT city,count(city) as cnt_city from store,(select sid from destination)as myTable
where myTable.sid = store.sid group by city having count(*) = (select max(cnt_city) from (select city,count(city)as cnt_city from store,(select sid from destination)as myTable where myTable.sid = store.sid group by city) store);
";

if(mysqli_query($con,$recent_sql)){
  $res_table = $con->query($recent_sql);
  if($res_table->num_rows > 0)
  {
    while($row = mysqli_fetch_assoc($res_table))
    {
      echo "<br>";
      echo "City: " . $row["city"]. "<br>". " - Amount: " . $row["cnt_city"]. "<br>";
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
