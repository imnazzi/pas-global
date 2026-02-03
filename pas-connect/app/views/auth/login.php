<?php require __DIR__ . '/../layouts/header.php'; ?>

<style>
    :root {
        --brand-deep: #063a15;
        --brand-bright: #4ade80;
        --glass-bg: rgba(255, 255, 255, 0.7);
        --brand-gradient: linear-gradient(135deg, #063a15 0%, #10b981 100%);
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        background: #f0f4f2;
        background-image: 
            radial-gradient(circle at 2px 2px, rgba(0,0,0,0.03) 1px, transparent 0);
        background-size: 40px 40px;
    }

    /* Split Screen Layout - Matching Register */
    .auth-visual-side {
        flex: 1;
        background: var(--brand-gradient);
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 60px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .auth-form-side {
        width: 550px;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 40px;
        background: #f8fafc;
    }

    @media (max-width: 992px) {
        .auth-visual-side { display: none; }
        .auth-form-side { width: 100%; }
    }

    /* Decorative Orb - Matching Register */
    .glass-orb {
        position: absolute;
        width: 300px;
        height: 300px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        backdrop-filter: blur(50px);
        top: -100px;
        right: -100px;
    }

    .login-card {
        width: 100%;
        max-width: 420px;
        animation: slideUp 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Form Styling - Matching Register */
    .form-label-group {
        position: relative;
        margin-bottom: 20px;
    }

    .form-control-custom {
        width: 100%;
        padding: 16px 20px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        transition: all 0.3s;
        font-size: 0.95rem;
    }

    .form-control-custom:focus {
        border-color: var(--brand-bright);
        box-shadow: 0 0 0 4px rgba(74, 222, 128, 0.1);
        outline: none;
    }

    .custom-label {
        font-size: 0.8rem;
        font-weight: 700;
        color: var(--brand-deep);
        text-transform: uppercase;
        letter-spacing: 0.05em;
        margin-bottom: 8px;
        display: block;
    }

    /* Submit Button - Matching Register */
    .btn-authorize {
        background: var(--brand-deep);
        color: white;
        border: none;
        width: 100%;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        letter-spacing: 0.5px;
        transition: all 0.3s;
        margin-top: 10px;
    }

    .btn-authorize:hover {
        background: #084d1d;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(6, 58, 21, 0.15);
    }

    /* Mirroring the Progress Bar as a "Security Status" */
    .security-bar {
        display: flex;
        gap: 6px;
        margin-bottom: 30px;
    }

    .bar-segment {
        height: 4px;
        flex: 1;
        background: var(--brand-bright);
        border-radius: 2px;
        opacity: 0.3;
    }

    .bar-segment.filled {
        opacity: 1;
    }
</style>

<div class="auth-wrapper">
    <div class="auth-visual-side">
        <div class="glass-orb"></div>
        <div style="z-index: 10;">
            <h1 class="display-4 fw-bold mb-3"><?php echo htmlspecialchars(t('welcome_back')); ?> <br>to the Network.</h1>
            <p class="lead opacity-75"><?php echo htmlspecialchars(t('login_instructions')); ?></p>
            
            <div class="mt-5 d-flex gap-4">
                <div class="small"><i class="fas fa-shield-alt me-2"></i> Authorized Access</div>
                <div class="small"><i class="fas fa-history me-2"></i> Real-time Sync</div>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="login-card">
            <div class="security-bar">
                <div class="bar-segment filled"></div>
                <div class="bar-segment filled"></div>
                <div class="bar-segment filled"></div>
            </div>

            <h2 class="fw-800 text-dark mb-1"><?php echo htmlspecialchars(t('sign_in')); ?></h2>
            <p class="text-muted small mb-4"><?php echo htmlspecialchars(t('login_instructions')); ?></p>

            <form method="post" action="?page=auth_login">
                <div class="form-label-group">
                    <label class="custom-label">Email Address</label>
                    <input type="email" name="email" class="form-control-custom" placeholder="name@company.com" required autofocus>
                </div>

                <div class="form-label-group">
                    <div class="d-flex justify-content-between align-items-center">
                        <label class="custom-label">Password</label>
                        <a href="#" class="text-muted x-small text-decoration-none mb-2" style="font-size: 0.7rem; font-weight: 700;">FORGOT?</a>
                    </div>
                    <input type="password" name="password" class="form-control-custom" placeholder="••••••••" required>
                </div>

                <div class="form-check mb-4 mt-2">
                    <input class="form-check-input" type="checkbox" id="remember">
                    <label class="form-check-label small text-muted ms-2" for="remember">
                        Trust this device for 30 days
                    </label>
                </div>

                <button type="submit" class="btn-authorize">
                    <?php echo htmlspecialchars(t('verify_identity')); ?>
                </button>
            </form>

            <div class="text-center mt-4 pt-2">
                <span class="text-muted small"><?php echo htmlspecialchars(t('already_registered')); ?></span> 
                <a href="?page=register" class="text-dark fw-bold small text-decoration-none ms-1"><?php echo htmlspecialchars(t('request_access')); ?></a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>