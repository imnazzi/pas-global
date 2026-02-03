<?php require __DIR__ . '/../layouts/header.php'; ?>

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    :root {
        --bg-body: #081a12;        /* Hijau sangat gelap (Latar belakang) */
        --card-bg: #0d261b;        /* Hijau gelap (Kad) */
        --brand-green: #10b981;    /* Hijau Emerald (Butang & Ikon) */
        --text-white: #ffffff;
        --text-gray: #94a3b8;
        --border-line: rgba(16, 185, 129, 0.1);
    }

    body {
        background-color: var(--bg-body);
        color: var(--text-white);
        font-family: 'Inter', sans-serif;
        margin: 0;
        padding: 0;
    }

    .dashboard-wrapper {
        padding: 40px 0;
    }

    /* Header */
    .welcome-text h1 {
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 5px;
    }

    .welcome-text p {
        color: var(--text-gray);
        font-size: 0.95rem;
    }

    /* Top Stats Grid - Sebijik macam dalam gambar */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: var(--card-bg);
        border: 1px solid var(--border-line);
        padding: 30px 20px;
        border-radius: 12px;
        text-align: left;
    }

    .stat-card .number {
        font-size: 3rem;
        font-weight: 800;
        display: block;
        line-height: 1;
        margin-bottom: 10px;
    }

    .stat-card .label {
        color: var(--text-gray);
        font-size: 0.85rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Main Content Layout */
    .main-grid {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 25px;
    }

    /* Sidebar Menu */
    .side-nav {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-line);
        overflow: hidden;
    }

    .nav-link-custom {
        display: flex;
        align-items: center;
        padding: 15px 20px;
        color: var(--text-gray);
        text-decoration: none !important;
        border-bottom: 1px solid rgba(255,255,255,0.03);
        transition: 0.2s;
    }

    .nav-link-custom i {
        width: 30px;
        font-size: 1.1rem;
        color: var(--brand-green);
    }

    .nav-link-custom:hover, .nav-link-custom.active {
        background: rgba(16, 185, 129, 0.1);
        color: var(--text-white);
    }

    /* Content Area (News Feed) */
    .content-area {
        background: var(--card-bg);
        border-radius: 12px;
        border: 1px solid var(--border-line);
        padding: 25px;
    }

    .content-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }

    .btn-announcement {
        background: var(--brand-green);
        color: #000;
        border: none;
        padding: 8px 18px;
        border-radius: 6px;
        font-weight: 700;
        font-size: 0.9rem;
    }

    /* Post Card Item */
    .post-item {
        background: rgba(0, 0, 0, 0.2);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        border-left: 4px solid var(--brand-green);
    }

    .post-user {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
    }

    .user-avatar {
        width: 40px;
        height: 40px;
        background: var(--brand-green);
        color: #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-right: 12px;
    }

    .post-meta h6 { margin: 0; font-size: 0.95rem; }
    .post-meta span { font-size: 0.75rem; color: var(--text-gray); }

    .post-content h5 {
        font-weight: 700;
        margin-bottom: 10px;
    }

    .post-content p {
        color: var(--text-gray);
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .post-footer {
        display: flex;
        gap: 20px;
        font-size: 0.85rem;
        color: var(--text-gray);
        margin-top: 15px;
    }

    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
        .main-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="dashboard-wrapper">
    <div class="container">
        <header class="welcome-text mb-4">
            <h1>Selamat Datang ke PAS Global Connect</h1>
            <p>Platform komunikasi khusus ahli PAS Luar Negara di seluruh dunia</p>
        </header>

        <div class="stats-row">
            <?php
            $pdo = getPDO();
            $stats_map = [
                'users' => 'Jumlah Ahli',
                'videos' => 'Negara Aktif',
                'community_posts' => 'Aktiviti Bulan Ini',
                'forums' => 'Topik Diskusi'
            ];
            foreach ($stats_map as $table => $label):
                $count = $pdo->query("SELECT COUNT(*) FROM `$table`")->fetchColumn();
            ?>
                <div class="stat-card">
                    <span class="number"><?= number_format($count); ?></span>
                    <span class="label"><?= $label; ?></span>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="main-grid">
            <aside>
                <div class="side-nav">
                    <a href="#" class="nav-link-custom active"><i class="fas fa-home"></i> Beranda</a>
                    <a href="?page=messages" class="nav-link-custom"><i class="fas fa-envelope"></i> Mesej</a>
                    <a href="?page=forums" class="nav-link-custom"><i class="fas fa-comments"></i> Forum</a>
                    <a href="?page=videos" class="nav-link-custom"><i class="fas fa-video"></i> Video Ceramah</a>
                    <a href="?page=community" class="nav-link-custom"><i class="fas fa-users"></i> Komuniti</a>
                </div>
            </aside>

            <main>
                <div class="content-area">
                    <div class="content-header">
                        <h4 class="m-0 fw-bold"><i class="far fa-newspaper me-2"></i> Berita & Pengumuman</h4>
                        <button class="btn-announcement">+ Buat Pengumuman</button>
                    </div>

                    <div class="post-item">
                        <div class="post-user">
                            <div class="user-avatar">A</div>
                            <div class="post-meta">
                                <h6>Ahmad bin Abdullah</h6>
                                <span>2 bulan yang lalu</span>
                            </div>
                        </div>
                        <div class="post-content">
                            <h5>Mesyuarat Agung Tahunan 2024</h5>
                            <p>Mesyuarat Agung Tahunan PAS Luar Negara akan diadakan pada bulan depan secara virtual. Semua ahli dijemput hadir untuk membincangkan hala tuju organisasi.</p>
                        </div>
                        <div class="post-footer">
                            <span><i class="far fa-heart"></i> 15</span>
                            <span><i class="far fa-comment"></i> 5</span>
                            <span><i class="fas fa-share"></i> Kongsi</span>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layouts/footer.php'; ?>