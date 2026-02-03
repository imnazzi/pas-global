<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PAS Global</title>
    
    <link rel="icon" type="image/png" href="https://www.genspark.ai/api/files/s/VDVJkiGL" sizes="32x32">
    <link rel="shortcut icon" href="public/img/favicon.ico">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="public/css/style.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --brand-deep: #063A15; 
            --brand-bright: #4ade80; 
            --brand-gradient: linear-gradient(135deg, #042d10 0%, #0a5c24 100%);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f0f4f2;
        }

        .custom-navbar {
            background: var(--brand-gradient);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 0.7rem 0;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }

        .navbar-brand {
            font-size: 1.25rem;
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        .nav-logo {
            height: 42px;
            width: auto;
            filter: drop-shadow(0 0 8px rgba(255,255,255,0.2));
            transition: transform 0.3s ease;
        }

        .navbar-brand:hover .nav-logo {
            transform: scale(1.05) rotate(2deg);
        }

        .btn-nav {
            border-radius: 12px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
            font-size: 0.85rem;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .btn-login {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #fff;
            transform: translateY(-2px);
        }

        .btn-register {
            background: #fff;
            color: var(--brand-deep);
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .btn-register:hover {
            background: var(--brand-bright);
            color: var(--brand-deep);
            transform: translateY(-2px);
        }

        .bell-icon {
            color: rgba(255,255,255,0.8);
        }

        .badge-notification {
            font-size: 0.6rem;
            top: 2px !important;
            right: 2px !important;
            border: 2px solid var(--brand-deep);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark custom-navbar">
  <div class="container">
    <a class="navbar-brand" href="?page=dashboard">
      <img src="public/img/logo-45.png" alt="PAS Global" class="nav-logo me-2" />
      <span class="fw-bold text-white">PAS <span style="color: var(--brand-bright);">Global</span></span>
    </a>

    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarMain">
      <div class="ms-auto d-flex align-items-center mt-3 mt-lg-0">
        <?php if (!empty($_SESSION['admin_id']) || !empty($_SESSION['user_id'])): ?>
          
          <div class="nav-item dropdown me-3">
            <a class="nav-link position-relative p-2" href="#" id="notifDropdown" role="button" data-bs-toggle="dropdown">
              <i class="fa-regular fa-bell fa-lg bell-icon"></i>
              <span id="notifBadge" class="position-absolute translate-middle badge rounded-pill bg-danger badge-notification" style="<?= ($unreadCount > 0) ? '' : 'display:none;' ?>">
                  <?= $unreadCount; ?>
              </span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end p-3 shadow-lg" style="min-width:300px;">
              <li class="text-center small text-muted"><?php echo htmlspecialchars(t('no_new_notifications')); ?></li>
            </ul>
          </div>

          <a href="?page=messages_inbox" class="btn btn-nav btn-login me-2">
              <i class="fa-regular fa-comment-dots me-1"></i> <?php echo htmlspecialchars(t('messages')); ?>
          </a>
          <a href="?page=logout" class="btn btn-nav btn-outline-danger btn-sm border-0 text-white"><?php echo htmlspecialchars(t('logout')); ?></a>

        <?php else: ?>
          <a href="?page=login" class="btn btn-nav btn-login me-2"><?php echo htmlspecialchars(t('login')); ?></a>
          <a href="?page=register" class="btn btn-nav btn-register"><?php echo htmlspecialchars(t('get_started')); ?></a>
        <?php endif; ?>

        <!-- Language switch -->
        <div class="dropdown ms-3">
            <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" id="langSwitch" data-bs-toggle="dropdown" aria-expanded="false">
                <?php echo strtoupper(get_locale()); ?>
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="langSwitch">
                <?php $__lang_base = strtok($_SERVER['REQUEST_URI'], '?'); $__qs = $_GET; $__qs['lang'] = 'en'; $linkEn = $__lang_base . '?' . http_build_query($__qs); $__qs['lang'] = 'ms'; $linkMs = $__lang_base . '?' . http_build_query($__qs); ?>
                <li><a class="dropdown-item" href="<?php echo htmlspecialchars($linkEn); ?>"><?php echo htmlspecialchars(t('lang_en')); ?></a></li>
                <li><a class="dropdown-item" href="<?php echo htmlspecialchars($linkMs); ?>"><?php echo htmlspecialchars(t('lang_ms')); ?></a></li>
            </ul>
        </div>

        <script>
            window.I18N = {
                confirm_delete: <?php echo json_encode(t('confirm_delete')); ?>,
                delete_failed: <?php echo json_encode(t('delete_failed')); ?>,
                cancel: <?php echo json_encode(t('cancel')); ?>
            };
        </script>
      </div>
    </div>
  </div>
</nav>

<div id="flashMessage" class="container mt-3" style="display:none; z-index:9999;"></div>

