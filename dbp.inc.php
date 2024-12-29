<?php

    $dsn = "mysql:host=localhost;dbname=dbproject";
    $username = "root";
    $password = "root";
    $dbname = "dbproject";

    try {
        $conn = new PDO($dsn, $username, $password);
        // Set PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
    } catch(PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }