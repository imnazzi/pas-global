<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --post-bg: #ffffff;
        --page-bg: #fdfdfd; /* Slightly warmer white to reduce blue light strain */
        --brand-emerald: #10b981;
        --text-headline: #1a202c;
        --text-body: #2d3748; /* Dark grey instead of pure black for better legibility */
        --border-color: #edf2f7;
    }

    .article-wrapper {
        padding: 80px 0;
        background: var(--page-bg);
        min-height: 100vh;
    }

    .article-container {
        max-width: 720px; /* Reduced width for the perfect "Measure" (65-75 characters per line) */
        margin: 0 auto;
        padding: 0 20px;
    }

    /* Header Section */
    .article-header {
        margin-bottom: 50px;
        text-align: left; /* Left-aligned text is significantly easier to read than centered */
    }

    .article-title {
        font-family: 'Georgia', serif; /* Serif titles feel more authoritative and readable in long-form */
        font-size: 3rem;
        font-weight: 800;
        letter-spacing: -0.02em;
        line-height: 1.1;
        color: var(--text-headline);
        margin-bottom: 20px;
    }

    .author-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 30px;
        border-bottom: 1px solid var(--border-color);
    }

    .author-avatar {
        width: 44px;
        height: 44px;
        background: #f1f5f9;
        color: var(--brand-emerald);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        border: 1px solid var(--border-color);
    }

    /* Content Typography - The most important part for readability */
    .article-body {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        font-size: 1.25rem; /* Increased size for effortless reading */
        line-height: 1.85; /* Spacious leading to prevent lines from blurring together */
        color: var(--text-body);
        letter-spacing: -0.003em; /* Optimal kerning for digital screens */
    }

    .article-body p {
        margin-bottom: 2rem; /* Clear separation between thoughts */
    }

    /* Highlights & Quotes */
    .article-body blockquote {
        border-left: 4px solid var(--brand-emerald);
        padding-left: 20px;
        font-style: italic;
        color: var(--text-headline);
        margin: 40px 0;
    }

    /* Interaction Footer */
    .interaction-bar {
        margin-top: 60px;
        padding: 30px 0;
        display: flex;
        align-items: center;
        gap: 24px;
        border-top: 2px solid #f8fafc;
    }

    .read-time {
        font-size: 0.9rem;
        color: #94a3b8;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .btn-action {
        background: none;
        border: none;
        color: #64748b;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 8px;
        transition: color 0.2s;
        cursor: pointer;
    }

    .btn-action:hover { color: var(--brand-emerald); }
</style>

<div class="article-wrapper">
    <div class="article-container">
        
        <nav class="mb-5">
            <a href="?page=community" class="text-decoration-none text-muted fw-bold small">
                <i class="fas fa-arrow-left me-2"></i> BACK TO FEED
            </a>
        </nav>

        <article>
            <header class="article-header">
                <h1 class="article-title"><?php echo htmlspecialchars($post['title']); ?></h1>
                
                <div class="author-meta">
                    <div class="author-avatar">
                        <?php echo strtoupper(substr($post['uploader_email'] ?? 'U', 0, 1)); ?>
                    </div>
                    <div>
                        <span class="d-block fw-bold" style="color: var(--text-headline);"><?php echo htmlspecialchars($post['uploader_email'] ?? 'System User'); ?></span>
                        <span class="post-date text-muted small"><?php echo date('M j, Y', strtotime($post['created_at'])); ?></span>
                    </div>
                    <div class="ms-auto">
                        <span class="read-time"><?php echo ceil(str_word_count($post['body']) / 200); ?> min read</span>
                    </div>
                </div>
            </header>

            <div class="article-body">
                <?php 
                    // To make it extra readable, we can wrap the first paragraph in a lead class if we wanted, 
                    // but nl2br is fine for a standard dynamic body.
                    echo nl2br(htmlspecialchars($post['body'])); 
                ?>
            </div>

            <footer class="interaction-bar">
                <button class="btn-action">
                    <i class="far fa-heart"></i> Helpful
                </button>
                <button class="btn-action">
                    <i class="far fa-share-square"></i> Share
                </button>
                <div class="ms-auto text-muted small italic">
                    <i class="fas fa-lock me-1"></i> Private PAS Discussion
                </div>
            </footer>
        </article>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>