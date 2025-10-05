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
                <i data-lucide="calendar-check"></i>
            </div>
            <div>
                <h1>Appointments Management</h1>
                <p class="page-subtitle">View and manage all patient appointments</p>
            </div>
        </div>
        <div class="page-header-actions">
            <a href="<?php echo APP_URL; ?>/public/appointment/add" class="btn btn-primary">
                <i data-lucide="calendar-plus"></i>
                Schedule Appointment
            </a>
        </div>
    </div>
</div>

<!-- Filters and Search -->
<div class="filter-section">
    <div class="filter-container">
        <form method="GET" action="<?php echo APP_URL; ?>/public/appointment" class="filter-form" id="searchForm">
            <div class="search-input-wrapper">
                <i data-lucide="search" class="search-icon"></i>
                <input 
                    type="text" 
                    name="search" 
                    class="search-input-modern" 
                    placeholder="Search by patient name, email, or dentist..." 
                    value=""
                    id="searchInput"
                >
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
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="completed">Completed</option>
                        <option value="declined">Declined</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date From</label>
                    <input type="date" class="filter-input" name="date_from">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Date To</label>
                    <input type="date" class="filter-input" name="date_to">
                </div>
                <div class="filter-group">
                    <label class="filter-label">Dentist</label>
                    <select class="filter-select" name="dentist">
                        <option value="">All Dentists</option>
                    </select>
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
            <div class="quick-stat-label">Total</div>
            <div class="quick-stat-value"><?php echo count($data['appointments']); ?></div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">Pending</div>
            <div class="quick-stat-value warning">
                <?php echo count(array_filter($data['appointments'], fn($a) => $a->status == 'pending')); ?>
            </div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">Confirmed</div>
            <div class="quick-stat-value info">
                <?php echo count(array_filter($data['appointments'], fn($a) => $a->status == 'confirmed')); ?>
            </div>
        </div>
        <div class="quick-stat-divider"></div>
        <div class="quick-stat-item">
            <div class="quick-stat-label">Completed</div>
            <div class="quick-stat-value success">
                <?php echo count(array_filter($data['appointments'], fn($a) => $a->status == 'completed')); ?>
            </div>
        </div>
    </div>
</div>

