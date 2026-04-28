<?php
$menu = [
    'Dashboard' => ['/dashboard.php', 'bi-grid-1x2-fill'],
    'Admissions' => ['/modules/admissions/index.php', 'bi-person-plus-fill'],
    'Students' => ['/modules/students/index.php', 'bi-people-fill'],
    'Faculty' => ['/modules/faculty/index.php', 'bi-person-badge-fill'],
    'Departments' => ['/modules/departments/index.php', 'bi-diagram-3-fill'],
    'Courses' => ['/modules/courses/index.php', 'bi-journal-richtext'],
    'Attendance' => ['/modules/attendance/index.php', 'bi-clipboard2-check-fill'],
    'Timetable' => ['/modules/timetable/index.php', 'bi-calendar3'],
    'Fees' => ['/modules/fees/index.php', 'bi-cash-coin'],
    'Accounts' => ['/modules/accounts/index.php', 'bi-wallet2'],
    'Exams' => ['/modules/exams/index.php', 'bi-file-earmark-text-fill'],
    'Results' => ['/modules/results/index.php', 'bi-trophy-fill'],
    'Library' => ['/modules/library/index.php', 'bi-book-half'],
    'Hostel' => ['/modules/hostel/index.php', 'bi-house-door-fill'],
    'Transport' => ['/modules/transport/index.php', 'bi-bus-front-fill'],
    'HR' => ['/modules/hr/index.php', 'bi-person-workspace'],
    'Reports' => ['/modules/reports/index.php', 'bi-bar-chart-fill'],
    'Settings' => ['/modules/settings/index.php', 'bi-gear-fill'],
];
$curr = $_SERVER['SCRIPT_NAME'] ?? '';
?>
<aside id="sidebar" class="sidebar glass">
    <div class="brand"><i class="bi bi-mortarboard-fill"></i><span>Nimbus College</span></div>
    <nav>
        <?php foreach ($menu as $name => [$path, $icon]): ?>
            <a class="menu-link <?= str_contains($curr, trim($path, '/')) ? 'active' : '' ?>" href="<?= $path ?>"><i class="bi <?= $icon ?>"></i><span><?= $name ?></span></a>
        <?php endforeach; ?>
    </nav>
</aside>
