# Dokumentasi: Mengganti Notifikasi Menjadi "Resep Saya"

## Tanggal: 17 Oktober 2025

---

## 📋 RINGKASAN PERUBAHAN

### Konsep Perubahan:

❌ **DULU**: Menu "Notifikasi" untuk melihat notifikasi sistem  
✅ **SEKARANG**: Menu "Resep Saya" untuk mengelola resep pribadi user

### URL:

-   **URL tetap sama**: `http://127.0.0.1:8000/notifikasi`
-   **Fungsi berubah**: Dari notification center → My recipes management
-   **Icon tetap**: `<i class="fas fa-bell"></i>` (icon lonceng)
-   **Text berubah**: "Notifikasi" → "Resep Saya"

---

## 🎯 FITUR "RESEP SAYA"

### 1. Halaman List Resep (Card View)

**Tampilan:**

```
┌─────────────────────────────────┐
│  📢 Resep Saya                  │
│  Kelola semua resep yang telah  │
│  Anda buat                      │
└─────────────────────────────────┘

┌──────────────────┐ ┌──────────────────┐ ┌──────────────────┐
│  [Foto Resep]    │ │  [Foto Resep]    │ │  [Foto Resep]    │
│                  │ │                  │ │                  │
│ 🏷️ Kategori      │ │ 🏷️ Kategori      │ │ 🏷️ Kategori      │
│                  │ │                  │ │                  │
│ Judul Resep      │ │ Judul Resep      │ │ Judul Resep      │
│ Deskripsi...     │ │ Deskripsi...     │ │ Deskripsi...     │
│                  │ │                  │ │                  │
│ ⭐ 4.5 (10)      │ │ ⭐ 4.8 (25)      │ │ ⭐ 4.2 (5)       │
│ 👁️ 150  💬 5    │ │ 👁️ 320  💬 12   │ │ 👁️ 89   💬 3    │
│                  │ │                  │ │                  │
│ [Lihat Detail]   │ │ [Lihat Detail]   │ │ [Lihat Detail]   │
│ [Edit Resep]     │ │ [Edit Resep]     │ │ [Edit Resep]     │
│ [Komentar (5)]   │ │ [Komentar (12)]  │ │ [Komentar (3)]   │
│ [Hapus Resep]    │ │ [Hapus Resep]    │ │ [Hapus Resep]    │
└──────────────────┘ └──────────────────┘ └──────────────────┘
```

**Fitur Card:**

-   ✅ Foto resep (atau gradient placeholder)
-   ✅ Badge kategori dengan icon
-   ✅ Judul resep (max 2 baris)
-   ✅ Deskripsi singkat (max 2 baris)
-   ✅ Statistik:
    -   ⭐ Rating rata-rata & jumlah rating
    -   👁️ Total views
    -   💬 Jumlah komentar
-   ✅ 4 Action buttons:
    1. **Lihat Detail** (🟢 Hijau) - Lihat resep lengkap
    2. **Edit Resep** (🔵 Biru) - Edit resep
    3. **Komentar** (🟠 Orange) - Lihat komentar user lain
    4. **Hapus Resep** (🔴 Merah) - Hapus resep

### 2. Interaksi

**Klik Gambar:**

-   Langsung ke detail resep (`/resep/{id}`)

**Tombol "Lihat Detail":**

-   Redirect ke `/resep/{id}`
-   Menampilkan resep lengkap seperti user lain melihatnya

**Tombol "Edit Resep":**

-   Redirect ke `/recipe/edit/{id}`
-   Form edit seperti di `/recipe/create`

**Tombol "Komentar":**

-   Redirect ke `/resep/{id}#comments`
-   Auto scroll ke section komentar
-   Bisa melihat & membalas komentar user lain

**Tombol "Hapus Resep":**

-   Konfirmasi dialog
-   Hapus resep dari database
-   Redirect kembali dengan pesan sukses

---

## 🗂️ FILE YANG DIMODIFIKASI

### 1. **routes/web.php**

**Perubahan:**

```php
// BEFORE
Route::get('/notifikasi', [NotificationController::class, 'index'])
    ->name('notifications.index');

// AFTER
Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi', [RecipeController::class, 'myRecipes'])
        ->name('recipe.my-recipes');
});
```

-   ✅ URL `/notifikasi` sekarang mengarah ke `RecipeController@myRecipes`
-   ✅ Protected dengan middleware `auth`
-   ✅ Hapus route lama notifikasi

