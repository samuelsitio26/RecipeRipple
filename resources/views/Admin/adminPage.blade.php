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
        {{-- <a href="/admin/resep"><i class="fas fa-book"></i>Resep</a> --}}
        <a href="{{ route('recipe.index') }}"><i class="fas fa-book"></i>Tambah recipe</a>
        <a href="{{ route('kategori.index') }}"><i class="fas fa-book"></i>Tambah Kategori</a>
        <a href="{{ route('admin.ratings.index') }}"><i class="fas fa-star"></i>Ratings</a>
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
        </div>
        <div class="dashboard">
            <h2>Dashboard</h2>

            <!-- Statistics Summary -->
            <div class="stats-summary"
                style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 2rem;">
                <div class="stat-card"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <h3 style="margin: 0; font-size: 2rem;">{{ $totalUsers }}</h3>
                    <p style="margin: 0.5rem 0 0 0;">Total Users</p>
                </div>
                <div class="stat-card"
                    style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <h3 style="margin: 0; font-size: 2rem;">{{ $totalRecipes }}</h3>
                    <p style="margin: 0.5rem 0 0 0;">Total Resep</p>
                </div>
                <div class="stat-card"
                    style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <h3 style="margin: 0; font-size: 2rem;">{{ $totalRatings }}</h3>
                    <p style="margin: 0.5rem 0 0 0;">Total Ratings</p>
                </div>
                <div class="stat-card"
                    style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; padding: 1.5rem; border-radius: 10px; text-align: center;">
                    <h3 style="margin: 0; font-size: 2rem;">{{ $averageRating ?? 0 }}/5</h3>
                    <p style="margin: 0.5rem 0 0 0;">Rata-rata Rating</p>
                </div>
            </div>

            <div class="cards">
                <div class="card">
                    <h3>User Registration</h3>
                    <canvas id="userChart"></canvas>
                </div>
                <div class="card">
                    <h3>Jumlah Resep</h3>
                    <canvas id="recipeChart"></canvas>
                </div>
                <div class="card">
                    <h3>Jumlah Rating</h3>
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>
            </div>
        </div>
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

    <script>
        // Toggle sidebar visibility
        function toggleSidebar() {
            const sidebar = document.getElementById("sidebar");
            const content = document.getElementById("content");
            sidebar.classList.toggle("collapsed");
            content.classList.toggle("shifted");
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


        // Ambil data dari PHP ke JavaScript
        const userData = @json($userData);
        const recipeData = @json($recipeData);
        const ratingData = @json($ratingData);

        const userCtx = document.getElementById('userChart').getContext('2d');
        const userChart = new Chart(userCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'User Registration',
                    data: userData,
                    fill: false,
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Registrasi User per Bulan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const recipeCtx = document.getElementById('recipeChart').getContext('2d');
        const recipeChart = new Chart(recipeCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Jumlah Resep',
                    data: recipeData,
                    fill: false,
                    borderColor: 'rgb(255, 99, 132)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Resep Ditambahkan per Bulan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        const ratingCtx = document.getElementById('ratingChart').getContext('2d');
        const ratingChart = new Chart(ratingCtx, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Jumlah Rating',
                    data: ratingData,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgb(54, 162, 235)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    title: {
                        display: true,
                        text: 'Rating Diberikan per Bulan'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
</body>

</html>
