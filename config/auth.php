<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function requireAuth(): void
{
    if (!isset($_SESSION['user'])) {
        header('Location: /login.php');
        exit;
    }
}

function hasRole(array|string $roles): bool
{
    $roles = (array) $roles;
    return isset($_SESSION['user']['role']) && in_array($_SESSION['user']['role'], $roles, true);
}

function roleGuard(array|string $roles): void
{
    if (!hasRole($roles)) {
        http_response_code(403);
        exit('Unauthorized');
    }
}
