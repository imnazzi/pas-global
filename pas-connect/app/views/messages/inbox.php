<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        /* Light Mode Palette */
        --inbox-bg: #f5f7f9;
        --inbox-white: #ffffff;
        --inbox-border: #e2e8f0;
        --inbox-text-main: #1e293b;
        --inbox-text-sub: #64748b;
        --brand-primary: #10b981;
        --brand-soft: rgba(16, 185, 129, 0.08);
    }

    .inbox-wrapper {
        padding: 40px 0;
        background: var(--inbox-bg);
        min-height: 100vh;
        color: var(--inbox-text-main);
    }

    .inbox-card {
        background: var(--inbox-white);
        border: 1px solid var(--inbox-border);
        border-radius: 24px;
        overflow: hidden;
        /* Softer, more natural shadow for white backgrounds */
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    }

    /* Sidebar Actions */
    .inbox-sidebar {
        background: #fafbfc;
        border-right: 1px solid var(--inbox-border);
        padding: 30px 20px;
    }

    .nav-pill-custom {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 16px;
        color: var(--inbox-text-sub);
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.2s;
        margin-bottom: 4px;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .nav-pill-custom:hover {
        background: #f1f5f9;
        color: var(--inbox-text-main);
    }

    .nav-pill-custom.active {
        background: var(--brand-soft);
        color: var(--brand-primary);
    }

    /* Conversation List */
    .conv-item {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 22px 28px;
        border-bottom: 1px solid #f1f5f9;
        text-decoration: none !important;
        transition: all 0.2s ease;
        background: var(--inbox-white);
    }

    .conv-item:hover {
        background: #f8fafc;
        transform: scale(1.002);
    }

    /* Avatar Logic */
    .avatar-circle {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #f1f5f9; /* Neutral bg for avatars */
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        flex-shrink: 0;
        border: 1px solid var(--inbox-border);
    }

    .conv-title {
        color: var(--inbox-text-main);
        font-weight: 700;
        font-size: 1rem;
        margin-bottom: 2px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .conv-preview {
        color: var(--inbox-text-sub);
        font-size: 0.875rem;
        font-weight: 400;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .conv-meta {
        font-size: 0.75rem;
        color: #94a3b8;
        font-weight: 500;
    }

    .search-input {
        background: #f1f5f9 !important;
        border: none !important;
        border-radius: 10px !important;
        padding: 10px 15px !important;
        font-size: 0.9rem !important;
    }

    /* Badge for unread or total */
    .count-badge {
        background: #e2e8f0;
        color: #475569;
        padding: 2px 8px;
        border-radius: 6px;
        font-size: 0.75rem;
        font-weight: 700;
    }
</style>

<div class="inbox-wrapper">
    <div class="container">
        <div class="row g-0 inbox-card">
            
            <div class="col-lg-3 inbox-sidebar">
                <div class="d-flex align-items-center justify-content-between mb-4 px-2">
                    <h5 class="fw-800 m-0" style="color: var(--inbox-text-main); letter-spacing: -0.5px;">Inbox</h5>
                    <i class="fas fa-edit text-muted cursor-pointer"></i>
                </div>
                
                <nav>
                    <a href="#" class="nav-pill-custom active">
                        <i class="fas fa-inbox"></i> All Messages
                    </a>
                    <a href="#" class="nav-pill-custom">
                        <i class="fas fa-bolt"></i> Urgent
                    </a>
                    <a href="#" class="nav-pill-custom">
                        <i class="fas fa-archive"></i> Archive
                    </a>
                </nav>

                <div class="mt-5 px-2">
                    <p class="text-uppercase small fw-bold text-muted mb-3" style="font-size: 0.7rem; letter-spacing: 1px;">Quick Links</p>
                    <a href="?page=user_dashboard" class="nav-pill-custom">
                        <i class="fas fa-arrow-left"></i> Exit to Dashboard
                    </a>
                </div>
            </div>

            <div class="col-lg-9">
                <div class="p-4 border-bottom d-flex justify-content-between align-items-center">
                    <div class="position-relative" style="width: 350px;">
                        <i class="fas fa-search position-absolute text-muted" style="left: 15px; top: 12px;"></i>
                        <input type="text" class="form-control search-input ps-5" placeholder="Search conversations...">
                    </div>
                    <div>
                        <span class="count-badge"><?php echo count($convs); ?> Threads</span>
                    </div>
                </div>

                <div class="conv-list">
                    <?php if (empty($convs)): ?>
                        <div class="text-center py-5">
                            <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                                <i class="fas fa-envelope-open text-muted fa-2x"></i>
                            </div>
                            <h5 class="fw-700">Inbox is empty</h5>
                            <p class="text-muted small">Your communications with the network will appear here.</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($convs as $c):
                            if (!empty($_SESSION['admin_id'])) {
                                $title = $c['name'] ?: $c['email'];
                                $link = '?page=messages_view&admin_id=' . (int)$_SESSION['admin_id'] . '&user_id=' . (int)$c['user_id'];
                            } else {
                                $aid = $c['admin_id'] ?? $c['id'];
                                $title = $c['admin_email'] ?? 'System Support';
                                $link = '?page=messages_view&admin_id=' . (int)$aid . '&user_id=' . (int)$_SESSION['user_id'];
                            }
                            $initial = strtoupper(substr($title, 0, 1));
                        ?>
                        <a href="<?php echo $link; ?>" class="conv-item">
                            <div class="avatar-circle">
                                <?php echo $initial; ?>
                            </div>
                            <div class="conv-body">
                                <div class="conv-title">
                                    <span><?php echo htmlspecialchars($title); ?></span>
                                    <span class="conv-meta"><?php echo date('M d', strtotime($c['created_at'] ?? 'now')); ?></span>
                                </div>
                                <div class="conv-preview">
                                    <?php echo htmlspecialchars(substr($c['body'] ?? 'No message content available...', 0, 110)); ?>
                                </div>
                            </div>
                            <i class="fas fa-angle-right text-muted ms-3 opacity-50"></i>
                        </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>