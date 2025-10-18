<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Management</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet" />
    <style>
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

        .sidebar {
            width: 250px;
            background-color: #603044;
            color: white;
            padding: 20px;
            display: flex;
            flex-direction: column;
            transition: width 0.3s ease;
            overflow: hidden;
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

        .content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s;
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

        .recipe-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .recipe-table th,
        .recipe-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .recipe-table th {
            background-color: #603044;
            color: white;
        }

        .recipe-table img {
            border-radius: 5px;
            width: 60px;
            height: 60px;
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

        .btn-delete,
        .btn-edit,
        .btn-view {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
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
            <img alt="Logo" src="{{ url('../frontend/images/Logo.png') }}" />
            <h1>Recipe <span>Ripple</span></h1>
        </div>
        <a href="/admin"><i class="fas fa-home"></i>Dashboard</a>
        <a href="/admin/user"><i class="fas fa-user"></i>User</a>
        <a class="active" href="/admin/resep"><i class="fas fa-book"></i>Resep</a>

        <a href="{{ route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a href="{{ route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a <a
            href="/admin/komentar"><i class="fas fa-comments"></i>Komentar</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="header">
            <div class="menu" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="profile" onclick="toggleProfilePopup()">
                <img alt="Profile Picture" src="{{ url('../frontend/images/profile1.jpg') }}" width="40"
                    height="40" />
                <span>Admin</span>
            </div>
        </div>

        <!-- Recipe Management Section -->
        <h2>Manage Recipes</h2>
        <button class="btn-add-recipe" onclick="window.location.href='{{ route('recipe.create') }}'">
            <i class="fas fa-book"></i> Tambah Recipe
        </button>

        <table class="recipe-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Nama Resep</th>
                    <th>Kategori</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recipes as $recipe)
                    <tr>
                        <td>
                            @if ($recipe->image_path)
                                <img src="{{ asset('uploads/recipe/image/' . $recipe->image_path) }}" alt="Recipe Image"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                            @else
                                <img src="{{ url('../frontend/images/placeholder.png') }}" alt="No Image"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                            @endif
                        </td>
                        <td>{{ $recipe->name }}</td>
                        <td>{{ $recipe->kategori->nama ?? 'No Category' }}</td>
                        <td>{{ Str::limit($recipe->description, 50) }}</td>
                        <td>
                            <button class="btn-view"
                                onclick="window.location.href='{{ route('recipe.show', $recipe->id) }}'">Lihat</button>
                            <button class="btn-edit"
                                onclick="window.location.href='{{ route('recipe.edit', $recipe->id) }}'">Edit</button>
                            <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; padding: 20px; color: #666;">
                            Belum ada resep yang tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Profile Popup for Logout -->
    <div class="profile-popup" id="profilePopup">
        <div class="d-flex align-items-center">
            <img src="{{ url('../frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle"
                width="40" height="40" />
            <div style="margin-left: 10px;">
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

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("shifted");
        }

        function toggleProfilePopup() {
            const popup = document.getElementById("profilePopup");
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        window.onclick = function(event) {
            const popup = document.getElementById("profilePopup");
            if (!event.target.closest('.profile') && !event.target.closest('#profilePopup')) {
                popup.style.display = 'none';
            }
        };

        // Fungsi untuk menambah
        function addRecipe() {
            window.location.href = "{{ route('admin.recipes.create') }}";
        }

        // Fungsi untuk melihat resep
        function viewRecipe() {
            window.location.href = "{{ route('admin.recipes.show', '') }}/" + id;
        }

        // Fungsi untuk mengedit resep
        function editRecipe() {
            window.location.href = "{{ route('admin.recipes.edit', '') }}/" + id;
        }

        // Fungsi untuk menghapus resep
        function deleteRecipe(id) {
            if (confirm('Apakah Anda yakin ingin menghapus resep ini?')) {
                fetch("{{ route('admin.recipes.destroy', '') }}/" + id, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                }).then(response => {
                    if (response.ok) {
                        window.location.reload();
                    } else {
                        alert('Gagal menghapus resep');
                    }
                });
            }
        }
    </script>
</body>

</html>
