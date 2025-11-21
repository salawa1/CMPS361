<?php

function csrf_token(): string {
    return $_SESSION['csrf'] ?? '';
}

function csrf_check(string $token): bool {
    return isset($_SESSION['csrf']) && hash_equals($_SESSION['csrf'], $token);
}