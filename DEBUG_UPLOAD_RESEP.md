# Debug Upload Resep - Panduan Troubleshooting

## 🔍 Masalah

Form upload resep tidak menyimpan data ke database.

## ✅ Yang Sudah Diperbaiki

### 1. Route Conflict (SOLVED ✅)

**Masalah:** Ada 2 route dengan nama `recipe.store`

-   `Route::resource('recipe', RecipeController::class)` → POST /recipe
-   `Route::post('/recipe/create', ...)` → POST /recipe/create

**Solusi:** Sudah dihapus `Route::resource` yang konflik.

**Verifikasi:**

```bash
php artisan route:list | Select-String "recipe.store"
```

Hasil: Hanya 1 route `POST recipe/create → recipe.store`

### 2. Logging untuk Debugging (ADDED ✅)

Sudah ditambahkan log di `RecipeController@store`:

-   Log semua input yang diterima
-   Log user ID
-   Log recipe yang berhasil dibuat
-   Log error validasi dengan detail
-   Log exception dengan trace

## 🧪 Cara Testing

### 1. Buka Form Upload

```
http://127.0.0.1:8000/recipe/create
```

### 2. Isi Form dengan Data Minimal

-   **Judul:** "Test Resep Upload"
-   **Deskripsi:** "Ini adalah test untuk memeriksa apakah upload berfungsi dengan baik"
-   **Kategori:** Pilih salah satu (misalnya "Makanan Utama")
-   **Bahan:** Minimal 1 bahan, misalnya "Nasi"
-   **Langkah:** Minimal 1 langkah, misalnya "Masak nasi"
-   **Gambar:** Upload gambar (optional)
-   **Video:** Skip dulu (optional)

### 3. Submit Form

Klik tombol "Unggah"

### 4. Cek Log Laravel

```powershell
Get-Content storage/logs/laravel.log -Tail 100
```

## 📊 Interpretasi Log

### Jika Upload Berhasil

```
[2025-01-17 ...] local.INFO: Recipe Store - All Input: {"name":"Test Resep Upload",...}
[2025-01-17 ...] local.INFO: Recipe Store - User ID: {"user_id":1}
[2025-01-17 ...] local.INFO: Recipe Created Successfully: {"recipe_id":123,"recipe_name":"Test Resep Upload"}
```

✅ **Resep berhasil disimpan!** Cek database di tabel `recipes`.

### Jika Validasi Gagal

```
[2025-01-17 ...] local.ERROR: Recipe Validation Failed: {"errors":{"name":["The name field is required."]},...}
```

❌ **Field yang required tidak diisi.** Periksa field yang error di log.

### Jika Ada Error Exception

```
[2025-01-17 ...] local.ERROR: Error creating recipe: SQLSTATE[23000]: Integrity constraint violation...
```

❌ **Database error.** Kemungkinan:

-   User belum login (user_id NULL)
-   Kategori tidak valid
-   Field database tidak cocok

## 🔧 Kemungkinan Masalah & Solusi

### 1. User Tidak Login

**Gejala:** Error "user_id cannot be null"
**Solusi:** Pastikan user sudah login sebelum mengakses form

### 2. Kategori Tidak Valid

**Gejala:** Validation error "kategori_id must exist in kategoris table"
**Solusi:**

```sql
SELECT * FROM kategoris;
```

Pastikan ada data kategori di database.

### 3. Field Tidak Terkirim

**Gejala:** Log menunjukkan field kosong (null)
**Solusi:**

-   Periksa JavaScript di `create.blade.php`
-   Pastikan hidden input `video_type` dan `video_url` dibuat dengan benar
-   Periksa form `enctype="multipart/form-data"`

### 4. CSRF Token Mismatch

**Gejala:** Error 419 atau "CSRF token mismatch"
**Solusi:**

-   Pastikan ada `@csrf` di form
-   Clear browser cache/cookies
-   Restart Laravel: `php artisan serve`

### 5. File Upload Gagal

**Gejala:** Error "The gambar must be an image" atau file not uploaded
**Solusi:**

-   Cek `php.ini`: `upload_max_filesize` dan `post_max_size`
-   Cek permission folder `public/uploads/recipe/`
-   Pastikan file format sesuai (jpeg, png, jpg, gif, webp)

## 📁 Struktur Folder Upload

```
public/
  uploads/
    recipe/
      gambar/      (untuk foto resep)
      video/       (untuk video upload)
      image/       (untuk foto langkah)
```

Pastikan folder-folder ini ada dan memiliki permission write.

## 🗄️ Cek Database

### Cek Resep Terakhir

```sql
SELECT * FROM recipes ORDER BY id DESC LIMIT 5;
```

### Cek User yang Login

```sql
SELECT id, name, email FROM users WHERE id = 1;
```

### Cek Kategori Available

```sql
SELECT * FROM kategoris;
```

## 🚀 Next Steps

1. **Test Upload:** Coba upload resep dengan data minimal
2. **Cek Log:** Lihat log di `storage/logs/laravel.log`
3. **Cek Database:** Periksa apakah data masuk ke tabel `recipes`
4. **Report:** Share log yang muncul untuk analisis lebih lanjut

## 📞 Troubleshooting Commands

```powershell
# Clear all cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear

# Check routes
php artisan route:list | Select-String "recipe.store"

# View latest logs
Get-Content storage/logs/laravel.log -Tail 100

# Check Laravel log in real-time
Get-Content storage/logs/laravel.log -Wait -Tail 50
```

## 🎯 Status Saat Ini

-   ✅ Route conflict sudah diperbaiki
-   ✅ Logging sudah ditambahkan
-   ✅ Cache sudah dibersihkan
-   ⏳ Menunggu test upload untuk melihat log

**Silakan coba upload resep sekarang dan share log yang muncul!**
