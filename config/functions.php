<?php
declare(strict_types=1);

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function post(string $key, string $default = ''): string
{
    return trim((string) ($_POST[$key] ?? $default));
}

function get(string $key, string $default = ''): string
{
    return trim((string) ($_GET[$key] ?? $default));
}

function csrfToken(): string
{
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string
{
    return '<input type="hidden" name="csrf_token" value="' . e(csrfToken()) . '">';
}

function verifyCsrf(): void
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', (string) $token)) {
            http_response_code(419);
            exit('CSRF validation failed.');
        }
    }
}

function flash(string $key, ?string $value = null): ?string
{
    if ($value !== null) {
        $_SESSION['_flash'][$key] = $value;
        return null;
    }
    $msg = $_SESSION['_flash'][$key] ?? null;
    unset($_SESSION['_flash'][$key]);
    return $msg;
}

function fetchAll(string $sql, array $params = []): array
{
    $pdo = getDbConnection();
    if (!$pdo) {
        return [];
    }
    $st = $pdo->prepare($sql);
    $st->execute($params);
    return $st->fetchAll();
}

function fetchOne(string $sql, array $params = []): ?array
{
    $rows = fetchAll($sql, $params);
    return $rows[0] ?? null;
}

function executeSql(string $sql, array $params = []): bool
{
    $pdo = getDbConnection();
    if (!$pdo) {
        return false;
    }
    $st = $pdo->prepare($sql);
    return $st->execute($params);
}
