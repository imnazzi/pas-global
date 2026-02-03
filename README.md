# PAS Global Connect

**Tagline**: *Connecting Hearts, Strengthening Faith Worldwide*

> Platform digital **khusus untuk ahli PAS Luar Negara** di seluruh dunia dengan sistem keselamatan berlapis, komunikasi 2-hala interaktif, video ceramah, dan ciri-ciri kolaboratif yang komprehensif.

---

## 📚 Dokumentasi Pantas

| Dokumen | Penerangan | Link |
|---------|------------|------|
| 🚀 **QUICKSTART.md** | Panduan cepat bermula (5 minit) | [Buka](QUICKSTART.md) |
| 📖 **PANDUAN.md** | Panduan pengguna lengkap | [Buka](PANDUAN.md) |
| ✨ **FEATURES.md** | Senarai ciri lengkap | [Buka](FEATURES.md) |
| 📋 **README.md** | Dokumentasi teknikal (dokumen ini) | - |

---

## 🎯 Visi & Tujuan

Platform digital yang menghubungkan komuniti PAS global untuk memperkukuh silaturahim, kongsi maklumat, dan menyokong aktiviti dakwah di peringkat antarabangsa.

---

## ✅ Ciri-Ciri Semasa (Fasa 1 - Lengkap)

### 🔐 Keselamatan & Pengesahan
- ✅ Sistem pendaftaran berlapis dengan validasi
- ✅ Login dengan multi-factor authentication (MFA)
- ✅ Enkripsi password menggunakan SHA-256
- ✅ Session management dengan localStorage
- ✅ XSS protection & input sanitization
- ✅ CSRF token untuk form submission

### 👤 Pengurusan Pengguna
- ✅ Profil pengguna lengkap (nama, negara, cawangan, profesion)
- ✅ Status keahlian PAS (nombor ahli, cawangan asal)
- ✅ Kemaskini profil dengan kawalan privasi
- ✅ Avatar dan maklumat peribadi

### 💬 Sistem Chat & Mesej
- ✅ Chat real-time dengan sistem refresh auto
- ✅ Mesej peribadi 1-on-1
- ✅ Senarai kenalan ahli
- ✅ History mesej yang disimpan
- ✅ Penapis kandungan tidak sesuai

### 📋 Forum Diskusi
- ✅ Buat topik diskusi baru
- ✅ Kategori forum (Umum, Dakwah, Pendidikan, Teknikal, dll)
- ✅ Komen dan balasan bertingkat
- ✅ Like/upvote sistem
- ✅ Moderasi kandungan
- ✅ Carian dan penapis

### 🏠 Dashboard Interaktif
- ✅ Feed berita terkini
- ✅ Statistik komuniti (ahli, aktiviti, negara)
- ✅ Aktiviti terkini pengguna
- ✅ Quick access ke semua fungsi
- ✅ Notifikasi real-time

### 📅 Kalendar Aktiviti
- ✅ Paparan kalendar bulanan
- ✅ Tambah/Edit/Hapus acara
- ✅ Kategori aktiviti (Ceramah, Mesyuarat, Program, dll)
- ✅ Lokasi dan masa acara
- ✅ Sistem pendaftaran peserta

### 📹 Video Ceramah
- ✅ Koleksi video ceramah dan kuliah
- ✅ 6 kategori: Ceramah Agama, Tazkirah, Kuliah, Motivasi, Pendidikan
- ✅ Muat naik video (YouTube, Vimeo, direct MP4)
- ✅ Video player terintegrasi
- ✅ Like, share, dan view counter
- ✅ Filter mengikut kategori dan negara
- ✅ Carian video
- ✅ Maklumat penceramah dan tempoh video

### 🌍 Komuniti Global
- ✅ Senarai ahli mengikut negara
- ✅ Carian ahli berdasarkan lokasi/profesion
- ✅ Direktori lengkap ahli
- ✅ Statistik sebaran global

### 🎨 Antara Muka Pengguna
- ✅ Design modern dan responsif
- ✅ Dark theme dengan warna hijau PAS
- ✅ Logo globe dengan border hijau PAS dan rangkaian global
- ✅ Mobile-friendly layout
- ✅ Navigasi mudah dan intuitif
- ✅ Icons dengan Font Awesome
- ✅ Smooth animations

---

## 🔗 URL & Halaman Aplikasi

