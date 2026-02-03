# PAS Global / PAS Connect

Ini adalah rangka awal untuk aplikasi penuh PAS Connect (PHP + MySQL + Bootstrap).

Mula cepat (XAMPP):
1. Salin folder ini ke dalam `htdocs` XAMPP anda (sudah diletakkan di sini jika anda membuka projek ini dalam persekitaran XAMPP anda).
2. Import skema DB: `mysql -u root < sql/schema.sql` atau gunakan phpMyAdmin dan import `sql/schema.sql`.
3. Edit `config/db.php` jika kelayakan MySQL anda berbeza.
4. Jalankan skrip seed untuk membuat akaun Master Admin:
   `php scripts/seed_admin.php`
5. Buka di penyemak imbas: `http://localhost/pas-global/pas-connect/`

Kelayakan admin seed (lalai):

- Master admin (disediakan oleh `scripts/seed_admin.php`):
  - Emel: `master@pas.local`
  - Kata Laluan: `Admin@123`

- Admin sampel tambahan (jalankan `php scripts/seed_admins_full.php` untuk membuat):
  - `master@pasglobalconnect.com` / `password` (Master Admin)
  - `admin1@pasglobalconnect.com` / `password` (Sub Admin)
  - `admin2@pasglobalconnect.com` / `password` (Sub Admin)
  - `admin3@pasglobalconnect.com` / `password` (Sub Admin)

Nota: tukar ini untuk persekitaran pengeluaran. Kata laluan disimpan dalam DB selepas di-hash menggunakan bcrypt.

**Logo:** Logo utama tapak telah dikemas kini kepada fail logo rasmi PAS Global Connect `public/img/logo-final.png` (gantikan dengan PNG resolusi penuh jika perlu). — Dikemas kini 2026-02-01

Nota keselamatan:
- Ini adalah rangka permulaan. Untuk pengeluaran: konfigurasikan HTTPS, tetapan sesi yang ketat, dan pindahkan konfigurasi sensitif di luar webroot.

Terjemahan:
- Antara muka pengguna kini menyokong Bahasa Melayu dan ditetapkan sebagai lalai. Tukar bahasa menggunakan dropdown di bar navigasi atau tambahkan `?lang=en` untuk kembali ke English jika perlu.
