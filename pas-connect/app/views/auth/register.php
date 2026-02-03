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
        /* Geometric pattern background */
        background-image: 
            radial-gradient(circle at 2px 2px, rgba(0,0,0,0.03) 1px, transparent 0);
        background-size: 40px 40px;
    }

    /* Split Screen Layout */
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

    /* Floating Decorative Elements */
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

    .register-card {
        width: 100%;
        max-width: 420px;
        animation: slideUp 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }

    @keyframes slideUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Form Styling Improvements */
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

    /* Submit Button */
    .btn-provision {
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

    .btn-provision:hover {
        background: #084d1d;
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(6, 58, 21, 0.15);
    }

    .step-indicator {
        display: flex;
        gap: 6px;
        margin-bottom: 30px;
    }

    .step-bar {
        height: 4px;
        flex: 1;
        background: #e2e8f0;
        border-radius: 2px;
    }

    .step-bar.active {
        background: var(--brand-bright);
    }
</style>

<div class="auth-wrapper">
    <div class="auth-visual-side">
        <div class="glass-orb"></div>
        <div style="z-index: 10;">
            <h1 class="display-4 fw-bold mb-3">Provision Your <br>Global Access.</h1>
            <p class="lead opacity-75">Connect with the PAS Network to manage your visual assets, engage in communities, and schedule global events.</p>
            
            <div class="mt-5 d-flex gap-4">
                <div class="small"><i class="fas fa-check-circle me-2"></i> Encrypted Identity</div>
                <div class="small"><i class="fas fa-check-circle me-2"></i> Global Connectivity</div>
            </div>
        </div>
    </div>

    <div class="auth-form-side">
        <div class="register-card">
            <div class="step-indicator">
                <div class="step-bar active"></div>
                <div class="step-bar"></div>
                <div class="step-bar"></div>
            </div>

            <h2 class="fw-800 text-dark mb-1"><?php echo htmlspecialchars(t('create_account')); ?></h2>
            <p class="text-muted small mb-4"><?php echo htmlspecialchars(t('enter_credentials')); ?></p>

            <form method="post" action="?page=auth_register">
                <div class="form-label-group">
                    <label class="custom-label"><?php echo htmlspecialchars(t('full_name')); ?></label>
                    <input type="text" name="name" class="form-control-custom" placeholder="e.g. Alexander Pierce">
                </div>

                <div class="form-label-group">
                    <label class="custom-label"><?php echo htmlspecialchars(t('email_address')); ?></label>
                    <input type="email" name="email" class="form-control-custom" placeholder="name@company.com" required>
                </div>
                
                <div class="row g-3">
                    <div class="col-6">
                        <div class="form-label-group">
                            <label class="custom-label"><?php echo htmlspecialchars(t('password')); ?></label>
                            <input type="password" name="password" class="form-control-custom" placeholder="••••••" required>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-label-group">
                            <label class="custom-label"><?php echo htmlspecialchars(t('confirm_password')); ?></label>
                            <input type="password" name="password_confirm" class="form-control-custom" placeholder="••••••" required>
                        </div>
                    </div>
                </div>

                <div class="form-check mb-4 mt-2">
                    <input class="form-check-input" type="checkbox" id="terms" required>
                    <label class="form-check-label small text-muted ms-2" for="terms">
                        <?php echo htmlspecialchars(t('privacy_accept')); ?>
                    </label>
                </div>

                <button type="submit" class="btn-provision">
                    <?php echo htmlspecialchars(t('establish_identity')); ?>
                </button>
            </form>

            <div class="text-center mt-4 pt-2">
                <span class="text-muted small"><?php echo htmlspecialchars(t('already_registered')); ?></span> 
                <a href="?page=login" class="text-dark fw-bold small text-decoration-none ms-1"><?php echo htmlspecialchars(t('sign_in')); ?></a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>