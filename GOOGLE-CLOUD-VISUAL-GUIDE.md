# 📸 PANDUAN VISUAL: Deploy ke Google Cloud (Firebase Hosting)

**Platform**: PAS Global Connect  
**Method**: Firebase Hosting  
**Time**: 10 minit  
**Cost**: FREE

---

## 🎯 **OVERVIEW**

```
Step 1: Install Firebase CLI      (2 minit)
Step 2: Login Firebase             (1 minit)
Step 3: Create Firebase Project    (2 minit)
Step 4: Initialize Project         (2 minit)
Step 5: Deploy Site                (1 minit)
Step 6: Verify & Test              (2 minit)
──────────────────────────────────────────
Total: 10 minit ✅
```

---

## 📋 **STEP 1: Install Firebase CLI** (2 minit)

### **1.1 Install Node.js** (if not installed)

**Download Node.js:**
```
URL: https://nodejs.org
```

**What you see:**
```
┌─────────────────────────────────────┐
│  Node.js                            │
│                                     │
│  LTS (Recommended)                  │
│  [Download for Windows/Mac/Linux]   │
│                                     │
│  Latest Features                    │
│  [Download Current]                 │
└─────────────────────────────────────┘
```

**Action:**
1. Click "LTS" (Long Term Support)
2. Download installer
3. Run installer
4. Follow wizard (Next, Next, Install)
5. Finish

**Verify installation:**
```bash
# Open Terminal/Command Prompt
node --version
# Should show: v18.x.x or v20.x.x

npm --version
# Should show: 9.x.x or 10.x.x
```

---

### **1.2 Install Firebase CLI**

**Open Terminal/Command Prompt:**

**Windows:**
```
Press: Windows Key + R
Type: cmd
Press: Enter
```

**Mac:**
```
Press: Cmd + Space
Type: terminal
Press: Enter
```

**Install Firebase:**
```bash
npm install -g firebase-tools
```

**What happens:**
```
Installing firebase-tools...
████████████████████ 100%
+ firebase-tools@13.0.0
added 627 packages in 45s
✓ Installation complete!
```

**Verify:**
```bash
firebase --version
# Should show: 13.0.0 or higher
```

---

## 🔐 **STEP 2: Login Firebase** (1 minit)

### **2.1 Login Command**

```bash
firebase login
```

**What happens:**
```
? Allow Firebase to collect CLI and Emulator Suite usage
  and error reporting information? (Y/n)
```

**Action:** Type `Y` and press Enter

---

### **2.2 Browser Opens**

**You'll see:**
```
┌─────────────────────────────────────┐
│  Google Sign In                     │
│                                     │
│  Choose an account:                 │
│  ○ youremail@gmail.com              │
│  ○ Use another account              │
│                                     │
│  [Continue]                         │
└─────────────────────────────────────┘
```

**Action:**
1. Select your Google account
2. Click "Continue"

---

### **2.3 Grant Permissions**

**Firebase CLI wants to:**
```
✓ View and manage your data across Google Cloud services
✓ View and administer all your Firebase data

[Allow]  [Cancel]
```

**Action:** Click "Allow"

---

### **2.4 Success!**

**Browser shows:**
```
✓ Success!
Firebase CLI Login Successful

You may now close this tab.
```

**Terminal shows:**
```
✔ Success! Logged in as youremail@gmail.com
```

---

## 🎨 **STEP 3: Create Firebase Project** (2 minit)

### **3.1 Open Firebase Console**

```
URL: https://console.firebase.google.com
```

**What you see:**
```
┌─────────────────────────────────────┐
│  Firebase Console                   │
│                                     │
│  Welcome to Firebase                │
│                                     │
│  [+ Add project]                    │
│                                     │
│  Your existing projects:            │
│  (empty or list of projects)        │
└─────────────────────────────────────┘
```

**Action:** Click "+ Add project"

---

### **3.2 Create Project - Step 1**

**Enter project name:**
```
┌─────────────────────────────────────┐
│  Create a project                   │
│                                     │
│  Project name:                      │
│  [pas-global-connect___________]    │
│                                     │
│  ● Your Firebase resources will be  │
│    identified with this name        │
│                                     │
│  [Continue]  [Cancel]               │
└─────────────────────────────────────┘
```

**Action:**
1. Type: `pas-global-connect`
2. Click "Continue"