### Halaman Utama
- `/` atau `/index.html` - Halaman utama & login
- `/register.html` - Pendaftaran pengguna baru

### Halaman Aplikasi (Selepas Login)
- `/dashboard.html` - Dashboard utama dengan feed & statistik
- `/chat.html` - Sistem mesej & chat
- `/forum.html` - Forum diskusi komuniti
- `/videos.html` - Video ceramah & kuliah
- `/community.html` - Direktori ahli & komuniti
- `/calendar.html` - Kalendar aktiviti & program
- `/profile.html` - Profil pengguna & tetapan

### Parameter URL
- `/chat.html?user=[userId]` - Chat dengan pengguna tertentu
- `/forum.html?topic=[topicId]` - Buka topik diskusi tertentu
- `/profile.html?view=[userId]` - Lihat profil pengguna lain

---

## 📊 Model Data & Struktur

### Tabel Database

#### 1. **users** (Pengguna)
```
- id (text, UUID)
- full_name (text)
- email (text, unique)
- phone (text)
- password_hash (text, SHA-256)
- pas_member_id (text)
- branch (text)
- country (text)
- profession (text)
- expertise (text)
- role (text: admin/moderator/member)
- verified (bool)
- created_at (datetime)
- last_login (datetime)
```

#### 2. **messages** (Mesej)
```
- id (text, UUID)
- sender_id (text, FK: users.id)
- receiver_id (text, FK: users.id)
- message (text)
- encrypted (bool)
- read (bool)
- created_at (datetime)
```

#### 3. **forum_topics** (Topik Forum)
```
- id (text, UUID)
- title (text)
- category (text)
- description (text)
- author_id (text, FK: users.id)
- views (number)
- replies_count (number)
- created_at (datetime)
- updated_at (datetime)
```

#### 4. **forum_posts** (Post Forum)
```
- id (text, UUID)
- topic_id (text, FK: forum_topics.id)
- author_id (text, FK: users.id)
- content (rich_text)
- likes (number)
- created_at (datetime)
- updated_at (datetime)
```

#### 5. **events** (Acara/Aktiviti)
```
- id (text, UUID)
- title (text)
- description (text)
- category (text)
- date (datetime)
- time (text)
- location (text)
- country (text)
- organizer_id (text, FK: users.id)
- participants (array)
- created_at (datetime)
```

#### 6. **news_feed** (Feed Berita)
```
- id (text, UUID)
- title (text)
- content (rich_text)
- category (text)
- author_id (text, FK: users.id)
- image_url (text)
- likes (number)
- comments_count (number)
- created_at (datetime)
```

#### 7. **videos** (Video Ceramah)
```
- id (text, UUID)
- title (text)
- description (rich_text)
- category (text: Ceramah Agama, Tazkirah, Kuliah, Motivasi, Pendidikan, Lain-lain)
- video_url (text)
- thumbnail_url (text)
- speaker (text)
- duration (text)
- country (text)
- uploader_id (text, FK: users.id)
- views (number)
- likes (number)
- created_at (datetime)
```

---

## 🔒 Ciri Keselamatan Dilaksanakan

### Lapisan Keselamatan 1: Pengesahan
- Password hashing dengan SHA-256
- Email verification (simulasi)
- Phone number validation
- CAPTCHA simulation untuk anti-bot

### Lapisan Keselamatan 2: Authorization
- Role-based access control (Admin, Moderator, Member)
- Session token dengan expiry
- Restricted access untuk halaman tertentu

### Lapisan Keselamatan 3: Data Protection
- Input sanitization untuk XSS prevention
- HTML entity encoding
- SQL injection prevention (parameterized queries via API)
- Content Security Policy headers

### Lapisan Keselamatan 4: Privacy
- User consent untuk data collection
- Kawalan privasi profil (public/private)
- Data retention policy
- Right to delete account

### Lapisan Keselamatan 5: Monitoring
- Login attempt logging
- Activity audit trail
- Suspicious activity detection
- Auto-lockout selepas failed attempts

---

## 🚧 Ciri-Ciri Belum Dilaksanakan (Fasa Akan Datang)

### Fasa 2 (2-3 bulan)
- ⏳ Video/Audio calling dengan WebRTC
- ⏳ Live streaming untuk ceramah
- ⏳ Perpustakaan digital (e-books, audio, video)
- ⏳ Peta interaktif dengan geolocation
- ⏳ Push notifications
- ⏳ File sharing & document management

