<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General styling */
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

        /* Sidebar styling */
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

        /* Collapsed sidebar styling */
        .sidebar.collapsed {
            width: 0;
            padding: 0;
        }

        /* Logo and title styling */
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

        /* Content area styling */
        .content {
            flex: 1;
            padding: 20px;
            transition: margin-left 0.3s;
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


        /* Header styling */
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

        /* Dashboard content styling */
        .dashboard h2 {
            margin-bottom: 20px;
            font-size: 1.6em;
            color: #333;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .card {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .card h3 {
            font-size: 1.2em;
            margin-bottom: 15px;
            color: #333;
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
        }

        .btn-delete {
            background-color: #de302a;
        }

        .btn-delete:hover {
            background-color: #c0211b;
        }

        .btn-edit {
            background-color: #53da67;
            margin: 4px;
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
        {{-- <a href="/admin/resep"><i class="fas fa-book"></i>Resep</a> --}}
        <a href="{{ route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a class="active" href="{{ route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a>
        <a href="/admin/komentar"><i class="fas fa-comments"></i>Komentar</a>
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
            <h2>Daftar Kategori</h2>
            <button class="btn-add-recipe" onclick="window.location.href='{{ route('kategori.create') }}'">
                <i class="fas fa-book"></i> Tambah Kategori
            </button>
            <table border="1" cellspacing="0" cellpadding="10" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #603044; color: white;">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($kategori as $kategori)
                        <tr>
                            <td>{{ $kategori->id }}</td>
                            <td>{{ $kategori->nama }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn-edit"
                                    onclick="window.location.href='{{ route('kategori.edit', $kategori->id) }}'">Edit</button>

                                <!-- Hapus Button -->
                                <form action="{{ route('kategori.destroy', $kategori->id) }}" method="POST"
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
    </script>
</body>

</html>
