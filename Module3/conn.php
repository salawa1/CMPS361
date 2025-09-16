<?php
   // Authentication credentials
    $host = "localhost";
    $port = "5432";
    $dbname = "ShowLog";
    $user = "postgres";
    $password = "Amat1966";

    // Connection String
    $dsn = "pgsql:host=$host;dbname=$dbname";

    try {
        // Session
        $instance = new PDO($dsn,$user,$password);

        // Set an error alert
        $instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Echo messages
        echo "Successfully connected to the database";
    
    } catch (PDOException $e) {
        echo "Connection Failed: " . $e->getMessage();
    }
?>