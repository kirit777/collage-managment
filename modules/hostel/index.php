<?php
$moduleTitle='Hostel Administration';
$moduleSubtitle='Room occupancy, wardens, vacant rooms and mess fee status.';
$moduleContent='<div class="table-responsive"><table class="table"><thead><tr><th>Room</th><th>Capacity</th><th>Occupied</th><th>Warden</th></tr></thead><tbody>';
foreach(getDemoData()['hostelRooms'] as $r){$moduleContent.='<tr><td>'.e($r['room']).'</td><td>'.e((string)$r['capacity']).'</td><td><span class="badge '.($r['occupied']<$r['capacity']?'text-bg-success':'text-bg-danger').'">'.e((string)$r['occupied']).'</span></td><td>'.e($r['warden']).'</td></tr>';}
$moduleContent.='</tbody></table></div>';
include __DIR__ . '/../_module.php';
