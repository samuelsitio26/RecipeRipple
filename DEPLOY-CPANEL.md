# 🚀 Deploy RecipeRipple ke cPanel Hosting

## Persiapan File

### 1. Build Assets Dulu (Lokal)

```bash
npm install
npm run build
```

### 2. File yang Perlu Diupload:

-   ✅ Semua folder: app/, config/, database/, public/, resources/, routes/, etc.
-   ✅ File: .env.example, composer.json, package.json, artisan, etc.
-   ❌ Jangan upload: vendor/, node_modules/, .git/, storage/logs/

## Langkah Deploy ke cPanel

### Step 1: Upload Files

1. Zip project ini (exclude vendor/ dan node_modules/)
2. Upload zip ke cPanel File Manager → public_html/
3. Extract zip di public_html/

### Step 2: Install Dependencies

```bash
# Via Terminal cPanel atau SSH
composer install --optimize-autoloader --no-dev
```

### Step 3: Setup Environment

```bash
# Copy environment file
cp .env.example .env

# Generate app key
php artisan key:generate
```

### Step 4: Database Setup

1. Buat database MySQL di cPanel
2. Edit .env dengan kredensial database:

```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_db_username
DB_PASSWORD=your_db_password
```

### Step 5: Run Migrations

```bash
php artisan migrate --seed
```

### Step 6: Set Permissions

```bash
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/
```

### Step 7: Build Assets (di Server)

```bash
npm install
npm run build
```

## Troubleshooting cPanel

### Jika Error Composer:

-   Pastikan PHP version minimal 8.1
-   Enable extension: mbstring, openssl, pdo_mysql, tokenizer, xml

### Jika Error Assets:

-   Build assets lokal dulu sebelum upload
-   Atau install Node.js di cPanel hosting

### Jika Error Database:

-   Pastikan database credentials benar
-   Check database user permissions

## Keuntungan cPanel vs Railway:

✅ Tidak ada Docker complexity
✅ Direct access ke files
✅ Stable hosting (berbayar)
✅ Easy database management
✅ No build timeouts
✅ Support PHP native

Selamat deploy! 🎉
