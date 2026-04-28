<?php
require_once __DIR__ . '/config/app.php';
if (!isInstalled()) { header('Location: /install.php'); exit; }
touchSession();
if (isset($_SESSION['user'])) { header('Location: /dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verifyCsrf();
    $email = filter_var(post('email'), FILTER_VALIDATE_EMAIL) ?: '';
    $password = post('password');
    $user = fetchOne('SELECT * FROM users WHERE email=? AND is_active=1', [$email]);
    if ($user && password_verify($password, $user['password_hash'])) {
        loginUser($user);
        executeSql('UPDATE users SET last_login_at=NOW() WHERE id=?', [$user['id']]);
        header('Location: /dashboard.php');
        exit;
    }
    $error = 'Invalid credentials.';
}
?>
<!doctype html><html lang="en"><head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login | <?= APP_NAME ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="/assets/css/style.css" rel="stylesheet"></head>
<body class="auth-page"><div class="auth-card glass">
<h4>Sign In</h4><?php if ($error): ?><div class="alert alert-danger"><?= e($error) ?></div><?php endif; ?>
<form method="post" class="vstack gap-2"><?= csrfField() ?>
<input class="form-control" name="email" type="email" placeholder="Email" required>
<input class="form-control" name="password" type="password" placeholder="Password" required>
<button class="btn btn-primary">Login</button>
<a href="/forgot-password.php" class="small">Forgot password?</a></form>
</div></body></html>
