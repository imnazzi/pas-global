# 📸 PANDUAN VISUAL: Deploy ke Netlify (Step-by-Step dengan Screenshots)

**Platform**: PAS Global Connect  
**Method**: Manual Deploy (Paling Mudah)  
**Time**: 10 minit

---

## 🎯 **OVERVIEW**

```
Step 1: Buat Akaun Netlify      (2 minit)
Step 2: Sediakan Project Files  (3 minit)
Step 3: Upload ke Netlify       (2 minit)
Step 4: Site Live!              (1 minit)
Step 5: Setup Admin & Test      (2 minit)
────────────────────────────────────────
Total: 10 minit ✅
```

---

## 📋 **STEP 1: Buat Akaun Netlify** (2 minit)

### **1.1 Pergi ke Netlify**
```
URL: https://www.netlify.com
```

**What you see:**
- Homepage dengan "Sign up" button
- "Get started for free" banner

**Action:**
- Click "Sign up" (top right corner)

---

### **1.2 Pilih Sign Up Method**

**Options:**
```
A. GitHub (DISYORKAN) ⭐
   - Fast & easy
   - Good for future updates
   - Automatic deployments

B. GitLab
   - If you use GitLab

C. Bitbucket
   - If you use Bitbucket

D. Email
   - Traditional email/password
   - Slower but works
```

**Recommended:**
- Click "GitHub"
- Authorize Netlify
- Create account (free)

---

### **1.3 Verify Email**

**What happens:**
- Netlify sends verification email
- Check inbox/spam folder
- Click verification link
- Account activated! ✅

---

## 📁 **STEP 2: Sediakan Project Files** (3 minit)

### **2.1 Download Project Files**

**Dari mana?**
- Jika dari development environment ini, semua files sudah ada
- Pastikan ada SEMUA files dan folders

---

### **2.2 Check File Structure**

**CRITICAL: Pastikan struktur betul!**

```
pas-global-connect/          ← Main folder
│
├── index.html               ← Login page ✅
├── register.html            ← Basic registration
├── register-full.html       ← Full registration ✅
├── dashboard.html           ← Dashboard ✅
├── chat.html               
├── forum.html              
├── videos.html             
├── community.html          
├── calendar.html           
├── profile.html            
├── test-system.html         ← Admin setup ✅
├── presentation.html       
├── presentation-updated.html
│
├── netlify.toml             ← Netlify config ✅
├── _redirects               ← Routing config ✅
├── README.md               
│
├── css/                     ← CSS folder ✅
│   ├── style.css
│   ├── chat.css
│   └── videos.css
│
└── js/                      ← JavaScript folder ✅
    ├── utils.js
    ├── auth.js
    ├── dashboard.js
    ├── chat.js
    ├── forum.js
    ├── videos.js
    ├── community.js
    ├── calendar.js
    └── register-full.js
```

---

### **2.3 Verify Critical Files**

**Must Have:**
```
✅ netlify.toml   (Netlify configuration)
✅ _redirects     (Routing rules)
✅ index.html     (Landing/Login page)
✅ css/ folder    (All stylesheets)
✅ js/ folder     (All JavaScript files)
```

**Check:**
```bash
# In your project folder, check:
ls -la

# Should see:
# - netlify.toml
# - _redirects
# - index.html
# - css/
# - js/
```

---

## 🚀 **STEP 3: Upload ke Netlify** (2 minit)

### **3.1 Login ke Netlify Dashboard**

```
URL: https://app.netlify.com
```

**What you see:**
- Dashboard dengan "Sites" page
- "Add new site" button
- List of your sites (kosong jika baru)

---

### **3.2 Click "Add New Site"**

**Location:**
- Top right corner
- Green button "Add new site"

**What appears:**
- Dropdown menu dengan options:
  1. Import an existing project
  2. Deploy manually
  3. Start from template

**Action:**
- Click "Deploy manually" ⭐

---

### **3.3 Drag & Drop Your Site**

**What you see:**
```
┌─────────────────────────────────────┐
│                                     │
│   Drag and drop your site folder    │
│            output here              │
│                                     │
│         [Browse to upload]          │
│                                     │
└─────────────────────────────────────┘
```

**Action:**

**METHOD A: Drag & Drop** (Easiest)
```
1. Open File Explorer/Finder
2. Navigate to pas-global-connect folder
3. Select THE ENTIRE FOLDER
4. Drag folder to Netlify upload box
5. Drop!
```

