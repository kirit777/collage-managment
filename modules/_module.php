<?php
require_once __DIR__ . '/../config/app.php';
requireAuth();
$pageTitle = $moduleTitle ?? 'Module';
$data = getDemoData();
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../includes/sidebar.php';
?>
<main class="content-wrap">
  <?php include __DIR__ . '/../includes/topbar.php'; ?>
  <section class="panel glass">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div><h4 class="mb-0"><?= e($moduleTitle) ?></h4><small class="text-muted"><?= e($moduleSubtitle) ?></small></div>
      <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm"><i class="bi bi-plus-lg"></i> Add New</button>
        <button class="btn btn-outline-secondary btn-sm"><i class="bi bi-download"></i> Export</button>
      </div>
    </div>
    <?= $moduleContent ?>
  </section>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
