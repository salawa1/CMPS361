<?php
// API URL
$apiURL = "http://localhost:3005/api/v1/shows";

// Fetch the data
$response = @file_get_contents($apiURL);

// Decode JSON
$data = json_decode($response, true);

// Validate if data exists
if ($data && is_array($data)){
    // Pagination
    $limit = 10;
    $totalRecords = count($data);
    $totalPages = ceil($totalRecords / $limit);

    // Capture the current page
    $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;

    // Capture the starting index of the current page
    if ($currentPage < 1) {
        $currentPage = 1;
    } else if ($currentPage > $totalPages) {
        $currentPage = $totalPages;
    }

    $startIndex = ($currentPage - 1) * $limit;
    $pageData = array_slice($data, $startIndex, $limit);

    // Build out the table
    echo "<table border='1' cellpadding='10'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>showid</th>";
    echo "<th>name</th>";
    echo "<th>seasons</th>";
    echo "<th>genre</th>";
    echo "<th>releaseyear</th>";
    echo "<th>country</th>";
    echo "<th>service</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    // Loop through the data
    foreach ($pageData as $post) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($post['showid']) . "</td>";
        echo "<td>" . htmlspecialchars($post['name']) . "</td>";
        echo "<td>" . htmlspecialchars($post['seasons']) . "</td>";
        echo "<td>" . htmlspecialchars($post['genre']) . "</td>";
        echo "<td>" . htmlspecialchars($post['releaseyear']) . "</td>";
        echo "<td>" . htmlspecialchars($post['country']) . "</td>";
        echo "<td>" . htmlspecialchars($post['service']) . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";

    // Pagination links
    echo "<div style='margin-top: 20px;'>";

    // Display previous link if not on first page
    if ($currentPage > 1) {
        echo '<a href="?page=' . ($currentPage - 1) . '">Previous</a> ';
    }

    // Display page numbers
    for ($i = 1; $i <= $totalPages; $i++) {
        if ($i == $currentPage) {
            echo "<strong>$i</strong> ";
        } else {
            echo '<a href="?page=' . $i . '">' . $i . '</a> ';
        }
    }

    // Next page
    if ($currentPage < $totalPages) {
        echo '<a href="?page=' . ($currentPage + 1) . '">Next</a>';
    }

    echo "</div>";

} else {
    // No data available
    echo "Sorry no data is available. See you tomorrow.";
}
?>