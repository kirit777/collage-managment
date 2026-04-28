<?php
$moduleTitle='Faculty Management';
$moduleSubtitle='Department mapping, workload and payroll linked profiles.';
$moduleContent='<div class="table-responsive"><table class="table"><thead><tr><th>ID</th><th>Name</th><th>Department</th><th>Experience</th><th>Salary</th></tr></thead><tbody>';
foreach(array_slice(getDemoData()['faculty'],0,12) as $f){$moduleContent.='<tr><td>'.e((string)$f['id']).'</td><td>'.e($f['name']).'</td><td>'.e($f['department']).'</td><td>'.e($f['experience']).'</td><td>₹'.number_format($f['salary']).'</td></tr>';}
$moduleContent.='</tbody></table></div>';
include __DIR__ . '/../_module.php';
