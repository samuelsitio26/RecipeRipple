<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Ripple | Home</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ url('homepage/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-sign {
            background-color: #F44708;
            color: #ffffff;
            margin-left: 10px;
        }

        .btn-sign:hover {
            background-color: #000000;
            color: #ffffff;
        }



        /* Navbar Styles */
        .navbar {
            transition: transform 0.3s ease;
        }

        .navbar.hidden {
            transform: translateY(-100%);
        }

        .navbar-brand {
            font-size: 1.5rem;
            display: flex;
            align-items: center;
        }

        .navbar-nav {
            margin-left: auto;
        }

        .navbar {
            transition: transform 0.3s ease, opacity 0.3s ease;
        }

        .navbar.hidden {
            transform: translateY(-100%);
            opacity: 0;
        }

        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            background-color: #F44708;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .scroll-to-top:hover {
            background-color: #000000;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="{{ url('frontend/images/logo.png') }}" alt="Recipe Ripple" width="30" class="me-2"
                    style="border-radius: 50%;">
                Recipe <span style="color: #F44708;">Ripple</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#" style="color:#F44708; font-size: 18px;">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about" style="font-size: 18px;">About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact" style="font-size: 18px;">Contact</a>
                    </li>
                </ul>
                <div class="ms-3">
                    <a href="login" class="btn btn-sign">Login</a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->

    <section class="hero-section d-flex align-items-center">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h1 class="display-4"><span style="color: #ffffff;">Recipe</span> <span
                            style="color: #F44708;">Ripple</span></h1>
                    <p class="lead" style="font-size: 20px;">"Bumbu yang Tepat, Masakan yang Hebat!"</p>
                    <p style="font-size: 19px;">Selamat datang di RecipeRipple, tempat di mana setiap resep menjadi
                        inspirasi! Temukan, bagikan, dan nikmati kreasi kuliner dari seluruh dunia, langsung dari dapur
                        rumah Anda.</p>
                    <a href="login" class="btn btn-lg"
                        style="color: #ffffff; background-color: #F44708; font-size: 20px;">Tulis Resepmu Disini!</a>

                </div>
            </div>
        </div>
    </section>

    <!-- Popular Recipes -->
    <section class="popular-recipes py-5">
        <div class="container text-center">
            <h2><strong>Popular Recipes</strong></h2>
            <div class="row justify-content-center">
                @forelse($popularRecipes as $recipe)
                    <div class="col-6 col-lg-3 col-md-4">
                        <div class="recipe-card shadow-sm p-3 mb-5 bg-white rounded">
                            <a href="{{ route('resep.show', $recipe->id) }}" class="text-decoration-none text-dark">
                                @if ($recipe->gambar)
                                    <img src="{{ asset('uploads/recipe/gambar/' . $recipe->gambar) }}" class="img-fluid"
                                        alt="{{ $recipe->name }}"
                                        style="width: 100%; height: 150px; object-fit: cover; border-radius: 10px;">
                                @else
                                    <div
                                        style="width: 100%; height: 150px; background-color: #f8f9fa; border-radius: 10px; display: flex; align-items: center; justify-content: center;">
                                        <i class="fas fa-image" style="font-size: 2rem; color: #dee2e6;"></i>
                                    </div>
                                @endif
                                <h5 class="mt-2">{{ Str::limit($recipe->name, 20) }}</h5>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div class="rating">
                                        <i class="fas fa-star" style="color: #FFD700;"></i>
                                        <span>{{ number_format($recipe->ratings_avg_rating ?? 0, 1) }}</span>
                                    </div>
                                    <div class="comments">
                                        <i class="fas fa-comment" style="color: #666;"></i>
                                        <span>{{ $recipe->comments_count }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-utensils" style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
                            <h5 class="text-muted">Belum ada resep tersedia</h5>
                            <p class="text-muted">Jadilah yang pertama berbagi resep lezat!</p>
                            <a href="/login" class="btn"
                                style="background-color: #F44708; color: white; margin-top: 1rem;">
                                <i class="fas fa-plus me-2"></i>Login untuk Menulis Resep
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Recipe Categories -->
    <div class="container mt-5">
        <div class="form-inline">
            <h2 class="mb-4" style="display: inline-block; margin: 0;">Telusuri Berdasarkan...</h2>
        </div>

        <div class="carousel slide" data-bs-ride="carousel" id="foodCarousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="row">
                        @forelse($categories as $category)
                            <div class="col-md-4">
                                <div class="card category-card"
                                    style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                    @php
                                        // Default images untuk kategori berdasarkan nama
                                        $categoryImages = [
                                            'appetizer' => 'appetizer.png',
                                            'main course' => 'maincourse.png',
                                            'dessert' => 'dessert.png',
                                        ];
                                        $imageName = $categoryImages[strtolower($category->nama)] ?? 'maincourse.png';
                                    @endphp
                                    <img src="{{ url('frontend/images/' . $imageName) }}" class="mt-4"
                                        alt="{{ $category->nama }}"
                                        style="width: 75%; height:200px; object-fit: cover; border-radius:15px;">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $category->nama }}</h5>
                                        <p class="card-text">{{ $category->recipe_count }} resep tersedia</p>
                                        <div class="rating">
                                            <i class="fas fa-star" style="color: #FFD700;"></i>
                                            <span>{{ number_format($category->avg_rating, 1) }}</span>
                                            <i class="fas fa-comment" style="margin-left: 150px; color: #666;"></i>
                                            <span>{{ $category->total_comments }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="text-center py-5">
                                    <i class="fas fa-tags"
                                        style="font-size: 3rem; color: #ddd; margin-bottom: 1rem;"></i>
                                    <h5 class="text-muted">Belum ada kategori tersedia</h5>
                                    <p class="text-muted">Kategori akan muncul otomatis saat ada resep yang dibuat.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- About Us -->
    <section class="about-us py-5" id="about">
        <div class="about-section">
            <div class="about-image">
                <img src="{{ url('frontend/images/logo-about.png') }}" height="200" width="200" />
            </div>
            <div class="about-content">
                <h2 style="color: black;">About Us</h2>
                <p>At RecipeRipple, we believe that cooking connects people. Our platform allows food lovers to
                    discover, share, and enjoy recipes from around the world. Whether youâ€™re a beginner or an
                    experienced cook, we provide an easy way to explore new dishes, upload your own creations, and
                    engage with a vibrant community.</p>
                <p>Join us in spreading the joy of cooking, one recipe at a time!</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-4 text-white text-center">
        <div class="container" id="contact">
            <p style="font-size: 30px;">Contact</p>
            <a href="#" class="text-white me-3"><span class="bg-orange rounded-circle p-2"><i
                        class="bi bi-facebook"></i></span></a>
            <a href="#" class="text-white me-3"><span class="bg-orange rounded-circle p-2"><i
                        class="bi bi-instagram"></i></span></a>
            <a href="#" class="text-white me-3"><span class="bg-orange rounded-circle p-2"><i
                        class="bi bi-twitter"></i></span></a>
            <a href="#" class="text-white"><span class="bg-orange rounded-circle p-2"><i
                        class="bi bi-telephone-fill"></i></span></a>
        </div>
    </footer>
    <button id="scrollToTopBtn" class="scroll-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Get the button
        const scrollToTopBtn = document.getElementById("scrollToTopBtn");

        // Show button when scrolling down
        window.onscroll = function() {
            if (document.body.scrollTop > 100 || document.documentElement.scrollTop > 100) {
                scrollToTopBtn.style.display = "block";
            } else {
                scrollToTopBtn.style.display = "none";
            }
        };

        // Scroll to top functionality
        scrollToTopBtn.addEventListener("click", function() {
            window.scrollTo({
                top: 0,
                behavior: "smooth"
            });
        });


        // Script for hiding/showing navbar on scroll
        let lastScrollTop = 0;
        const navbar = document.querySelector('.navbar');
        let isScrolling;

        window.addEventListener('scroll', function() {
            clearTimeout(isScrolling);

            const scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop) {
                // Scroll Down - Hide Navbar
                navbar.classList.add('hidden');
            } else {
                // Scroll Up - Show Navbar
                navbar.classList.remove('hidden');
            }

            // Save current scroll position
            lastScrollTop = scrollTop <= 0 ? 0 : scrollTop; // Avoid negative values
        });

        // Optional: To ensure navbar appears after scrolling stops
        isScrolling = setTimeout(() => {
            navbar.classList.remove('hidden');
        }, 250);
    </script>
</body>

</html>
