<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $OrderID = $_POST["OrderID"];
    $DropOffLocation = $_POST["DropOffLocation"];
    $ContactFName = $_POST["ContactFName"];
    $ContactLName = $_POST["ContactLName"];
    $email = $_POST["email"];
    $productid = $_POST["productid"];
    $DriverID = $_POST["DriverID"];
    $BusinessID = $_POST["BusinessID"];
    




    try{
        require_once "dbp.inc.php";

        $queryOrder = "INSERT INTO companyorder
  	     (OrderID, DropOffLocation, email)
	    VALUES
	     (?, ?, ?)";
        $stmt = $conn->prepare($queryOrder);
        $stmt->execute([$OrderID, $DropOffLocation, $email]);
        $stmt = null;



        $queryShipment = "INSERT INTO shipment
  	     (productid, OrderID)
	    VALUES
	     (?, ?)";
        $stmt = $conn->prepare($queryShipment);
        $stmt->execute([$productid, $OrderID]);
        $stmt = null;

        $queryDelivering = "INSERT INTO delivering
  	     (DriverID, BusinessID, OrderID)
	    VALUES
	     (?, ?, ?)";
        $stmt = $conn->prepare($queryDelivering);
        $stmt->execute([$DriverID, $BusinessID, $OrderID]);
        $stmt = null;


        $queryPartnership = "INSERT INTO partnership
  	     (orderConfirmation, BusinessID, email, orderid)
	    VALUES
	     (?, ?, ?, ?)";
        $stmt = $conn->prepare($queryPartnership);
        $stmt->execute(["pending", $BusinessID, $email, $orderid]);
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
