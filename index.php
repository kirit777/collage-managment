<?php
require_once __DIR__ . '/config/app.php';
header('Location: ' . (isset($_SESSION['user']) ? '/dashboard.php' : '/login.php'));
exit;