<!-- Appointments Table -->
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
                                <span>Dentist</span>
                            </div>
                        </th>
                        <th>
                            <div class="th-content">
                                <span>Date & Time</span>
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
                        <th>
                            <div class="th-content">
                                <span>Reason</span>
                            </div>
                        </th>
                        <th style="width: 180px; text-align: center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <tbody>
                    <?php if (!empty($data['appointments'])): ?>
                        <?php foreach ($data['appointments'] as $appointment): ?>
                            <tr>
                                <td>
                                    <div class="table-cell-complex">
                                        <div class="table-avatar">
                                            <?php 
                                            $name = $appointment->patient_name ?? 'N A';
                                            $parts = explode(' ', $name);
                                            echo strtoupper(substr($parts[0] ?? 'N', 0, 1) . substr($parts[1] ?? 'A', 0, 1)); 
                                            ?>
                                        </div>
                                        <div class="table-cell-content">
                                            <div class="table-cell-title">
                                                <?php echo $appointment->patient_name ?? 'N/A'; ?>
                                            </div>
                                            <div class="table-cell-subtitle">
                                                <i data-lucide="mail" style="width: 12px; height: 12px;"></i>
                                                <?php echo $appointment->patient_email ?? 'No email'; ?>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-cell-content">
                                        <div class="table-cell-title" style="color: hsl(var(--primary));">
                                            Dr. <?php echo $appointment->dentist_last_name; ?>
                                        </div>
                                        <div class="table-cell-subtitle">
                                            <?php echo $appointment->dentist_first_name; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-cell-content">
                                        <div class="table-cell-row">
                                            <i data-lucide="calendar" style="width: 14px; height: 14px; color: hsl(var(--primary));"></i>
                                            <span style="font-weight: 600;"><?php echo date('M d, Y', strtotime($appointment->appointment_date)); ?></span>
                                        </div>
                                        <div class="table-cell-row">
                                            <i data-lucide="clock" style="width: 14px; height: 14px; color: hsl(var(--muted-foreground));"></i>
                                            <span class="table-cell-subtitle"><?php echo date('h:i A', strtotime($appointment->appointment_time)); ?> (<?php echo $appointment->duration ?? 30; ?> min)</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge badge-<?php 
                                        $statusColors = [
                                            'pending' => 'warning',
                                            'approved' => 'info',
                                            'confirmed' => 'primary',
                                            'completed' => 'success',
                                            'declined' => 'error',
                                            'cancelled_by_patient' => 'error',
                                            'cancelled_by_clinic' => 'error',
                                            'rescheduled' => 'info',
                                            'no-show' => 'error'
                                        ];
                                        echo $statusColors[$appointment->status] ?? 'warning';
                                    ?>">
                                        <i data-lucide="<?php 
                                            $statusIcons = [
                                                'pending' => 'clock',
                                                'approved' => 'check',
                                                'confirmed' => 'check-circle',
                                                'completed' => 'check-check',
                                                'declined' => 'x-circle',
                                                'cancelled_by_patient' => 'x',
                                                'cancelled_by_clinic' => 'x',
                                                'rescheduled' => 'calendar',
                                                'no-show' => 'alert-circle'
                                            ];
                                            echo $statusIcons[$appointment->status] ?? 'circle';
                                        ?>" style="width: 12px; height: 12px;"></i>
                                        <?php echo ucfirst(str_replace('_', ' ', $appointment->status)); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="table-cell-content" style="max-width: 200px;">
                                        <div class="table-cell-title" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            <?php echo $appointment->reason; ?>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="table-actions" style="justify-content: center;">
                                        <?php if ($appointment->status == 'pending'): ?>
                                            <button onclick="updateAppointmentStatus(<?php echo $appointment->id; ?>, 'approved')" 
                                                    class="btn btn-sm btn-success" 
                                                    title="Approve Appointment"
                                                    style="padding: 0.4rem 0.75rem;">
                                                <i data-lucide="check" style="width: 14px; height: 14px;"></i>
                                                Approve
                                            </button>
                                            <button onclick="updateAppointmentStatus(<?php echo $appointment->id; ?>, 'declined')" 
                                                    class="btn btn-sm btn-error" 
                                                    title="Decline Appointment"
                                                    style="padding: 0.4rem 0.75rem;">
                                                <i data-lucide="x" style="width: 14px; height: 14px;"></i>
                                                Decline
                                            </button>
                                        <?php elseif ($appointment->status == 'approved'): ?>
                                            <button onclick="updateAppointmentStatus(<?php echo $appointment->id; ?>, 'confirmed')" 
                                                    class="btn btn-sm btn-primary" 
                                                    title="Confirm Appointment"
                                                    style="padding: 0.4rem 0.75rem;">
                                                <i data-lucide="check-circle" style="width: 14px; height: 14px;"></i>
                                                Confirm
                                            </button>
                                        <?php elseif ($appointment->status == 'confirmed'): ?>
                                            <button onclick="updateAppointmentStatus(<?php echo $appointment->id; ?>, 'completed')" 
                                                    class="btn btn-sm btn-success" 
                                                    title="Mark as Completed"
                                                    style="padding: 0.4rem 0.75rem;">
                                                <i data-lucide="check-check" style="width: 14px; height: 14px;"></i>
                                                Complete
                                            </button>
                                        <?php else: ?>
                                            <button class="btn btn-ghost btn-sm" title="View Details">
                                                <i data-lucide="eye"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <div class="empty-state-icon">
                                    <i data-lucide="calendar-x"></i>
                                </div>
                                <div class="empty-state-title">No appointments found</div>
                                <div class="empty-state-description">
                                    Get started by scheduling your first appointment.
                                </div>
                                <a href="<?php echo APP_URL; ?>/public/appointment/add" class="btn btn-primary" style="margin-top: 1rem;">
                                    <i data-lucide="calendar-plus"></i>
                                    Schedule First Appointment
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
            Showing <strong>1</strong> to <strong><?php echo count($data['appointments']); ?></strong> of <strong><?php echo count($data['appointments']); ?></strong> entries
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

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal-overlay" style="display: none;">
    <div class="modal-container">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Confirm Action</h3>
            <button class="modal-close" onclick="closeModal()">
                <i data-lucide="x"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-icon" id="modalIcon">
                <i data-lucide="alert-circle"></i>
            </div>
            <p class="modal-message" id="modalMessage">Are you sure you want to perform this action?</p>
        </div>
        <div class="modal-footer">
            <button class="btn btn-ghost" onclick="closeModal()">Cancel</button>
            <button class="btn btn-primary" id="confirmButton" onclick="confirmAction()">OK</button>
        </div>
    </div>
</div>

<script>
// Modal functionality
let pendingAction = null;

