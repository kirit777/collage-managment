<?php
require_once __DIR__ . '/config/app.php';
if (!isInstalled()) {
    header('Location: /install.php');
    exit;
}
header('Location: ' . (isset($_SESSION['user']) ? '/dashboard.php' : '/login.php'));
exit;
