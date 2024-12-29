<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //running the query
    try{
        require_once "dbp.inc.php";

        $query = "SELECT * FROM manager;";

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
    <h2>Manager Report</h2>
    

    <?php
    if (empty($result)) {
        echo "<div class='no-results'>";
        echo "<p>No Manager found</p>";
        echo "</div>";

    }else{
        echo '<form action = "viewMan.php" method = "post">';
        echo '<select name="options" id="options">';
        foreach ($result as $row) {
            echo '<option value="' . htmlspecialchars($row["ManagerID"]) . '">' . htmlspecialchars($row["ManagerFName"] . ' ' . $row["ManagerLName"]) . '</option>';
        }
        echo '</select>';
        echo '<br></br>';
        echo '<button type="submit">Get Manager Information</button>';
        echo '</form>';

        echo "<br></br><hr>";


        foreach ($result as $row) {
            echo "<h4>".$row["ManagerFName"] . " " . $row["ManagerLName"]."<h4>";


            echo "<table class='results-table'>";
            echo "<tr><th>ID</th><th>Supervisor</th><th>CompanyID</th>";
                $name = $row["ManagerFName"] . " " . $row["ManagerLName"];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["ManagerID"])  . "</td>";
                echo "<td>" . htmlspecialchars($row["Manages_ManagerID"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["CompanyID"]). "</td>";
                echo "</tr>";
            echo "</table>";
    
    
            echo '<h4>Manages</h4>';


            try{

                $query2 = "SELECT * FROM driver WHERE managerid = :managerid";
                $stmt = $conn->prepare($query2);
                $stmt->bindValue(":managerid", $row["ManagerID"], PDO::PARAM_STR);  // Assuming managerid is a string
                $stmt->execute();
                $result2 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;


                $query3 = "SELECT mm.managerid, mm.managerfname, mm.managerlname, mm.companyid, mm.manages_managerID 
                FROM manager m, manager mm 
                WHERE m.managerid = mm.Manages_ManagerID AND m.managerid = :managerid;";
                $stmt = $conn->prepare($query3);
                $stmt->bindValue(":managerid", $row["ManagerID"], PDO::PARAM_STR);
                $stmt->execute();
                $result3 = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $stmt = null;

            }catch (PDOException $e){
                echo "its empty";
                die("Query failed: ".$e->getMessage());
        
            }
    
            echo "<table class='results-table'>";
            echo "<tr><th>Subordinate ID</th><th>Subordinate Name</th>";
            foreach ($result2 as $row2) {
                $name = $row2["DriverFName"] . " " . $row2["DriverLName"];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row2["DriverID"]) . "</td>";
                echo "<td>" . htmlspecialchars($name) . "</td>";
                echo "</tr>";
            }
    
            foreach ($result3 as $row3) {
                echo " ".htmlspecialchars($row2["managerid"]);
    
                $name = $row3["managerfname"] . " " . $row3["managerlname"];
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row3["managerid"]) . "</td>";
                echo "<td>" . htmlspecialchars($name) . "</td>";
                echo "</tr>";
            }
    
            echo "</table>";

            echo "<br></br><hr>";

        }

    
    }
    ?>

    <br></br>
    <form action = "addMan.php" method = "post">
        <button type="submit">Add a New Manager</button>
    </form>

</body>
</html>
