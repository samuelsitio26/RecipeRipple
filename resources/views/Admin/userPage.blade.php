<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <link rel="shortcut icon" type="x-icon" href="{{url('frontend/images/Logo.png')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;700&display=swap" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* General Styles */
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
            overflow: hidden;
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
        .sidebar a.active, .sidebar a:hover {
            background-color: #3d1626;
            border-radius: 5px;
        }
        .content {
            flex: 1;
            padding: 20px;
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
        .user-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .user-table th, .user-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        .user-table th {
            background-color: #603044;
            color: white;
        }
        .btn-add-user {
            background-color: #F44708;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-bottom: 20px;
        }
        .btn-delete, .btn-edit {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete {
            background-color: #de302a;
            color: white;
        }
        .btn-edit {
            background-color: #53da67;
            color: white;
        }
        /* Modal Styling */
        #addUserModal, #editUserModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            padding: 20px;
            z-index: 1000;
        }
        #addUserModal h3, #editUserModal h3 {
            font-size: 1.5em;
            color: #603044;
            margin-bottom: 15px;
            text-align: center;
        }
        #addUserModal input, #editUserModal input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        #addUserModal label, #editUserModal label {
            display: block;
            margin-top: 10px;
            font-weight: bold;
            color: #333;
        }
        #addUserModal button, #editUserModal button {
            width: 100%;
            padding: 10px;
            margin-top: 15px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        #addUserModal button[type="submit"], #editUserModal button[type="submit"] {
            background-color: #53da67;
            color: white;
            font-weight: bold;
        }
        #addUserModal button[type="button"], #editUserModal button[type="button"] {
            background-color: #de302a;
            color: white;
            font-weight: bold;
        }
        /* Modal Background Overlay */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
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
        <a class="active" href="admin/user"><i class="fas fa-user"></i>User</a>
        {{-- <a href="/admin/resep"><i class="fas fa-book"></i>Resep</a> --}}
        <a href="{{route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a href="{{route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a>
        <a href="/admin/komentar"><i class="fas fa-comments"></i>Komentar</a>

    </div>

    <!-- Main Content -->
    <div class="content">
        <div class="header">
            <div class="menu" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <span>Admin</span>
        </div>

        <h2>Manage Users</h2>
        <button class="btn-add-user" onclick="openAddUserModal()">Tambah User</button>

        <!-- Alert Message -->
        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <table class="user-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->nomor_telepon }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <button class="btn-edit" onclick="openEditUserModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->nomor_telepon }}', '{{ $user->email }}')">Edit</button>
                        <form action="{{ route('user.destroy', $user->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal untuk Tambah User -->
    <div id="addUserModal">
        <form action="{{ route('user.store') }}" method="POST">
            @csrf
            <h3>Tambah User Baru</h3>
            <label>Nama:</label>
            <input type="text" name="name" required>
            <label>Nomor Telepon:</label>
            <input type="text" name="nomor_telepon" required>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <label>Konfirmasi Password:</label>
            <input type="password" name="password_confirmation" required>
            <button type="submit">Tambah</button>
            <button type="button" onclick="closeModal('addUserModal')">Batal</button>
        </form>
    </div>

    <!-- Modal untuk Edit User -->
    <div id="editUserModal">
        <form id="editUserForm" method="POST">
            @csrf
            @method('PUT')
            <h3>Edit User</h3>
            <label>Nama:</label>
            <input type="text" name="name" id="editName" required>
            <label>Nomor Telepon:</label>
            <input type="text" name="nomor_telepon" id="editPhone" required>
            <label>Email:</label>
            <input type="email" name="email" id="editEmail" required>
            <button type="submit">Update</button>
            <button type="button" onclick="closeModal('editUserModal')">Batal</button>
        </form>
    </div>

    <!-- Modal Overlay -->
    <div class="modal-overlay" id="modalOverlay" style="display: none;"></div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            sidebar.classList.toggle("collapsed");
        }

        function openAddUserModal() {
            document.getElementById("addUserModal").style.display = "block";
            document.getElementById("modalOverlay").style.display = "block";
        }

        function openEditUserModal(id, name, nomor_telepon, email) {
            const form = document.getElementById("editUserForm");
            form.action = `/admin/user/${id}`;
            document.getElementById("editName").value = name;
            document.getElementById("editPhone").value = nomor_telepon;
            document.getElementById("editEmail").value = email;
            document.getElementById("editUserModal").style.display = "block";
            document.getElementById("modalOverlay").style.display = "block";
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = "none";
            document.getElementById("modalOverlay").style.display = "none";
        }
    </script>
</body>
</html>
