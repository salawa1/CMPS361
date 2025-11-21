<?php

    session_start();

    require_once __DIR__ . '/conn.php';
    require_once __DIR__ . '/helper.php';

    // total page views (30 days)
    $totalPageViewsStmt = $pdo->query("
        SELECT COUNT(*) AS total_page_views_30d
        FROM page_views
        WHERE created_at >= NOW() - INTERVAL '30 days'
    ");
    $totalPageViews = $totalPageViewsStmt->fetch(PDO::FETCH_ASSOC)['total_page_views_30d'] ?? 0;

    // unique visitors (distinct sessions) (30 days)
    $uniqueVisitorsStmt = $pdo->query("
        SELECT COUNT(DISTINCT session_id) AS unique_visitors_30d
        FROM page_views
        WHERE created_at >= NOW() - INTERVAL '30 days'
    ");
    $uniqueVisitors = $uniqueVisitorsStmt->fetch(PDO::FETCH_ASSOC)['unique_visitors_30d'] ?? 0;

    // total events (30 days)
    $totalEventsStmt = $pdo->query("
        SELECT COUNT(*) AS total_events_30d
        FROM web_events
        WHERE created_at >= NOW() - INTERVAL '30 days'
    ");
    $totalEvents = $totalEventsStmt->fetch(PDO::FETCH_ASSOC)['total_events_30d'] ?? 0;

    // --- 2) Page views by day (last 14 days) ---

    $pageViewsByDayStmt = $pdo->query("
        SELECT
            date_trunc('day', created_at) AS day,
            COUNT(*) AS views
        FROM page_views
        WHERE created_at >= NOW() - INTERVAL '14 days'
        GROUP BY day
        ORDER BY day DESC
    ");
    $pageViewsByDay = $pageViewsByDayStmt->fetchAll(PDO::FETCH_ASSOC);

    // --- 3) Top pages (last 30 days) ---

    $topPagesStmt = $pdo->query("
        SELECT
            path,
            COUNT(*) AS views
        FROM page_views
        WHERE created_at >= NOW() - INTERVAL '30 days'
        GROUP BY path
        ORDER BY views DESC
        LIMIT 10
    ");
    $topPages = $topPagesStmt->fetchAll(PDO::FETCH_ASSOC);

    // --- 4) Events by type (last 30 days) ---

    $eventsByTypeStmt = $pdo->query("
        SELECT
            event_name,
            COUNT(*) AS events_count
        FROM web_events
        WHERE created_at >= NOW() - INTERVAL '30 days'
        GROUP BY event_name
        ORDER BY events_count DESC
    ");
    $eventsByType = $eventsByTypeStmt->fetchAll(PDO::FETCH_ASSOC);

    // --- 5) Simple funnel example: checkout_started -> checkout_completed (30 days) ---

    $checkoutStartedStmt = $pdo->query("
        SELECT COUNT(*) AS c
        FROM web_events
        WHERE event_name = 'checkout_started'
        AND created_at >= NOW() - INTERVAL '30 days'
    ");
    $checkoutCompletedStmt = $pdo->query("
        SELECT COUNT(*) AS c
        FROM web_events
        WHERE event_name = 'checkout_completed'
        AND created_at >= NOW() - INTERVAL '30 days'
    ");
    $checkoutStarted   = $checkoutStartedStmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;
    $checkoutCompleted = $checkoutCompletedStmt->fetch(PDO::FETCH_ASSOC)['c'] ?? 0;

    $checkoutConversion = null;
    if ($checkoutStarted > 0) {
        $checkoutConversion = round(($checkoutCompleted / $checkoutStarted) * 100, 2);
    }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Site Metrics</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background: #f5f5f5;
        }
        h1, h2 {
            color: #333;
        }
        .cards {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            margin-bottom: 24px;
        }
        .card {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.08);
            min-width: 200px;
        }
        .card-title {
            font-size: 12px;
            text-transform: uppercase;
            color: #777;
            margin-bottom: 4px;
        }
        .card-value {
            font-size: 24px;
            font-weight: bold;
            color: #222;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 24px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }
        th, td {
            padding: 8px 10px;
            border-bottom: 1px solid #eee;
            text-align: left;
            font-size: 14px;
        }
        th {
            background: #fafafa;
            font-weight: bold;
        }
        tr:nth-child(even) td {
            background: #fbfbfb;
        }
        .subtext {
            font-size: 12px;
            color: #777;
            margin-top: -8px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<h1>Site Metrics Dashboard</h1>
<p class="subtext">Data from PostgreSQL: page_views, web_sessions, web_events</p>

<div class="cards">
    <div class="card">
        <div class="card-title">Page Views (Last 30 Days)</div>
        <div class="card-value"><?= htmlspecialchars((string)$totalPageViews) ?></div>
    </div>
    <div class="card">
        <div class="card-title">Unique Visitors (Last 30 Days)</div>
        <div class="card-value"><?= htmlspecialchars((string)$uniqueVisitors) ?></div>
    </div>
    <div class="card">
        <div class="card-title">Events Logged (Last 30 Days)</div>
        <div class="card-value"><?= htmlspecialchars((string)$totalEvents) ?></div>
    </div>
    <div class="card">
        <div class="card-title">Checkout Conversion (30 Days)</div>
        <div class="card-value">
            <?php if ($checkoutConversion !== null): ?>
                <?= htmlspecialchars((string)$checkoutConversion) ?>%
            <?php else: ?>
                N/A
            <?php endif; ?>
        </div>
    </div>
</div>

<h2>Page Views by Day (Last 14 Days)</h2>
<table>
    <tr>
        <th>Day</th>
        <th>Views</th>
    </tr>
    <?php if (empty($pageViewsByDay)): ?>
        <tr><td colspan="2">No data</td></tr>
    <?php else: ?>
        <?php foreach ($pageViewsByDay as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['day']) ?></td>
                <td><?= htmlspecialchars($row['views']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<h2>Top Pages (Last 30 Days)</h2>
<table>
    <tr>
        <th>Path</th>
        <th>Views</th>
    </tr>
    <?php if (empty($topPages)): ?>
        <tr><td colspan="2">No data</td></tr>
    <?php else: ?>
        <?php foreach ($topPages as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['path']) ?></td>
                <td><?= htmlspecialchars($row['views']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<h2>Events by Type (Last 30 Days)</h2>
<table>
    <tr>
        <th>Event Name</th>
        <th>Count</th>
    </tr>
    <?php if (empty($eventsByType)): ?>
        <tr><td colspan="2">No data</td></tr>
    <?php else: ?>
        <?php foreach ($eventsByType as $row): ?>
            <tr>
                <td><?= htmlspecialchars($row['event_name']) ?></td>
                <td><?= htmlspecialchars($row['events_count']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

</body>
</html>