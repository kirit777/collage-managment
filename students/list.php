<?php
require_once __DIR__ . '/../config.php';
requireLogin();
$pageTitle = 'Students';
$assetPrefix = '../';
$search = strtolower(sanitize($_GET['search'] ?? ''));
$filterCourse = sanitize($_GET['course'] ?? '');
$filtered = array_filter($students, function ($s) use ($search, $filterCourse) {
    $matchSearch = $search === '' || str_contains(strtolower($s['name']), $search) || str_contains(strtolower($s['email']), $search);
    $matchCourse = $filterCourse === '' || $s['course'] === $filterCourse;
    return $matchSearch && $matchCourse;
});
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="students.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['ID', 'Name', 'Email', 'Course', 'Year', 'Fees', 'Status']);
    foreach ($filtered as $row) fputcsv($out, [$row['id'], $row['name'], $row['email'], $row['course'], $row['year'], $row['fees'], $row['status']]);
    fclose($out);
    exit;
}
?>
<?php include __DIR__ . '/../includes/header.php'; ?>
<?php include __DIR__ . '/../includes/sidebar.php'; ?>
<main class="main-content">
    <header class="topbar"><button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button><h5 class="m-0">Students</h5><a href="add.php" class="btn btn-primary">+ Add Student</a></header>
    <form class="card p-3 mb-3 d-flex flex-md-row gap-2">
        <input class="form-control" name="search" value="<?= sanitize($_GET['search'] ?? '') ?>" placeholder="Live search student">
        <select class="form-select" name="course"><option value="">All courses</option><?php foreach ($courses as $c): ?><option <?= $filterCourse === $c['name'] ? 'selected' : '' ?>><?= $c['name'] ?></option><?php endforeach; ?></select>
        <button class="btn btn-outline-primary">Filter</button><a class="btn btn-success" href="?export=csv">Export CSV</a>
    </form>
    <div class="table-card">
        <table class="table table-hover align-middle">
            <thead><tr><th>ID</th><th>Photo</th><th>Name</th><th>Email</th><th>Course</th><th>Year</th><th>Fees</th><th>Status</th><th>Action</th></tr></thead>
            <tbody><?php foreach ($filtered as $s): ?><tr>
                <td><?= $s['id'] ?></td><td><img src="<?= $s['photo'] ?>" class="avatar" alt=""></td><td><?= sanitize($s['name']) ?></td><td><?= sanitize($s['email']) ?></td>
                <td><?= $s['course'] ?></td><td><?= $s['year'] ?></td><td><?= currency($s['fees']) ?></td><td><span class="badge <?= $s['status'] === 'Active' ? 'text-bg-success' : 'text-bg-secondary' ?>"><?= $s['status'] ?></span></td>
                <td><a class="btn btn-sm btn-outline-primary" href="edit.php?id=<?= $s['id'] ?>">Edit</a> <button class="btn btn-sm btn-outline-danger" onclick="demoDelete()">Delete</button></td>
            </tr><?php endforeach; ?></tbody>
        </table>
    </div>
</main>
<?php include __DIR__ . '/../includes/footer.php'; ?>
