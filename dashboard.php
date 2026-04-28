<?php
require_once __DIR__ . '/config/app.php';
requireAuth();
$pageTitle = 'Executive Dashboard';
$data = getDemoData();
$totalStudents = count($data['students']);
$totalFaculty = count($data['faculty']);
$newAdmissions = 67;
$monthlyRevenue = array_sum(array_map(fn($s) => $s['fee_paid'], $data['students']));
$pendingFees = array_sum(array_map(fn($s) => $s['fee_total'] - $s['fee_paid'], $data['students']));
$avgAttendance = round(array_sum(array_column($data['students'], 'attendance')) / $totalStudents);
$upcomingExams = 12;
$hostelOccupancy = round((array_sum(array_column($data['hostelRooms'], 'occupied')) / (count($data['hostelRooms']) * 3)) * 100);
$admissionsTrend = [120,130,145,160,158,172,169,180,192,201,211,225];
$monthly = [42,44,49,53,51,58,56,61,60,66,69,74];
include __DIR__ . '/includes/header.php';
include __DIR__ . '/includes/sidebar.php';
?>
<main class="content-wrap">
  <?php include __DIR__ . '/includes/topbar.php'; ?>
  <section class="dashboard-grid">
    <?php foreach ([
      ['Total Students',$totalStudents,'bi-people-fill'],['Active Faculty',$totalFaculty,'bi-person-badge-fill'],['New Admissions',$newAdmissions,'bi-person-plus-fill'],
      ['Monthly Revenue','₹' . number_format($monthlyRevenue),'bi-cash-stack'],['Pending Fees','₹' . number_format($pendingFees),'bi-exclamation-diamond-fill'],
      ['Avg Attendance',$avgAttendance . '%','bi-clipboard2-check-fill'],['Upcoming Exams',$upcomingExams,'bi-calendar2-week-fill'],['Hostel Occupancy',$hostelOccupancy . '%','bi-house-door-fill'],
    ] as $kpi): ?>
      <article class="kpi panel glass"><p><?= e($kpi[0]) ?></p><h3><?= e((string) $kpi[1]) ?></h3><i class="bi <?= e($kpi[2]) ?> text-primary"></i></article>
    <?php endforeach; ?>

    <article class="panel glass span-8"><h6>Admissions Trend</h6><canvas id="admissionsChart" data-values='<?= json_encode($admissionsTrend) ?>'></canvas></article>
    <article class="panel glass span-4"><h6>Course-wise Students</h6><canvas id="courseChart"></canvas></article>
    <article class="panel glass span-12"><h6>Revenue Monthly (Lakhs)</h6><canvas id="revenueChart" data-values='<?= json_encode($monthly) ?>'></canvas></article>

    <article class="panel glass span-8">
      <div class="d-flex justify-content-between mb-2"><h6 class="m-0">Recent Admissions</h6><span class="badge badge-soft">Live</span></div>
      <div class="table-responsive"><table class="table align-middle"><thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Semester</th><th>Status</th></tr></thead><tbody>
      <?php foreach (array_slice($data['students'], 0, 8) as $s): ?><tr data-search="<?= e($s['name'] . ' ' . $s['course']) ?>"><td><?= e((string) $s['id']) ?></td><td><?= e($s['name']) ?></td><td><?= e($s['course']) ?></td><td><?= e((string) $s['semester']) ?></td><td><span class="badge text-bg-success">Approved</span></td></tr><?php endforeach; ?>
      </tbody></table></div>
    </article>

    <article class="panel glass span-4">
      <h6>Quick Actions</h6>
      <div class="d-grid gap-2">
        <a class="btn btn-outline-primary" href="/modules/students/index.php">Add Student</a>
        <a class="btn btn-outline-primary" href="/modules/fees/index.php">Add Fee</a>
        <a class="btn btn-outline-primary" href="/modules/attendance/index.php">Mark Attendance</a>
        <a class="btn btn-outline-primary" href="/modules/notices/index.php">Publish Notice</a>
      </div>
    </article>
  </section>
</main>
<?php include __DIR__ . '/includes/footer.php'; ?>
