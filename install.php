<?php
require_once __DIR__ . '/config/auth.php';
$message = ''; $error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $host = trim($_POST['db_host'] ?? '127.0.0.1');
    $name = trim($_POST['db_name'] ?? 'college_erp');
    $user = trim($_POST['db_user'] ?? 'root');
    $pass = (string) ($_POST['db_pass'] ?? '');
    try {
        $pdo = new PDO('mysql:host=' . $host . ';charset=utf8mb4', $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $sql = file_get_contents(__DIR__ . '/database/college.sql');
        $sql = str_replace('college_erp', $name, $sql);
        $pdo->exec($sql);
        $cfg = "<?php\ndefine('DB_HOST','" . addslashes($host) . "');\ndefine('DB_NAME','" . addslashes($name) . "');\ndefine('DB_USER','" . addslashes($user) . "');\ndefine('DB_PASS','" . addslashes($pass) . "');\n";
        file_put_contents(__DIR__ . '/config/db_config.php', $cfg);
        $pdo2 = new PDO('mysql:host=' . $host . ';dbname=' . $name . ';charset=utf8mb4', $user, $pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $hash = password_hash('Admin@123', PASSWORD_DEFAULT);
        $pdo2->prepare('INSERT IGNORE INTO users(full_name,email,password_hash,role,is_active) VALUES (?,?,?,?,1)')->execute(['Super Admin','admin@college.com',$hash,'Super Admin']);
        $message = 'Installation complete. Login: admin@college.com / Admin@123';
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}
?><!doctype html><html><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"></head><body class="p-4"><div class="container" style="max-width:620px"><h3>Install College ERP</h3><?php if($message):?><div class="alert alert-success"><?=htmlspecialchars($message)?></div><?php endif; ?><?php if($error):?><div class="alert alert-danger"><?=htmlspecialchars($error)?></div><?php endif; ?><form method="post" class="vstack gap-2"><input class="form-control" name="db_host" placeholder="DB Host" value="127.0.0.1" required><input class="form-control" name="db_name" placeholder="DB Name" value="college_erp" required><input class="form-control" name="db_user" placeholder="DB User" value="root" required><input class="form-control" name="db_pass" placeholder="DB Password" type="password"><button class="btn btn-primary">Install</button></form></div></body></html>
