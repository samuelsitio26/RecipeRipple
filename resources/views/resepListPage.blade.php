<!DOCTYPE html>
<html lang="en">

<head>
    <title>Resep - Recipe Ripple</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #FFF7E6;
            font-family: 'Montserrat', sans-serif;
        }

        .navbar {
            background-color: #FFFFFF;
            padding: 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
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

        .main-container {
            max-width: 1200px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .page-title {
            text-align: center;
            color: #333;
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 2rem;
        }

        .page-title span {
            color: #FF4500;
        }

        .filters {
            background-color: white;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .filter-row {
            display: flex;
            gap: 1rem;
            align-items: end;
        }

        .filter-group {
            flex: 1;
        }

        .filter-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: #333;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .btn-filter {
            background-color: #FF4500;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1rem;
            height: fit-content;
        }

        .btn-filter:hover {
            background-color: #FF6347;
        }

        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
        }

        .recipe-card {
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .recipe-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            text-decoration: none;
            color: inherit;
        }

        .recipe-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            object-position: center;
            background-color: #f8f9fa;
        }

        .recipe-content {
            padding: 1.5rem;
        }

        .recipe-title {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recipe-description {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .recipe-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .recipe-category {
            background-color: #FF4500;
            color: white;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .recipe-author {
            font-size: 0.85rem;
            color: #888;
        }

        .recipe-rating {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1rem;
        }

        .stars {
            display: flex;
            gap: 2px;
        }

        .star {
            color: #ddd;
            font-size: 1rem;
        }

        .star.filled {
            color: #FFD700;
        }

        .rating-text {
            font-size: 0.9rem;
            color: #666;
        }

        .recipe-stats {
            display: flex;
            justify-content: flex-start;
            align-items: center;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 0.3rem;
            font-size: 0.85rem;
            color: #888;
        }

        .no-recipes {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            margin: 3rem 0;
        }

        .pagination {
            margin-top: 3rem;
            justify-content: center;
        }

        .page-link {
            color: #FF4500;
            border-color: #FF4500;
        }

        .page-item.active .page-link {
            background-color: #FF4500;
            border-color: #FF4500;
        }

        /* Profile Popup */
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
            min-width: 200px;
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

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                gap: 1rem;
            }

            .recipes-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ url('frontend/images/logo.png') }}" alt="Recipe Ripple" width="30" class="me-2"
                style="border-radius: 50%;">
            Recipe <span style="color: #F44708;">Ripple</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

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
                    <a class="nav-link active" href="/resep"
                        style="display: flex; flex-direction: column; align-items: center; color:#F44708">
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
                    <a class="nav-link" href="/notifikasi"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-bell"></i>
                        Resep Saya
                    </a>
                </li>
                @auth
                    <li class="nav-item">
                        <a class="nav-link d-flex align-items-center" href="#" onclick="toggleProfilePopup()">
                            <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile"
                                class="rounded-circle me-2" width="30" height="30" />
                            <span>{{ Auth::user()->name }}</span>
                        </a>
                    </li>
                @else
                    <li class="nav-item">
                        <a class="nav-link" href="/login"
                            style="display: flex; flex-direction: column; align-items: center;">
                            <i class="fas fa-sign-in-alt"></i>
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </nav>

    <div class="main-container">
        <!-- Filters -->
        <div class="filters">
            <form method="GET" action="{{ url('/resep') }}">
                <div class="filter-row">
                    <div class="filter-group">
                        <label for="search">Cari Resep</label>
                        <input type="text" id="search" name="search"
                            placeholder="Cari berdasarkan nama atau bahan..." value="{{ request('search') }}">
                    </div>

                    <div class="filter-group">
                        <label for="kategori">Kategori</label>
                        <select id="kategori" name="kategori">
                            <option value="">Semua Kategori</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('kategori') == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="filter-group">
                        <label for="sort">Urutkan</label>
                        <select id="sort" name="sort">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Terbaru</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Terpopuler
                            </option>
                            <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Paling
                                Dilihat</option>
                        </select>
                    </div>

                    <button type="submit" class="btn-filter">
                        <i class="fas fa-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>

        <!-- Recipes Grid -->
        @if ($recipes->count() > 0)
            <div class="recipes-grid">
                @foreach ($recipes as $recipe)
                    <a href="{{ route('resep.show', $recipe->id) }}" class="recipe-card">
                        @if ($recipe->gambar)
                            <img src="{{ asset('uploads/recipe/gambar/' . $recipe->gambar) }}"
                                alt="{{ $recipe->name }}" class="recipe-image">
                        @else
                            <div class="recipe-image"
                                style="background-color: #f8f9fa; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="font-size: 3rem; color: #dee2e6;"></i>
                            </div>
                        @endif

                        <div class="recipe-content">
                            <h3 class="recipe-title">{{ $recipe->name }}</h3>
                            <p class="recipe-description">{{ Str::limit($recipe->description, 120) }}</p>

                            <div class="recipe-meta">
                                <span class="recipe-category">{{ $recipe->kategori->nama ?? 'Uncategorized' }}</span>
                                <span class="recipe-author">oleh {{ $recipe->user->name ?? 'Unknown' }}</span>
                            </div>

                            <div class="recipe-rating">
                                <div class="stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i
                                            class="fas fa-star star {{ $i <= floor($recipe->average_rating) ? 'filled' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="rating-text">
                                    {{ number_format($recipe->average_rating, 1) }}
                                </span>
                            </div>

                            <div class="recipe-stats">
                                <div class="stat-item">
                                    <i class="fas fa-eye"></i>
                                    <span>{{ $recipe->views_count ?? 0 }} dilihat</span>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <nav aria-label="Recipe pagination">
                {{ $recipes->appends(request()->query())->links() }}
            </nav>
        @else
            <div class="no-recipes">
                <i class="fas fa-search" style="font-size: 3rem; margin-bottom: 1rem; color: #ddd;"></i>
                <p>Tidak ada resep yang ditemukan.</p>
                @if (request()->hasAny(['search', 'kategori']))
                    <a href="{{ url('/resep') }}" class="btn-filter">Reset Filter</a>
                @endif
            </div>
        @endif
    </div>

    @auth
        <!-- Profile Popup -->
        <div class="profile-popup" id="profilePopup">
            <div class="d-flex align-items-center">
                <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle me-2"
                    width="40" height="40" />
                <div>
                    <h5>{{ Auth::user()->name }}</h5>
                    <p>{{ Auth::user()->email }}</p>
                </div>
            </div>
            <hr>
            <a href="/profil" class="btn btn-sm btn-outline-primary w-100 mb-2">Profil</a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm w-100">Keluar</button>
            </form>
        </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleProfilePopup() {
            const popup = document.getElementById('profilePopup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        // Hide popup when clicking outside
        window.onclick = function(event) {
            const popup = document.getElementById('profilePopup');
            if (!event.target.closest('.nav-link') && !event.target.closest('#profilePopup')) {
                popup.style.display = 'none';
            }
        }
    </script>
</body>

</html>
