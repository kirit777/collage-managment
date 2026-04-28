<?php
require_once __DIR__ . '/config.php';
if (isset($_SESSION['user'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitize($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (isset($demoUsers[$email]) && password_verify($password, $demoUsers[$email]['password'])) {
        $_SESSION['user'] = ['email' => $email, 'name' => $demoUsers[$email]['name'], 'role' => $demoUsers[$email]['role']];
        if ($remember) {
            setcookie('remember_email', $email, time() + (86400 * 30), '/');
        }
        header('Location: dashboard.php');
        exit;
    }
    $error = 'Invalid email or password.';
}
$remembered = $_COOKIE['remember_email'] ?? '';
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - <?= APP_NAME ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="auth-body">
<div class="auth-card shadow-lg">
    <h2 class="mb-2">Welcome Back</h2>
    <p class="text-muted">Sign in to continue to College ERP.</p>
    <?php if ($error): ?><div class="alert alert-danger"><?= $error ?></div><?php endif; ?>
    <form method="post">
        <div class="mb-3"><label>Email</label><input class="form-control" name="email" value="<?= sanitize($remembered) ?>" required></div>
        <div class="mb-3 position-relative"><label>Password</label><input type="password" class="form-control" id="password" name="password" required><button type="button" class="btn btn-sm btn-light pass-toggle" onclick="togglePassword()">Show</button></div>
        <div class="d-flex justify-content-between mb-3">
            <div class="form-check"><input class="form-check-input" type="checkbox" name="remember" id="remember"><label class="form-check-label" for="remember">Remember me</label></div>
            <span class="badge text-bg-primary">Admin/Staff/Student</span>
        </div>
        <button class="btn btn-primary w-100">Login</button>
    </form>
    <hr>
    <small class="text-muted d-block">Demo: admin@gmail.com / 123456</small>
    <small class="text-muted d-block">Demo: staff@gmail.com / 123456</small>
    <small class="text-muted d-block">Demo: student@gmail.com / 123456</small>
</div>
<script src="assets/js/script.js"></script>
</body>
</html>
