<?php

function updateSession(PDO $pdo, string $sessionId, ?int $userId): void {
    $ip = $_SERVER['REMOTE_ADDR'] ?? null;
    $ua = $_SERVER['HTTP_USER_AGENT'] ?? null;

    $sql = "
        INSERT INTO web_sessions (session_id, user_id, ip_address, user_agent, last_seen_at)
        VALUES (:session_id, :user_id, :ip, :ua, NOW())
        ON CONFLICT (session_id) DO UPDATE
        SET last_seen_at = NOW(),
            user_id = COALESCE(EXCLUDED.user_id, web_sessions.user_id),
            ip_address = EXCLUDED.ip_address,
            user_agent = EXCLUDED.user_agent
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':session_id' => $sessionId,
        ':user_id' => $userId,
        ':ip' => $ip,
        ':ua' => $ua,
    ]);
}

function logPageView(PDO $pdo, string $sessionId, ?int $userId): void {
    $path = $_SERVER['REQUEST_URI'] ?? '/';
    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $referrer = $_SERVER['HTTP_REFERER'] ?? null;
    $statusCode = http_response_code();

    $sql = "
        INSERT INTO page_views (session_id, user_id, path, http_method, status_code, referrer)
        VALUES (:session_id, :user_id, :path, :method, :status_code, :referrer)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':session_id' => $sessionId,
        ':user_id' => $userId,
        ':path' => $path,
        ':method' => $method,
        ':status_code' => $statusCode,
        ':referrer' => $referrer
    ]);
}

function logEvent(PDO $pdo, string $sessionId, ?int $userId, string $eventName, ?string $eventData = null): void {

    $sql = "
        INSERT INTO web_events (session_id, user_id, event_name, event_data)
        VALUES (:session_id, :user_id, :event_name, :event_data)
    ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        ':session_id' => $sessionId,
        ':user_id' => $userId,
        ':event_name' => $eventName,
        ':event_data' => $eventData,
    ]);
}

?>