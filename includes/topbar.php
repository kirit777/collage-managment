<header class="topbar glass">
    <button class="btn btn-sm btn-outline-secondary" onclick="toggleSidebar()"><i class="bi bi-list"></i></button>
    <div class="search-wrap"><i class="bi bi-search"></i><input id="globalSearch" class="form-control" placeholder="Search students, fees, notices..."></div>
    <div class="ms-auto d-flex gap-2 align-items-center">
        <span id="clock" class="text-muted small"></span>
        <button class="btn btn-light btn-sm position-relative"><i class="bi bi-bell"></i><span class="notification-dot"></span></button>
        <button class="btn btn-light btn-sm"><i class="bi bi-chat-left-text"></i></button>
        <button class="btn btn-dark btn-sm" onclick="toggleTheme()"><i class="bi bi-moon-stars"></i></button>
        <div class="dropdown">
            <button class="btn btn-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown"><?= e($_SESSION['user']['name']) ?></button>
            <ul class="dropdown-menu dropdown-menu-end">
                <li><span class="dropdown-item-text text-muted"><?= e($_SESSION['user']['role']) ?></span></li>
                <li><a class="dropdown-item" href="/modules/settings/index.php">Profile Settings</a></li>
                <li><a class="dropdown-item text-danger" href="/logout.php">Logout</a></li>
            </ul>
        </div>
    </div>
</header>
