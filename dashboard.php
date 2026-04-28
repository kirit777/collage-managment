<?php
require_once __DIR__ . '/config.php';
requireLogin();
$pageTitle = 'Dashboard';
$assetPrefix = '';
$totalStudents = count($students);
$totalTeachers = count($teachers);
$totalCourses = count($courses);
$totalFeesCollected = array_sum(array_column($students, 'fees'));
$totalPending = array_sum(array_map(fn($s) => $s['total_fee'] - $s['fees'], $students));
$avgAttendance = round(array_sum($attendanceTrend) / count($attendanceTrend));
?>
<?php include __DIR__ . '/includes/header.php'; ?>
<?php include __DIR__ . '/includes/sidebar.php'; ?>
<main class="main-content">
    <header class="topbar">
        <button class="btn btn-light" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
        <input class="form-control search-bar" placeholder="Search modules, students, notices..." />
        <div class="d-flex align-items-center gap-2">
            <button class="btn btn-light position-relative"><i class="bi bi-bell"></i><span class="dot"></span></button>
            <button class="btn btn-dark" onclick="toggleTheme()"><i class="bi bi-moon-stars"></i></button>
            <div class="dropdown"><button class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"><?= sanitize($_SESSION['user']['name']) ?></button><ul class="dropdown-menu dropdown-menu-end"><li><span class="dropdown-item-text"><?= sanitize($_SESSION['user']['role']) ?></span></li><li><a class="dropdown-item" href="logout.php">Logout</a></li></ul></div>
        </div>
    </header>

    <section class="row g-3 mb-3">
        <?php
        $cards = [
            ['Total Students', $totalStudents, 'bi-people'],
            ['Total Teachers', $totalTeachers, 'bi-person-badge'],
            ['Courses', $totalCourses, 'bi-journal-bookmark'],
            ['Fees Collected', currency($totalFeesCollected), 'bi-cash-coin'],
            ['Pending Fees', currency($totalPending), 'bi-exclamation-circle'],
            ['Attendance %', $avgAttendance . '%', 'bi-clipboard2-check'],
            ['Upcoming Exams', 6, 'bi-calendar-event'],
            ['Library Books', count($books), 'bi-book'],
        ];
        foreach ($cards as [$title, $value, $icon]): ?>
            <div class="col-6 col-md-4 col-xl-3"><div class="card card-stat"><div><small><?= $title ?></small><h4><?= $value ?></h4></div><i class="bi <?= $icon ?>"></i></div></div>
        <?php endforeach; ?>
    </section>

    <section class="row g-3">
        <div class="col-lg-8"><div class="card p-3"><h6>Monthly Admissions</h6><canvas id="admissionChart" data-values='<?= json_encode($monthlyAdmissions) ?>'></canvas></div></div>
        <div class="col-lg-4"><div class="card p-3"><h6>Attendance Trend</h6><canvas id="attendanceChart" data-values='<?= json_encode($attendanceTrend) ?>'></canvas></div></div>
        <div class="col-lg-12"><div class="card p-3"><h6>Fee Collection (in Lakhs)</h6><canvas id="feeChart" data-values='<?= json_encode($feeCollection) ?>'></canvas></div></div>
    </section>

    <section class="card p-3 mt-3">
        <h6>Recent Activity</h6>
        <ul class="activity-list">
            <li>✅ New Admission: Aarav Sharma enrolled in BCA.</li>
            <li>💳 Fee Paid: Meera Singh paid semester installment.</li>
            <li>📢 New Notice: Exam Date Declared for MBA Semester II.</li>
            <li>🗓️ Exam Scheduled: BBA Internal on May 10, 2026.</li>
        </ul>
    </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
