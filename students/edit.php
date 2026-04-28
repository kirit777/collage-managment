<?php
require_once __DIR__ . '/../config.php';
requireLogin();
$pageTitle = 'Edit Student';
$assetPrefix = '../';
$id = (int)($_GET['id'] ?? 0);
$student = current(array_filter($students, fn($s) => $s['id'] === $id));
if (!$student) { $student = $students[0]; }
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') $success = 'Student updated successfully (demo mode).';
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content"><header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5>Edit Student</h5><a href="list.php" class="btn btn-outline-secondary">Back</a></header>
<div class="card p-3"><?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<form method="post" class="row g-3">
<div class="col-md-6"><label>Name</label><input class="form-control" value="<?= sanitize($student['name']) ?>"></div>
<div class="col-md-6"><label>Email</label><input class="form-control" value="<?= sanitize($student['email']) ?>"></div>
<div class="col-md-6"><label>Course</label><input class="form-control" value="<?= sanitize($student['course']) ?>"></div>
<div class="col-md-6"><label>Status</label><select class="form-select"><option>Active</option><option>Inactive</option></select></div>
<div class="col-12"><button class="btn btn-primary">Update</button></div>
</form></div></main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
