<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $TruckID = $_POST["TruckID"];
    $TruckModel = $_POST["TruckModel"];
    $Damage = $_POST["Damage"];
    $ownerid = $_POST["ownerid"];
    $driverid = $_POST["driverid"];


    try{
        require_once "dbp.inc.php";

        $query = "INSERT INTO truck
  	     (truckid, truckmodel, damage, ownerid, driverid)
	    VALUES
	     (?, ?, ?, ?, ?)";

         $stmt = $conn->prepare($query);

         $stmt->execute([$TruckID, $TruckModel, $Damage, $ownerid, $driverid]);

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
