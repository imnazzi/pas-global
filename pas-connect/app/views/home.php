<?php require __DIR__ . '/layouts/header.php'; ?>

<style>
    :root {
        /* Exact color extraction from the source link */
        --brand-deep: #063A15; 
        --brand-bright: #4ADE80; 
        --brand-emerald: #10B981;
        --brand-gradient: linear-gradient(135deg, #063A15 0%, #0A5C24 100%);
        --glass-bg: rgba(255, 255, 255, 0.82);
        --text-main: #1E293B;
        --text-muted: #64748B;
    }

    /* 1. Full-Screen Dynamic Mesh Wrapper */
    .page-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        background-color: #F8FAF9;
        /* The exact dual-gradient mesh from the link */
        background-image: 
            radial-gradient(at 0% 0%, rgba(74, 222, 128, 0.15) 0px, transparent 50%),
            radial-gradient(at 100% 100%, rgba(6, 58, 21, 0.1) 0px, transparent 50%);
        overflow: hidden;
    }

    /* 2. Floating Orbs for the "Cyber-Forest" look */
    .decorative-orb {
        position: absolute;
        width: 500px;
        height: 500px;
        border-radius: 50%;
        filter: blur(120px);
        z-index: 1;
        opacity: 0.18;
    }

    /* 3. The Entrance Animation */
    @keyframes revealCard {
        0% { opacity: 0; transform: translateY(30px) scale(0.97); filter: blur(10px); }
        100% { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
    }

    /* 4. The Exact Glassmorphic Card */
    .auth-card {
        background: var(--glass-bg);
        backdrop-filter: blur(25px);
        -webkit-backdrop-filter: blur(25px);
        border: 1px solid rgba(255, 255, 255, 0.6);
        border-radius: 40px; /* Exact radius from source */
        padding: 55px 45px;
        width: 100%;
        max-width: 460px;
        text-align: center;
        box-shadow: 0 30px 60px -12px rgba(6, 58, 21, 0.15);
        z-index: 10;
        animation: revealCard 0.9s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    .brand-logo {
        height: 68px;
        width: auto;
        margin-bottom: 28px;
        filter: drop-shadow(0 12px 20px rgba(6, 58, 21, 0.12));
    }

    .auth-headline {
        font-weight: 800;
        font-size: 2.5rem;
        color: var(--brand-deep);
        letter-spacing: -1.5px;
        line-height: 1.1;
        margin-bottom: 12px;
    }

    .auth-subtitle {
        color: var(--text-muted);
        font-size: 1.05rem;
        line-height: 1.6;
        margin-bottom: 35px;
        font-weight: 500;
    }

    /* 5. Modern Button with the exact link's glow */
    .btn-action-primary {
        background: var(--brand-gradient);
        color: #FFFFFF !important;
        border: none;
        border-radius: 18px;
        padding: 18px 30px;
        font-weight: 700;
        font-size: 1.1rem;
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 12px 24px rgba(6, 58, 21, 0.2);
        text-decoration: none;
    }

    .btn-action-primary:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 20px 40px rgba(6, 58, 21, 0.3);
    }

    .btn-action-primary i {
        font-size: 1.2rem;
        opacity: 0.9;
    }

    .secondary-cta {
        margin-top: 25px;
        font-size: 0.95rem;
        color: var(--text-muted);
    }

    .secondary-cta a {
        color: var(--brand-deep);
        font-weight: 800;
        text-decoration: none;
        transition: color 0.2s;
    }

    .secondary-cta a:hover {
        color: var(--brand-emerald);
    }
</style>

<div class="page-wrapper">
    <div class="decorative-orb" style="top: -100px; left: -100px; background: var(--brand-bright);"></div>
    <div class="decorative-orb" style="bottom: -100px; right: -100px; background: var(--brand-deep);"></div>

    <div class="auth-card">
        <img src="https://www.genspark.ai/api/files/s/VDVJkiGL" alt="PAS Global Logo" class="brand-logo">
        
        <h1 class="auth-headline"><?php echo htmlspecialchars(t('welcome_back')); ?></h1>
        <p class="auth-subtitle"><?php echo htmlspecialchars(t('home_subtitle')); ?></p>

        <a href="?page=login" class="btn-action-primary">
            <i class="fas fa-shield-halved"></i> <?php echo htmlspecialchars(t('authorized_entry')); ?>
        </a>

        <div class="secondary-cta">
            <?php echo htmlspecialchars(t('already_registered') . ' '); ?> <a href="?page=register"><?php echo htmlspecialchars(t('request_access')); ?></a>
        </div>
    </div>
</div>

<?php require __DIR__ . '/layouts/footer.php'; ?>