<?php require_once __DIR__.'/../../config/app.php'; requireAuth(); $pageTitle='Reports';
$stats=[
 'students'=>fetchOne('SELECT COUNT(*) c FROM students')['c']??0,
 'fees_pending'=>fetchOne('SELECT COUNT(*) c FROM fees_invoices WHERE status!="Paid"')['c']??0,
 'attendance'=>fetchOne('SELECT ROUND(100*SUM(status="Present")/COUNT(*),2) c FROM attendance_students')['c']??0,
 'toppers'=>fetchAll('SELECT s.full_name,MAX(r.percentage) pct FROM results r JOIN students s ON s.id=r.student_id GROUP BY s.id ORDER BY pct DESC LIMIT 5'),
 'salary'=>fetchOne('SELECT COALESCE(SUM(salary),0) c FROM faculty')['c']??0,
 'revenue'=>fetchAll('SELECT DATE_FORMAT(paid_at,"%Y-%m") m,SUM(amount) amt FROM payments GROUP BY DATE_FORMAT(paid_at,"%Y-%m") ORDER BY m DESC LIMIT 12'),
];
if(get('export')==='csv'){header('Content-Type:text/csv');header('Content-Disposition:attachment; filename=report.csv');$o=fopen('php://output','w');fputcsv($o,['Metric','Value']);fputcsv($o,['Total Students',$stats['students']]);fputcsv($o,['Fees Pending',$stats['fees_pending']]);fputcsv($o,['Attendance %',$stats['attendance']]);fclose($o);exit;}
include __DIR__.'/../../includes/header.php'; include __DIR__.'/../../includes/sidebar.php'; ?><main class="content-wrap"><?php include __DIR__.'/../../includes/topbar.php'; ?><section class="panel glass"><a class="btn btn-success" href="?export=csv">CSV</a> <button class="btn btn-secondary" onclick="window.print()">Print</button><div class="row mt-3"><div class="col-md-4"><div class="card p-3"><h6>Total Students</h6><h3><?=$stats['students']?></h3></div></div><div class="col-md-4"><div class="card p-3"><h6>Fees Pending</h6><h3><?=$stats['fees_pending']?></h3></div></div><div class="col-md-4"><div class="card p-3"><h6>Attendance %</h6><h3><?=$stats['attendance']?></h3></div></div></div><hr><h5>Exam Toppers</h5><table class="table"><?php foreach($stats['toppers'] as $t):?><tr><td><?=e($t['full_name'])?></td><td><?=$t['pct']?>%</td></tr><?php endforeach;?></table></section></main><?php include __DIR__.'/../../includes/footer.php'; ?>
