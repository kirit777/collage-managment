<?php
$moduleTitle='System Settings';
$moduleSubtitle='Theme customizer, profile settings, backup UI and audit logs.';
$moduleContent='<div class="row g-3"><div class="col-md-6"><div class="card p-3"><h6>Profile Settings</h6><label class="form-label">Display Name</label><input class="form-control" value="'.e($_SESSION['user']['name']).'"></div></div><div class="col-md-6"><div class="card p-3"><h6>Audit Logs</h6><ul><li>Fee structure updated - 2026-04-27</li><li>Role permission changed - 2026-04-26</li></ul></div></div></div>';
include __DIR__ . '/../_module.php';
