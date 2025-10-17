<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Ripple | Beranda</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ url('homepage/style.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        .btn-sign {
            background-color: #F44708;
            /* Set the background color to white */
            color: #ffffff;
            /* Set the text color to white */
            margin-left: 20px;
            /* Add margin to the left of the button */
        }

        .btn-sign:hover {
            background-color: #000000;
            /* Set the hover background color to black */
            color: #ffffff;
            /* Set the hover text color to white */
        }

        .btn-search {
            width: 300px;
            /* Set a fixed width for the search input */

        }

        .navbar {
            background-color: #FFFFFF;
            padding: 1rem;
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
            /* Hidden by default */
            position: absolute;
            /* Positioning it absolutely */
            top: 60px;
            /* Adjust this value based on navbar height */
            right: 20px;
            /* Adjust to fit within the page */
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            /* Ensures it appears above other elements */
            padding: 1rem;
            min-width: 120px;
            /* Minimum width to prevent it from being too small */
            width: auto;
            /* Allow the width to adjust based on content */
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


        @media (max-width: 408px) {
            .navbar-nav {
                display: none;
                flex-direction: column;
                text-align: center;
                width: 100%;
                background-color: #ffffff;
            }

            .navbar-toggler {
                display: block;
                border: none;
                background: none;
            }

            .navbar-toggler-icon {
                font-size: 1.5rem;
                color: #ff4500;
            }

            .navbar-nav.show {
                display: flex;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
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
                    <a class="nav-link active" href="/beranda"
                        style="display: flex; flex-direction: column; align-items: center; color:#F44708">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="resep"
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
                    <a class="nav-link" href="/notifikasi"
                        style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-bell"></i>
                        Resep Saya
                    </a>
                </li>
                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="#" onclick="toggleProfilePopup()">
                        <img src="frontend/images/profile1.jpg" alt="User Profile" class="rounded-circle me-2"
                            width="30" height="30" />
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
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
                    <a href="writeresep" class="btn btn-lg"
                        style="color: #ffffff; background-color: #F44708; font-size: 20px;">Tulis Resepmu Disini!</a>

                </div>
            </div>
        </div>
    </section>

    <!-- Popular Recipes -->
    <section class="popular-recipes py-5">
        <div class="container text-center">
            <h2><strong>Popular Recipes</strong></h2>
            <div class="row">
                <div class="col-6 col-md-3">
                    <div class="recipe-card shadow-sm p-3 mb-5 bg-white rounded">
                        <a href="/resep" class="text-decoration-none text-dark">
                            <img src="{{ url('frontend/images/nasigoreng.png') }}" class="img-fluid" alt="Nasi Goreng">
                            <h5 class="mt-2">Nasi Goreng</h5>
                        </a>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="recipe-card shadow-sm p-3 mb-5 bg-white rounded">
                        <img src="{{ url('frontend/images/buburkacanghijau.png') }}" class="img-fluid"
                            alt="Bubur Kacang Hijau">
                        <h5 class="mt-2">Bubur Kacang Hijau</h5>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="recipe-card shadow-sm p-3 mb-5 bg-white rounded">
                        <img src="{{ url('frontend/images/kuelapis.png') }}" class="img-fluid" alt="Kue Lapis">
                        <h5 class="mt-2">Kue Lapis</h5>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="recipe-card shadow-sm p-3 mb-5 bg-white rounded">
                        <img src="{{ url('frontend/images/cendol.png') }}" class="img-fluid" alt="Cendol">
                        <h5 class="mt-2">Cendol</h5>
                    </div>
                </div>
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
                        <div class="col-md-4">
                            <div class="card category-card"
                                style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <img src="{{ url('frontend/images/appetizer.png') }}" class="mt-4"
                                    alt="Appetizer image" style="width: 75%; height:75%; border-radius:15px;">
                                <div class="card-body">
                                    <h5 class="card-title">Appetizer</h5>
                                    <p class="card-text">Lihat resep</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.9</span>
                                        <i class="fas fa-comment" style="margin-left: 210px;"></i>
                                    </div>
                                    <div class="heart-icon">
                                        <i class="fas fa-heart" id="heart-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card category-card"
                                style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <img src="{{ url('frontend/images/maincourse.png') }}" class="mt-4"
                                    alt="maincourse image" style="width: 75%; height:75%; border-radius:15px;">
                                <div class="card-body">
                                    <h5 class="card-title">Main Course</h5>
                                    <p class="card-text">Lihat resep</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.6</span>
                                        <i class="fas fa-comment" style="margin-left: 210px;"></i>
                                    </div>
                                </div>
                                <div class="heart-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card category-card"
                                style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                                <img src="{{ url('frontend/images/dessert.png') }}" class="mt-4"
                                    alt="Appetizer image" style="width: 75%; height:75%; border-radius:15px;">
                                <div class="card-body">
                                    <h5 class="card-title">Dessert</h5>
                                    <p class="card-text">Lihat resep</p>
                                    <div class="rating">
                                        <i class="fas fa-star"></i>
                                        <span>4.8</span>
                                        <i class="fas fa-comment" style="margin-left: 210px;"></i>
                                    </div>
                                </div>
                                <div class="heart-icon">
                                    <i class="fas fa-heart"></i>
                                </div>
                            </div>
                        </div>
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

    <div class="profile-popup" id="profilePopup">
        <div class="d-flex align-items-center">
            <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle" />
            <div>
                <a href="/profil">
                    <strong>{{ Auth::user()->name }}</strong><br>
                </a>
                <small>{{ Auth::user()->email }}</small>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                style="width: 100%; background-color: #f44708; color: white; border: none; border-radius: 5px; padding: 0.5rem; cursor: pointer;">
                Keluar
            </button>
        </form>
    </div>

    <button id="scrollToTopBtn" class="scroll-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
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


        function toggleProfilePopup() {
            const popup = document.getElementById('profilePopup');
            popup.style.display = popup.style.display === 'block' ? 'none' : 'block';
        }

        function logout() {
            // Implement logout functionality
            alert("Logout clicked!");
            // For example, redirect or perform logout logic here
        }

        // Hide popup when clicking outside
        window.onclick = function(event) {
            const popup = document.getElementById('profilePopup');
            if (!event.target.closest('.nav-link') && !event.target.closest('#profilePopup')) {
                popup.style.display = 'none'; // Hide popup
            }
        }
    </script>
</body>

</html>
