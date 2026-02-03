<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --forum-bg: #fdfdfd;
        --forum-card: #ffffff;
        --forum-text: #1a202c;
        --forum-muted: #64748b;
        --brand-emerald: #10b981;
        --row-hover: #f8fafc;
        --border-color: #edf2f7;
    }

    .forum-wrapper {
        padding: 60px 0;
        background: var(--forum-bg);
        min-height: 100vh;
    }

    .forum-container {
        max-width: 1000px;
        margin: 0 auto;
    }

    /* Header Styling */
    .forum-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 40px;
    }

    .forum-title {
        font-family: 'Georgia', serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--forum-text);
        margin: 0;
    }

    /* Forum Row Architecture */
    .topic-row {
        background: var(--forum-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px 30px;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        text-decoration: none !important;
        transition: all 0.2s ease-in-out;
    }

    .topic-row:hover {
        transform: scale(1.01);
        border-color: var(--brand-emerald);
        background: var(--row-hover);
        box-shadow: 0 10px 20px rgba(0,0,0,0.02);
    }

    .topic-status {
        width: 48px;
        height: 48px;
        background: #f1f5f9;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-emerald);
        margin-right: 20px;
        flex-shrink: 0;
    }

    .topic-main {
        flex-grow: 1;
    }

    .topic-headline {
        font-size: 1.15rem;
        font-weight: 700;
        color: var(--forum-text);
        margin-bottom: 4px;
        display: block;
    }

    .topic-preview {
        font-size: 0.95rem;
        color: var(--forum-muted);
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Stats & Engagement */
    .topic-stats {
        display: flex;
        gap: 30px;
        margin-left: 40px;
        text-align: center;
        min-width: 180px;
    }

    .stat-box {
        display: flex;
        flex-direction: column;
    }

    .stat-value {
        font-weight: 800;
        color: var(--forum-text);
        font-size: 1rem;
    }

    .stat-label {
        font-size: 0.7rem;
        text-transform: uppercase;
        font-weight: 700;
        color: #94a3b8;
        letter-spacing: 0.05em;
    }

    .btn-new-topic {
        background: var(--forum-text);
        color: white;
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 700;
        border: none;
        transition: all 0.3s;
    }

    .btn-new-topic:hover {
        background: var(--brand-emerald);
        transform: translateY(-2px);
    }
</style>

<div class="forum-wrapper">
    <div class="container">
        
        <div class="forum-container">
            <header class="forum-header">
                <div>
                    <h1 class="forum-title"><?php echo htmlspecialchars(t('knowledge_forums')); ?> <span style="color: var(--brand-emerald)"></span></h1>
                    <p class="text-muted mt-2"><?php echo htmlspecialchars(t('forums_sub')); ?></p>
                </div>
                <button class="btn-new-topic" data-bs-toggle="modal" data-bs-target="#modalCreateTopic">
                    <i class="fas fa-plus-circle me-2"></i> <?php echo htmlspecialchars(t('start_topic')); ?>
                </button>

                <!-- Create Topic Modal -->
                <div class="modal fade" id="modalCreateTopic" tabindex="-1">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title"><?php echo htmlspecialchars(t('start_new_topic')); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label"><?php echo htmlspecialchars(t('title')); ?></label>
                            <input id="topicTitle" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label"><?php echo htmlspecialchars(t('body')); ?></label>
                            <textarea id="topicBody" class="form-control" rows="6"></textarea>
                        </div>
                        <div id="topicStatus" class="text-danger small" style="display:none;"></div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo htmlspecialchars(t('cancel')); ?></button>
                        <button id="createTopicBtn" type="button" class="btn btn-primary"><?php echo htmlspecialchars(t('create_topic')); ?></button>
                      </div>
                    </div>
                  </div>
                </div>
            </header>

            <?php if (empty($topics)): ?>
                <div class="text-center py-5 bg-white rounded-4 border">
                    <i class="fas fa-comments fa-3x text-muted mb-3 opacity-20"></i>
                    <h5 class="text-muted">No discussions found in this sector.</h5>
                </div>
            <?php else: ?>                <!-- Optionally load via API in the future -->                <div class="forum-list">
                    <?php foreach ($topics as $t): ?>
                    <a href="?page=forum_view&id=<?php echo (int)$t['id']; ?>" class="topic-row" data-topic-id="<?=(int)$t['id']?>">
                        <div class="topic-status">
                            <i class="far fa-comments"></i>
                        </div>
                        
                        <div class="topic-main">
                            <span class="topic-headline"><?php echo htmlspecialchars($t['title']); ?></span>
                            <span class="topic-preview"><?php echo htmlspecialchars(substr($t['body'],0,200)); ?></span>
                        </div>

                        <div class="topic-stats d-none d-md-flex">
                            <div class="stat-box">
                                <span class="stat-value"><?php echo (int)($t['replies_count'] ?? 0); ?></span>
                                <span class="stat-label">Replies</span>
                            </div>
                            <div class="stat-box">
                                <span class="stat-value">—</span>
                                <span class="stat-label">Views</span>
                            </div>
                        </div>

                        <div class="ms-4 text-muted d-none d-lg-block">
                            <i class="fas fa-chevron-right opacity-50"></i>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
(function(){
    var btn = document.getElementById('createTopicBtn');
    if (!btn) return;
    btn.addEventListener('click', function(){
        var t = document.getElementById('topicTitle').value.trim();
        var b = document.getElementById('topicBody').value.trim();
        var status = document.getElementById('topicStatus');
        status.style.display = 'none';
        if (!t || !b){ status.innerText = 'Title and body are required.'; status.style.display='block'; return; }
        var fd = new FormData(); fd.append('title', t); fd.append('body', b);
        fetch('api/forum_create.php', { method: 'POST', body: fd }).then(r=>r.json()).then(j=>{
            if (j.success){ location.href = '?page=forum_view&id='+j.id; } else { status.innerText = j.error || 'Error'; status.style.display='block'; }
        }).catch(e=>{ status.innerText = 'Network error'; status.style.display='block'; });
    });
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>