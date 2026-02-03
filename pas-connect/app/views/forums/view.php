<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --thread-bg: #f8fafc;
        --op-card: #ffffff;
        --brand-emerald: #10b981;
        --text-headline: #1a202c;
        --text-body: #334155;
        --border-color: #eef2f7;
    }

    .thread-wrapper {
        padding: 50px 0 100px;
        background: var(--thread-bg);
        min-height: 100vh;
    }

    .thread-container {
        max-width: 850px;
        margin: 0 auto;
    }

    /* Original Post Card */
    .op-card {
        background: var(--op-card);
        border-radius: 24px;
        border: 1px solid var(--border-color);
        padding: 45px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02);
        margin-bottom: 40px;
    }

    .thread-category {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: var(--brand-emerald);
        margin-bottom: 15px;
        display: block;
    }

    .thread-title {
        font-family: 'Georgia', serif;
        font-size: 2.25rem;
        font-weight: 800;
        color: var(--text-headline);
        line-height: 1.2;
        margin-bottom: 25px;
    }

    /* Author Bar */
    .thread-meta {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-bottom: 35px;
        padding-bottom: 25px;
        border-bottom: 1px solid var(--border-color);
    }

    .author-circle {
        width: 40px;
        height: 40px;
        background: #f1f5f9;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        color: var(--brand-emerald);
    }

    /* Content Typography */
    .thread-body {
        font-size: 1.15rem;
        line-height: 1.8;
        color: var(--text-body);
    }

    /* Reply Section Placeholder */
    .discussion-divider {
        display: flex;
        align-items: center;
        gap: 20px;
        margin-bottom: 30px;
        color: #94a3b8;
        font-size: 0.85rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .discussion-divider::after {
        content: "";
        flex-grow: 1;
        height: 1px;
        background: #e2e8f0;
    }

    .btn-reply-fab {
        background: var(--brand-emerald);
        color: white;
        padding: 12px 30px;
        border-radius: 14px;
        font-weight: 700;
        border: none;
        transition: all 0.2s;
        box-shadow: 0 10px 15px -3px rgba(16, 185, 129, 0.2);
    }

    .btn-reply-fab:hover {
        transform: translateY(-2px);
        filter: brightness(1.05);
    }
</style>

<div class="thread-wrapper">
    <div class="container">
        
        <div class="thread-container">
            <nav class="mb-4">
                <a href="?page=forums" class="text-decoration-none text-muted small fw-bold">
                    <i class="fas fa-chevron-left me-1"></i> FORUM INDEX
                </a>
            </nav>

            <article class="op-card">
                <span class="thread-category">Technical Support</span>
                <h1 class="thread-title"><?php echo htmlspecialchars($topic['title']); ?></h1>
                
                <div class="thread-meta">
                    <div class="author-circle">
                        <?php echo strtoupper(substr($topic['creator_email'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div>
                        <div class="fw-bold small"><?php echo htmlspecialchars($topic['creator_email'] ?? 'Member'); ?></div>
                        <div class="text-muted small"><?php echo date('M j, Y • g:i A', strtotime($topic['created_at'])); ?></div>
                    </div>
                    <div class="ms-auto">
                        <span class="badge bg-light text-muted border px-3 py-2 rounded-pill small">Topic Starter</span>
                    </div>
                </div>

                <div class="thread-body">
                    <?php echo nl2br(htmlspecialchars($topic['body'])); ?>
                </div>

                <div class="mt-5 d-flex gap-2">
                    <button class="btn btn-sm btn-light border px-3 rounded-pill fw-bold">
                        <i class="far fa-thumbs-up me-1"></i> <?php echo htmlspecialchars(t('helpful')); ?>
                    </button>
                    <button class="btn btn-sm btn-light border px-3 rounded-pill fw-bold">
                        <i class="far fa-flag me-1"></i> <?php echo htmlspecialchars(t('report')); ?>
                    </button>

                    <?php if (!empty($_SESSION['user_id']) && (int)$_SESSION['user_id'] === (int)$topic['author_user_id']): ?>
                        <button id="btnEditTopic" class="btn btn-sm btn-outline-primary"><?php echo htmlspecialchars(t('edit')); ?></button>
                        <button id="btnDeleteTopic" class="btn btn-sm btn-danger"><?php echo htmlspecialchars(t('delete')); ?></button>
                    <?php endif; ?>
                    <?php if (!empty($_SESSION['admin_id'])): ?>
                        <button id="btnDeleteTopicAdmin" class="btn btn-sm btn-danger"><?php echo htmlspecialchars(t('delete_admin')); ?></button>
                    <?php endif; ?>
                </div>
            </article>

            <div class="discussion-divider">
                <?php echo htmlspecialchars(t('community_discussion')); ?>
            </div>

            <?php if (!empty($replies)): ?>
                <div class="mb-4">
                    <?php foreach ($replies as $r): ?>
                        <div class="op-card mb-3">
                            <div class="d-flex align-items-start gap-3">
                                <div class="author-circle"><?php echo strtoupper(substr($r['author_email'] ?? 'U',0,1)); ?></div>
                                <div>
                                    <div class="fw-bold small"><?php echo htmlspecialchars($r['author_email'] ?? 'Member'); ?></div>
                                    <div class="text-muted small"><?php echo date('M j, Y • g:i A', strtotime($r['created_at'])); ?></div>
                                    <div class="mt-2 thread-body"><?php echo nl2br(htmlspecialchars($r['body'])); ?></div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <div class="text-center py-4 text-muted"><?php echo htmlspecialchars(t('no_replies')); ?></div>
            <?php endif; ?>

            <div class="text-center py-4">
                <p class="text-muted small mb-4"><?php echo htmlspecialchars(t('contribute_thread')); ?></p>
                <button class="btn-reply-fab" id="btnReplyOpen" data-bs-toggle="modal" data-bs-target="#modalReply"> 
                    <i class="fas fa-reply me-2"></i> <?php echo htmlspecialchars(t('post_a_reply')); ?>
                </button>
            </div>

            <!-- Reply Modal -->
            <div class="modal fade" id="modalReply" tabindex="-1">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title"><?php echo htmlspecialchars(t('post_a_reply')); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                  </div>
                  <div class="modal-body">
                    <textarea id="replyBody" class="form-control" rows="6"></textarea>
                    <div id="replyStatus" class="text-danger small" style="display:none;"></div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal"><?php echo htmlspecialchars(t('cancel')); ?></button>
                    <button id="postReplyBtn" type="button" class="btn btn-primary"><?php echo htmlspecialchars(t('post_reply')); ?></button>
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    var btn = document.getElementById('postReplyBtn');
    if (btn){
        btn.addEventListener('click', function(){
            var body = document.getElementById('replyBody').value.trim();
            var status = document.getElementById('replyStatus'); status.style.display='none';
            if (!body){ status.innerText=<?php echo json_encode(t('reply_empty')); ?>; status.style.display='block'; return; }
            var fd = new FormData(); fd.append('forum_id', <?php echo (int)($topic['id'] ?? 0); ?>); fd.append('body', body);
            fetch('api/forum_reply_create.php', { method: 'POST', body: fd }).then(r=>r.json()).then(j=>{
                if (j.success){ location.reload(); } else { status.innerText = j.error || <?php echo json_encode(t('update_failed')); ?>; status.style.display='block'; }
            }).catch(e=>{ status.innerText=<?php echo json_encode(t('network_error')); ?>; status.style.display='block'; });
        });
    }

    // Edit/Delete handlers
    var editBtn = document.getElementById('btnEditTopic');
    var deleteBtn = document.getElementById('btnDeleteTopic');
    var deleteAdminBtn = document.getElementById('btnDeleteTopicAdmin');
    if (editBtn){
        editBtn.addEventListener('click', function(){
            var t = prompt(<?php echo json_encode(t('edit_title')); ?>, <?php echo json_encode($topic['title'] ?? ''); ?>);
            if (t === null) return;
            var b = prompt(<?php echo json_encode(t('edit_body')); ?>, <?php echo json_encode($topic['body'] ?? ''); ?>);
            if (b === null) return;
            var fd = new FormData(); fd.append('id', <?php echo (int)($topic['id'] ?? 0); ?>); fd.append('title', t); fd.append('body', b);
            fetch('api/forum_update.php', { method: 'POST', body: fd }).then(r=>r.json()).then(j=>{
                if (j.success) location.reload(); else alert(j.error||<?php echo json_encode(t('update_failed')); ?>);
            }).catch(()=>alert(<?php echo json_encode(t('network_error')); ?>));
        });
    }
    if (deleteBtn){ deleteBtn.addEventListener('click', function(){ if (!confirm(<?php echo json_encode(t('delete_topic_confirm')); ?>)) return; var fd=new FormData(); fd.append('id', <?php echo (int)($topic['id'] ?? 0); ?>); fetch('api/forum_delete.php',{method:'POST', body:fd}).then(r=>r.json()).then(j=>{ if (j.success) location.href='?page=forums'; else alert(j.error||<?php echo json_encode(t('delete_failed')); ?>); }); }); }
    if (deleteAdminBtn){ deleteAdminBtn.addEventListener('click', function(){ if (!confirm(<?php echo json_encode(t('delete_topic_admin_confirm')); ?>)) return; var fd=new FormData(); fd.append('id', <?php echo (int)($topic['id'] ?? 0); ?>); fetch('api/forum_delete.php',{method:'POST', body:fd}).then(r=>r.json()).then(j=>{ if (j.success) location.href='?page=forums'; else alert(j.error||<?php echo json_encode(t('delete_failed')); ?>); }); }); }
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>