### 2. **resources/views/recipe/my-recipes.blade.php**

**Perubahan Besar:**

-   ✅ Design card yang lebih modern
-   ✅ Page header dengan icon bell & judul "Resep Saya"
-   ✅ Responsive layout (Mobile, Tablet, Desktop)
-   ✅ Hover effects pada card
-   ✅ Gradient placeholder untuk resep tanpa foto
-   ✅ Action buttons dengan full width di mobile
-   ✅ Empty state yang menarik
-   ✅ Auto-hide alert setelah 5 detik

**CSS Improvements:**

```css
/* Card dengan shadow & hover effect */
.recipe-card {
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
}

.recipe-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

/* Gradient untuk gambar kosong */
background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);

/* Button styles dengan icon */
.btn-action {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}
```

### 3. **resources/views/\*.blade.php** (Multiple files)

**File yang diupdate text "Notifikasi" → "Resep Saya":**

-   ✅ `berandaPage.blade.php`
-   ✅ `writeResepPage.blade.php`
-   ✅ `updateprofilPage.blade.php`
-   ✅ `searchresepPage.blade.php`
-   ✅ `resepPage.blade.php`
-   ✅ `profilPage.blade.php`
-   ✅ `pencarianresepPage.blade.php`
-   ✅ `editprofilePage.blade.php`
-   ✅ `user/card.blade.php`
-   ✅ `user/tampilan.blade.php`
-   ✅ `recipe/show.blade.php`

**Perubahan di semua file:**

```html
<!-- BEFORE -->
<a class="nav-link" href="/notifikasi">
    <i class="fas fa-bell"></i>
    Notifikasi
</a>

<!-- AFTER -->
<a class="nav-link" href="/notifikasi">
    <i class="fas fa-bell"></i>
    Resep Saya
</a>
```

---

## 🔄 FLOW PENGGUNA

### Skenario 1: Lihat & Edit Resep

```
1. User klik menu "🔔 Resep Saya" di navbar
   ↓
2. Tampil halaman /notifikasi dengan list resep dalam card
   ↓
3. User klik "Edit Resep" pada salah satu card
   ↓
4. Redirect ke /recipe/edit/{id}
   ↓
5. User edit resep (ubah judul, gambar, bahan, dll)
   ↓
6. Klik "Update" atau "Simpan"
   ↓
7. Redirect kembali ke halaman edit dengan pesan sukses
```

### Skenario 2: Lihat Komentar dari User Lain

```
1. User di halaman "Resep Saya"
   ↓
2. User klik "Komentar (12)" pada resep
   ↓
3. Redirect ke /resep/{id}#comments
   ↓
4. Auto scroll ke section komentar
   ↓
5. User bisa baca komentar dari user lain
   ↓
6. User bisa balas komentar
   ↓
7. User bisa lihat rating yang diberikan user lain
```

### Skenario 3: Hapus Resep

```
1. User di halaman "Resep Saya"
   ↓
2. User klik tombol "Hapus Resep"
   ↓
3. Muncul dialog konfirmasi:
   "Apakah Anda yakin ingin menghapus resep [Nama Resep]?"
   ↓
4. User klik "OK"
   ↓
5. Resep dihapus dari database
   ↓
6. Redirect kembali ke /notifikasi
   ↓
7. Tampil alert hijau: "Resep berhasil dihapus"
```

---

## 🎨 DESAIN & UI IMPROVEMENTS

### Page Header

```html
<div class="page-header">
    <h2 class="page-title">
        <i class="fas fa-bell"></i>
        <span>Resep Saya</span>
    </h2>
    <p class="text-muted mb-0">Kelola semua resep yang telah Anda buat</p>
</div>
```

-   ✅ Icon bell konsisten dengan navbar
-   ✅ Subtitle deskriptif
-   ✅ White background dengan shadow

### Recipe Card

**Structure:**

```
┌─────────────────────────────────┐
│  [Image/Gradient]               │ ← Clickable, 220px height
├─────────────────────────────────┤
│  🏷️ Kategori                    │ ← Badge orange
│                                 │
│  Judul Resep                    │ ← Bold, 2 lines max
│  Deskripsi singkat...           │ ← Gray, 2 lines max
│  ─────────────────────────      │ ← Border separator
│  ⭐ 4.5 (10) 👁️ 150 💬 5      │ ← Stats badges
│                                 │
│  [Lihat Detail]                 │ ← Green
│  [Edit Resep]                   │ ← Blue
│  [Komentar (5)]                 │ ← Orange
│  [Hapus Resep]                  │ ← Red
└─────────────────────────────────┘
```

