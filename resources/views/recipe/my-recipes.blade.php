<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep Saya - Recipe Ripple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #FFF7E6;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #FFFFFF;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            width: 100%;
        }

        body {
            padding-top: 80px;
        }

        .navbar-brand {
            font-weight: bold;
            color: #040100;
        }

        .nav-link {
            font-size: 1rem;
            margin-left: 0.5rem;
            color: #333;
        }

        .nav-link:hover {
            color: #f44708;
        }

        .nav-link.active {
            color: #f44708;
        }

        .profile-popup {
            display: none;
            position: absolute;
            top: 60px;
            right: 20px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 1rem;
            min-width: 120px;
            width: auto;
        }

        .profile-popup img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .profile-popup h5 {
            margin: 0;
            font-size: 14px;
        }

        .profile-popup p {
            margin: 0.5rem 0;
            font-size: 12px;
        }

        .profile-popup button {
            width: 100%;
            background-color: #f44708;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 0.5rem;
        }

        .profile-popup button:hover {
            background-color: #FF6347;
        }

        .container {
            margin-top: 2rem;
            margin-bottom: 2rem;
            max-width: 1200px;
        }

        .page-header {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .page-title {
            display: flex;
            align-items: center;
            gap: 1rem;
            color: #333;
            margin: 0;
        }

        .page-title i {
            color: #FF4500;
            font-size: 2rem;
        }

        .recipe-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 2rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            position: relative;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .recipe-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            cursor: pointer;
        }

        .recipe-card-body {
            padding: 1.5rem;
        }

        .recipe-title {
            font-size: 1.2rem;
            font-weight: bold;
            margin-bottom: 0.5rem;
            color: #333;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            overflow: hidden;
            cursor: pointer;
        }

        .recipe-title:hover {
            color: #FF4500;
        }

        .recipe-stats {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-top: 0.75rem;
            font-size: 0.9rem;
            color: #666;
        }

        .recipe-stats i {
            color: #FF4500;
            margin-right: 0.3rem;
        }

        .manage-buttons {
            display: none;
            position: absolute;
            top: 10px;
            right: 10px;
            gap: 0.5rem;
            z-index: 10;
        }

        .recipe-card:hover .manage-buttons {
            display: flex;
        }

        .btn-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: none;
            color: white;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .btn-icon:hover {
            transform: scale(1.1);
        }

        .btn-edit-icon {
            background-color: #2196F3;
        }

        .btn-delete-icon {
            background-color: #f44336;
        }

        .badge-category {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 69, 0, 0.9);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            z-index: 5;
        }

        .badge-category {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 69, 0, 0.9);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            z-index: 5;
        }

        .stats-badge {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
        }

        background: white;
        border-radius: 15px;
        text-align: center;
        padding: 4rem 2rem;
        color: #999;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .empty-state i {
            font-size: 5rem;
            margin-bottom: 1.5rem;
            color: #FF4500;
            opacity: 0.3;
        }

        .empty-state h4 {
            color: #666;
            margin-bottom: 1rem;
        }

        .badge-category {
            background-color: #FF4500;
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .stats-badge {
            background-color: #f8f9fa;
            padding: 0.4rem 0.8rem;
            border-radius: 8px;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
            color: #666;
        }

        .stats-badge i {
            color: #FF4500;
        }

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .btn-add-recipe {
            background-color: #FF4500;
            color: white;
            border: none;
            padding: 0.6rem 1.5rem;
            border-radius: 25px;
            font-weight: 500;
            transition: all 0.3s;
        }

        .btn-add-recipe:hover {
            background-color: #FF6347;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 69, 0, 0.3);
        }

        .about-container {
            background-color: #550527;
            color: white;
            padding: 2rem 0;
            font-family: 'Montserrat', sans-serif;
            margin-top: 3rem;
            width: 100%;
        }

        .about-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .social-icon {
            color: white;
            background-color: #F44708;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 20px;
        }

        .social-icon:last-child {
            margin-right: 0;
        }

        .social-icon:hover {
            color: #FFFFFF;
            background-color: #FF6347;
        }

        .about-container h2 {
            font-weight: bold;
        }

        .social-icons-container {
            display: flex;
            align-items: center;
        }

        @media (max-width: 768px) {
            .recipe-card-body {
                padding: 1rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-action {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="/beranda">
            <img src="{{ url('frontend/images/logo.png') }}" alt="Recipe Ripple" width="30" class="me-2"
                style="border-radius: 50%;">
            Recipe <span style="color: #F44708;">Ripple</span>
        </a>

        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/beranda"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/resep"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-book"></i>
                        Resep
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/writeresep"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-pen"></i>
                        Tulis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="/notifikasi"
                        style="display: flex; flex-direction: column; align-items: center; color:#F44708">
                        <i class="fas fa-bell"></i>
                        Resep Saya
                    </a>
                </li>
                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="#" onclick="toggleProfilePopup()">
                        <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile"
                            class="rounded-circle me-2" width="30" height="30" />
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Profile Popup -->
    <div class="profile-popup" id="profilePopup">
        <div class="d-flex align-items-center mb-2">
            <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile" />
            <div>
                <h5>{{ Auth::user()->name ?? 'User' }}</h5>
                <p>{{ Auth::user()->email ?? 'user@example.com' }}</p>
            </div>
        </div>
        <button onclick="window.location.href='/profil'">Profil</button>
        <form action="/logout" method="POST">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </div>

    <div class="container">
        <div class="page-header">
            <h2 class="page-title">
                <i class="fas fa-bell"></i>
                <span>Resep Saya</span>
            </h2>
            <p class="text-muted mb-0">Kelola semua resep yang telah Anda buat</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($recipes->count() > 0)
            <div class="row">
                @foreach ($recipes as $recipe)
                    <div class="col-md-6 col-lg-3">
                        <div class="recipe-card">
                            <!-- Category Badge -->
                            <span class="badge-category">
                                <i class="fas fa-tag"></i> {{ $recipe->kategori->nama ?? 'Tanpa Kategori' }}
                            </span>

                            <!-- Manage Buttons (appear on hover) -->
                            <div class="manage-buttons">
                                <a href="{{ route('recipe.edit', $recipe->id) }}" class="btn-icon btn-edit-icon"
                                    title="Edit Resep">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('recipe.destroy', $recipe->id) }}" method="POST"
                                    style="display: inline;"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus resep {{ $recipe->name }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-icon btn-delete-icon" title="Hapus Resep">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Recipe Image -->
                            @if ($recipe->gambar)
                                <img src="{{ asset('uploads/recipe/gambar/' . $recipe->gambar) }}"
                                    alt="{{ $recipe->name }}" class="recipe-image"
                                    onclick="window.location.href='{{ route('recipe.show', $recipe->id) }}'">
                            @else
                                <div class="recipe-image"
                                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center;"
                                    onclick="window.location.href='{{ route('recipe.show', $recipe->id) }}'">
                                    <i class="fas fa-utensils"
                                        style="font-size: 3rem; color: white; opacity: 0.7;"></i>
                                </div>
                            @endif

                            <!-- Recipe Body -->
                            <div class="recipe-card-body">
                                <h5 class="recipe-title"
                                    onclick="window.location.href='{{ route('recipe.show', $recipe->id) }}'">
                                    {{ $recipe->name }}
                                </h5>

                                <div class="recipe-stats">
                                    <span class="stats-badge">
                                        <i class="fas fa-star"></i>
                                        {{ number_format($recipe->average_rating, 1) }}
                                    </span>
                                    <span class="stats-badge">
                                        <i class="fas fa-comment"></i>
                                        {{ $recipe->comments->count() }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $recipes->links() }}
            </div>
        @else
            <div class="empty-state">
                <i class="fas fa-utensils"></i>
                <h4>Belum Ada Resep</h4>
                <p class="mb-4">Anda belum membuat resep apapun. Yuk mulai berbagi resep favorit Anda dengan
                    komunitas Recipe Ripple!</p>
                <a href="/recipe/create" class="btn btn-add-recipe">
                    <i class="fas fa-plus me-2"></i> Buat Resep Pertama Saya
                </a>
            </div>
        @endif

    </div>

    <!-- Footer About Us -->
    <div class="about-container">
        <div class="about-content">
            <h2>About Us</h2>
            <p>At RecipeRipple, we believe that cooking connects people. Our platform allows food lovers to discover,
                share,
                and enjoy recipes from around the world. Whether you're a beginner or an experienced cook, we provide an
                easy way to explore new dishes, upload your own creations, and engage with a vibrant community.</p>
            <p>Join us in spreading the joy of cooking, one recipe at a time!</p>
            <h2>Contact</h2>
            <div class="social-icons-container">
                <a class="social-icon" href="#"><i class="fab fa-facebook"></i></a>
                <a class="social-icon" href="#"><i class="fab fa-instagram"></i></a>
                <a class="social-icon" href="#"><i class="fab fa-twitter"></i></a>
                <a class="social-icon" href="#"><i class="fas fa-phone"></i></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Auto hide alerts after 5 seconds
        setTimeout(function() {
            var alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                var bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);

        // Toggle profile popup
        function toggleProfilePopup() {
            var popup = document.getElementById('profilePopup');
            popup.style.display = (popup.style.display === 'block') ? 'none' : 'block';
        }

        // Close popup when clicking outside
        window.onclick = function(event) {
            var popup = document.getElementById('profilePopup');
            if (!event.target.matches('.nav-link') && !event.target.closest('.profile-popup')) {
                if (popup.style.display === 'block') {
                    popup.style.display = 'none';
                }
            }
        }
    </script>
</body>

</html>
