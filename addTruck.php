<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ownerid = $_POST["driverID"];

    try{
        require_once "dbp.inc.php";

    }catch (PDOException $e){
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
    <h2>
        New Truck Information
    </h2>

    <form action = "confirmNewTruck.php" method = "post">
        <label for="TruckID">TruckID:</label>
        <input type="text" id="TruckID" name="TruckID" placeholder= "TruckID">
        <br></br>

        <label for="TruckModel">TruckModel:</label>
        <input type="text" id="TruckModel" name="TruckModel" placeholder= "TruckModel">
        <br></br>

        <label for="Damage">Damage:</label>
        <input type="text" id="Damage" name="Damage" placeholder= "Damage">
        <br></br>

        <input type="hidden" name="ownerid" value="<?php echo htmlspecialchars($ownerid); ?>">

        <label for="driverid">driverid:</label>
        <input type="text" id="driverid" name="driverid" placeholder= "driverid">
        <br></br>

        <button type="submit">Submit</button>
    </form>

</body>

