<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $damage = $_POST["damageDescription"];
    $truckID = $_POST["truckID"];

    try{
        require_once "dbp.inc.php";

        $query = "UPDATE truck
        SET  Damage = ?
        WHERE truckid = ?;";

         $stmt = $conn->prepare($query);

         $stmt->execute([$damage, $truckID]);

         $stmt = null;

         header("Location: ../includes/driverInfo.php");

         die();

    }catch (PDOException $e){
        die("Query failed: ".$e->getMessage());

    }

    
} else {
    header("Location: ../index.php");
    exit(); 
}
?>


<!DOCTYPE html>
<html>
  <head>
    <title>Added New Manager</title>
  </head>
  <body>

  <p>something</p>

  </body>
</html>
