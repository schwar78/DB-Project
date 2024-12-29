<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ManagerID = $_POST["ManagerID"];
    $ManagerFName = $_POST["ManagerFName"];
    $ManagerLName = $_POST["ManagerLName"];
    $CompanyID = $_POST["CompanyID"];
    $Manages_ManagerID = $_POST["Manages_ManagerID"];

    try{
        require_once "dbp.inc.php";

        $query = "INSERT INTO manager
  	     (managerid, managerfname, managerlname, companyid, manages_managerid)
	    VALUES
	     (?, ?, ?, ?, ?)";

         $stmt = $conn->prepare($query);

         $stmt->execute([$ManagerID, $ManagerFName, $ManagerLName, $CompanyID, $Manages_ManagerID]);

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