---

### **3.3 Create Project - Step 2**

**Google Analytics:**
```
┌─────────────────────────────────────┐
│  Google Analytics for your project  │
│                                     │
│  ○ Enable Google Analytics          │
│  ● Disable (Recommended for demo)   │
│                                     │
│  [Continue]  [Back]                 │
└─────────────────────────────────────┘
```

**Action:**
1. Select "Disable"  (simpler for now)
2. Click "Continue"

---

### **3.4 Creating Project**

**Wait screen:**
```
Creating your project...
████████████████ 80%

Setting up Firebase...
```

**Time:** 20-40 seconds

---

### **3.5 Project Ready!**

**Success screen:**
```
┌─────────────────────────────────────┐
│  Your new project is ready!         │
│                                     │
│  pas-global-connect                 │
│                                     │
│  [Continue]                         │
└─────────────────────────────────────┘
```

**Action:** Click "Continue"

---

## ⚙️ **STEP 4: Initialize Project** (2 minit)

### **4.1 Navigate to Project Folder**

**In Terminal:**
```bash
# Windows
cd C:\Users\YourName\pas-global-connect

# Mac/Linux
cd ~/pas-global-connect
```

**Verify you're in correct folder:**
```bash
# List files
dir    # Windows
ls     # Mac/Linux

# Should see:
# index.html, css/, js/, etc.
```

---

### **4.2 Initialize Firebase**

```bash
firebase init hosting
```

**What happens:**
```
     ######## #### ########  ######## ########     ###     ######  ########
     ##        ##  ##     ## ##       ##     ##  ##   ##  ##       ##
     ######    ##  ########  ######   ########  #########  ######  ######
     ##        ##  ##    ##  ##       ##     ## ##     ##       ## ##
     ##       #### ##     ## ######## ########  ##     ##  ######  ########

You're about to initialize a Firebase project in this directory:
  C:\Users\YourName\pas-global-connect

? Are you ready to proceed? (Y/n)
```

**Action:** Press `Y` then Enter

---

### **4.3 Select Project**

```
? Please select an option:
  ○ Use an existing project
  ○ Create a new project
  ○ Don't set up a default project
```

**Action:**
1. Use arrow keys to select "Use an existing project"
2. Press Enter

**Then:**
```
? Select a default Firebase project:
  ○ pas-global-connect (pas-global-connect)
  ○ other-project
```

**Action:**
1. Select "pas-global-connect"
2. Press Enter

---

### **4.4 Configure Hosting**

**Question 1: Public directory**
```
? What do you want to use as your public directory?
  (public)
```

**Action:**
1. Delete "public"
2. Type: `.` (just a dot)
3. Press Enter

**Question 2: Single-page app**
```
? Configure as a single-page app (rewrite all urls to /index.html)?
  (y/N)
```

**Action:**
1. Type: `y`
2. Press Enter

**Question 3: GitHub setup**
```
? Set up automatic builds and deploys with GitHub?
  (y/N)
```

**Action:**
1. Type: `n`
2. Press Enter

**Question 4: Overwrite index.html**
```
? File index.html already exists. Overwrite?
  (y/N)
```

**Action:**
1. Type: `n` (NO! Keep existing)
2. Press Enter

---

### **4.5 Initialization Complete**

**Success message:**
```
✔ Firebase initialization complete!

Files created:
✓ firebase.json
✓ .firebaserc
```

---

## 🚀 **STEP 5: Deploy Site** (1 minit)

### **5.1 Deploy Command**

```bash
firebase deploy --only hosting
```

**What happens:**
```
=== Deploying to 'pas-global-connect'...

i  deploying hosting
i  hosting[pas-global-connect]: beginning deploy...
i  hosting[pas-global-connect]: found 50 files in .
✔  hosting[pas-global-connect]: file upload complete
i  hosting[pas-global-connect]: finalizing version...
✔  hosting[pas-global-connect]: version finalized
i  hosting[pas-global-connect]: releasing new version...
✔  hosting[pas-global-connect]: release complete

✔  Deploy complete!

Project Console: 
  https://console.firebase.google.com/project/pas-global-connect/overview

Hosting URL: 
  https://pas-global-connect.web.app
```

---

### **5.2 Copy Your URL**

