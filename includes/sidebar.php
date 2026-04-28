<?php
$items = [
    ['Dashboard', '/dashboard.php', 'bi-grid-1x2-fill', ['Super Admin','Principal','Accountant','Faculty','Librarian','Student']],
    ['Students', '/modules/students/index.php', 'bi-people-fill', ['Super Admin','Principal','Faculty']],
    ['Faculty', '/modules/faculty/index.php', 'bi-person-badge-fill', ['Super Admin','Principal','HR']],
    ['Courses', '/modules/courses/index.php', 'bi-journal-richtext', ['Super Admin','Principal','Faculty']],
    ['Attendance', '/modules/attendance/index.php', 'bi-clipboard2-check-fill', ['Super Admin','Principal','Faculty']],
    ['Fees', '/modules/fees/index.php', 'bi-cash-coin', ['Super Admin','Accountant','Principal']],
    ['Exams', '/modules/exams/index.php', 'bi-file-earmark-text-fill', ['Super Admin','Principal','Faculty']],
    ['Results', '/modules/results/index.php', 'bi-trophy-fill', ['Super Admin','Principal','Faculty']],
    ['Library', '/modules/library/index.php', 'bi-book-half', ['Super Admin','Librarian']],
    ['Hostel', '/modules/hostel/index.php', 'bi-house-door-fill', ['Super Admin','Principal']],
    ['Transport', '/modules/transport/index.php', 'bi-bus-front-fill', ['Super Admin','Principal']],
    ['HR', '/modules/hr/index.php', 'bi-person-workspace', ['Super Admin','Principal']],
    ['Notices', '/modules/notices/index.php', 'bi-megaphone-fill', ['Super Admin','Principal','Faculty']],
    ['Reports', '/modules/reports/index.php', 'bi-bar-chart-fill', ['Super Admin','Principal','Accountant']],
    ['Settings', '/modules/settings/index.php', 'bi-gear-fill', ['Super Admin','Principal','Accountant','Faculty','Librarian','Student']],
];
$curr = $_SERVER['SCRIPT_NAME'] ?? '';
?>
<aside id="sidebar" class="sidebar glass">
  <div class="brand"><i class="bi bi-mortarboard-fill"></i><span><?= APP_NAME ?></span></div>
  <nav>
    <?php foreach ($items as [$name,$path,$icon,$roles]): if (!hasRole($roles)) continue; ?>
      <a class="menu-link <?= str_contains($curr, trim($path, '/')) ? 'active' : '' ?>" href="<?= $path ?>"><i class="bi <?= $icon ?>"></i><span><?= e($name) ?></span></a>
    <?php endforeach; ?>
  </nav>
</aside>
