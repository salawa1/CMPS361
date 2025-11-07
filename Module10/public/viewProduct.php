<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'connection.php';

/** @var PDO $pdo */
$pdo = $pdo ?? null;

$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Pagination
$limit = 5;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;

// Sorting
$validColumns = ['name','artist','description','price','stock_level'];
$sortColumn = isset($_GET['sort']) && in_array($_GET['sort'], $validColumns, true)
    ? $_GET['sort']
    : 'name';
$orderParam = isset($_GET['order']) ? strtolower($_GET['order']) : 'asc';
$sortOrder = $orderParam === 'desc' ? 'DESC' : 'ASC';

// Record count (PHPStan correction)
$totalRecords = 0;
if ($search !== '') {
    $searchLike = "%$search%";
    $countStmt = $pdo->prepare("
        SELECT COUNT(*) FROM products
        WHERE name ILIKE :s
           OR artist ILIKE :s
           OR description ILIKE :s
           OR CAST(price AS TEXT) ILIKE :s
           OR CAST(stock_level AS TEXT) ILIKE :s
    ");
    $countStmt->execute([':s' => $searchLike]);
    $result = $countStmt->fetchColumn();
    if ($result !== false && $result !== null) {
        $totalRecords = (int) $result;
    }
} else {
    $stmt = $pdo->query("SELECT COUNT(*) FROM products");
    if ($stmt instanceof PDOStatement) {
        $result = $stmt->fetchColumn();
        if ($result !== false && $result !== null) {
            $totalRecords = (int) $result;
        }
    }
}

$totalPages = (int) ceil($totalRecords / $limit);
$offset = ($page - 1) * $limit;

// Fetch records
if ($search !== '') {
    $stmt = $pdo->prepare("
        SELECT * FROM products
        WHERE name ILIKE :s
           OR artist ILIKE :s
           OR description ILIKE :s
           OR CAST(price AS TEXT) ILIKE :s
           OR CAST(stock_level AS TEXT) ILIKE :s
        ORDER BY $sortColumn $sortOrder
        LIMIT :limit OFFSET :offset
    ");
    $stmt->bindValue(':s', $searchLike, PDO::PARAM_STR);
} else {
    $stmt = $pdo->prepare("
        SELECT * FROM products
        ORDER BY $sortColumn $sortOrder
        LIMIT :limit OFFSET :offset
    ");
}

$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

/**
 * Toggle sorting order for column headers.
 */
function toggleOrder(string $column, string $currentSort, string $currentOrder): string {
    if ($column === $currentSort) {
        return $currentOrder === 'ASC' ? 'desc' : 'asc';
    }
    return 'asc';
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Products</title>
    <link rel="stylesheet" href="css/product.css">
    <style>
        .header-bar {
            position: relative;
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            height: 60px;
        }

        .header-bar h1 {
            position: absolute;
            left: 50%;
            transform: translateX(-50%);
            font-size: 32px;
            color: #222;
            margin: 0;
        }

        .home-btn {
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
        }

        .home-btn:hover {
            transform: translateY(-50%);
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
        }

        .header-bar form {
            position: absolute;
            right: 0;
            top: 50%;
            transform: translateY(-50%);
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .header-bar input#searchInput {
            height: 40px;
            padding: 0 16px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
            outline: none;
        }

        #dataGrid thead th {
            font-size: 16px !important;
            font-weight: 600 !important;
            white-space: nowrap;
        }

        #dataGrid thead th a {
            font-weight: inherit !important;
            font-size: inherit !important;
        }

        #dataGrid tbody td {
            font-size: 16px !important;
            padding: 10px 14px !important;
            line-height: 1.4 !important;
            vertical-align: middle !important;
            white-space: nowrap;
        }

        #dataGrid th,
        #dataGrid td {
            max-width: 200px;
            white-space: normal !important;
            word-wrap: break-word;
        }

        th a { text-decoration: none; color: inherit; }
        th a:hover { text-decoration: underline; }
        .search-form input[type="text"] {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
<div class="container">

    <div class="header-bar">
        <a href="welcome.php" class="btn btn-secondary home-btn">← Back</a>
        <h1>Products</h1>
        <form method="GET" class="search-form">
            <input type="text" name="search" placeholder="Search products..." value="<?= htmlspecialchars($search) ?>">
            <input type="hidden" name="sort" value="<?= htmlspecialchars($sortColumn) ?>">
            <input type="hidden" name="order" value="<?= strtolower($sortOrder) ?>">
        </form>
    </div>

    <table id="dataGrid">
        <thead>
            <tr>
                <th><a href="?sort=name&order=<?= toggleOrder('name', $sortColumn, $sortOrder) ?>&search=<?= urlencode($search) ?>">Name</a></th>
                <th><a href="?sort=artist&order=<?= toggleOrder('artist', $sortColumn, $sortOrder) ?>&search=<?= urlencode($search) ?>">Artist</a></th>
                <th><a href="?sort=description&order=<?= toggleOrder('description', $sortColumn, $sortOrder) ?>&search=<?= urlencode($search) ?>">Description</a></th>
                <th><a href="?sort=price&order=<?= toggleOrder('price', $sortColumn, $sortOrder) ?>&search=<?= urlencode($search) ?>">Price</a></th>
                <th><a href="?sort=stock_level&order=<?= toggleOrder('stock_level', $sortColumn, $sortOrder) ?>&search=<?= urlencode($search) ?>">Stock Level</a></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= htmlspecialchars($product['name']) ?></td>
                    <td><?= htmlspecialchars($product['artist']) ?></td>
                    <td><?= htmlspecialchars($product['description']) ?></td>
                    <td>$<?= htmlspecialchars(number_format($product['price'], 2)) ?></td>
                    <td><?= htmlspecialchars($product['stock_level']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="?page=<?= $page - 1 ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>&search=<?= urlencode($search) ?>" class="btn btn-secondary">Previous</a>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>&search=<?= urlencode($search) ?>" class="page-link <?= $i == $page ? 'active' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>

        <?php if ($page < $totalPages): ?>
            <a href="?page=<?= $page + 1 ?>&sort=<?= $sortColumn ?>&order=<?= $sortOrder ?>&search=<?= urlencode($search) ?>" class="btn btn-secondary">Next</a>
        <?php endif; ?>
    </div>

    <div style="margin-top: 20px;">
        <strong>Total Records: <?= $totalRecords ?></strong>
    </div>

</div>
</body>
</html>