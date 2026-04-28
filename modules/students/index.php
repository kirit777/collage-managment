<?php
require_once __DIR__ . '/../../config/app.php';
requireAuth();
roleGuard(['Super Admin','Principal','Faculty']);
$pageTitle='Students';
$pdo = getDbConnection();
if (!$pdo) { exit('Database not connected. Run install.'); }

if (isset($_GET['delete'])) {
    executeSql('DELETE FROM students WHERE id=?', [(int)$_GET['delete']]);
    flash('success','Student deleted.'); header('Location: /modules/students/index.php'); exit;
}

if ($_SERVER['REQUEST_METHOD']==='POST') {
    verifyCsrf();
    $id=(int)($_POST['id']??0);
    $photo = $_POST['existing_photo'] ?? null;
    if (!empty($_FILES['photo']['name'])) {
        $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
        $name = 'student_' . time() . '_' . mt_rand(100,999) . '.' . $ext;
        $dest = __DIR__ . '/../../assets/uploads/' . $name;
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $dest)) $photo = '/assets/uploads/' . $name;
    }
    $data=[post('full_name'),post('email'),post('phone'),post('dob'),post('gender','Other'),post('address'),post('guardian_name'),post('guardian_phone'),(int)post('course_id','0')?:null,(int)post('semester','1'),post('admission_date'),post('fees_status','Pending'),$photo];
    if ($id>0) {
        $data[]=$id;
        executeSql('UPDATE students SET full_name=?,email=?,phone=?,dob=?,gender=?,address=?,guardian_name=?,guardian_phone=?,course_id=?,semester=?,admission_date=?,fees_status=?,photo=? WHERE id=?',$data);
        flash('success','Student updated.');
    } else {
        $code = 'STD' . date('Y') . str_pad((string)random_int(1,99999),5,'0',STR_PAD_LEFT);
        executeSql('INSERT INTO students(student_code,full_name,email,phone,dob,gender,address,guardian_name,guardian_phone,course_id,semester,admission_date,fees_status,photo) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)',array_merge([$code],$data));
        flash('success','Student added.');
    }
    header('Location: /modules/students/index.php'); exit;
}

