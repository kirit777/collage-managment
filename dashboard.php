<?php
require_once __DIR__ . '/config/app.php';
requireAuth();
$pageTitle = 'Dashboard';
$counts = [
  'students' => fetchOne('SELECT COUNT(*) c FROM students')['c'] ?? 0,
  'faculty' => fetchOne('SELECT COUNT(*) c FROM faculty')['c'] ?? 0,
  'payments' => fetchOne('SELECT COALESCE(SUM(amount),0) c FROM payments')['c'] ?? 0,
  'books' => fetchOne('SELECT COUNT(*) c FROM books')['c'] ?? 0,
];
$admissions = fetchAll('SELECT DATE_FORMAT(admission_date, "%b") m, COUNT(*) c FROM students GROUP BY DATE_FORMAT(admission_date, "%Y-%m") ORDER BY MIN(admission_date) LIMIT 12');
$labels = array_column($admissions, 'm');
$values = array_map('intval', array_column($admissions, 'c'));
include __DIR__ . '/includes/header.php'; include __DIR__ . '/includes/sidebar.php';
?><main class="content-wrap"><?php include __DIR__ . '/includes/topbar.php'; ?>
<?php if ($m = flash('success')): ?><div class="alert alert-success"><?= e($m) ?></div><?php endif; ?>
<section class="dashboard-grid">
<?php foreach ([['Students',$counts['students'],'bi-people'],['Faculty',$counts['faculty'],'bi-person-badge'],['Revenue','₹'.number_format((float)$counts['payments'],2),'bi-cash-stack'],['Books',$counts['books'],'bi-book']] as $k): ?>
<article class="kpi panel glass"><p><?=e($k[0])?></p><h3><?=e((string)$k[1])?></h3><i class="bi <?=$k[2]?>"></i></article>
<?php endforeach; ?>
<article class="panel glass span-12"><h6>Admissions Trend</h6><canvas id="admissionsChart" data-labels='<?= json_encode($labels) ?>' data-values='<?= json_encode($values) ?>'></canvas></article>
</section></main><?php include __DIR__ . '/includes/footer.php'; ?>
