# 🚀 PANDUAN LENGKAP: Deploy ke Netlify

**Platform**: PAS Global Connect  
**Tarikh**: Januari 2026  
**Deployment**: Netlify.app

---

## 📋 **ISI KANDUNGAN**

1. [Cara 1: Deploy Melalui Netlify Website (Paling Mudah)](#cara-1-deploy-melalui-netlify-website)
2. [Cara 2: Deploy Menggunakan Netlify CLI](#cara-2-deploy-menggunakan-netlify-cli)
3. [Cara 3: Deploy dari GitHub](#cara-3-deploy-dari-github)
4. [Konfigurasi & Setup](#konfigurasi--setup)
5. [Testing Selepas Deploy](#testing-selepas-deploy)
6. [Troubleshooting](#troubleshooting)

---

## 🎯 **CARA 1: Deploy Melalui Netlify Website** (PALING MUDAH)

### **Step 1: Buat Akaun Netlify** (2 minit)

1. **Pergi ke**: https://www.netlify.com
2. **Klik**: "Sign up" (Sudut kanan atas)
3. **Pilih salah satu**:
   - Sign up with GitHub (Disyorkan)
   - Sign up with GitLab
   - Sign up with Bitbucket
   - Sign up with Email

---

### **Step 2: Sediakan Files** (5 minit)

**PENTING**: Anda perlu ada SEMUA files projek dalam satu folder.

**Struktur folder yang betul:**
```
pas-global-connect/
├── index.html
├── register.html
├── register-full.html
├── dashboard.html
├── chat.html
├── forum.html
├── videos.html
├── community.html
├── calendar.html
├── profile.html
├── test-system.html
├── presentation.html
├── presentation-updated.html
├── css/
│   ├── style.css
│   ├── chat.css
│   └── videos.css
├── js/
│   ├── utils.js
│   ├── auth.js
│   ├── dashboard.js
│   ├── chat.js
│   ├── forum.js
│   ├── videos.js
│   ├── community.js
│   ├── calendar.js
│   └── register-full.js
├── netlify.toml
├── _redirects
└── README.md
```

---

### **Step 3: Deploy via Drag & Drop** (3 minit)

#### **A. Login ke Netlify**
1. Pergi ke: https://app.netlify.com
2. Login dengan akaun anda

#### **B. Deploy Project**
1. **Klik**: "Add new site" (atau "Sites" → "Add new site")
2. **Pilih**: "Deploy manually"
3. **Drag & Drop**: 
   - Buka folder `pas-global-connect` di komputer anda
   - **DRAG seluruh folder** ke kotak "Drag and drop your site output folder here"
   - ATAU klik "Browse to upload" dan pilih folder

#### **C. Tunggu Upload**
```
Uploading files... ⏳
Processing... ⏳
Building... ⏳
Deploying... ⏳
SUCCESS! ✅
```

#### **D. Site Live!**
- Netlify akan beri URL: `https://random-name-123456.netlify.app`
- **Site anda sudah LIVE!** 🎉

---

### **Step 4: Custom Domain (Optional)** (5 minit)

#### **A. Tukar Site Name**
1. Dalam Netlify dashboard
2. Klik site anda
3. **Site settings** → **Site details**
4. **Change site name**
5. Masukkan nama pilihan: `pasglobalconnect` atau `pas-connect`
6. URL baru: `https://pasglobalconnect.netlify.app` ✅

#### **B. Custom Domain (Jika ada)**
1. **Domain settings**
2. **Add custom domain**
3. Masukkan domain anda: `pasglobalconnect.com`
4. Ikut arahan untuk setup DNS

---

## 🖥️ **CARA 2: Deploy Menggunakan Netlify CLI**

### **Step 1: Install Netlify CLI**

```bash
# Install menggunakan npm (Node.js required)
npm install -g netlify-cli

# Verify installation
netlify --version
```

---

### **Step 2: Login ke Netlify**

```bash
# Login command
netlify login

# Browser akan terbuka → Authorize
```

---

### **Step 3: Deploy Project**

```bash
# Navigate ke project folder
cd pas-global-connect

# Deploy (first time)
netlify deploy

# Jawab soalan:
# ? Create & configure a new site: Yes
# ? Team: [Pilih team anda]
# ? Site name: pasglobalconnect (optional)
# ? Publish directory: . (current directory)

# Deploy akan upload files
# Netlify beri DRAFT URL untuk preview
```

---

### **Step 4: Deploy Production**

```bash
# Selepas test draft URL, deploy production
netlify deploy --prod

# Site akan live di production URL!
```

---

## 🔗 **CARA 3: Deploy dari GitHub**

### **Step 1: Push ke GitHub** (Jika belum ada)

```bash
# Initialize git (jika belum)
cd pas-global-connect
git init

# Add all files
git add .

# Commit
git commit -m "Initial commit - PAS Global Connect"

# Create repo di GitHub, then:
git remote add origin https://github.com/yourusername/pas-global-connect.git
git branch -M main
git push -u origin main
```

---

### **Step 2: Connect ke Netlify**

1. **Login** ke Netlify: https://app.netlify.com
2. **Klik**: "Add new site" → "Import an existing project"
3. **Pilih**: "GitHub"
4. **Authorize**: Netlify to access GitHub
5. **Pilih**: Repository `pas-global-connect`
6. **Build settings**:
   - Build command: (leave empty - no build needed)
   - Publish directory: `/` (root)
7. **Klik**: "Deploy site"

---

### **Step 3: Automatic Deployments**

```
✅ Setiap kali push ke GitHub → Auto deploy!
✅ Pull request → Preview deploy
✅ Main branch → Production deploy
```

---

## ⚙️ **KONFIGURASI & SETUP**

### **File 1: `netlify.toml`** (Configuration)

File ini sudah dibuat untuk anda. Ia mengandungi:

```toml
[build]
  publish = "."
  
[build.environment]
  NODE_VERSION = "18"

[[redirects]]
  from = "/*"
  to = "/index.html"
  status = 200
```

**Kegunaan:**
- `publish = "."` → Root directory
- Redirects → Untuk single-page routing

---

### **File 2: `_redirects`** (Routing)

File ini sudah dibuat untuk anda:

```
/*    /index.html   200
```

**Kegunaan:**
- Handle client-side routing
- Semua routes pergi ke index.html

---

## 🧪 **TESTING SELEPAS DEPLOY**

### **Checklist Testing:**

#### **1. Test Pages** ✅
```
✓ https://yoursite.netlify.app/
✓ https://yoursite.netlify.app/register-full.html
✓ https://yoursite.netlify.app/dashboard.html
✓ https://yoursite.netlify.app/test-system.html
```

#### **2. Test Functionality** ✅
```
✓ Initialize admin accounts (test-system.html)
✓ Login dengan Master Admin
✓ Register new user
✓ Access dashboard
✓ Navigate ke semua pages
```

#### **3. Test External Links** ✅
```
✓ Pautan Rasmi PAS (semua buka)
✓ Pautan Lain-lain (semua buka)
```

#### **4. Test Responsive** ✅
```
✓ Desktop view
✓ Tablet view (iPad)
✓ Mobile view (iPhone)
```

---

## 🔍 **TROUBLESHOOTING**

### **Problem 1: "Page not found" error**

**Solution:**
```
1. Check _redirects file exists
2. Check netlify.toml exists
3. Redeploy site:
   - Deploys → Trigger deploy → Deploy site
```

---

### **Problem 2: CSS/JS tidak load**

**Symptoms:**
- Page putih
- No styling
- Console errors

**Solution:**
```
1. Check file paths dalam HTML:
   - Must use relative paths
   - ✅ src="js/utils.js"
   - ❌ src="/js/utils.js"
   
2. Check case sensitivity:
   - ✅ style.css
   - ❌ Style.css (Netlify case-sensitive)
   
3. Check files uploaded:
   - Netlify dashboard → Deploys → Latest deploy
   - Check "Deploy log"
```

---

### **Problem 3: API/Database tidak berfungsi**

**Important:**
```
⚠️ RESTful Table API hanya berfungsi dalam development environment!

Untuk production, anda perlu:
1. Setup backend sendiri (Node.js, PHP, etc.)
2. Atau gunakan Firebase/Supabase
3. Atau deploy di platform yang support server-side
```

**Quick Fix (Development):**
- Guna netlify dev untuk local testing dengan API

---

### **Problem 4: "Build failed" error**

**Solution:**
```
Static site (HTML/CSS/JS) tidak perlu build!

1. Build settings → Edit settings
2. Build command: (leave empty)
3. Publish directory: .
4. Save → Redeploy
```

---

## 📊 **DEPLOYMENT CHECKLIST**

### **Before Deploy:**
- [x] Semua files ada dalam folder
- [x] netlify.toml created
- [x] _redirects file created
- [x] Test login locally (test-system.html)
- [x] All links working
- [x] External links open correctly

### **After Deploy:**
- [ ] Site accessible via Netlify URL
- [ ] All pages load correctly
- [ ] CSS/JS load correctly
- [ ] Images display correctly
- [ ] Forms work (registration)
- [ ] Login works (test-system.html)
- [ ] Admin accounts initialized
- [ ] All navigation links work
- [ ] Mobile responsive
- [ ] External links work

---

## 🎯 **DEPLOYMENT OPTIONS**

### **Option A: Manual Deploy** (Quickest)
```
Pros: Very fast, no setup needed
Cons: Manual upload setiap kali update
Best for: Testing, quick demos
Time: 5 minutes
```

### **Option B: CLI Deploy**
```
Pros: Command-line control, faster updates
Cons: Need to install Node.js & CLI
Best for: Developers, frequent updates
Time: 10 minutes setup
```

### **Option C: GitHub Deploy**
```
Pros: Automatic deploy on push, version control
Cons: Need GitHub account, git knowledge
Best for: Team collaboration, production
Time: 15 minutes setup
```

---

## 💡 **TIPS & BEST PRACTICES**

### **1. Site Name**
```
✅ Good: pasglobalconnect, pas-connect, pasconnect
❌ Bad: random-name-123456
```

### **2. Custom Domain**
```
Free subdomain: yourname.netlify.app
Custom domain: pasglobalconnect.com (perlu beli domain)
```

### **3. Environment**
```
Development: test-system.html visible
Production: Hide test-system.html (optional)
```

### **4. Security**
```
✅ HTTPS automatic (Netlify provides free SSL)
✅ Password hashing (SHA-256)
❌ Don't commit passwords to GitHub
```

### **5. Performance**
```
✅ Netlify CDN (fast globally)
✅ Gzip compression (automatic)
✅ Caching (automatic)
```

---

## 📈 **SELEPAS DEPLOY**

### **Share Your Site:**
```
🔗 Netlify URL: https://pasglobalconnect.netlify.app
📱 Mobile friendly: Yes
🔒 HTTPS: Yes (automatic)
🌍 Global CDN: Yes (fast everywhere)
```

### **Admin Setup:**
```
1. Share URL dengan admin
2. Buka: https://yoursite.netlify.app/test-system.html
3. Initialize admin accounts
4. Login via: https://yoursite.netlify.app/
5. Start using!
```

---

## 🎉 **DEPLOY SUCCESS!**

```
╔═══════════════════════════════════════════╗
║  NETLIFY DEPLOYMENT - SUCCESS ✅          ║
╠═══════════════════════════════════════════╣
║  Your site is live at:                    ║
║  https://pasglobalconnect.netlify.app     ║
╠═══════════════════════════════════════════╣
║  ✅ HTTPS Enabled                         ║
║  ✅ Global CDN                            ║
║  ✅ Free SSL Certificate                  ║
║  ✅ Automatic Compression                 ║
║  ✅ Fast Loading                          ║
╠═══════════════════════════════════════════╣
║  STATUS: PRODUCTION READY ✅              ║
╚═══════════════════════════════════════════╝
```

---

## 📞 **SUPPORT**

### **Netlify Support:**
- Documentation: https://docs.netlify.com
- Support: https://www.netlify.com/support
- Community: https://answers.netlify.com

### **PAS Global Connect:**
- Documentation: README.md
- Quick Start: QUICKSTART-LOGIN.md
- Troubleshooting: LOGIN-REGISTRATION-FIX.md

---

## 🔄 **UPDATE SITE (After Deploy)**

### **Method 1: Drag & Drop**
```
1. Make changes locally
2. Netlify dashboard → Deploys
3. Drag updated folder
4. Site auto-updates!
```

### **Method 2: CLI**
```bash
netlify deploy --prod
```

### **Method 3: GitHub**
```bash
git add .
git commit -m "Update"
git push
# Auto deploys!
```

---

**Platform**: PAS Global Connect  
**Deployment**: Netlify.app  
**Status**: Ready to Deploy ✅  
**Date**: Januari 2026

---

**© 2026 PAS Global Connect - Deployment Guide**

**Selamat Deploy! 🚀**
