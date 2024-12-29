<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //running the query
    try{
        require_once "dbp.inc.php";

        $query1 = "SELECT d.driverid, d.managerid, d.driverfname, d.driverlname, d.driverLicenseNo, c.companyname
                    FROM driver d
                    JOIN manager m ON m.managerid = d.managerid
                    JOIN truck_company c ON c.companyid = m.companyid;";
        $query2 = "SELECT d.driverid, d.managerid, c.companyname
                    FROM driver d
                    JOIN manager m ON m.managerid = d.managerid
                    JOIN truck_company c ON c.companyid = m.companyid;";

        $stmt1 = $conn->prepare($query1);
        $stmt2 = $conn->prepare($query2);

        $stmt1->execute();
        $stmt2->execute();

        $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
        $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        $stmt1 = null;
        $stmt2 = null;

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

<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Horizontal Line</title>
    <style>
        hr {
            border: none;
            height: 2px; /* Thickness of the line */
            background-color: #000; /* Color of the line */
            margin: 0; /* Removes default spacing */
        }
    </style>
</head>

<head>
    <title>Driver Report</title>
</head>
<body>
    <h1>Driver Report</h1>
    <h2>Select a Driver</h2>
    

    <?php
    if (empty($result1)) {
        echo "<div class='no-results'>";
        echo "<p>No Driver found</p>";
        echo "</div>";

    }else{
        echo '<form action = "viewDriver.php" method = "post">';
        echo '<select name="options" id="options">';
        foreach ($result1 as $row) {
            echo '<option value="' . htmlspecialchars($row["driverid"]) . '">' . htmlspecialchars($row["driverfname"] . ' ' . $row["driverlname"]) . '</option>';
        }
        echo '</select>';
        echo '<br></br>';
        echo '<button type="submit">Get Driver Information</button>';
        echo '</form>';

    
    }
    ?>

</body>
<br></br>
<hr>
<body>
   

    <?php
        if (empty($result1)) {
            echo "<div class='no-results'>";
            echo "<p>No Driver found</p>";
            echo "</div>";

        }else{

            foreach ($result1 as $row) {
                $name = $row["driverfname"] . " " . $row["driverlname"];


                echo "<p><b>Driver Name: </b> ".htmlspecialchars($name)."</p>";
                echo "<p><b>Driver ID: </b> ".htmlspecialchars($row["driverid"])."</p>";
                echo "<p><b>Driver Company: </b>".htmlspecialchars($row["companyname"])."</p>";
                echo "<p><b>Manager: </b> ".htmlspecialchars($row["managerid"])."</p>";
                
                echo "<p><b>Trucks:</b></p>";


                try {
                    // Fetch trucks for the current driver
                    $stmt = $conn->prepare("SELECT * FROM truck WHERE ownerid = :ownerid");
                    $stmt->bindValue(":ownerid", $row["driverid"], PDO::PARAM_STR);
                    $stmt->execute();
                    $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null; // Close the truck statement


                    
                    $stmt = $conn->prepare("SELECT 
                                                d.DriverID, 
                                                o.OrderID, 
                                                o.DropOffLocation, 
                                                o.email
                                            FROM delivering d
                                            JOIN companyorder o ON d.OrderID = o.OrderID
                                            WHERE d.DriverID = :ownerid;");
                    $stmt->bindValue(":ownerid", $row["driverid"], PDO::PARAM_STR);
                    $stmt->execute();
                    $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    $stmt = null; // Close the truck statement

    
                    if (empty($result2)) {
                        echo "<p>No trucks found for this driver.</p>";
                    } else {
                        echo "<table class='results-table'>";
                        echo "<tr><th>Truck ID</th><th>Truck Model</th><th>Damage</th><th>Driver ID</th></tr>";
                        foreach ($result2 as $row2) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row2["TruckID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row2["TruckModel"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row2["Damage"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row2["driverid"]) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }

                    echo "<p><b>Orders:</b></p>";

                    if (empty($result3)) {
                        echo "<p>No orders found for this driver.</p>";
                    } else {
                        echo "<table class='results-table'>";
                        echo "<tr><th>Order ID</th><th>DropOffLocation</th><th>email</th></tr>";
                        foreach ($result3 as $row3) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row3["OrderID"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row3["DropOffLocation"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row3["email"]) . "</td>";
                            echo "</tr>";
                        }
                        echo "</table>";
                    }
                } catch (PDOException $e) {
                    echo "<p>Failed to fetch trucks: " . htmlspecialchars($e->getMessage()) . "</p>";
                }

                echo "<br></br><hr>";

            }
        }
        ?>

</body>
</html>
