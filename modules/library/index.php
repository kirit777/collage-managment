<?php
$moduleTitle='Library Management';
$moduleSubtitle='Inventory, issue/return, fines and author/title search.';
$moduleContent='<div class="table-responsive"><table class="table"><thead><tr><th>Book ID</th><th>Title</th><th>Author</th><th>Status</th></tr></thead><tbody>';
foreach(array_slice(getDemoData()['books'],0,12) as $b){$moduleContent.='<tr><td>'.e($b['id']).'</td><td>'.e($b['title']).'</td><td>'.e($b['author']).'</td><td><span class="badge '.($b['status']==='Available'?'text-bg-success':'text-bg-warning').'">'.$b['status'].'</span></td></tr>';}
$moduleContent.='</tbody></table></div>';
include __DIR__ . '/../_module.php';
