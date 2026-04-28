<?php require_once __DIR__ . '/../config.php'; requireLogin(); $pageTitle='Notices'; $assetPrefix='../'; ?>
<?php include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content"><header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5>Notice Board</h5><button class="btn btn-primary">+ Add Notice</button></header>
<div class="card p-3"><ul class="list-group"><?php foreach($notices as $n): ?><li class="list-group-item d-flex justify-content-between"><div><strong><?= sanitize($n['title']) ?></strong><br><small><?= $n['date'] ?></small></div><span class="badge text-bg-info"><?= $n['priority'] ?></span></li><?php endforeach; ?></ul></div></main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
