<?php
require_once __DIR__ . '/../config.php';
requireLogin();
$pageTitle = 'Add Student';
$assetPrefix = '../';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitize($_POST['name'] ?? '');
    $email = sanitize($_POST['email'] ?? '');
    if ($name && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $success = 'Student added successfully (demo mode: not persisted).';
    }
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content"><header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5>Add Student</h5><a href="list.php" class="btn btn-outline-secondary">Back</a></header>
<div class="card p-3"><?php if ($success): ?><div class="alert alert-success"><?= $success ?></div><?php endif; ?>
<form method="post" class="row g-3">
<div class="col-md-6"><label>Name</label><input class="form-control" name="name" required></div>
<div class="col-md-6"><label>Email</label><input class="form-control" type="email" name="email" required></div>
<div class="col-md-4"><label>Course</label><select class="form-select" name="course"><?php foreach ($courses as $c): ?><option><?= $c['name'] ?></option><?php endforeach; ?></select></div>
<div class="col-md-4"><label>DOB</label><input class="form-control" type="date" name="dob"></div>
<div class="col-md-4"><label>Contact</label><input class="form-control" name="contact"></div>
<div class="col-md-6"><label>Parent Details</label><input class="form-control" name="parent"></div>
<div class="col-md-6"><label>Address</label><input class="form-control" name="address"></div>
<div class="col-md-12"><label>Upload Photo</label><input class="form-control" type="file" name="photo"></div>
<div class="col-md-12"><button class="btn btn-primary">Save Student</button></div>
</form></div></main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
