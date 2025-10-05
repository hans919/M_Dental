<?php require_once '../app/views/layouts/header.php'; ?>

<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success">
        <span class="alert-icon">✓</span>
        <?php echo $_SESSION['message']; unset($_SESSION['message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error">
        <span class="alert-icon">✕</span>
        <?php echo $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<!-- Page Header -->
<div class="page-header">
    <div class="page-header-content">
        <div class="page-header-title">
            <div class="page-icon">
                <i data-lucide="users"></i>
            </div>
            <div>
                <h1>Patients Management</h1>
                <p class="page-subtitle">View and manage all patient records</p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?php echo APP_URL; ?>/public/patient/add" class="btn btn-primary">
                <i data-lucide="user-plus"></i>
                Add New Patient
            </a>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="filter-section">
    <div class="filter-container">
        <form method="GET" action="<?php echo APP_URL; ?>/public/patient" class="filter-form" id="searchForm">
            <div class="search-input-wrapper">
                <i data-lucide="search" class="search-icon"></i>
                <input 
                    type="text" 
                    name="search" 
                    class="search-input-modern" 
                    placeholder="Search by name, code, phone, or email..." 
                    value="<?php echo $data['search']; ?>"
                    id="searchInput"
                >
                <?php if (!empty($data['search'])): ?>
                    <a href="<?php echo APP_URL; ?>/public/patient" class="search-clear">
                        <i data-lucide="x"></i>
                    </a>
                <?php endif; ?>
            </div>
            
            <div class="filter-actions">
                <button type="button" class="btn btn-outline btn-sm" id="filterToggle">
                    <i data-lucide="sliders-horizontal"></i>
                    Filters
                </button>
                <button type="submit" class="btn btn-primary btn-sm">
                    <i data-lucide="search"></i>
                    Search
                </button>
            </div>
        </form>
        
        <!-- Advanced Filters (Hidden by default) -->
        <div class="advanced-filters" id="advancedFilters" style="display: none;">
            <div class="filter-grid">
                <div class="filter-group">
                    <label class="filter-label">Status</label>
                    <select class="filter-select" name="status">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Gender</label>
                    <select class="filter-select" name="gender">
                        <option value="">All Genders</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Registration Date</label>
                    <input type="date" class="filter-input" name="date_from" placeholder="From">
                </div>
                <div class="filter-group">
                    <label class="filter-label" style="opacity: 0;">To</label>
                    <input type="date" class="filter-input" name="date_to" placeholder="To">
                </div>
            </div>
            <div class="filter-footer">
                <button type="button" class="btn btn-ghost btn-sm" onclick="resetFilters()">
                    <i data-lucide="x"></i>
                    Clear Filters
                </button>
                <button type="button" class="btn btn-primary btn-sm" onclick="applyFilters()">
                    <i data-lucide="check"></i>
                    Apply Filters
                </button>
            </div>
        </div>
    </div>
    
    <!-- Quick Stats -->
    <div class="quick-stats">
        <div class="quick-stat-item">
            <div class="quick-stat-label">Total Patients</div>
            <div class="quick-stat-value"><?php echo count($data['patients']); ?></div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">Active</div>
            <div class="quick-stat-value success">
                <?php echo count(array_filter($data['patients'], fn($p) => $p->status == 'active')); ?>
            </div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">Inactive</div>
            <div class="quick-stat-value error">
                <?php echo count(array_filter($data['patients'], fn($p) => $p->status == 'inactive')); ?>
            </div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">This Month</div>
            <div class="quick-stat-value info">
                <?php 
                $thisMonth = count(array_filter($data['patients'], function($p) {
                    return date('Y-m', strtotime($p->created_at)) == date('Y-m');
                }));
                echo $thisMonth;
                ?>
            </div>
        </div>
    </div>
</div>

<!-- Bulk Actions Bar -->
<div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
    <div class="bulk-actions-content">
        <div class="bulk-actions-left">
            <i data-lucide="check-square"></i>
            <span class="bulk-actions-count"><strong id="selectedCount">0</strong> selected</span>
        </div>
        <div class="bulk-actions-right">
            <button class="btn btn-ghost btn-sm" onclick="deselectAll()">
                <i data-lucide="x"></i>
                Deselect All
            </button>
            <button class="btn btn-outline btn-sm">
                <i data-lucide="download"></i>
                Export Selected
            </button>
            <button class="btn btn-outline btn-sm" style="color: hsl(var(--error));">
                <i data-lucide="trash-2"></i>
                Delete Selected
            </button>
        </div>
    </div>
</div>

<!-- Patients Table -->
<div class="card">
    <!-- Table Toolbar -->
    <div class="table-toolbar">
        <div class="table-toolbar-left">
            <div class="view-options">
                <button class="view-btn active" title="Table View">
                    <i data-lucide="table-2"></i>
                </button>
                <button class="view-btn" title="Grid View">
                    <i data-lucide="grid-3x3"></i>
                </button>
            </div>
            <div class="toolbar-divider"></div>
            <div class="entries-selector">
                <label class="entries-label">Show</label>
                <select class="entries-select" onchange="changeEntries(this.value)">
                    <option value="10">10</option>
                    <option value="25" selected>25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
                <span class="entries-label">entries</span>
            </div>
        </div>
        <div class="table-toolbar-right">
            <button class="btn btn-ghost btn-sm" onclick="refreshTable()">
                <i data-lucide="refresh-cw"></i>
                Refresh
            </button>
            <button class="btn btn-outline btn-sm" onclick="exportData()">
                <i data-lucide="download"></i>
                Export
            </button>
            <div class="toolbar-divider"></div>
            <button class="btn btn-ghost btn-sm" title="Column Settings">
                <i data-lucide="columns"></i>
            </button>
        </div>
    </div>
    
    <div class="card-content" style="padding: 0;">
        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 50px;">
                            <input type="checkbox" class="checkbox" id="selectAll">
                        </th>
                        <th>
                            <div class="th-content">
                                <span>Patient</span>
                                <button class="sort-btn">
                                    <i data-lucide="arrow-up-down"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <span>Contact</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <span>Gender</span>
                                <button class="sort-btn">
                                    <i data-lucide="arrow-up-down"></i>
                                </button>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <span>Status</span>
                                <button class="sort-btn">
                                    <i data-lucide="arrow-up-down"></i>
                                </button>
                            </div>
                        </th>
                        <th style="width: 120px; text-align: right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($data['patients'])): ?>
                        <?php foreach ($data['patients'] as $patient): ?>
                            <tr>
                                <td>
                                    <input type="checkbox" class="checkbox" value="<?php echo $patient->id; ?>">
                                </td>
                                <td>
                                    <div class="table-cell-complex">
                                        <div class="table-avatar">
                                            <?php echo strtoupper(substr($patient->first_name, 0, 1) . substr($patient->last_name, 0, 1)); ?>
                                        </div>
                                        <div class="table-cell-content">
                                            <div class="table-cell-title">
                                                <?php echo $patient->first_name . ' ' . $patient->last_name; ?>
                                                <?php if ($patient->source == 'user_table'): ?>
                                                    <span class="badge badge-info" style="font-size: 0.7rem; margin-left: 0.5rem;">Registered User</span>
                                                <?php endif; ?>
                                            </div>
                                            <div class="table-cell-subtitle">
                                                <i data-lucide="hash" style="width: 12px; height: 12px;"></i>
                                                <?php echo $patient->patient_code; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-cell-content">
                                        <?php if ($patient->phone): ?>
                                            <div class="table-cell-row">
                                                <i data-lucide="phone" style="width: 14px; height: 14px; color: hsl(var(--muted-foreground));"></i>
                                                <span><?php echo $patient->phone; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($patient->email): ?>
                                            <div class="table-cell-row">
                                                <i data-lucide="mail" style="width: 14px; height: 14px; color: hsl(var(--muted-foreground));"></i>
                                                <span class="table-cell-subtitle"><?php echo $patient->email; ?></span>
                                            </div>
                                        <?php endif; ?>
                                        <?php if (!$patient->phone && !$patient->email): ?>
                                            <span class="table-cell-subtitle">No contact info</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($patient->gender): ?>
                                        <div class="gender-badge gender-<?php echo $patient->gender; ?>">
                                            <i data-lucide="<?php echo $patient->gender == 'male' ? 'user' : 'user'; ?>" style="width: 14px; height: 14px;"></i>
                                            <span><?php echo ucfirst($patient->gender); ?></span>
                                        </div>
                                    <?php else: ?>
                                        <span class="table-cell-subtitle">Not specified</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $patient->status == 'active' ? 'success' : 'error'; ?>">
                                        <i data-lucide="<?php echo $patient->status == 'active' ? 'check-circle' : 'x-circle'; ?>" style="width: 12px; height: 12px;"></i>
                                        <?php echo ucfirst($patient->status); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="table-actions" style="justify-content: flex-end;">
                                        <a href="<?php echo APP_URL; ?>/public/patient/detail/<?php echo $patient->id; ?>?source=<?php echo $patient->source; ?>" class="btn-icon" title="View Details">
                                            <i data-lucide="eye"></i>
                                        </a>
                                        <?php if ($patient->source == 'patient_table'): ?>
                                            <a href="<?php echo APP_URL; ?>/public/patient/edit/<?php echo $patient->id; ?>" class="btn-icon" title="Edit Patient">
                                                <i data-lucide="pencil"></i>
                                            </a>
                                            <button class="btn-icon btn-icon-danger" title="Delete Patient" onclick="confirmDelete(<?php echo $patient->id; ?>)">
                                                <i data-lucide="trash-2"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="table-cell-subtitle" style="font-size: 0.75rem; padding: 0 0.5rem;">User Account</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i data-lucide="users-round"></i>
                                </div>
                                <div class="empty-state-title">No patients found</div>
                                <div class="empty-state-description">
                                    <?php if (!empty($data['search'])): ?>
                                        No patients match your search criteria. Try adjusting your filters.
                                    <?php else: ?>
                                        Get started by adding your first patient to the system.
                                    <?php endif; ?>
                                </div>
                                <a href="<?php echo APP_URL; ?>/public/patient/add" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i data-lucide="user-plus"></i>
                                    Add First Patient
                                </a>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- Table Footer / Pagination -->
    <div class="table-footer">
        <div class="table-footer-info">
            Showing <strong>1</strong> to <strong><?php echo count($data['patients']); ?></strong> of <strong><?php echo count($data['patients']); ?></strong> entries
            <?php if (!empty($data['search'])): ?>
                <span class="filter-badge">
                    <i data-lucide="filter"></i>
                    Filtered
                </span>
            <?php endif; ?>
        </div>
        <div class="pagination">
            <button class="pagination-btn" disabled>
                <i data-lucide="chevron-left"></i>
                Previous
            </button>
            <div class="pagination-numbers">
                <button class="pagination-number active">1</button>
                <button class="pagination-number">2</button>
                <button class="pagination-number">3</button>
                <span class="pagination-ellipsis">...</span>
                <button class="pagination-number">10</button>
            </div>
            <button class="pagination-btn">
                Next
                <i data-lucide="chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<script>
// Filter Toggle
document.getElementById('filterToggle')?.addEventListener('click', function() {
    const filters = document.getElementById('advancedFilters');
    if (filters.style.display === 'none') {
        filters.style.display = 'block';
        this.classList.add('active');
    } else {
        filters.style.display = 'none';
        this.classList.remove('active');
    }
});

// Checkbox functionality
const checkboxes = document.querySelectorAll('.table tbody .checkbox');
const selectAllCheckbox = document.getElementById('selectAll');
const bulkActionsBar = document.getElementById('bulkActionsBar');
const selectedCountEl = document.getElementById('selectedCount');

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.table tbody .checkbox:checked');
    const count = checkedBoxes.length;
    
    if (count > 0) {
        bulkActionsBar.style.display = 'flex';
        selectedCountEl.textContent = count;
    } else {
        bulkActionsBar.style.display = 'none';
    }
}

selectAllCheckbox?.addEventListener('change', function() {
    checkboxes.forEach(cb => cb.checked = this.checked);
    updateBulkActions();
});

checkboxes.forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        selectAllCheckbox.checked = Array.from(checkboxes).every(cb => cb.checked);
        updateBulkActions();
    });
});

function deselectAll() {
    checkboxes.forEach(cb => cb.checked = false);
    selectAllCheckbox.checked = false;
    updateBulkActions();
}

function resetFilters() {
    document.getElementById('searchForm').reset();
    window.location.href = '<?php echo APP_URL; ?>/public/patient';
}

function applyFilters() {
    document.getElementById('searchForm').submit();
}

function changeEntries(value) {
    console.log('Change entries to:', value);
    // Implement pagination logic
}

function refreshTable() {
    window.location.reload();
}

function exportData() {
    alert('Export functionality - coming soon!');
}

function confirmDelete(id) {
    if (confirm('Are you sure you want to delete this patient? This action cannot be undone.')) {
        window.location.href = '<?php echo APP_URL; ?>/public/patient/delete/' + id;
    }
}
</script>

<?php require_once '../app/views/layouts/footer.php'; ?>
