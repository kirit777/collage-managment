<?php
require_once __DIR__ . '/../../config/app.php'; requireAuth();
$id=(int)($_GET['id']??0); $s=fetchOne('SELECT s.*, c.name course_name FROM students s LEFT JOIN courses c ON c.id=s.course_id WHERE s.id=?',[$id]); if(!$s){exit('Student not found');}
?><!doctype html><html><head><meta charset="UTF-8"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4"><div class="container"><h3>Student Profile</h3><table class="table table-bordered"><?php foreach($s as $k=>$v):?><tr><th><?=e((string)$k)?></th><td><?=e((string)$v)?></td></tr><?php endforeach;?></table><button class="btn btn-secondary" onclick="window.print()">Print</button></div></body></html>
