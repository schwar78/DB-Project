<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $ownerid = $_POST["driverID"];

    echo "<p>" . htmlspecialchars( $ownerid ) . "</p>";

    try{
        require_once "dbp.inc.php";
        $query = "SELECT productid, productname FROM product;";

        $stmt = $conn->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt = null;

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
        New Order Information
    </h2>

    <form action = "confirmOrder.php" method = "post">
        <label for="OrderID">OrderID:</label>
        <input type="text" id="OrderID" name="OrderID" placeholder= "OrderID">
        <br></br>

        <label for="BusinessID">BusinessID:</label>
        <input type="text" id="BusinessID" name="BusinessID" placeholder= "BusinessID">
        <br></br>

        <label for="DropOffLocation">DropOffLocation:</label>
        <input type="text" id="DropOffLocation" name="DropOffLocation" placeholder= "DropOffLocation">
        <br></br>

        <label for="ContactFName">ContactFName:</label>
        <input type="text" id="ContactFName" name="ContactFName" placeholder= "ContactFName">
        <br></br>

        <label for="ContactLName">ContactLName:</label>
        <input type="text" id="ContactLName" name="ContactLName" placeholder= "ContactLName">
        <br></br>

        <input type="hidden" name="DriverID" value="<?php echo htmlspecialchars($ownerid); ?>">

        <label for="email">Email:</label>
        <input type="text" id="email" name="email" placeholder= "Email">
        <br></br>

        <select name="productid" id="productid">
            <?php
            foreach ($result as $row) {
                echo '<option value="' . htmlspecialchars($row["productid"]) . '">' . htmlspecialchars($row["productname"]) .'</option>';
            }
            ?>
        </select>
        <br></br>

        <button type="submit">Submit</button>
    </form>

</body>

