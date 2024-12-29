<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $DriverID = $_POST["deleteDriver"];

    echo " ".htmlspecialchars($DriverID);

    //running the query
    try{
        
        require_once "dbp.inc.php";

        $query = "DELETE FROM driver WHERE driverid = ?;";

        $stmt = $conn->prepare($query);

        $stmt->execute([$DriverID]);

        $stmt = null;

        header("Location: ../includes/driverInfo.php");

        die();
        

        }catch (PDOException $e){
            echo "fail";
            die("Query failed: ".$e->getMessage());

    }

    
} else {
    header("Location: ../index.php");
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: .9em;
            color: #000000;
            background-color: #FFFFFF;
            margin: 0;
            padding: 10px 20px 20px 20px;
        }

        .text {
            width: 80%;
            margin-left: 90px;
            line-height: 140%;
        }

        .results-table {
            width: 80%;
            margin: 20px auto;
            border-collapse: collapse;
        }

        .results-table th, .results-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .results-table th {
            background-color: #f4f4f4;
        }

        .no-results {
            text-align: center;
            padding: 20px;
            color: #666;
        }
    </style>
</head>

<body>
    <h2>Delete Driver</h2>

</body>

