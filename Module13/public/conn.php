<?php
$dsn  = 'pgsql:host=localhost;port=5432;dbname=authentication;';
$user = 'postgres';
$pass = 'Amat1966';

try {
    $pdo = new PDO($dsn, $user, $pass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
} catch (PDOException $e) {
    error_log("DB Connection Failed: " . $e->getMessage());
    die("Database error");
}


if (isset($_POST['user_input'])) {
    $user_input = trim($_POST['user_input']);
    $stmt = $pdo->prepare("SELECT answer FROM questions_answers_ WHERE question ILIKE :question");
    $stmt->execute([':question' => '%' . $user_input . '%']);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        echo $result['answer'];
    } else {
        echo "Sorry, I don't know the answer to that. Ask another question about our record collection!";
    }
    exit;
}
?>