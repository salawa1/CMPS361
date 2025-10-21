<?php 
include 'connection.php';

$success = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $stmt = $pdo->prepare("
        INSERT INTO products (name, artist, description, price, stock_level) 
        VALUES (:name, :artist, :description, :price, :stock_level)
    ");

    $stmt->execute([
        ':name'        => $_POST['name'],
        ':artist'      => $_POST['artist'],
        ':description' => $_POST['description'],
        ':price'       => $_POST['price'],
        ':stock_level' => $_POST['stock_level']
    ]);

    $success = "Record added successfully!";
}
?>

<html>
    <head>
        <link rel="stylesheet" href="css/addproduct.css">
        <title>Add Products</title>
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

    <form method="POST">
        <label>Album Name:</label>
        <input type="text" name="name" required>
        
        <label>Artist:</label>
        <input type="text" name="artist" required>
        
        <label>Description:</label>
        <input type="text" name="description" required>
        
        <label>Price:</label>
        <input type="number" step="0.01" name="price" required>
        
        <label>Amount In Stock:</label>
        <input type="number" name="stock_level" required>

        <input type="submit" value="Add Product">
    </form>
    </div>
    </body>
</html>