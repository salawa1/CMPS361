<?php
    $dsn = 'pgsql:host=localhost;port=5432;dbname=authentication;';
    $user = 'postgres';
    $pass = 'Amat1966';

    try {
        $pdo = new PDO($dsn,$user,$pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        error_log("DB Connection Failed: " . $e->getMessage());
        die("Database error");
    }
?>