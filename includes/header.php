<?php require_once __DIR__ . '/../config.php'; requireLogin(); ?>
<!doctype html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= APP_NAME ?> - <?= sanitize($pageTitle ?? 'Dashboard') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= ($assetPrefix ?? '') ?>assets/css/style.css">
</head>
<body>
<div id="loader"><div class="spinner-border text-primary"></div></div>
<div class="app-shell">
