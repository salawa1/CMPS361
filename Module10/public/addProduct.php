<?php 
session_start();

require 'db.php';           // database connection
require 'csrf.php';         // CSRF protection functions
include 'connection.php';

/** @var PDO $pdo */
$pdo = $pdo ?? null;

$success = null;
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verify CSRF token
    if (!csrf_check($_POST['csrf'] ?? '')) {
        $errors[] = 'Incorrect form token. Please try again.';
    }

    // Sanitize inputs
    $name = trim($_POST['name'] ?? '');
    $artist = trim($_POST['artist'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = trim($_POST['price'] ?? '');
    $stock_level = trim($_POST['stock_level'] ?? '');

    // Validation
    if ($name === '') $errors[] = 'Album name is required.';
    if ($artist === '') $errors[] = 'Artist name is required.';
    if ($description === '') $errors[] = 'Description is required.';
    if ($price === '' || !is_numeric($price) || $price < 0) $errors[] = 'Price must be a non-negative number.';
    if ($stock_level === '' || !is_numeric($stock_level) || $stock_level < 0) $errors[] = 'Stock level must be a non-negative number.';

    // Insert if no errors
    if (!$errors) {
        $stmt = $pdo->prepare("
            INSERT INTO products (name, artist, description, price, stock_level) 
            VALUES (:name, :artist, :description, :price, :stock_level)
        ");

        $stmt->execute([
            ':name'        => $name,
            ':artist'      => $artist,
            ':description' => $description,
            ':price'       => $price,
            ':stock_level' => $stock_level
        ]);

        $success = "Record added successfully!";
        $_POST = []; // clear form after success
    }
}
?>

<html>
    <head>
        <link rel="stylesheet" href="css/addproduct.css">
        <title>Add Products</title>
        <style>
            /* Match alert-success styling for error messages */
            .alert-error {
                background: #f8d7da;
                color: #721c24;
                border: 1px solid #f5c6cb;
                padding: 8px 14px;
                border-radius: 6px;
                font-weight: 600;
                font-size: 14px;
                box-shadow: 0 2px 6px rgba(0,0,0,0.05);
                margin-bottom: 20px;
            }

            .alert-error ul {
                margin: 0;
                padding-left: 20px;
            }

            .alert-error li {
                list-style-type: disc;
            }
        </style>
    </head>
    <body>
        <div class="container">

            <div class="header-bar">
                <div class="left-slot">
                    <a href="welcome.php" class="btn btn-secondary home-btn">← Back</a>
                </div>

                <h1>Add Products</h1>

                <div class="right-slot">
                    <?php if ($success): ?>
                        <div class="alert-success"><?= htmlspecialchars($success) ?></div>
                    <?php endif; ?>
                </div>
            </div>

            <?php if ($errors): ?>
                <div class="alert-error">
                    <ul>
                        <?php foreach ($errors as $error): ?>
                            <li><?= htmlspecialchars($error) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST">
                <input type="hidden" name="csrf" value="<?= htmlspecialchars(csrf_token()) ?>">

                <label>Album Name:</label>
                <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
                
                <label>Artist:</label>
                <input type="text" name="artist" value="<?= htmlspecialchars($_POST['artist'] ?? '') ?>" required>
                
                <label>Description:</label>
                <input type="text" name="description" value="<?= htmlspecialchars($_POST['description'] ?? '') ?>" required>
                
                <label>Price:</label>
                <input type="number" step="0.01" name="price" value="<?= htmlspecialchars($_POST['price'] ?? '') ?>" required>
                
                <label>Amount In Stock:</label>
                <input type="number" name="stock_level" value="<?= htmlspecialchars($_POST['stock_level'] ?? '') ?>" required>

                <input type="submit" value="Add Product">
            </form>
        </div>
    </body>
</html>