**METHOD B: Browse Upload**
```
1. Click "Browse to upload"
2. Select pas-global-connect folder
3. Click "Open" or "Select"
```

**IMPORTANT:**
- ⚠️ Upload THE FOLDER, not individual files
- ⚠️ Make sure netlify.toml is included
- ⚠️ Make sure _redirects is included

---

### **3.4 Wait for Upload**

**Progress stages:**
```
Stage 1: Uploading files...
├─ index.html ✓
├─ css/style.css ✓
├─ js/utils.js ✓
└─ [all other files] ✓

Stage 2: Processing...
├─ Checking files ✓
├─ Reading configuration ✓
└─ Preparing deployment ✓

Stage 3: Building...
├─ No build needed (static site) ✓
└─ Skipping build step ✓

Stage 4: Deploying...
├─ Publishing to CDN ✓
├─ Configuring domain ✓
└─ Generating SSL certificate ✓

Stage 5: Site Live! ✅
└─ https://random-name-123456.netlify.app
```

**Time:** Usually 30-60 seconds

---

## 🎉 **STEP 4: Site Live!** (1 minit)

### **4.1 Success Screen**

**What you see:**
```
╔═══════════════════════════════════════╗
║  🎉 Site is live!                     ║
╠═══════════════════════════════════════╣
║  URL: https://random-name-123456      ║
║       .netlify.app                    ║
╠═══════════════════════════════════════╣
║  [Open production deploy]             ║
║  [Site settings]                      ║
╚═══════════════════════════════════════╝
```

**Your site is now:**
- ✅ Live on internet
- ✅ Accessible globally
- ✅ HTTPS enabled (secure)
- ✅ Fast (CDN)

---

### **4.2 Change Site Name** (Optional)

**Default URL:** `https://random-name-123456.netlify.app`
**Better URL:** `https://pasglobalconnect.netlify.app`

**How to change:**
```
1. Click "Site settings"
2. Under "Site information"
3. Click "Change site name"
4. Enter: pasglobalconnect (or your choice)
5. Click "Save"
6. New URL: https://pasglobalconnect.netlify.app ✅
```

**Note:**
- Name must be unique (not taken by others)
- Only letters, numbers, hyphens allowed
- No spaces or special characters

---

## ✅ **STEP 5: Setup Admin & Test** (2 minit)

### **5.1 Initialize Admin Accounts**

```
1. Open: https://pasglobalconnect.netlify.app/test-system.html
2. Click: "Initialize Admin Accounts"
3. Wait: 4 accounts created
4. Verify: Success messages ✅
```

---

### **5.2 Test Login**

```
1. In test-system.html
2. Click: "Test Master Admin Login"
3. Verify: Login successful ✅
```

---

### **5.3 Login to Platform**

```
1. Go to: https://pasglobalconnect.netlify.app
2. Enter:
   Email: master@pasglobalconnect.com
   Password: MasterAdmin@2026
3. Click: Log Masuk
4. SUCCESS: Dashboard opens! ✅
```

---

## 📊 **DEPLOYMENT SUMMARY**

```
╔════════════════════════════════════════╗
║  DEPLOYMENT COMPLETE ✅                ║
╠════════════════════════════════════════╣
║  Platform: PAS Global Connect          ║
║  Hosting: Netlify                      ║
║  URL: https://pasglobalconnect         ║
║       .netlify.app                     ║
║  Status: LIVE ✅                       ║
║  HTTPS: Enabled ✅                     ║
║  CDN: Global ✅                        ║
╠════════════════════════════════════════╣
║  Time Taken: ~10 minutes               ║
║  Admin Accounts: 4 Ready               ║
║  Pages: All Working                    ║
╚════════════════════════════════════════╝
```

---

## 🔍 **VERIFICATION CHECKLIST**

### **After Deployment:**

**Basic Checks:**
- [ ] Site URL accessible
- [ ] Login page loads
- [ ] CSS styling appears correctly
- [ ] Logo displays
- [ ] Navigation links work

**Functionality Checks:**
- [ ] test-system.html accessible
- [ ] Admin initialization works
- [ ] Login works (Master Admin)
- [ ] Registration works (new user)
- [ ] Dashboard accessible after login
- [ ] All menu links work
- [ ] External links open (Pautan PAS, etc.)

