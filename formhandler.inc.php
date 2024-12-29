<?php
$temp = "tem";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    //username and password from login
    $username = $_POST["username"];
    $pwd = $_POST["password"];

    //check to see who the current user is
    if($username == "manager" | $username == "driver" | $username == "business"){
        echo htmlspecialchars($username);
    }else{
        echo htmlspecialchars("user not found");
    };

    //running the query
    try{
        require_once "dbp.inc.php";

        $query = "SELECT * FROM driver;";

        $stmt = $conn->prepare($query);
        $stmt->execute();

        $conn = null;
        $stmt = null;
        die();

    }catch (PDOException $e){
        die("Query failed: ".$e->getMessage());

    }

    echo htmlspecialchars($query);
    
} else {
    header("Location: ../index.php");
    exit(); 
}
?>



