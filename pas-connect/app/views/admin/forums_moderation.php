<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    .mod-portal {
        padding: 40px 0 100px;
        background: #f8faf9;
        min-height: 100vh;
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    /* Glass Sidebar Card */
    .mod-sidebar-card {
        background: #ffffff;
        border-radius: 24px;
        padding: 30px;
        border: 1px solid rgba(0,0,0,0.05);
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        position: sticky;
        top: 20px;
    }

    /* Topic Feed Styling */
    .mod-topic-item {
        background: #ffffff;
        border-radius: 24px;
        padding: 30px;
        margin-bottom: 24px;
        border: 1px solid rgba(0,0,0,0.04);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .mod-topic-item:hover {
        transform: translateX(10px);
        border-color: var(--brand-bright);
        box-shadow: 0 20px 40px rgba(0,0,0,0.04);
    }

    /* Status Indicators */
    .status-indicator {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .status-active { background-color: #22c55e; box-shadow: 0 0 10px rgba(34, 197, 94, 0.4); }
    .status-closed { background-color: #eab308; }

    /* Meta Info */
    .topic-meta {
        font-size: 0.8rem;
        font-weight: 600;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .topic-title {
        font-weight: 800;
        color: var(--brand-deep);
        font-size: 1.25rem;
        margin: 10px 0;
        line-height: 1.3;
    }

    .topic-snippet {
        color: #64748b;
        font-size: 0.95rem;
        line-height: 1.6;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Action Buttons Group */
    .mod-actions {
        display: flex;
        gap: 8px;
        margin-top: 20px;
        opacity: 0.6;
        transition: opacity 0.3s;
    }

    .mod-topic-item:hover .mod-actions {
        opacity: 1;
    }

    .btn-mod {
        border-radius: 12px;
        padding: 8px 16px;
        font-size: 0.8rem;
        font-weight: 700;
        border: none;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-mod-secondary { background: #f1f5f9; color: #475569; }
    .btn-mod-secondary:hover { background: #e2e8f0; }
    
    .btn-mod-danger { background: #fff1f2; color: #e11d48; }
    .btn-mod-danger:hover { background: #e11d48; color: white; }

    /* Avatar Branding */
    .mod-avatar {
        width: 36px;
        height: 36px;
        border-radius: 12px;
        background: var(--brand-gradient);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 0.9rem;
    }
</style>

<div class="mod-portal">
    <div class="container">
        <header class="mb-5">
            <div class="row align-items-center">
                <div class="col-md-8">
                    <h1 class="fw-800" style="color: var(--brand-deep); letter-spacing: -0.04em;">Forum Moderation</h1>
                    <p class="text-muted">Review, close, or archive community discussions.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <div class="badge bg-white text-dark p-2 px-3 border rounded-pill shadow-sm">
                        <span class="status-indicator status-active"></span> Mod Live Sync Active
                    </div>
                </div>
            </div>
        </header>

        <div class="row g-4">
            <div class="col-lg-3 order-lg-2">
                <div class="mod-sidebar-card">
                    <h6 class="fw-bold mb-4 text-uppercase small text-muted">System Health</h6>
                    <?php 
                        $topics = (function(){ 
                            $pdo = getPDO(); 
                            $stmt=$pdo->prepare('SELECT f.*, u.email as author_email FROM forums f LEFT JOIN users u ON f.author_user_id=u.id ORDER BY f.created_at DESC'); 
                            $stmt->execute(); 
                            return $stmt->fetchAll(); 
                        })(); 
                        $closedCount = count(array_filter($topics, fn($t) => $t['is_closed']));
                    ?>
                    <div class="mb-4">
                        <div class="d-flex justify-content-between mb-1">
                            <span class="small text-muted">Active Topics</span>
                            <span class="small fw-bold"><?= count($topics) - $closedCount ?></span>
                        </div>
                        <div class="progress" style="height: 6px; border-radius: 10px;">
                            <div class="progress-bar bg-success" style="width: <?= count($topics) > 0 ? ((count($topics)-$closedCount)/count($topics))*100 : 0 ?>%"></div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <div class="p-3 bg-light rounded-3 text-center">
                            <h3 class="fw-bold mb-0"><?= $closedCount ?></h3>
                            <span class="extra-small text-uppercase text-muted fw-bold">Closed Cases</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-9 order-lg-1">
                <?php if (empty($topics)): ?>
                    <div class="mod-topic-item text-center py-5">
                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" style="width: 80px; opacity: 0.2;" class="mb-3">
                        <h5 class="text-muted">Queue is clear. No topics require attention.</h5>
                    </div>
                <?php else: ?>
                    <?php foreach ($topics as $t): ?>
                        <div class="mod-topic-item">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="topic-meta d-flex align-items-center">
                                    <?php if ($t['is_closed']): ?>
                                        <span class="status-indicator status-closed"></span> ARCHIVED
                                    <?php else: ?>
                                        <span class="status-indicator status-active"></span> LIVE DISCUSSION
                                    <?php endif; ?>
                                    <span class="ms-2"><?= date('M d, Y', strtotime($t['created_at'])) ?></span>
                                </div>
                                <div class="mod-avatar">
                                    <?= strtoupper(substr($t['author_email'], 0, 1)) ?>
                                </div>
                            </div>

                            <h3 class="topic-title"><?= htmlspecialchars($t['title']) ?></h3>
                            <p class="topic-snippet"><?= htmlspecialchars($t['body']) ?></p>

                            <div class="d-flex justify-content-between align-items-center">
                                <div class="small text-muted fw-600">
                                    <i class="fa-regular fa-user me-1"></i> <?= htmlspecialchars($t['author_email']) ?>
                                </div>
                                
                                <div class="mod-actions">
                                    <?php if ($t['is_closed']): ?>
                                        <form method="post" action="api/forum_moderate.php">
                                            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                                            <input type="hidden" name="action" value="open">
                                            <button class="btn-mod btn-mod-secondary"><i class="fas fa-unlock"></i> Reopen</button>
                                        </form>
                                    <?php else: ?>
                                        <form method="post" action="api/forum_moderate.php">
                                            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                                            <input type="hidden" name="action" value="close">
                                            <button class="btn-mod btn-mod-secondary"><i class="fas fa-lock"></i> Close</button>
                                        </form>
                                    <?php endif; ?>

                                        <form method="post" action="api/forum_moderate.php" onsubmit="return confirm(<?php echo json_encode(t('permanently_delete_topic')); ?>);">
                                            <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                                            <input type="hidden" name="action" value="delete">
                                            <button class="btn-mod btn-mod-danger"><i class="fas fa-trash-alt"></i> <?php echo htmlspecialchars(t('delete')); ?></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>