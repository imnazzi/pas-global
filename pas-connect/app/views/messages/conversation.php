<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    .chat-wrapper {
        padding: 40px 0;
        background: var(--bg-main);
        min-height: calc(100vh - 80px);
    }

    .chat-container {
        max-width: 900px;
        margin: 0 auto;
        background: var(--bg-card);
        backdrop-filter: var(--glass-blur);
        border: 1px solid var(--glass-border);
        border-radius: 28px;
        display: flex;
        flex-direction: column;
        height: 75vh;
        overflow: hidden;
        box-shadow: var(--shadow-lg);
    }

    /* Top Bar */
    .chat-header {
        padding: 20px 30px;
        background: rgba(255, 255, 255, 0.03);
        border-bottom: 1px solid var(--glass-border);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .chat-user-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .status-indicator {
        width: 10px;
        height: 10px;
        background: var(--brand-emerald);
        border-radius: 50%;
        box-shadow: 0 0 10px var(--brand-emerald);
    }

    /* Message Area */
    #conversationBox {
        flex: 1;
        padding: 30px;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 12px;
        background-image: radial-gradient(circle at 50% 50%, rgba(16, 185, 129, 0.02) 0%, transparent 80%);
    }

    /* Custom Scrollbar */
    #conversationBox::-webkit-scrollbar { width: 6px; }
    #conversationBox::-webkit-scrollbar-thumb { background: var(--glass-border); border-radius: 10px; }

    .msg-bubble {
        max-width: 75%;
        padding: 14px 20px;
        border-radius: 18px;
        position: relative;
        font-size: 0.95rem;
        line-height: 1.5;
        animation: slideIn 0.3s ease-out;
    }

    /* Mine (Sent) */
    .msg-mine {
        align-self: flex-end;
        background: var(--brand-gradient);
        color: white;
        border-bottom-right-radius: 4px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.2);
    }

    /* Theirs (Received) */
    .msg-theirs {
        align-self: flex-start;
        background: var(--bg-hover);
        color: var(--text-primary);
        border-bottom-left-radius: 4px;
        border: 1px solid var(--glass-border);
    }

    .msg-time {
        font-size: 0.7rem;
        opacity: 0.6;
        margin-top: 6px;
        display: block;
    }

    /* Input Area */
    .chat-footer {
        padding: 25px 30px;
        background: rgba(2, 6, 23, 0.5);
        border-top: 1px solid var(--glass-border);
    }

    .input-wrapper {
        position: relative;
        display: flex;
        gap: 15px;
        align-items: flex-end;
    }

    .chat-input {
        flex: 1;
        background: rgba(255, 255, 255, 0.05) !important;
        border: 1px solid var(--glass-border) !important;
        border-radius: 16px !important;
        color: white !important;
        padding: 12px 20px !important;
        resize: none;
        transition: all 0.3s;
    }

    .chat-input:focus {
        border-color: var(--brand-emerald) !important;
        box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1) !important;
    }

    .btn-send {
        width: 50px;
        height: 50px;
        border-radius: 15px;
        background: var(--brand-emerald);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s;
        box-shadow: 0 4px 15px var(--brand-glow);
    }

    .btn-send:hover {
        transform: scale(1.05) translateY(-2px);
        background: #12d393;
    }
</style>

<div class="chat-wrapper">
    <div class="container">
        <div class="chat-container">
            <div class="chat-header">
                <div class="chat-user-info">
                    <a href="?page=messages_inbox" class="btn btn-sm btn-secondary rounded-circle" style="width:35px; height:35px; padding:0; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div class="avatar-mini bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width:40px; height:40px; font-weight:bold;">
                        <?php echo !empty($_GET['user_id']) ? 'U' : 'A'; ?>
                    </div>
                    <div>
                        <h6 class="m-0 fw-bold">Direct Conversation</h6>
                        <div class="d-flex align-items-center gap-2">
                            <span class="status-indicator"></span>
                            <small class="text-muted">Secure Terminal Active</small>
                        </div>
                    </div>
                </div>
                <div class="text-muted small fw-bold text-uppercase letter-spacing-1">PAS-Connect v2.0</div>
            </div>

            <div id="conversationBox">
                <?php if (empty($messages)): ?>
                    <div class="text-center my-auto opacity-50">
                        <i class="fas fa-comments fa-3x mb-3"></i>
                        <p>Begin a secure session. Type your message below.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($messages as $m):
                        $isAdminSender = !empty($m['sender_admin_id']);
                        $meIsAdmin = !empty($_SESSION['admin_id']);
                        $isMine = ($isAdminSender && $meIsAdmin && $_SESSION['admin_id'] === $m['sender_admin_id']) || 
                                  (!$isAdminSender && !$meIsAdmin && $_SESSION['user_id'] === $m['sender_user_id']);
                    ?>
                    <div class="msg-bubble <?php echo $isMine ? 'msg-mine' : 'msg-theirs'; ?>">
                        <?php echo nl2br(htmlspecialchars($m['body'])); ?>
                        <span class="msg-time <?php echo $isMine ? 'text-white-50' : 'text-muted'; ?>">
                            <?php echo date('M d, H:i', strtotime($m['created_at'])); ?>
                        </span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <div class="chat-footer">
                <form id="sendMessageForm" class="input-wrapper">
                    <textarea name="body" id="msgInput" class="form-control chat-input" rows="1" placeholder="Type a secure message..." required></textarea>
                    
                    <?php if (!empty($_GET['admin_id'])): ?><input type="hidden" name="to_admin_id" value="<?php echo (int)$_GET['admin_id']; ?>" /><?php endif; ?>
                    <?php if (!empty($_GET['user_id'])): ?><input type="hidden" name="to_user_id" value="<?php echo (int)$_GET['user_id']; ?>" /><?php endif; ?>
                    
                    <button class="btn-send" id="sendBtn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
(function(){
    const box = document.getElementById('conversationBox');
    const form = document.getElementById('sendMessageForm');
    const input = document.getElementById('msgInput');

    // Scroll to bottom immediately
    box.scrollTop = box.scrollHeight;

    // Auto-resize textarea
    input.addEventListener('input', function() {
        this.style.height = 'auto';
        this.style.height = (this.scrollHeight) + 'px';
    });

    form.addEventListener('submit', function(e){
        e.preventDefault();
        const btn = document.getElementById('sendBtn');
        const fd = new FormData(this);

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';

        fetch('api/messages_send.php', { method: 'POST', body: fd })
        .then(r => r.json())
        .then(j => {
            if (j.success) {
                // Smooth reload to show message
                location.reload(); 
            } else {
                alert(j.error || 'System error');
                btn.disabled = false;
                btn.innerHTML = '<i class="fas fa-paper-plane"></i>';
            }
        })
        .catch(() => {
            alert('Network failure');
            btn.disabled = false;
        });
    });

    // Submit on Enter (but not Shift+Enter)
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            form.dispatchEvent(new Event('submit'));
        }
    });
})();
</script>

<?php require __DIR__ . '/../layouts/footer.php'; ?>