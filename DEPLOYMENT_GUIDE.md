# 🚀 Panduan Deployment Recipe Ripple - Hosting Gratis

## 📋 Pilihan Hosting Gratis

### 1. 🥇 **Railway (Rekomendasi)**

-   **Database**: MySQL/PostgreSQL gratis
-   **Traffic**: Unlimited
-   **Storage**: 1GB
-   **Uptime**: 500 jam/bulan (cukup untuk project kecil)
-   **URL**: https://railway.app

### 2. 🌟 **Render**

-   **Database**: PostgreSQL gratis
-   **Traffic**: 100GB/bulan
-   **Sleep**: Setelah 15 menit tidak ada traffic
-   **URL**: https://render.com

### 3. 🎯 **Heroku**

-   **Database**: PostgreSQL (10,000 rows)
-   **Dyno**: 1000 jam/bulan
-   **Sleep**: Setelah 30 menit tidak ada traffic
-   **URL**: https://heroku.com

---

## 🚀 **TUTORIAL: Deploy ke Railway**

### **Step 1: Persiapkan Repository GitHub**

1. **Push ke GitHub:**

```bash
cd "d:\laragon\www\RecipeRipple"
git add .
git commit -m "Prepare for Railway deployment"
git push origin main
```

### **Step 2: Setup Railway**

1. **Daftar di Railway:**

    - Kunjungi: https://railway.app
    - Login dengan GitHub
    - Klik "New Project"

2. **Deploy from GitHub:**
    - Pilih "Deploy from GitHub repo"
    - Pilih repository "RecipeRipple"
    - Klik "Deploy Now"

### **Step 3: Setup Database**

1. **Tambah Database:**

    - Di dashboard Railway, klik "+ New"
    - Pilih "Database" → "MySQL" atau "PostgreSQL"
    - Tunggu hingga database terbuat

2. **Connect Database:**
    - Klik service Laravel app
    - Go to "Variables" tab
    - Railway akan auto-generate DB variables

### **Step 4: Environment Variables**

Tambahkan variables berikut di Railway:

```env
APP_NAME="Recipe Ripple"
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:gDwnJmtRYZ9XiDUsjLKX/sbCOZmBg5ffBRlqAE2B7cs=

# Database variables (auto-generated oleh Railway)
DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQL_HOST}}
DB_PORT=${{MySQL.MYSQL_PORT}}
DB_DATABASE=${{MySQL.MYSQL_DATABASE}}
DB_USERNAME=${{MySQL.MYSQL_USER}}
DB_PASSWORD=${{MySQL.MYSQL_PASSWORD}}
```

### **Step 5: Deploy Script**

Railway akan otomatis menjalankan:

1. `composer install`
2. `npm ci && npm run build`
3. `php artisan migrate --force`

---

## 🌟 **TUTORIAL: Deploy ke Render**

### **Step 1: Setup Render**

1. **Daftar di Render:**

    - Kunjungi: https://render.com
    - Login dengan GitHub

2. **Create Web Service:**
    - Klik "New +" → "Web Service"
    - Connect GitHub repository
    - Pilih "RecipeRipple"

### **Step 2: Konfigurasi Build**

**Build Command:**

```bash
composer install --no-dev --optimize-autoloader && npm ci && npm run build
```

**Start Command:**

```bash
vendor/bin/heroku-php-apache2 public/
```

### **Step 3: Database PostgreSQL**

1. **Create Database:**

    - Klik "New +" → "PostgreSQL"
    - Berikan nama database

2. **Environment Variables:**

```env
DATABASE_URL=${{PostgreSQL.DATABASE_URL}}
DB_CONNECTION=pgsql
```

---

## ⚡ **Quick Deploy Commands**

### **Untuk Railway:**

```bash
# Install Railway CLI
npm install -g @railway/cli

# Login
railway login

# Deploy
railway up
```

### **Untuk Heroku:**

```bash
# Install Heroku CLI
# Download from: https://devcenter.heroku.com/articles/heroku-cli

# Login
heroku login

# Create app
heroku create recipe-ripple-app

# Add database
heroku addons:create jawsdb:kitefin

# Deploy
git push heroku main
```

---

## 🔧 **Troubleshooting**

### **Error: Storage Permission**

```bash
chmod -R 775 storage bootstrap/cache
```

### **Error: APP_KEY Missing**

```bash
php artisan key:generate --force
```

### **Error: Database Migration**

```bash
php artisan migrate:fresh --force --seed
```

### **Error: Assets Missing**

```bash
npm run build
```

---

## 🎯 **Rekomendasi Setup**

**Untuk Pemula:** Railway (paling mudah)
**Untuk Advanced:** Render (kontrol lebih banyak)
**Untuk Portfolio:** Vercel + PlanetScale

### **Next Steps:**

1. Custom domain (opsional)
2. SSL certificate (auto)
3. CDN setup untuk gambar
4. Monitoring & analytics

---

## 📞 **Support**

Jika ada masalah deployment, beri tahu saya error messagenya dan saya akan bantu troubleshoot! 🚀
