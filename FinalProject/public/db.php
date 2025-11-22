<?php
// Config DSN, USER, AND PASS
$dsn = 'pgsql:host=127.0.0.1;port=5432;dbname=authentication';
$db_user = 'postgres';
$db_pass = 'Amat1966';

// Try catch statement
try {
    $pdo = new PDO($dsn, $db_user, $db_pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (throwable $e) {
    http_response_code(500);
    echo "Database Connection Failed." . $e->getMessage();
    exit;
}
?>