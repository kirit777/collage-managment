<?php
require_once __DIR__ . '/config.php';
session_unset();
session_destroy();
setcookie('remember_email', '', time() - 3600, '/');
header('Location: login.php');
exit;