function showModal(title, message, iconName, status) {
    const modal = document.getElementById('confirmModal');
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const modalIcon = document.getElementById('modalIcon');
    const confirmButton = document.getElementById('confirmButton');
    
    modalTitle.textContent = title;
    modalMessage.textContent = message;
    
    // Update icon
    modalIcon.innerHTML = `<i data-lucide="${iconName}"></i>`;
    
    // Update button style based on action
    confirmButton.className = 'btn';
    if (status === 'declined' || status === 'cancelled_by_clinic') {
        confirmButton.classList.add('btn-error');
    } else if (status === 'approved') {
        confirmButton.classList.add('btn-success');
    } else if (status === 'confirmed') {
        confirmButton.classList.add('btn-primary');
    } else if (status === 'completed') {
        confirmButton.classList.add('btn-success');
    } else {
        confirmButton.classList.add('btn-primary');
    }
    
    modal.style.display = 'flex';
    lucide.createIcons();
}

function closeModal() {
    document.getElementById('confirmModal').style.display = 'none';
    pendingAction = null;
}

function confirmAction() {
    if (pendingAction) {
        pendingAction();
    }
    closeModal();
}

// Close modal on outside click
document.getElementById('confirmModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

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

function resetFilters() {
    document.getElementById('searchForm').reset();
    window.location.href = '<?php echo APP_URL; ?>/public/appointment';
}

function applyFilters() {
    document.getElementById('searchForm').submit();
}

function changeEntries(value) {
    console.log('Change entries to:', value);
}

function refreshTable() {
    window.location.reload();
}

function exportData() {
    alert('Export functionality - coming soon!');
}

function updateAppointmentStatus(appointmentId, status) {
    // Set up the action
    const statusMessages = {
        'approved': {
            title: 'Approve Appointment',
            message: 'Are you sure you want to approve this appointment?',
            icon: 'check-circle'
        },
        'declined': {
            title: 'Decline Appointment',
            message: 'Are you sure you want to decline this appointment?',
            icon: 'x-circle'
        },
        'confirmed': {
            title: 'Confirm Appointment',
            message: 'Are you sure you want to confirm this appointment?',
            icon: 'calendar-check'
        },
        'completed': {
            title: 'Complete Appointment',
            message: 'Are you sure you want to mark this appointment as completed?',
            icon: 'check-check'
        }
    };
    
    const config = statusMessages[status] || {
        title: 'Update Status',
        message: `Are you sure you want to ${status} this appointment?`,
        icon: 'alert-circle'
    };
    
    pendingAction = function() {
        const btn = event.target.closest('button');
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i data-lucide="loader" style="width: 14px; height: 14px; animation: spin 1s linear infinite;"></i> Processing...';
        
        // Send AJAX request
        fetch('<?php echo APP_URL; ?>/public/appointment/updateStatus', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: `appointment_id=${appointmentId}&status=${status}`
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert('Error: ' + (data.message || 'Failed to update appointment status'));
                btn.disabled = false;
                btn.innerHTML = originalText;
                lucide.createIcons();
            }
        })
        .catch(error => {
            alert('Error: ' + error.message);
            btn.disabled = false;
            btn.innerHTML = originalText;
            lucide.createIcons();
        });
    };
    
    showModal(config.title, config.message, config.icon, status);
}
</script>

<style>
/* Modal Styles */
.modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 9999;
    animation: fadeIn 0.2s ease-out;
}

@keyframes fadeIn {
    from {
        opacity: 0;
    }
    to {
        opacity: 1;
    }
}

.modal-container {
    background: white;
    border-radius: var(--radius);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    max-width: 400px;
    width: 90%;
    animation: slideUp 0.3s ease-out;
}

@keyframes slideUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1.5rem;
    border-bottom: 1px solid hsl(var(--border));
}

.modal-title {
    font-size: 1.125rem;
    font-weight: 600;
    color: hsl(var(--foreground));
    margin: 0;
}

.modal-close {
    background: none;
    border: none;
    padding: 0.5rem;
    cursor: pointer;
    color: hsl(var(--muted-foreground));
    border-radius: 4px;
    transition: all 0.2s;
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-close:hover {
    background: hsl(var(--muted));
    color: hsl(var(--foreground));
}

.modal-body {
    padding: 2rem 1.5rem;
    text-align: center;
}

.modal-icon {
    width: 64px;
    height: 64px;
    margin: 0 auto 1.5rem;
    border-radius: 50%;
    background: hsl(var(--primary) / 0.1);
    display: flex;
    align-items: center;
    justify-content: center;
    color: hsl(var(--primary));
}

.modal-icon i {
    width: 32px;
    height: 32px;
}

.modal-message {
    font-size: 1rem;
    color: hsl(var(--muted-foreground));
    line-height: 1.6;
    margin: 0;
}

.modal-footer {
    padding: 1rem 1.5rem;
    border-top: 1px solid hsl(var(--border));
    display: flex;
    gap: 0.75rem;
    justify-content: flex-end;
}

.modal-footer .btn {
    min-width: 80px;
}

@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
