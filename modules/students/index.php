<?php
$moduleTitle='Student Lifecycle';
$moduleSubtitle='Profile, guardians, academic history, fees and attendance.';
$moduleContent = '<div class="table-responsive"><table class="table"><thead><tr><th>Student ID</th><th>Name</th><th>Course</th><th>Attendance</th><th>Fee Status</th></tr></thead><tbody>';
foreach(array_slice(getDemoData()['students'],0,12) as $s){$moduleContent .= '<tr data-search="'.e($s['name']).'"><td>'.e((string)$s['id']).'</td><td>'.e($s['name']).'</td><td>'.e($s['course']).'</td><td><span class="badge text-bg-info">'.e((string)$s['attendance']).'%</span></td><td><span class="badge '.(($s['fee_total']-$s['fee_paid'])>25000?'text-bg-danger':'text-bg-success').'">'.(($s['fee_total']-$s['fee_paid'])>25000?'Pending':'Clear').'</span></td></tr>';} 
$moduleContent .= '</tbody></table></div>';
include __DIR__ . '/../_module.php';
