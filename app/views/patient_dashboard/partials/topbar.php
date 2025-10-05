    <!-- Top Bar -->
    <header class="patient-topbar">
        <div class="topbar-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i data-lucide="menu"></i>
            </button>
            <h1 class="page-title"><?php echo $data['title'] ?? 'Dashboard'; ?></h1>
        </div>
        
        <div class="topbar-right">
            <button class="topbar-btn">
                <i data-lucide="bell"></i>
                <span class="notification-badge">3</span>
            </button>
            
            <div class="user-menu">
                <div class="user-info">
                    <span class="user-name"><?php echo $data['user']['first_name'] . ' ' . $data['user']['last_name']; ?></span>
                    <span class="user-role">Patient</span>
                </div>
                <div class="user-avatar">
                    <?php echo strtoupper(substr($data['user']['first_name'], 0, 1)); ?>
                </div>
            </div>
        </div>
    </header>
