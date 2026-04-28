<?php require_once __DIR__ . '/../config.php'; requireLogin(); $pageTitle='Courses'; $assetPrefix='../'; ?>
<?php include __DIR__ . '/../includes/header.php'; include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content"><header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5>Course Management</h5><button class="btn btn-primary">+ Add Course</button></header>
<div class="table-card"><table class="table table-striped"><thead><tr><th>Course</th><th>Duration</th><th>Fees</th><th>Subjects</th><th>Seats</th><th>Teacher</th></tr></thead><tbody><?php foreach($courses as $c): ?><tr><td><?= $c['name'] ?></td><td><?= $c['duration'] ?></td><td><?= currency($c['fees']) ?></td><td><?= $c['subjects'] ?></td><td><?= $c['seats'] ?></td><td><?= sanitize($c['teacher']) ?></td></tr><?php endforeach; ?></tbody></table></div></main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