### Color Scheme

-   🟢 **Hijau** (#4CAF50) - Lihat/View action
-   🔵 **Biru** (#2196F3) - Edit action
-   🟠 **Orange** (#FF9800) - Komentar action
-   🔴 **Merah** (#f44336) - Hapus action
-   🟠 **Orange** (#FF4500) - Primary brand color (kategori, add button)

### Responsive Breakpoints

```css
/* Desktop: 3 columns */
@media (min-width: 992px) {
    .col-lg-4 {
        width: 33.33%;
    }
}

/* Tablet: 2 columns */
@media (min-width: 768px) {
    .col-md-6 {
        width: 50%;
    }
}

/* Mobile: 1 column, full width buttons */
@media (max-width: 768px) {
    .btn-action {
        width: 100%;
    }
}
```

### Empty State

```
       🍴
    (Icon besar)

  Belum Ada Resep

Anda belum membuat resep apapun.
Yuk mulai berbagi resep favorit
Anda dengan komunitas Recipe Ripple!

  [+ Buat Resep Pertama Saya]
```

-   ✅ Icon utensils besar dengan opacity
-   ✅ Text deskriptif & ramah
-   ✅ Call-to-action button yang jelas

---

## 🧪 CARA TESTING

### Test 1: Akses Menu Resep Saya

```
1. Login sebagai user
2. Klik menu "🔔 Resep Saya" di navbar
3. ✅ URL harus: http://127.0.0.1:8000/notifikasi
4. ✅ Tampil list resep milik user
5. ✅ Tidak tampil resep user lain
```

### Test 2: Lihat Detail Resep

```
1. Di halaman Resep Saya
2. Klik gambar atau tombol "Lihat Detail"
3. ✅ Redirect ke /resep/{id}
4. ✅ Tampil detail lengkap resep
5. ✅ User bisa lihat resep seperti user lain melihatnya
```

### Test 3: Edit Resep

```
1. Di halaman Resep Saya
2. Klik tombol "Edit Resep"
3. ✅ Redirect ke /recipe/edit/{id}
4. ✅ Form terisi dengan data resep
5. Edit judul, deskripsi, gambar
6. Klik Update
7. ✅ Redirect kembali dengan pesan sukses
```

### Test 4: Lihat Komentar

```
1. Di halaman Resep Saya
2. Klik tombol "Komentar (X)"
3. ✅ Redirect ke /resep/{id}#comments
4. ✅ Auto scroll ke section komentar
5. ✅ Tampil semua komentar dari user lain
6. ✅ Bisa reply komentar
```

### Test 5: Hapus Resep

```
1. Di halaman Resep Saya
2. Klik tombol "Hapus Resep"
3. ✅ Muncul dialog konfirmasi
4. Klik OK
5. ✅ Resep terhapus
6. ✅ Redirect dengan pesan sukses
7. ✅ Resep tidak muncul lagi di list
```

### Test 6: Empty State

```
1. Login dengan user baru (belum buat resep)
2. Klik menu "Resep Saya"
3. ✅ Tampil empty state dengan icon
4. ✅ Ada tombol "Buat Resep Pertama Saya"
5. Klik tombol tersebut
6. ✅ Redirect ke /recipe/create
```

### Test 7: Responsive Design

```
Mobile:
1. Buka di mobile/resize browser
2. ✅ Card jadi 1 kolom
3. ✅ Button jadi full width
4. ✅ Layout tetap rapi

Tablet:
1. Resize ke ukuran tablet
2. ✅ Card jadi 2 kolom
3. ✅ Layout balanced

Desktop:
1. Full screen
2. ✅ Card jadi 3 kolom
3. ✅ Padding optimal
```

---

## 🔒 SECURITY & AUTHORIZATION

### Middleware Protection

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/notifikasi', [RecipeController::class, 'myRecipes']);
});
```

-   ✅ Harus login untuk akses
-   ✅ Guest redirect ke login page

### Data Filtering

```php
$recipes = Recipe::where('user_id', Auth::id())
    ->orderBy('created_at', 'desc')
    ->paginate(12);
```

-   ✅ Hanya tampil resep milik user yang login
-   ✅ Filter by `user_id`

### Permission Check (Edit & Delete)

```php
// Di RecipeController@edit
if (Auth::user()->role !== 'admin' && Auth::id() !== $recipe->user_id) {
    return redirect()->route('recipe.index')
        ->with('error', 'Tidak memiliki izin');
}
```

-   ✅ User hanya bisa edit/hapus resep sendiri
-   ✅ Admin bisa edit/hapus semua resep

---

## 📊 DATABASE

**Tidak ada perubahan schema!**

Menggunakan tabel & relasi yang sudah ada:

-   ✅ `recipes` table
-   ✅ `users` table (relasi via `user_id`)
-   ✅ `kategoris` table (relasi via `kategori_id`)
-   ✅ `comments` table (relasi via `recipe_id`)
-   ✅ `ratings` table (relasi via `recipe_id`)

Query utama:

```sql
SELECT recipes.*
FROM recipes
WHERE user_id = {current_user_id}
ORDER BY created_at DESC
LIMIT 12;
```

---

## 📝 PERBEDAAN DENGAN SISTEM NOTIFIKASI LAMA

| Aspek          | Notifikasi (Lama)         | Resep Saya (Baru)                   |
| -------------- | ------------------------- | ----------------------------------- |
| **Fungsi**     | Melihat notifikasi sistem | Mengelola resep pribadi             |
| **Data**       | Tabel `notifications`     | Tabel `recipes` (filter by user_id) |
| **Controller** | `NotificationController`  | `RecipeController`                  |
| **Method**     | `index()`                 | `myRecipes()`                       |
| **Icon**       | 🔔 Bell                   | 🔔 Bell (sama)                      |
| **Text Menu**  | "Notifikasi"              | "Resep Saya"                        |
| **URL**        | `/notifikasi`             | `/notifikasi` (sama)                |
| **Action**     | Mark as read              | Edit, Delete, View comments         |
| **Target**     | Notifikasi untuk user     | Resep yang dibuat user              |

---

## ✅ CHECKLIST LENGKAP

### Routes

-   ✅ Update route `/notifikasi` ke `RecipeController@myRecipes`
-   ✅ Tambah middleware `auth`
-   ✅ Hapus route notifikasi lama

### Views

-   ✅ Update `my-recipes.blade.php` dengan design baru
-   ✅ Update text "Notifikasi" → "Resep Saya" di semua navbar
-   ✅ Konsisten icon bell di semua halaman

### Controller

-   ✅ Method `myRecipes()` sudah ada di `RecipeController`
-   ✅ Filter recipes by `user_id`
-   ✅ Load relasi `kategori` dan `comments`

### Functionality

-   ✅ Lihat detail resep
-   ✅ Edit resep
-   ✅ Hapus resep dengan konfirmasi
-   ✅ Lihat komentar user lain
-   ✅ Statistik (rating, views, comments)
-   ✅ Empty state untuk user baru

### UI/UX

-   ✅ Card layout yang menarik
-   ✅ Hover effects
-   ✅ Responsive design
-   ✅ Color-coded buttons
-   ✅ Auto-hide alerts
-   ✅ Gradient placeholder untuk gambar kosong

### Security

-   ✅ Middleware auth
-   ✅ User hanya lihat resep sendiri
-   ✅ Permission check untuk edit/delete

---

## 🎉 KESIMPULAN

**Sistem Notifikasi telah berhasil diganti menjadi "Resep Saya"!**

### Keuntungan Perubahan:

1. ✅ **Lebih Relevan**: User bisa langsung kelola resep mereka
2. ✅ **Lebih Interaktif**: Edit, hapus, lihat komentar dalam 1 tempat
3. ✅ **Lebih Informatif**: Statistik lengkap (rating, views, comments)
4. ✅ **Lebih Modern**: Design card yang menarik & responsive
5. ✅ **Konsisten UX**: Icon bell tetap, URL tetap, hanya konten yang berubah

### URL yang Bisa Diakses:

-   **Resep Saya**: http://127.0.0.1:8000/notifikasi
-   **Edit Resep**: http://127.0.0.1:8000/recipe/edit/{id}
-   **Detail Resep**: http://127.0.0.1:8000/resep/{id}
-   **Komentar**: http://127.0.0.1:8000/resep/{id}#comments

---

**Silakan test semua fitur dan pastikan semuanya berfungsi dengan baik!** 🚀
