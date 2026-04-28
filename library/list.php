<?php require_once __DIR__ . '/../config.php'; requireLogin(); $pageTitle='Library'; $assetPrefix='../'; ?>
<?php include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content"><header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5>Library Management</h5><button class="btn btn-primary">+ Add Book</button></header>
<div class="table-card"><table class="table"><thead><tr><th>Book ID</th><th>Title</th><th>Author</th><th>Quantity</th><th>Status</th></tr></thead><tbody><?php foreach($books as $b): ?><tr><td><?= $b['id'] ?></td><td><?= sanitize($b['title']) ?></td><td><?= sanitize($b['author']) ?></td><td><?= $b['quantity'] ?></td><td><?= $b['status'] ?></td></tr><?php endforeach; ?></tbody></table></div></main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
