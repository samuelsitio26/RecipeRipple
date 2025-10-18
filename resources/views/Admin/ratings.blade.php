<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rating Management</title>
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

        .rating-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .rating-table th,
        .rating-table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        .rating-table th {
            background-color: #603044;
            color: white;
        }

        .rating-table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .rating-table tr:hover {
            background-color: #f1f1f1;
        }

        .stars {
            color: #FFD700;
        }

        .btn-delete {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            background-color: #de302a;
            color: white;
            cursor: pointer;
        }

        .btn-delete:hover {
            background-color: #c0211b;
        }

        .stats-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 2em;
            font-weight: bold;
            color: #603044;
        }

        .stat-label {
            color: #666;
            margin-top: 5px;
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
        <a href="admin/user"><i class="fas fa-user"></i>User</a>
        <a href="{{ route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a href="{{ route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a>
        <a class="active" href="{{ route('admin.ratings.index') }}"><i class="fas fa-star"></i>Ratings</a>
        <a href="{{ route('admin.comments.index') }}"><i class="fas fa-comments"></i>Komentar</a>
    </div>

    <!-- Main Content -->
    <div class="content" id="content">
        <div class="header">
            <div class="menu" onclick="toggleSidebar()"><i class="fas fa-bars"></i></div>
            <div class="profile" onclick="toggleProfilePopup()">
                <img alt="User" height="40" src="{{ url('../frontend/images/profile1.jpg') }}" width="40" />
                <span>Admin</span>
            </div>
        </div>

        <!-- Rating Management Section -->
        <h2>Manage Ratings</h2>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stats-card">
                <div class="stat-item">
                    <div class="stat-number">{{ $totalRatings ?? 0 }}</div>
                    <div class="stat-label">Total Ratings</div>
                </div>
            </div>
            <div class="stats-card">
                <div class="stat-item">
                    <div class="stat-number">{{ number_format($averageRating ?? 0, 1) }}</div>
                    <div class="stat-label">Average Rating</div>
                </div>
            </div>
            <div class="stats-card">
                <div class="stat-item">
                    <div class="stat-number">{{ $topRatedRecipes ?? 0 }}</div>
                    <div class="stat-label">Top Rated Recipes</div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if (session('success'))
            <div
                style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 12px; border-radius: 5px; margin-bottom: 20px;">
                {{ session('error') }}
            </div>
        @endif

        <!-- Ratings Table -->
        <table class="rating-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Recipe</th>
                    <th>Rating</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($ratings as $rating)
                    <tr>
                        <td>{{ $rating->user->name ?? 'Unknown User' }}</td>
                        <td>{{ $rating->recipe->name ?? 'Unknown Recipe' }}</td>
                        <td>
                            <span class="stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $rating->rating)
                                        <i class="fas fa-star"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                            </span>
                            ({{ $rating->rating }}/5)
                        </td>
                        <td>{{ $rating->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST"
                                style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete"
                                    onclick="return confirm('Are you sure you want to delete this rating?')">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #666; font-style: italic;">
                            No ratings found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        @if (isset($ratings) && $ratings->hasPages())
            <div style="margin-top: 20px;">
                {{ $ratings->links() }}
            </div>
        @endif
    </div>

    <!-- Profile Popup for Logout -->
    <div class="profile-popup" id="profilePopup">
        <div class="d-flex align-items-center">
            <img src="{{ url('../frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle"
                width="40" height="40" />
            <div style="margin-left: 10px;">
                <h5>{{ Auth::user()->name ?? 'Admin' }}</h5>
                <p>{{ Auth::user()->email ?? 'admin@example.com' }}</p>
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
    </script>
</body>

</html>
