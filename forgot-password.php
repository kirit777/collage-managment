<?php
require_once __DIR__ . '/config/app.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = filter_var(post('email'), FILTER_VALIDATE_EMAIL) ?: '';
    $user = fetchOne('SELECT id FROM users WHERE email=?', [$email]);
    if ($user) {
        $temp = bin2hex(random_bytes(4));
        executeSql('UPDATE users SET password_hash=? WHERE id=?', [password_hash($temp, PASSWORD_DEFAULT), $user['id']]);
        $msg = 'Temporary password: ' . $temp . ' (change it immediately after login).';
    } else {
        $msg = 'Email not found.';
    }
}
?><!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4"><div class="container"><h3>Forgot Password</h3><?php if($msg):?><div class="alert alert-info"><?=e($msg)?></div><?php endif;?><form method="post"><?=csrfField()?><input name="email" class="form-control mb-2" type="email" required><button class="btn btn-primary">Reset</button></form></div></body></html>