**Your site is now live at:**
```
Primary URL:
https://pas-global-connect.web.app

Alternative URL:
https://pas-global-connect.firebaseapp.com
```

**Both URLs work the same!**

---

## ✅ **STEP 6: Verify & Test** (2 minit)

### **6.1 Open Site in Browser**

**Option A: Click URL in terminal**
- Control + Click (Windows/Linux)
- Command + Click (Mac)

**Option B: Copy & paste URL:**
```
https://pas-global-connect.web.app
```

---

### **6.2 What You Should See**

**Login Page:**
```
┌─────────────────────────────────────┐
│  [PAS GLOBAL CONNECT LOGO]          │
│                                     │
│  PAS Global Connect                 │
│  Connecting Hearts Worldwide        │
│                                     │
│  Email or Phone:                    │
│  [_____________________________]    │
│                                     │
│  Password:                          │
│  [_____________________________] 👁  │
│                                     │
│  ☐ Remember me    Forgot password?  │
│                                     │
│  [Log Masuk]                        │
│                                     │
│  Don't have account? Register       │
└─────────────────────────────────────┘
```

**Check:**
- ✓ Logo displays
- ✓ Styling correct (colors, layout)
- ✓ Forms visible
- ✓ Links clickable

---

### **6.3 Test Pages**

**Navigate to:**
```
✓ https://pas-global-connect.web.app/
✓ https://pas-global-connect.web.app/register-full.html
✓ https://pas-global-connect.web.app/dashboard.html
✓ https://pas-global-connect.web.app/test-system.html
```

**All should load correctly!**

---

### **6.4 Test Mobile**

**On phone:**
1. Open browser
2. Go to: pas-global-connect.web.app
3. Check responsive layout
4. Test touch interactions

---

## 🎯 **DEPLOYMENT CHECKLIST**

```
✅ Prerequisites:
   ✓ Node.js installed
   ✓ Firebase CLI installed
   ✓ Google account ready

✅ Project Setup:
   ✓ Firebase project created
   ✓ Project initialized locally
   ✓ firebase.json configured

✅ Deployment:
   ✓ Files uploaded successfully
   ✓ Site accessible via URL
   ✓ HTTPS working (padlock icon)
   ✓ All pages load correctly

✅ Verification:
   ✓ Login page displays
   ✓ CSS styling works
   ✓ Images load
   ✓ Navigation works
   ✓ Mobile responsive
```

---

## 🔄 **HOW TO UPDATE SITE**

### **After Making Changes:**

```bash
# 1. Edit your files
# (make changes to HTML/CSS/JS)

# 2. Deploy updated version
firebase deploy --only hosting

# Wait ~30 seconds

# 3. Refresh browser
# Changes live!
```

**Simple as that! 🚀**

---

## 🌐 **ADD CUSTOM DOMAIN**

### **Via Firebase Console:**

```
1. Firebase Console → Hosting
2. Click "Add custom domain"
3. Enter: pasglobalconnect.com
4. Verify ownership
5. Update DNS records:
   
   Type: A
   Name: @
   Value: 151.101.1.195
   
   Type: A
   Name: @
   Value: 151.101.65.195
   
6. Wait 5-30 minutes
7. SSL auto-provisioned
8. Domain active! ✅
```

---

## 🎨 **FIREBASE CONSOLE TOUR**

### **Main Dashboard:**

```
┌─────────────────────────────────────┐
│  pas-global-connect                 │
├─────────────────────────────────────┤
│  🏠 Project Overview                │
│  🔨 Build                           │
│     ├─ Authentication               │
│     ├─ Firestore Database           │
│     ├─ Storage                      │
│     └─ Hosting ← YOU ARE HERE       │
│  📊 Analytics                       │
│  ⚙️  Project settings               │
└─────────────────────────────────────┘
```

---

### **Hosting Dashboard:**

```
┌─────────────────────────────────────┐
│  Hosting                            │
├─────────────────────────────────────┤
│  🌐 Domains                         │
│     pas-global-connect.web.app      │
│     pas-global-connect.firebaseapp  │
│                                     │
│  📦 Deployments                     │
│     ✓ Live (just now)               │
│     - Version abc123                │
│     - 50 files, 2.3 MB              │
│                                     │
│  📊 Usage                           │
│     Storage: 100 MB / 10 GB         │
│     Transfer: 0 GB / 10 GB          │
│                                     │
│  [Deploy] [Add domain] [Settings]   │
└─────────────────────────────────────┘
```

