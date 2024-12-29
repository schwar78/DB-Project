<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $driverID = $_POST["result"];


    try{
        require_once "dbp.inc.php";

        //$query = "SELECT * FROM driver WHERE driverid = :driverid ;";

        $query = "SELECT d.driverid, d.managerid, d.driverfname, d.driverlname, d.driverLicenseNo, c.companyname
                    FROM driver d
                    JOIN manager m ON m.managerid = d.managerid
                    JOIN truck_company c ON c.companyid = m.companyid
                    WHERE driverid = :driverid ;";

        $stmt = $conn->prepare($query);
        $stmt->bindValue(":driverid", $driverID, PDO::PARAM_STR);
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

<h1>Update Truck Information</h1>

<?php
    if (empty($result)) {
        echo "<div class='no-results'>";
        echo "<p>No Driver found</p>";
        echo "</div>";

    }else{
        foreach ($result as $row) {
            $name = $row["driverfname"] . " " . $row["driverlname"];

            echo "<p><b>Driver Name: </b> ".htmlspecialchars($name)."</p>";
            echo "<p><b>Driver ID: </b> ".htmlspecialchars($row["driverid"])."</p>";
            echo "<p><b>Driver Company: </b>".htmlspecialchars($row["companyname"])."</p>";
            echo "<p><b>Manager: </b> ".htmlspecialchars($row["managerid"])."</p>";
            
            echo "<h3>Truck Information:</h3>";


            try {
                // Fetch trucks for the current driver
                $stmt = $conn->prepare("SELECT * FROM truck WHERE ownerid = :ownerid");
                $stmt->bindValue(":ownerid", $row["driverid"], PDO::PARAM_STR);
                $stmt->execute();
                $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            } catch (PDOException $e) {
                echo "<p>Failed to fetch trucks: " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        }
    }

    ?>


    <form action="deleteTruck.php" method="post">
        <select name="deleteTruck" id="deleteTruck">
            <?php
            foreach ($result2 as $row) {
                echo '<option value="' . htmlspecialchars($row["TruckID"]) . '">' . htmlspecialchars($row["TruckID"]) . '</option>';
            }
            ?>
        </select>
        <button type="submit">Delete Truck</button>
    </form>

    <br></br>


    <form action="reportDamage.php" method="post">
        <select name="reportDamageTruck" id="reportDamageTruck">
            <?php
            foreach ($result2 as $row) {
                echo '<option value="' . htmlspecialchars($row["TruckID"]) . '">' . htmlspecialchars($row["TruckID"]) . '</option>';
            }
            ?>
        </select>
        <button type="submit">Report Damage</button>
    </form>



</body>
      