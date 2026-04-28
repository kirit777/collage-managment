<?php
$moduleTitle='Course & Curriculum';
$moduleSubtitle='Degree, diploma and certificate programs with fees and seat intake.';
$moduleContent='<div class="table-responsive"><table class="table"><thead><tr><th>Course</th><th>Duration</th><th>Seats</th><th>Annual Fee</th></tr></thead><tbody>';
foreach(array_slice(getDemoData()['courses'],0,10) as $c){$moduleContent.='<tr><td>'.e($c['name']).'</td><td>'.e($c['duration']).'</td><td>'.e((string)$c['seats']).'</td><td>₹'.number_format($c['fee']).'</td></tr>';}
$moduleContent.='</tbody></table></div>';
include __DIR__ . '/../_module.php';
