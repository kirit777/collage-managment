<?php
require_once __DIR__ . '/config/app.php';
if (isset($_SESSION['user'])) {
    header('Location: /dashboard.php');
    exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var($_POST['email'] ?? '', FILTER_VALIDATE_EMAIL) ?: '';
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if (isset($demoUsers[$email]) && password_verify($password, $demoUsers[$email]['password'])) {
        $_SESSION['user'] = ['email' => $email, 'name' => $demoUsers[$email]['name'], 'role' => $demoUsers[$email]['role'], 'last_login' => date('Y-m-d H:i:s')];
        if ($remember) {
            setcookie('remember_email', $email, time() + 86400 * 30, '/');
        }
        header('Location: /dashboard.php');
        exit;
    }

    $error = 'Invalid credentials. Please check email and password.';
}
$rememberedEmail = $_COOKIE['remember_email'] ?? '';
?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | <?= APP_NAME ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
  <link href="/assets/css/style.css" rel="stylesheet">
</head>
<body class="auth-page">
  <div class="auth-card glass">
    <h3 class="fw-bold">Welcome back</h3>
    <p class="text-muted">Sign in to continue to <?= APP_NAME ?></p>
    <?php if ($error): ?><div class="alert alert-danger py-2"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="vstack gap-3">
      <div><label class="form-label">Email</label><input type="email" name="email" required class="form-control" value="<?= e($rememberedEmail) ?>"></div>
      <div><label class="form-label">Password</label><input type="password" name="password" required class="form-control"></div>
      <div class="d-flex justify-content-between">
        <label class="form-check"><input type="checkbox" class="form-check-input" name="remember"> <span class="form-check-label">Remember me</span></label>
        <a href="#" class="text-decoration-none small">Forgot password?</a>
      </div>
      <button class="btn btn-primary">Secure Login</button>
    </form>
    <hr>
    <small class="d-block text-muted">Demo: admin@college.com / 123456</small>
    <small class="d-block text-muted">Demo: faculty@college.com / 123456</small>
    <small class="d-block text-muted">Demo: student@college.com / 123456</small>
  </div>
  <script src="/assets/js/script.js"></script>
</body>
</html>
