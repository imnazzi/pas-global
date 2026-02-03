<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --comm-bg: #fdfdfd; /* Warmer, softer white */
        --comm-card: #ffffff;
        --comm-text: #1a202c;
        --comm-muted: #4a5568;
        --brand-emerald: #10b981;
        --border-color: #edf2f7;
    }

    .community-wrapper {
        padding: 60px 0;
        background: var(--comm-bg);
        min-height: 100vh;
    }

    .feed-container {
        max-width: 720px; /* Matched to Article View for visual consistency */
        margin: 0 auto;
    }

    .page-header {
        margin-bottom: 50px;
        border-bottom: 2px solid #f8fafc;
        padding-bottom: 30px;
    }

    .page-title {
        font-family: 'Georgia', serif;
        font-size: 2.5rem;
        font-weight: 800;
        color: var(--comm-text);
        letter-spacing: -0.02em;
    }

    /* Refined Post Card */
    .post-card {
        background: var(--comm-card);
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 35px;
        margin-bottom: 30px;
        text-decoration: none !important;
        display: block;
        transition: all 0.3s ease;
    }

    .post-card:hover {
        border-color: var(--brand-emerald);
        box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.04);
        transform: translateY(-2px);
    }

    .post-category {
        font-size: 0.75rem;
        font-weight: 700;
        color: var(--brand-emerald);
        text-transform: uppercase;
        letter-spacing: 0.08em;
        margin-bottom: 12px;
        display: block;
    }

    .post-title {
        font-size: 1.65rem;
        font-weight: 700;
        color: var(--comm-text);
        line-height: 1.25;
        margin-bottom: 15px;
    }

    .post-excerpt {
        color: var(--comm-muted);
        font-size: 1.1rem;
        line-height: 1.7;
        margin-bottom: 25px;
        display: -webkit-box;
        -webkit-line-clamp: 3; /* Keeps the feed tidy */
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* Metadata Footer */
    .post-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 20px;
        border-top: 1px solid #f8fafc;
    }

    .author-pill {
        display: flex;
        align-items: center;
        gap: 10px;
        background: #f1f5f9;
        padding: 6px 14px 6px 6px;
        border-radius: 30px;
    }

    .author-avatar {
        width: 28px;
        height: 28px;
        background: var(--brand-emerald);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.75rem;
        font-weight: 800;
    }

    .author-name {
        font-size: 0.85rem;
        font-weight: 700;
        color: var(--comm-text);
    }

    .post-meta-info {
        font-size: 0.85rem;
        color: #94a3b8;
        font-weight: 500;
    }

    /* FAB Customization */
    .fab-new-post {
        position: fixed;
        bottom: 40px;
        right: 40px;
        background: var(--comm-text); /* Sleeker black button */
        color: white;
        width: 64px;
        height: 64px;
        border-radius: 20px; /* Squircle shape for modern look */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.4rem;
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        border: none;
        cursor: pointer;
    }

    .fab-new-post:hover {
        transform: scale(1.1) rotate(5deg);
        background: var(--brand-emerald);
    }
</style>

<div class="community-wrapper">
    <div class="container">
        
        <header class="page-header feed-container">
            <h1 class="page-title"><?php echo htmlspecialchars(t('community_square')); ?></h1>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <p class="text-muted m-0"><?php echo htmlspecialchars(t('community_sub')); ?></p>
                <span class="badge border text-muted px-3 py-2 rounded-pill small">
                    <i class="fas fa-circle text-success me-1" style="font-size: 8px;"></i> <?php echo htmlspecialchars(sprintf(t('active_threads'), count($posts))); ?>
                </span>
            </div> 
        </header>

        <div class="feed-container">
            <?php if (empty($posts)): ?>
                <div class="text-center py-5">
                    <div class="bg-light d-inline-block p-4 rounded-circle mb-3">
                        <i class="fas fa-feather-alt fa-2x text-muted"></i>
                    </div>
                    <h4 class="text-dark"><?php echo htmlspecialchars(t('feed_waiting')); ?></h4>
                    <p class="text-muted"><?php echo htmlspecialchars(t('start_first_conversation')); ?></p>
                </div>
            <?php else: ?>
                
                <?php foreach ($posts as $p): 
                    $initial = strtoupper(substr($p['uploader_email'] ?? 'U', 0, 1));
                    $readTime = ceil(str_word_count($p['body']) / 200);
                ?>
                <a href="?page=community_view&id=<?php echo (int)$p['id']; ?>" class="post-card">
                    <span class="post-category">Insight</span>
                    <h2 class="post-title"><?php echo htmlspecialchars($p['title']); ?></h2>
                    <p class="post-excerpt"><?php echo htmlspecialchars($p['body']); ?></p>
                    
                    <div class="post-footer">
                        <div class="author-pill">
                            <div class="author-avatar"><?php echo $initial; ?></div>
                            <span class="author-name"><?php echo htmlspecialchars($p['uploader_email'] ?? 'Member'); ?></span>
                        </div>
                        
                        <div class="post-meta-info">
                            <span><?php echo date('M d', strtotime($p['created_at'] ?? 'now')); ?></span>
                            <span class="mx-2">·</span>
                            <span><?php echo $readTime; ?> min read</span>
                        </div>
                    </div>
                </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<button class="fab-new-post" title="<?php echo htmlspecialchars(t('start_discussion_title')); ?>">
    <i class="fas fa-pen-nib"></i>
</button> 

<?php require __DIR__ . '/../layouts/footer.php'; ?>