$q = get('q'); $course = (int) get('course_id','0'); $page=max(1,(int)get('page','1')); $per=10; $off=($page-1)*$per;
$where=' WHERE 1=1 ';$params=[];
if($q!==''){ $where.=' AND (s.full_name LIKE ? OR s.email LIKE ?)'; $params[]="%$q%"; $params[]="%$q%"; }
if($course>0){ $where.=' AND s.course_id=?'; $params[]=$course; }
$total=fetchOne('SELECT COUNT(*) c FROM students s'.$where,$params)['c']??0;
$list=fetchAll('SELECT s.*, c.name course_name FROM students s LEFT JOIN courses c ON c.id=s.course_id'.$where.' ORDER BY s.id DESC LIMIT '.$per.' OFFSET '.$off,$params);
$courses=fetchAll('SELECT id,name FROM courses ORDER BY name');
if(get('export')==='csv'){
    header('Content-Type:text/csv'); header('Content-Disposition:attachment; filename=students.csv');
    $out=fopen('php://output','w'); fputcsv($out,['Code','Name','Email','Phone','Course','Semester','Fee Status']);
    foreach($list as $r){fputcsv($out,[$r['student_code'],$r['full_name'],$r['email'],$r['phone'],$r['course_name'],$r['semester'],$r['fees_status']]);}
    fclose($out); exit;
}
$edit = get('edit') ? fetchOne('SELECT * FROM students WHERE id=?',[(int)get('edit')]) : null;
include __DIR__.'/../../includes/header.php'; include __DIR__.'/../../includes/sidebar.php'; ?>
<main class="content-wrap"><?php include __DIR__.'/../../includes/topbar.php'; ?>
<?php if($m=flash('success')):?><div class="alert alert-success"><?=e($m)?></div><?php endif; ?>
<section class="panel glass mb-3"><h5><?= $edit?'Edit':'Add' ?> Student</h5>
<form method="post" enctype="multipart/form-data" class="row g-2"><?=csrfField()?><input type="hidden" name="id" value="<?=$edit['id']??0?>"><input type="hidden" name="existing_photo" value="<?=e($edit['photo']??'')?>">
<div class="col-md-3"><input name="full_name" class="form-control" placeholder="Full Name" required value="<?=e($edit['full_name']??'')?>"></div>
<div class="col-md-3"><input name="email" type="email" class="form-control" placeholder="Email" required value="<?=e($edit['email']??'')?>"></div>
<div class="col-md-2"><input name="phone" class="form-control" placeholder="Phone" required value="<?=e($edit['phone']??'')?>"></div>
<div class="col-md-2"><input name="dob" type="date" class="form-control" value="<?=e($edit['dob']??'')?>"></div>
<div class="col-md-2"><select name="gender" class="form-select"><?php foreach(['Male','Female','Other'] as $g):?><option <?=($edit['gender']??'')===$g?'selected':''?>><?=$g?></option><?php endforeach;?></select></div>
<div class="col-md-3"><input name="guardian_name" class="form-control" placeholder="Guardian" value="<?=e($edit['guardian_name']??'')?>"></div><div class="col-md-2"><input name="guardian_phone" class="form-control" placeholder="Guardian Phone" value="<?=e($edit['guardian_phone']??'')?>"></div>
<div class="col-md-3"><select name="course_id" class="form-select"><option value="">Course</option><?php foreach($courses as $c):?><option value="<?=$c['id']?>" <?=((int)($edit['course_id']??0)===(int)$c['id'])?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select></div>
<div class="col-md-1"><input name="semester" type="number" min="1" class="form-control" value="<?=e((string)($edit['semester']??1))?>"></div>
<div class="col-md-2"><input name="admission_date" type="date" class="form-control" value="<?=e($edit['admission_date']??'')?>"></div>
<div class="col-md-1"><select name="fees_status" class="form-select"><?php foreach(['Pending','Partial','Paid'] as $f):?><option <?=($edit['fees_status']??'')===$f?'selected':''?>><?=$f?></option><?php endforeach;?></select></div>
<div class="col-md-4"><input name="address" class="form-control" placeholder="Address" value="<?=e($edit['address']??'')?>"></div>
<div class="col-md-2"><input name="photo" type="file" class="form-control"></div>
<div class="col-md-2"><button class="btn btn-primary w-100"><?= $edit?'Update':'Add' ?></button></div>
</form></section>
<section class="panel glass"><div class="d-flex gap-2 mb-2"><form class="d-flex gap-2"><input name="q" value="<?=e($q)?>" class="form-control" placeholder="Search"><select name="course_id" class="form-select"><option value="0">All Course</option><?php foreach($courses as $c):?><option value="<?=$c['id']?>" <?=$course===(int)$c['id']?'selected':''?>><?=e($c['name'])?></option><?php endforeach;?></select><button class="btn btn-outline-primary">Filter</button></form><a class="btn btn-success" href="?q=<?=urlencode($q)?>&course_id=<?=$course?>&export=csv">Export CSV</a><button class="btn btn-secondary" onclick="window.print()">Print</button></div>
<div class="table-responsive"><table class="table"><thead><tr><th>Code</th><th>Photo</th><th>Name</th><th>Email</th><th>Course</th><th>Sem</th><th>Fee</th><th>Action</th></tr></thead><tbody><?php foreach($list as $r):?><tr data-search="<?=e($r['full_name'].' '.$r['email'])?>"><td><?=e($r['student_code'])?></td><td><?php if($r['photo']):?><img src="<?=e($r['photo'])?>" width="40"><?php endif;?></td><td><a href="view.php?id=<?=$r['id']?>"><?=e($r['full_name'])?></a></td><td><?=e($r['email'])?></td><td><?=e($r['course_name']??'')?></td><td><?=$r['semester']?></td><td><?=$r['fees_status']?></td><td><a class="btn btn-sm btn-outline-primary" href="?edit=<?=$r['id']?>">Edit</a> <a onclick="return confirm('Delete?')" class="btn btn-sm btn-outline-danger" href="?delete=<?=$r['id']?>">Delete</a></td></tr><?php endforeach;?></tbody></table></div>
<?php $pages=max(1,ceil($total/$per)); ?><nav><ul class="pagination"><?php for($i=1;$i<=$pages;$i++):?><li class="page-item <?=$page===$i?'active':''?>"><a class="page-link" href="?page=<?=$i?>&q=<?=urlencode($q)?>&course_id=<?=$course?>"><?=$i?></a></li><?php endfor;?></ul></nav>
</section></main><?php include __DIR__.'/../../includes/footer.php'; ?>