---

## 💡 **PRO TIPS**

### **Tip 1: Local Preview**

```bash
# Test before deploy
firebase serve

# Opens at: http://localhost:5000
# Test thoroughly
# Then deploy for real
```

---

### **Tip 2: Deploy Specific Files**

```bash
# Deploy only CSS changes
firebase deploy --only hosting

# Much faster than full deploy
```

---

### **Tip 3: Rollback**

```bash
# View versions
firebase hosting:channel:list

# Rollback if needed
firebase hosting:rollback
```

---

### **Tip 4: Multiple Sites**

```bash
# Add another site to same project
firebase hosting:sites:create pas-global-connect-staging

# Deploy to staging
firebase deploy --only hosting:pas-global-connect-staging
```

---

## 🚨 **COMMON ISSUES & SOLUTIONS**

### **Issue 1: "Firebase not recognized"**

**Solution:**
```bash
# Close and reopen terminal
# Or add to PATH manually

# Windows: Add to Environment Variables
# Mac: Add to ~/.bash_profile or ~/.zshrc
export PATH="$PATH:$(npm config get prefix)/bin"
```

---

### **Issue 2: "Permission denied"**

**Solution:**
```bash
# Mac/Linux: Use sudo
sudo npm install -g firebase-tools

# Or fix npm permissions
mkdir ~/.npm-global
npm config set prefix '~/.npm-global'
echo 'export PATH=~/.npm-global/bin:$PATH' >> ~/.profile
source ~/.profile
```

---

### **Issue 3: "404 Not Found"**

**Solution:**
```
Check firebase.json:
- "public": "." (dot, not "public")
- Rewrites configured correctly
- index.html in root directory

Redeploy:
firebase deploy --only hosting --force
```

---

### **Issue 4: "Old version showing"**

**Solution:**
```
1. Hard refresh browser:
   Ctrl + Shift + R (Windows/Linux)
   Cmd + Shift + R (Mac)

2. Clear cache

3. Check deployment complete:
   firebase hosting:channel:list
```

---

## 🎊 **SUCCESS!**

```
╔═══════════════════════════════════════════╗
║  🎉 DEPLOYMENT COMPLETE!                  ║
╠═══════════════════════════════════════════╣
║  Platform: PAS Global Connect             ║
║  Hosting: Firebase (Google Cloud)         ║
║  URL: https://pas-global-connect.web.app  ║
╠═══════════════════════════════════════════╣
║  ✅ Global CDN                            ║
║  ✅ Free SSL Certificate                  ║
║  ✅ Automatic HTTPS                       ║
║  ✅ 99.95% Uptime SLA                     ║
║  ✅ Fast Load Times                       ║
╠═══════════════════════════════════════════╣
║  Setup Time: 10 minutes                   ║
║  Cost: $0/month (FREE)                    ║
║  Status: PRODUCTION READY ✅              ║
╚═══════════════════════════════════════════╝
```

---

## 📱 **SHARE YOUR SITE**

**Site URL:**
```
https://pas-global-connect.web.app
```

**Share with:**
- ✉️ Email team members
- 💬 WhatsApp groups
- 📱 Social media
- 📋 Presentations

**QR Code:**
```
Generate at: https://www.qr-code-generator.com
Enter URL: https://pas-global-connect.web.app
Download & share QR code
```

---

## 🎓 **NEXT STEPS**

### **Immediate:**
```
✓ Share URL with stakeholders
✓ Test all features
✓ Gather feedback
✓ Monitor usage in Firebase Console
```

### **Soon:**
```
✓ Add custom domain (optional)
✓ Setup Firebase Authentication
✓ Add Firestore database
✓ Enable analytics
```

### **Future:**
```
✓ CI/CD with GitHub Actions
✓ Multiple environments
✓ Performance monitoring
✓ A/B testing
```

---

**Tahniah! Site anda telah berjaya di-deploy ke Google Cloud! 🚀**

**Platform**: PAS Global Connect  
**Hosting**: Firebase Hosting (Google Cloud)  
**Status**: Live & Production Ready ✅  
**Date**: Januari 2026

---

**© 2026 PAS Global Connect - Visual Deployment Guide (Google Cloud)**