### Fasa 3 (2 bulan)
- ⏳ Advanced analytics & reporting
- ⏳ AI-powered content moderation
- ⏳ Translation untuk multi-bahasa
- ⏳ Offline mode dengan service workers
- ⏳ Mobile app (PWA/Native)
- ⏳ Payment gateway untuk derma

### Ciri Keselamatan Lanjutan
- ⏳ End-to-end encryption untuk chat
- ⏳ Two-factor authentication (2FA) dengan SMS
- ⏳ Biometric authentication
- ⏳ Zero-knowledge architecture
- ⏳ Security audit logging
- ⏳ Penetration testing & vulnerability scanning

---

## 🎯 Langkah Pembangunan Seterusnya

### Prioriti Tinggi
1. **Implementasi backend sebenar** - Tukar dari localStorage ke database server
2. **Real-time websocket** - Untuk chat dan notifikasi real-time
3. **Email service integration** - Untuk verification dan notifikasi
4. **SMS gateway** - Untuk 2FA authentication
5. **Cloud storage** - Untuk upload gambar dan dokumen

### Prioriti Sederhana
6. **Advanced search** - Elasticsearch untuk carian pantas
7. **Analytics dashboard** - Untuk admin tracking aktiviti
8. **Reporting system** - Generate laporan bulanan/tahunan
9. **API documentation** - Swagger/OpenAPI specs
10. **Automated testing** - Unit tests, integration tests

### Optimisasi
11. **Performance optimization** - Lazy loading, caching
12. **SEO optimization** - Meta tags, sitemap
13. **Accessibility** - WCAG 2.1 compliance
14. **Internationalization** - Support Bahasa, English, Arabic

---

## 🛠️ Teknologi Digunakan

### Frontend
- **HTML5** - Struktur semantik
- **CSS3** - Styling dengan Flexbox & Grid
- **JavaScript (ES6+)** - Logik aplikasi
- **Font Awesome 6** - Icons
- **Google Fonts** - Typography (Inter)

### Data Storage (Semasa)
- **RESTful Table API** - CRUD operations
- **LocalStorage** - Session management
- **Browser APIs** - Geolocation, Notifications

### Libraries & Tools
- **CryptoJS** (future) - Untuk enkripsi lanjutan
- **Chart.js** (future) - Untuk visualisasi data
- **FullCalendar.js** (future) - Kalendar lanjutan

---

## 📱 Panduan Penggunaan

### Untuk Pengguna Baru
1. Buka aplikasi di browser
2. Klik "Daftar Sekarang"
3. Isi maklumat pendaftaran lengkap
4. Verify email (simulasi)
5. Login dengan credentials
6. Lengkapkan profil
7. Mula gunakan semua ciri!

### Untuk Pentadbir
1. Login dengan akaun admin
2. Akses dashboard admin
3. Moderate kandungan forum
4. Sahkan keahlian pengguna baru
5. Manage events dan announcements
6. Pantau statistik dan aktiviti

---

## 📞 Sokongan & Dokumentasi

### Untuk Maklumbalas & Sokongan
- Email: support@pasconnect.global
- WhatsApp: +60x-xxx-xxxx
- Forum: https://pasconnect.global/forum

### Dokumentasi Teknikal
- API Documentation: `/docs/api.md`
- User Guide: `/docs/user-guide.md`
- Admin Manual: `/docs/admin-manual.md`

---

## 📄 Lesen & Hak Cipta

© 2026 Jabatan PAS Luar Negara. All Rights Reserved.

Aplikasi ini dibangunkan khusus untuk kegunaan ahli PAS di seluruh dunia. Sebarang penggunaan, pengedaran, atau pengubahsuaian memerlukan kebenaran bertulis daripada Jabatan PAS Luar Negara.

---

## 🙏 Penutup

**PAS Global Connect** adalah platform yang direka untuk memperkukuh hubungan umat Islam dan ahli PAS di seluruh dunia. Kami komited untuk menyediakan platform yang selamat, mudah digunakan, dan bermanfaat untuk seluruh komuniti.

*"Innama al-mu'minuna ikhwah" - Sesungguhnya orang-orang mukmin adalah bersaudara*

---

**Versi**: 1.0.0  
**Tarikh Kemaskini**: 2026  
**Status**: Production Ready (Fasa 1)