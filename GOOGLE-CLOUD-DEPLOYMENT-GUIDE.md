# 🚀 PANDUAN LENGKAP: Deploy ke Google Cloud Platform (GCP)

**Platform**: PAS Global Connect  
**Tarikh**: Januari 2026  
**Deployment**: Google Cloud Platform (3 Methods)

---

## 📋 **ISI KANDUNGAN**

1. [Overview - Pilihan GCP](#overview---pilihan-gcp)
2. [Method 1: Firebase Hosting (RECOMMENDED)](#method-1-firebase-hosting)
3. [Method 2: Google Cloud Storage](#method-2-google-cloud-storage)
4. [Method 3: Google App Engine](#method-3-google-app-engine)
5. [Comparison & Recommendations](#comparison--recommendations)
6. [Troubleshooting](#troubleshooting)

---

## 🌟 **OVERVIEW - PILIHAN GCP**

Google Cloud Platform menawarkan **3 cara** untuk host static website:

### **Option A: Firebase Hosting** ⭐ (RECOMMENDED)

```
✅ Fastest setup (10 minutes)
✅ FREE SSL certificate
✅ Global CDN
✅ Custom domain support
✅ CLI deployment
✅ Automatic HTTPS redirect
✅ Single-page app support
✅ Easy rollback
✅ Preview channels

Free Tier:
- 10GB storage
- 360MB/day bandwidth
- Custom domain included
```

**Best for:** PAS Global Connect (Perfect match!)

---

### **Option B: Google Cloud Storage**

```
✅ Simple storage bucket
✅ Cheap (pay per GB)
✅ Good for large files
✅ No build process
✅ Direct upload

Free Tier:
- 5GB storage/month
- 1GB network egress/month

Limitations:
- No automatic HTTPS (need Load Balancer)
- More manual setup
- No instant rollback
```

**Best for:** Large static files, simple hosting

---

### **Option C: Google App Engine**

```
✅ Full application platform
✅ Automatic scaling
✅ Multiple environments
✅ Version management
✅ Traffic splitting

Free Tier:
- 28 frontend instance hours/day
- 1GB outbound traffic/day

Limitations:
- Overkill for static site
- More complex
- Slower deployment
```

**Best for:** Dynamic web applications (not static)

---

## 🏆 **METHOD 1: Firebase Hosting** (RECOMMENDED)

### **Why Firebase Hosting?**

```
🎯 Perfect for PAS Global Connect:
✅ Part of Google Cloud
✅ Static site optimized
✅ Fast global CDN
✅ Free SSL
✅ Easy CLI deployment
✅ GitHub integration
✅ Preview deployments
✅ Instant rollback
✅ Custom domains
✅ FREE tier generous

Performance:
- Global CDN (180+ locations)
- HTTP/2 support
- Gzip compression
- SSD storage
```

---

### **STEP 1: Install Firebase CLI** (2 minit)

#### **Prerequisites:**
- Node.js installed (Download from https://nodejs.org)
- npm (comes with Node.js)

#### **Install Firebase Tools:**

```bash
# Install globally via npm
npm install -g firebase-tools

# Verify installation
firebase --version
# Should show: 13.x.x or higher
```

**Troubleshooting:**
```bash
# If permission error on Mac/Linux:
sudo npm install -g firebase-tools

# If Windows error:
# Run PowerShell as Administrator
npm install -g firebase-tools
```

---

### **STEP 2: Login to Firebase** (1 minit)

```bash
# Login command
firebase login

# Browser will open
# Sign in with Google account
# Grant permissions
# Return to terminal

# Verify login
firebase projects:list
```

**What you see:**
```
✔ Success! Logged in as your-email@gmail.com
```

---

### **STEP 3: Create Firebase Project** (3 minit)

#### **Option A: Via Web Console** (Easier)

```
1. Go to: https://console.firebase.google.com
2. Click: "Add project"
3. Project name: pas-global-connect
4. Accept terms
5. Disable Google Analytics (optional)
6. Click: "Create project"
7. Wait ~30 seconds
8. Click: "Continue"
```

#### **Option B: Via CLI**

```bash
# Create new project
firebase projects:create pas-global-connect

# Select project
firebase use pas-global-connect
```

---

### **STEP 4: Initialize Firebase in Project** (2 minit)

```bash
# Navigate to your project folder
cd pas-global-connect

# Initialize Firebase
firebase init hosting

# Answer questions:
```

**Interactive Setup:**
```
? Are you ready to proceed? Yes

? What do you want to use as your public directory?
  → Type: . (dot means current directory)
  → Press Enter

? Configure as a single-page app? 
  → Yes (rewrite all URLs to /index.html)

? Set up automatic builds with GitHub? 
  → No (for now, can add later)

? File ./index.html already exists. Overwrite? 
  → No (keep existing file)
```

**Files Created:**
```
✅ firebase.json (config file)
✅ .firebaserc (project settings)
```

---

### **STEP 5: Configure firebase.json** (1 minit)

**Default firebase.json:**
```json
{
  "hosting": {
    "public": ".",
    "ignore": [
      "firebase.json",
      "**/.*",
      "**/node_modules/**"
    ],
    "rewrites": [
      {
        "source": "**",
        "destination": "/index.html"
      }
    ]
  }
}
```

**Improved firebase.json for PAS Global Connect:**
```json
{
  "hosting": {
    "public": ".",
    "ignore": [
      "firebase.json",
      "**/.*",
      "**/node_modules/**",
      "**/*.md",
      "**/wrangler.toml",
      "**/netlify.toml"
    ],
    "rewrites": [
      {
        "source": "**",
        "destination": "/index.html"
      }
    ],
    "headers": [
      {
        "source": "**/*.@(css|js)",
        "headers": [
          {
            "key": "Cache-Control",
            "value": "max-age=31536000"
          }
        ]
      },
      {
        "source": "**/*.@(jpg|jpeg|gif|png|svg|webp)",
        "headers": [
          {
            "key": "Cache-Control",
            "value": "max-age=31536000"
          }
        ]
      },
      {
        "source": "**",
        "headers": [
          {
            "key": "X-Content-Type-Options",
            "value": "nosniff"
          },
          {
            "key": "X-Frame-Options",
            "value": "DENY"
          },
          {
            "key": "X-XSS-Protection",
            "value": "1; mode=block"
          }
        ]
      }
    ],
    "cleanUrls": true,
    "trailingSlash": false
  }
}
```

---

### **STEP 6: Deploy!** (1 minit)

```bash
# Deploy to Firebase Hosting
firebase deploy --only hosting

# Or shorter version
firebase deploy
```

**Deployment Process:**
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

Project Console: https://console.firebase.google.com/project/pas-global-connect/overview
Hosting URL: https://pas-global-connect.web.app
```

**Your site is now LIVE! 🎉**

---

### **STEP 7: Custom Domain** (Optional, 5 minit)

#### **Add Custom Domain:**

```bash
# Via CLI
firebase hosting:channel:deploy production --only hosting

# Or via Console:
```

**Web Console Steps:**
```
1. Firebase Console → Hosting
2. Click: "Add custom domain"
3. Enter domain: pasglobalconnect.com
4. Follow DNS setup instructions:
   - Add A records
   - Or CNAME record
5. Wait for verification (5-30 minutes)
6. SSL certificate auto-provisioned
7. Domain active! ✅
```

**DNS Records (Example):**
```
Type: A
Name: @
Value: 151.101.1.195 (or provided by Firebase)

Type: A  
Name: @
Value: 151.101.65.195
```

---

## 📊 **METHOD 2: Google Cloud Storage**

### **When to Use:**
- Simple static hosting
- Large files
- No need for CDN features
- Cost-conscious (pay only what you use)

---

### **STEP 1: Create Storage Bucket** (3 minit)

#### **Via Web Console:**

```
1. Go to: https://console.cloud.google.com
2. Create/Select project
3. Navigation menu → Cloud Storage → Buckets
4. Click: "Create bucket"
5. Name: pas-global-connect (must be globally unique)
6. Location: asia-southeast1 (Singapore)
7. Storage class: Standard
8. Access control: Fine-grained
9. Create
```

---

### **STEP 2: Upload Files** (5 minit)

#### **Via Console:**

```
1. Open bucket: pas-global-connect
2. Click: "Upload files"
3. Select all files from project folder
4. Wait for upload
5. Set permissions:
   - Select all files
   - Permissions → Add principal
   - New principals: allUsers
   - Role: Storage Object Viewer
   - Save
```

#### **Via gsutil (CLI):**

```bash
# Install Google Cloud SDK first
# Download from: https://cloud.google.com/sdk/docs/install

# Authenticate
gcloud auth login

# Set project
gcloud config set project pas-global-connect

# Upload files
gsutil -m cp -r * gs://pas-global-connect/

# Make files public
gsutil iam ch allUsers:objectViewer gs://pas-global-connect
```

---

### **STEP 3: Enable Website Configuration** (2 minit)

```bash
# Set index page
gsutil web set -m index.html gs://pas-global-connect

# Set 404 page (optional)
gsutil web set -e 404.html gs://pas-global-connect
```

**Your site URL:**
```
https://storage.googleapis.com/pas-global-connect/index.html
```

---

### **STEP 4: Custom Domain with Load Balancer** (15 minit)

**Required for HTTPS with custom domain:**

```
1. Reserve static IP
2. Create load balancer
3. Backend: Cloud Storage bucket
4. Frontend: HTTPS with SSL cert
5. Update DNS to point to IP
6. Wait for propagation
```

**Cost:** ~$18/month for load balancer

---

## 🔧 **METHOD 3: Google App Engine**

### **When to Use:**
- Need server-side processing
- Dynamic content
- Multiple environments
- Advanced routing

**Note:** Overkill for static site like PAS Global Connect

---

### **Quick Setup:**

#### **STEP 1: Create app.yaml**

```yaml
runtime: python39

handlers:
- url: /css
  static_dir: css

- url: /js
  static_dir: js

- url: /(.+)
  static_files: \1
  upload: (.+)

- url: /
  static_files: index.html
  upload: index.html
```

#### **STEP 2: Deploy**

```bash
# Install Google Cloud SDK

# Authenticate
gcloud auth login

# Initialize project
gcloud app create --project=pas-global-connect --region=asia-southeast1

# Deploy
gcloud app deploy

# Your URL: https://pas-global-connect.appspot.com
```

---

## ⚖️ **COMPARISON & RECOMMENDATIONS**

### **Feature Comparison:**

| Feature | Firebase Hosting | Cloud Storage | App Engine |
|---------|------------------|---------------|------------|
| **Setup Time** | 10 min ⭐ | 15 min | 20 min |
| **Cost (Free Tier)** | Generous ⭐ | Limited | Limited |
| **CDN** | ✅ Global ⭐ | ❌ No | ❌ No |
| **SSL** | ✅ Auto ⭐ | Need LB | ✅ Auto |
| **Custom Domain** | ✅ Easy ⭐ | Complex | ✅ Yes |
| **Rollback** | ✅ Instant ⭐ | Manual | ✅ Yes |
| **CLI** | ✅ Excellent ⭐ | ✅ Good | ✅ Good |
| **GitHub Integration** | ✅ Built-in ⭐ | ❌ No | ✅ Yes |

---

### **Cost Comparison (Monthly):**

**Firebase Hosting:**
```
Free Tier:
- Storage: 10GB
- Transfer: 360MB/day (10.8GB/month)
- Custom domain: FREE
- SSL: FREE
- CDN: FREE

Estimated for PAS Global Connect:
Storage: 100MB < 10GB ✅
Traffic: ~5GB/month < 10.8GB ✅
Cost: $0/month 🎉
```

**Cloud Storage:**
```
Storage: $0.020/GB/month
Network: $0.12/GB (to internet)

Estimated for PAS Global Connect:
Storage: 0.1GB × $0.02 = $0.002
Traffic: 5GB × $0.12 = $0.60
Load Balancer: $18/month (if need HTTPS + custom domain)

Cost: $0.60/month (without custom domain)
Cost: $18.60/month (with custom domain + HTTPS)
```

**App Engine:**
```
Free Tier:
- 28 instance hours/day
- 1GB outbound/day

Estimated for PAS Global Connect:
Cost: $0-5/month (within free tier)

But: Overkill for static site
```

---

### **🏆 RECOMMENDATION:**

```
╔═══════════════════════════════════════════╗
║  FOR PAS GLOBAL CONNECT:                  ║
║  🥇 FIREBASE HOSTING                      ║
╠═══════════════════════════════════════════╣
║  Reasons:                                 ║
║  ✅ Fastest setup (10 minutes)            ║
║  ✅ FREE (within generous limits)         ║
║  ✅ Global CDN included                   ║
║  ✅ Auto SSL + custom domain              ║
║  ✅ Easy CLI deployment                   ║
║  ✅ Instant rollback                      ║
║  ✅ Perfect for static sites              ║
╠═══════════════════════════════════════════╣
║  Cost: $0/month                           ║
║  Setup: 10 minutes                        ║
║  Performance: Excellent                   ║
╚═══════════════════════════════════════════╝
```

---

## 🎯 **QUICK START SUMMARY**

### **Firebase Hosting (RECOMMENDED):**

```bash
# 1. Install Firebase CLI
npm install -g firebase-tools

# 2. Login
firebase login

# 3. Navigate to project
cd pas-global-connect

# 4. Initialize
firebase init hosting

# 5. Deploy!
firebase deploy

# Done! Site live at: https://pas-global-connect.web.app
```

**Time:** 10 minutes  
**Cost:** FREE  
**Result:** Production-ready site with global CDN

---

## 🔍 **VERIFY DEPLOYMENT**

### **Check Your Site:**

```bash
# Open in browser
firebase open hosting:site

# Check deployment status
firebase hosting:channel:list

# View deployment history
firebase hosting:clone source:version target:version
```

### **Test URLs:**

```
Production: https://pas-global-connect.web.app
Also: https://pas-global-connect.firebaseapp.com

Test pages:
✓ https://pas-global-connect.web.app/
✓ https://pas-global-connect.web.app/dashboard.html
✓ https://pas-global-connect.web.app/test-system.html
```

---

## 🔄 **UPDATE WORKFLOW**

### **After Making Changes:**

```bash
# 1. Make your changes locally
# Edit HTML/CSS/JS files

# 2. Test locally (optional)
firebase serve
# Opens at: http://localhost:5000

# 3. Deploy to production
firebase deploy --only hosting

# 4. Verify
# Check: https://pas-global-connect.web.app
```

**Deployment time:** ~30 seconds

---

## 🎨 **PREVIEW CHANNELS** (Advanced)

### **Test Before Production:**

```bash
# Create preview channel
firebase hosting:channel:deploy preview-v2

# Get preview URL
# https://pas-global-connect--preview-v2-xxxxx.web.app

# Share with team for testing
# If good, deploy to production
firebase deploy --only hosting
```

---

## 🚨 **TROUBLESHOOTING**

### **Error 1: "Firebase command not found"**

```bash
# Reinstall Firebase tools
npm install -g firebase-tools

# Or use npx
npx firebase-tools login
npx firebase-tools deploy
```

---

### **Error 2: "Permission denied"**

```bash
# On Mac/Linux
sudo npm install -g firebase-tools

# Or change npm permissions
npm config set prefix ~/.npm-global
export PATH=~/.npm-global/bin:$PATH
```

---

### **Error 3: "Project not found"**

```bash
# List projects
firebase projects:list

# Use correct project
firebase use pas-global-connect

# Or reinitialize
firebase init hosting
```

---

### **Error 4: "Deploy failed"**

```bash
# Check firebase.json syntax
# Ensure "public": "." is set correctly

# Force deploy
firebase deploy --only hosting --force

# Check logs
firebase functions:log
```

---

## 📞 **SUPPORT & RESOURCES**

### **Firebase Documentation:**
```
📖 Hosting Docs: https://firebase.google.com/docs/hosting
🎓 Getting Started: https://firebase.google.com/docs/hosting/quickstart
💬 Community: https://firebase.google.com/support
```

### **Google Cloud Support:**
```
📖 Cloud Storage: https://cloud.google.com/storage/docs
📖 App Engine: https://cloud.google.com/appengine/docs
💰 Pricing Calculator: https://cloud.google.com/products/calculator
```

---

## 🎉 **COMPLETION CHECKLIST**

```
✅ Prerequisites:
   ✓ Node.js installed
   ✓ Firebase CLI installed
   ✓ Google account created

✅ Setup:
   ✓ Firebase project created
   ✓ Project initialized
   ✓ firebase.json configured

✅ Deployment:
   ✓ Files deployed
   ✓ Site accessible
   ✓ HTTPS working
   ✓ All pages load

✅ Optional:
   ✓ Custom domain added
   ✓ DNS configured
   ✓ SSL certificate active
```

---

## 💡 **PRO TIPS**

### **Tip 1: CI/CD with GitHub Actions**

```yaml
# .github/workflows/firebase-hosting-merge.yml
name: Deploy to Firebase Hosting
on:
  push:
    branches:
      - main
jobs:
  deploy:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v2
      - uses: FirebaseExtended/action-hosting-deploy@v0
        with:
          repoToken: '${{ secrets.GITHUB_TOKEN }}'
          firebaseServiceAccount: '${{ secrets.FIREBASE_SERVICE_ACCOUNT }}'
          projectId: pas-global-connect
```

---

### **Tip 2: Multiple Environments**

```bash
# Production
firebase use production
firebase deploy

# Staging
firebase use staging
firebase deploy

# Development
firebase use default
firebase deploy
```

---

### **Tip 3: Rollback**

```bash
# List versions
firebase hosting:versions:list

# Rollback to previous
firebase hosting:rollback
```

---

## 🎊 **DEPLOYMENT SUCCESS!**

```
╔═══════════════════════════════════════════╗
║  🎉 FIREBASE HOSTING - DEPLOYED ✅        ║
╠═══════════════════════════════════════════╣
║  URL: https://pas-global-connect.web.app  ║
╠═══════════════════════════════════════════╣
║  ✅ Global CDN (180+ locations)           ║
║  ✅ Free SSL Certificate                  ║
║  ✅ Automatic HTTPS                       ║
║  ✅ Custom Domain Support                 ║
║  ✅ Instant Rollback                      ║
║  ✅ Preview Channels                      ║
╠═══════════════════════════════════════════╣
║  Cost: $0/month (FREE)                    ║
║  Setup Time: 10 minutes                   ║
║  Status: PRODUCTION READY ✅              ║
╚═══════════════════════════════════════════╝
```

---

**Selamat! Site anda kini hosted di Google Cloud Platform via Firebase Hosting! 🚀**

**Platform**: PAS Global Connect  
**Hosting**: Google Cloud Platform (Firebase)  
**Date**: Januari 2026

---

**© 2026 PAS Global Connect - Google Cloud Deployment Guide**
