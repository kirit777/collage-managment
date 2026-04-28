<?php
declare(strict_types=1);

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

const SESSION_TIMEOUT_SECONDS = 3600;

function touchSession(): void
{
    $now = time();
    if (isset($_SESSION['last_activity']) && ($now - (int) $_SESSION['last_activity']) > SESSION_TIMEOUT_SECONDS) {
        session_unset();
        session_destroy();
        session_start();
    }
    $_SESSION['last_activity'] = $now;
}

function loginUser(array $user): void
{
    session_regenerate_id(true);
    $_SESSION['user'] = [
        'id' => (int) $user['id'],
        'name' => $user['full_name'],
        'email' => $user['email'],
        'role' => $user['role'],
    ];
    $_SESSION['last_activity'] = time();
}

function logoutUser(): void
{
    session_unset();
    session_destroy();
}

function requireAuth(): void
{
    touchSession();
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
