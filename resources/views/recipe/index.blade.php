<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Styling */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Nunito', sans-serif;
        }

        body {
            display: flex;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        /* Sidebar Styling */
        .sidebar {
            width: 250px;
            background-color: #603044;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
        }

        .sidebar.collapsed {
            width: 0;
            padding: 0;
        }

        .logo-container {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .logo-container img {
            width: 40px;
            height: 40px;
            margin-right: 8px;
        }

        .sidebar h1 {
            font-size: 1.2em;
            font-weight: bold;
            color: white;
        }

        .sidebar h1 span {
            color: #F44708;
        }

        .sidebar a {
            text-decoration: none;
            color: white;
            font-size: 1em;
            margin: 6px 0;
            padding: 8px;
            display: flex;
            align-items: center;
            transition: background-color 0.3s;
        }

        .sidebar a i {
            margin-right: 8px;
            font-size: 1.1em;
        }

        .sidebar a.active,
        .sidebar a:hover {
            background-color: #3d1626;
            border-radius: 5px;
        }

        /* Content Area Styling */
        .content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s;
        }


        .content.fullscreen {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: white;
            /* Atur warna latar jika diperlukan */
            z-index: 1000;
            /* Pastikan berada di atas elemen lain */
            overflow: auto;
            /* Untuk mengatasi scroll jika konten panjang */
        }

        .btn-add-recipe {
            background-color: #F44708;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }

        .btn-add-recipe:hover {
            background-color: #ff6347;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: #ffffff;
            padding: 15px 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
        }

        .header .menu {
            font-size: 1.5em;
            cursor: pointer;
        }

        .header .profile {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .header .profile img {
            border-radius: 50%;
            margin-right: 10px;
        }

        .dashboard h2 {
            margin-bottom: 20px;
            font-size: 1.6em;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 12px 8px;
            text-align: left;
            border: 1px solid #ddd;
            vertical-align: top;
        }

        table th {
            background-color: #603044;
            color: white;
            font-weight: 600;
            text-align: center;
        }

        table td {
            background-color: white;
        }

        table tr:nth-child(even) td {
            background-color: #f9f9f9;
        }

        table tr:hover td {
            background-color: #f0f0f0;
        }

        table img {
            transition: transform 0.2s ease;
        }

        table img:hover {
            transform: scale(1.05);
        }

        /* Profile Popup Styling */
        .profile-popup {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            min-width: 200px;
            z-index: 1000;
        }

        .profile-popup h5 {
            margin: 0;
            font-size: 14px;
            color: #333;
        }

        .profile-popup p {
            font-size: 12px;
            color: #666;
        }

        .profile-popup button {
            width: 100%;
            background-color: #f44708;
            color: white;
            border: none;
            border-radius: 5px;
            padding: 0.5rem;
            cursor: pointer;
            margin-top: 10px;
        }

        .profile-popup button:hover {
            background-color: #ff6347;
        }

        .btn-delete,
        .btn-edit,
        .btn-view {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            margin: 4px;
        }

        .btn-delete {
            background-color: #de302a;
        }

        .btn-delete:hover {
            background-color: #c0211b;
        }

        .btn-edit {
            background-color: #53da67;
        }

        .btn-edit:hover {
            background-color: #48bd59;
        }

        .btn-view {
            background-color: #3498db;
        }

        .btn-view:hover {
            background-color: #2980b9;
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="logo-container">
            <img alt="Logo" src="{{ url('../frontend/images/Logo.png') }}">
            <h1>Recipe <span>Ripple</span></h1>
        </div>
        <a href="/admin"><i class="fas fa-home"></i>Dashboard</a>
        <a href="/admin/user"><i class="fas fa-user"></i>User</a>
        {{-- <a href="/admin/resep"><i class="fas fa-book"></i>Resep</a> --}}
        <a class="active" href="{{ route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a href="{{ route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a>
        <a href="/admin/komentar"><i class="fas fa-comments"></i>Komentar</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="header">
            <div class="menu" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="profile" onclick="toggleProfilePopup()">
                <img alt="Profile Picture" src="{{ url('../frontend/images/profile1.jpg') }}" width="40"
                    height="40">
                <span>Admin</span>
            </div>
            <!-- Profile Popup for Logout -->
            <div class="profile-popup" id="profilePopup">
                <div class="d-flex align-items-center">
                    <img src="{{ url('../frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle"
                        width="40" height="40" />
                    <div>
                        <a href="/profil">
                            <h5>Admin</h5>
                        </a>
                        <p>admin@gmail.com</p>
                    </div>
                </div>
                <form action="{{ route('logout') }}" method="POST" style="margin-top: 10px;">
                    @csrf
                    <button type="submit">Keluar</button>
                </form>
            </div>
        </div>
        <div class="dashboard">
            <h2>Manage Recipes</h2>
            <button class="btn-add-recipe" onclick="window.location.href='{{ route('recipe.create') }}'">
                <i class="fas fa-book"></i> Tambah Recipe</button>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Gambar</th>
                        <th>Deskripsi</th>
                        <th>Kategori</th>
                        <th>Video</th>
                        <th>Bahan</th>
                        <th>Langkah</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recipes as $recipe)
                        <tr>
                            <td>{{ $recipe->id }}</td>
                            <td>{{ $recipe->name }}</td>
                            <td>
                                @if ($recipe->gambar)
                                    <img src="{{ asset('uploads/recipe/gambar/' . $recipe->gambar) }}" width="100"
                                        height="100" alt="Recipe image"
                                        style="object-fit: cover; border-radius: 5px;">
                                @else
                                    <div style="text-align: center; color: #666; font-style: italic;">No image available
                                    </div>
                                @endif
                            </td>
                            <td>{{ Str::limit($recipe->description, 50) }}</td>
                            <td>{{ $recipe->kategori->nama }}</td>
                            <td>
                                @if ($recipe->video_type === 'youtube' && $recipe->video_url)
                                    <iframe width="150" height="100"
                                        src="{{ $recipe->getVideoEmbedUrlAttribute() }}" frameborder="0"
                                        style="border-radius: 5px;"></iframe>
                                @elseif ($recipe->video_type === 'file' && $recipe->video_path)
                                    <video width="150" height="100" controls style="border-radius: 5px;">
                                        <source src="{{ asset('uploads/recipe/video/' . $recipe->video_path) }}"
                                            type="video/mp4">
                                        Your browser does not support the video tag.
                                    </video>
                                @elseif ($recipe->video_type === 'url' && $recipe->video_url)
                                    <iframe width="150" height="100" src="{{ $recipe->video_url }}"
                                        frameborder="0" style="border-radius: 5px;"></iframe>
                                @else
                                    <div style="text-align: center; color: #666; font-style: italic;">No video available
                                    </div>
                                @endif
                            </td>
                            <td
                                style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                @if (is_array($recipe->bahan))
                                    {{ implode(', ', array_slice($recipe->bahan, 0, 3)) }}
                                    @if (count($recipe->bahan) > 3)
                                        <span style="color: #666; font-style: italic;">... ({{ count($recipe->bahan) }}
                                            total)</span>
                                    @endif
                                @else
                                    {{ Str::limit($recipe->bahan, 50) }}
                                @endif
                            </td>
                            <td
                                style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                @if (is_array($recipe->langkah))
                                    {{ implode(', ', array_slice($recipe->langkah, 0, 2)) }}
                                    @if (count($recipe->langkah) > 2)
                                        <span style="color: #666; font-style: italic;">...
                                            ({{ count($recipe->langkah) }} steps)</span>
                                    @endif
                                @else
                                    {{ Str::limit($recipe->langkah, 50) }}
                                @endif
                            </td>
                            <td>
                                <!-- Lihat Button -->
                                <button class="btn-view"
                                    onclick="window.location.href='{{ route('user.tampilan', $recipe->id) }}'">Lihat</button>

                                <!-- Edit Button -->
                                <button class="btn-edit"
                                    onclick="window.location.href='{{ route('recipe.edit', $recipe->id) }}'">Edit</button>

                                <!-- Delete Button -->
                                <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST"
                                    style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-delete">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <script>
        // Toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");

            // Toggle fullscreen dan sembunyikan sidebar
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("fullscreen");
        }

        // Toggle profile popup visibility
        function toggleProfilePopup() {
            const popup = document.getElementById("profilePopup");
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        // Close profile popup when clicking outside
        window.onclick = function(event) {
            const popup = document.getElementById("profilePopup");
            if (!event.target.closest('.profile') && !event.target.closest('#profilePopup')) {
                popup.style.display = 'none';
            }
        };

        // Fungsi untuk menghapus resep
        function deleteRecipe() {
            if (confirm("Apakah Anda yakin ingin menghapus resep ini?")) {
                alert("Resep berhasil dihapus!");
                // Tambahkan logika penghapusan resep di sini
            }
        }
    </script>
</body>

</html>
