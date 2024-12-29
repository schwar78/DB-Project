<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $DriverID = $_POST["DriverID"];
    $DriverFName = $_POST["DriverFName"];
    $DriverLName = $_POST["DriverLName"];
    $DriverLicenseNo = $_POST["DriverLicenseNo"];
    $ManagerID = $_POST["ManagerID"];


    echo " ".htmlspecialchars($DriverID);
    try{
        require_once "dbp.inc.php";

        $query = "INSERT INTO driver
  	     (driverfname, driverlname, driverlicenseno, driverid, managerid)
	    VALUES
	     (?, ?, ?, ?, ?)";

         $stmt = $conn->prepare($query);

         $stmt->execute([$DriverFName, $DriverLName, $DriverLicenseNo, $DriverID, $ManagerID]);

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
    <title>Added New Driver</title>
  </head>
  <body>

  <p>something</p>

  </body>
</html>
