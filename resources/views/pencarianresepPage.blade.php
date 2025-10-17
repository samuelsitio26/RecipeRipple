<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Recipe Ripple</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #FFF7E6;
            color: #333;
        }

        /* .btn-search {
            border-radius: 40px;
            padding: 10px;
            font-size: 1rem;
            font-weight: bold;
            background-color: #f44708;
            border: 2px solid #f44708; Menambahkan border oranye
        } */
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

        .about-container {
            background-color: #550527;
            /* Dark red background */
            color: white;
            /* White text color */
            padding: 1.5rem;
            font-family: 'Montserrat', sans-serif;
            border-radius: 10px;
            /* Rounded corners */
            margin-top: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            /* Subtle shadow */
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
            /* Spacing of 20px between icons */
        }

        .social-icon:last-child {
            margin-right: 0;
            /* No margin on the last icon */
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
            /* Display icons in a row */
            align-items: center;
            /* Center icons vertically */
        }

        /* Popup Styles */
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


        .search-bar {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .search-container {
            display: flex;
            align-items: center;
            background-color: #f15a22;
            /* Warna oranye */
            border-radius: 20px;
            padding: 5px 15px;
            width: 300px;
            /* Sesuaikan lebar */
        }

        .search-container i {
            color: white;
            /* Warna ikon */
            font-size: 16px;
            margin-right: 10px;
            /* Jarak antara ikon dan input */
        }

        .search-container input {
            border: none;
            background: transparent;
            outline: none;
            color: white;
            /* Warna teks */
            width: 100%;
            font-size: 16px;
        }

        .search-container input::placeholder {
            color: rgba(255, 255, 255, 0.7);
            /* Warna placeholder */
        }

        .search-bar input {
            width: 50%;
            border-radius: 40px;
            padding: 10px;
            font-size: 1rem;
            background-color: #f44708;
            border: 2px solid #f44708;
            /* Menambahkan border oranye */
        }

        .search-bar button {
            background-color: #FF4500;
            border: none;
            padding: 0.5rem 1rem;
            color: #fff;
            border-radius: 0 5px 5px 0;
        }

        .card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background-color: #fff;
        }

        .card img {
            border-radius: 15px 15px 0 0;
        }

        .card-body {
            padding: 1rem;
        }

        .card-title {
            font-size: 1rem;
            font-weight: bold;
        }

        .card-text {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-text .fa-star {
            color: #FFD700;
        }

        .card-text .fa-user {
            color: #333;
        }

        .load-more {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .load-more button {
            background-color: #FF4500;
            border: none;
            padding: 0.75rem 2rem;
            color: #fff;
            border-radius: 25px;
            font-size: 1rem;
        }

        .footer {
            background-color: #800080;
            color: #fff;
            padding: 2rem 0;
            text-align: center;
        }

        .footer h2 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .footer p {
            font-size: 1rem;
            margin-bottom: 1rem;
        }

        .footer .social-icons a {
            color: #fff;
            margin: 0 0.5rem;
            font-size: 1.5rem;
        }

        @media (max-width: 400px) {
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
                        style="display: flex; flex-direction: column; align-items: center; ">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="pencarian"
                        style="display: flex; flex-direction: column; align-items: center; color: #F44708;">
                        <i class="fas fa-search"></i>
                        Cari
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

    <div class="container">
        <div class="text-center">
            <h1 class="my-4" style="font-weight: bold;">
                <img alt="Logo" class="me-2" height="50" src="{{ url('frontend/images/logo.png') }}"
                    width="50" />
                Recipe <span style="color: #FF4500;">Ripple</span>
            </h1>
        </div>
        <form action="/search" method="GET" class="search-container">
            <i class="fas fa-search"></i>
            <input type="text" name="query" placeholder="Search.." required />
            <button type="submit" style="display: none;"></button>
        </form>
        <br>

        <div class="row">
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="{{ url('resep/nasi-goreng-kampung') }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <img alt="Nasi Goreng Kampung" class="card-img-top" height="200"
                            src="{{ url('frontend/images/nasi_goreng_kampug.png') }}" width="300" />
                        <div class="card-body">
                            <h5 class="card-title">Resep Nasi Goreng Kampung, Lezat, Gampang</h5>
                            <p class="card-text">
                                <span><i class="fas fa-star"></i> 3.8</span>
                                <span><i class="fas fa-user"></i></span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="{{ url('resep/nasi-goreng-pedas-gila') }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <img alt="Nasi Goreng Pedas Gila" class="card-img-top" height="200"
                            src="{{ url('frontend/images/Nasi_Goreng_Pedas.png') }}" width="300" />
                        <div class="card-body">
                            <h5 class="card-title">Resep Nasi Goreng Pedas Gila, Sederhana</h5>
                            <p class="card-text">
                                <span><i class="fas fa-star"></i> 4.6</span>
                                <span><i class="fas fa-user"></i></span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="{{ url('resep/nasi-goreng-kambing') }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <img alt="Nasi Goreng Kambing" class="card-img-top" height="200"
                            src="{{ url('frontend/images/Nasi_Goreng_Kambing.png') }}" width="300" />
                        <div class="card-body">
                            <h5 class="card-title">Resep Nasi Goreng Kambing, Rasa Mantap Daging Empuk</h5>
                            <p class="card-text">
                                <span><i class="fas fa-star"></i> 4.8</span>
                                <span><i class="fas fa-user"></i></span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3 mb-4">
                <a href="{{ url('resep/nasi-goreng-spesial') }}" style="text-decoration: none; color: inherit;">
                    <div class="card">
                        <img alt="Nasi Goreng Spesial" class="card-img-top" height="200"
                            src="{{ url('frontend/images/Nasi_Goreng_Spesial.png') }}" width="300" />
                        <div class="card-body">
                            <h5 class="card-title">Resep Nasi Goreng Spesial ala Restoran Mewah</h5>
                            <p class="card-text">
                                <span><i class="fas fa-star"></i> 5.0</span>
                                <span><i class="fas fa-user"></i></span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        <div class="load-more">
            <button id="loadMoreButton">Tampilkan lebih banyak</button>
        </div>
    </div>


    </div>
    <div class="about-container">
        <h2>About Us</h2>
        <p>At RecipeRipple, we believe that cooking connects people. Our platform allows food lovers to discover, share,
            and enjoy recipes from around the world. Whether youâ€™re a beginner or an experienced cook, we provide an
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

    <!-- Profile Popup -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('loadMoreButton').addEventListener('click', function() {
            // Contoh konten baru yang akan ditambahkan (4 menu baru)
            const newContent = `
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <img alt="Resep bakso kampung mie keriting" class="card-img-top" height="200" src="{{ url('frontend/images/mie keriting.png') }}" width="300"/>
                <div class="card-body">
                    <h5 class="card-title">Resep bakso kampung mie keriting</h5>
                    <p class="card-text">
                        <span><i class="fas fa-star"></i> 3.8</span>
                        <span><i class="fas fa-user"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <img alt="Resep Risol Mayonise " class="card-img-top" height="200" src="{{ url('frontend/images/risol.png') }}" width="300"/>
                <div class="card-body">
                    <h5 class="card-title">Resep Risol Mayonise </h5>
                    <p class="card-text">
                        <span><i class="fas fa-star"></i> 4.5</span>
                        <span><i class="fas fa-user"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <img alt="Resep Lupis Ketan Gula Merah" class="card-img-top" height="200" src="{{ url('frontend/images/lupis.png') }}" width="300"/>
                <div class="card-body">
                    <h5 class="card-title">Resep Lupis Ketan Gula Merah</h5>
                    <p class="card-text">
                        <span><i class="fas fa-star"></i> 4.7</span>
                        <span><i class="fas fa-user"></i></span>
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card">
                <img alt="Resep Klepon Isi Gula Merah gurih dan kenyal" class="card-img-top" height="200" src="{{ url('frontend/images/klepon.png') }}" width="300"/>
                <div class="card-body">
                    <h5 class="card-title">Resep Klepon Isi Gula Merah gurih dan kenyal</h5>
                    <p class="card-text">
                        <span><i class="fas fa-star"></i> 4.0</span>
                        <span><i class="fas fa-user"></i></span>
                    </p>
                </div>
            </div>
        </div>
    `;

            // Menambahkan konten baru ke dalam container resep
            const recipeContainer = document.querySelector('.row');
            recipeContainer.insertAdjacentHTML('beforeend', newContent);
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
