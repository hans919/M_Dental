<!-- Top Bar -->
<header class="topbar">
    <div class="topbar-content">
        <div class="topbar-left">
            <button class="mobile-menu-toggle" id="mobileMenuToggle">
                <i data-lucide="menu"></i>
            </button>
            <div class="page-title">
                <h1><?php echo $data['title'] ?? 'Dashboard'; ?></h1>
                <span class="page-breadcrumb">
                    <a href="<?php echo APP_URL; ?>/public/home">Home</a>
                    <?php if (isset($data['title']) && $data['title'] != 'Dashboard'): ?>
                        <span class="breadcrumb-separator">/</span>
                        <span><?php echo $data['title']; ?></span>
                    <?php endif; ?>
                </span>
            </div>
        </div>
        
        <div class="topbar-right">
            <div class="topbar-actions">
                <button class="topbar-btn" title="Notifications">
                    <i data-lucide="bell"></i>
                    <span class="badge">3</span>
                </button>
                
                <div class="topbar-divider"></div>
                
                <div class="user-menu">
                    <button class="user-menu-trigger">
                        <div class="user-avatar-small">
                            <?php echo strtoupper(substr($_SESSION['username'], 0, 2)); ?>
                        </div>
                        <span class="user-name-text"><?php echo $_SESSION['username']; ?></span>
                        <i data-lucide="chevron-down" style="width: 16px; height: 16px;"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>
</header>