**Mobile Checks:**
- [ ] Site responsive on mobile
- [ ] Touch interactions work
- [ ] Forms usable on mobile
- [ ] Menu accessible

**Performance Checks:**
- [ ] Page loads fast (<3 seconds)
- [ ] Images load correctly
- [ ] No broken links
- [ ] No console errors

---

## 🎯 **WHAT'S NEXT?**

### **1. Share URL**
```
Site URL: https://pasglobalconnect.netlify.app
Admin URL: https://pasglobalconnect.netlify.app/test-system.html

Share dengan:
✓ Master Admin
✓ Regional Admins
✓ PAS members
```

---

### **2. Setup Admins**
```
Send credentials:
- Master Admin: master@pasglobalconnect.com / MasterAdmin@2026
- Admin 1: admin1@pasglobalconnect.com / Admin1@2026
- Admin 2: admin2@pasglobalconnect.com / Admin2@2026
- Admin 3: admin3@pasglobalconnect.com / Admin3@2026
```

---

### **3. Monitor Site**
```
Netlify Dashboard:
✓ View deploy history
✓ Check bandwidth usage
✓ Monitor performance
✓ View analytics
```

---

### **4. Future Updates**
```
To update site:
1. Make changes locally
2. Go to Netlify dashboard
3. Deploys → Drag new folder
4. Site auto-updates!
```

---

## 💡 **TIPS BERGUNA**

### **Tip 1: Custom Domain**
```
Free: yourname.netlify.app
Paid: yourdomain.com

To add custom domain:
1. Buy domain (Namecheap, GoDaddy, etc.)
2. Netlify → Domain settings
3. Add custom domain
4. Update DNS records
```

---

### **Tip 2: Environment Variables**
```
For API keys (future):
1. Site settings → Environment variables
2. Add key-value pairs
3. Access in JavaScript via process.env
```

---

### **Tip 3: Form Handling**
```
Netlify Forms (jika perlu):
1. Add netlify attribute to <form>
2. Forms auto-submit to Netlify
3. View submissions in dashboard
```

---

### **Tip 4: Analytics**
```
Free analytics included:
1. Site settings → Analytics
2. Enable Netlify Analytics ($9/month)
   OR
3. Use Google Analytics (free)
```

---

## 🚨 **COMMON ISSUES**

### **Issue 1: Upload Stuck**
```
Problem: Upload not completing
Solution:
1. Check internet connection
2. Try smaller batch upload
3. Clear browser cache
4. Try different browser
```

---

### **Issue 2: Site Name Taken**
```
Problem: "Site name already exists"
Solution:
1. Try different name
2. Add numbers: pasglobalconnect2026
3. Add hyphens: pas-global-connect
```

---

### **Issue 3: 404 Errors**
```
Problem: Pages showing "Not found"
Solution:
1. Check _redirects file uploaded
2. Check netlify.toml uploaded
3. Redeploy site
```

---

### **Issue 4: CSS Not Loading**
```
Problem: Site appears unstyled
Solution:
1. Check css/ folder uploaded
2. Check file paths in HTML
3. Clear browser cache
4. Hard refresh (Ctrl+F5)
```

---

## 📞 **NEED HELP?**

### **Resources:**
```
📖 Netlify Docs: https://docs.netlify.com
💬 Community: https://answers.netlify.com
📧 Support: https://www.netlify.com/support

📖 PAS Global Connect:
   - NETLIFY-DEPLOYMENT-GUIDE.md (detailed)
   - README.md (platform info)
   - QUICKSTART-LOGIN.md (quick setup)
```

---

## 🎊 **CONGRATULATIONS!**

```
╔═══════════════════════════════════════╗
║  🎉 YOUR SITE IS LIVE!                ║
╠═══════════════════════════════════════╣
║  Platform: PAS Global Connect         ║
║  URL: https://pasglobalconnect        ║
║       .netlify.app                    ║
╠═══════════════════════════════════════╣
║  ✅ Secure (HTTPS)                    ║
║  ✅ Fast (Global CDN)                 ║
║  ✅ Reliable (99.9% uptime)           ║
║  ✅ Free Forever                      ║
╚═══════════════════════════════════════╝
```

---

**Selamat! Site anda sudah online dan accessible di seluruh dunia! 🌍🚀**

**Platform**: PAS Global Connect  
**Hosting**: Netlify  
**Date**: Januari 2026

---

**© 2026 PAS Global Connect - Visual Deployment Guide**
