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
            color: white;
            padding: 1.5rem;
            font-family: 'Montserrat', sans-serif;
            border-radius: 10px;
            margin-top: 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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

        .search-bar {
            display: flex;
            justify-content: center;
            margin: 2rem 0;
        }

        .search-bar input {
            width: 50%;
            border-radius: 40px;
            padding: 10px;
            font-size: 1rem;
            background-color: #f44708;
            border: 2px solid #f44708;
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
            cursor: pointer;
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

        .card:hover {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transform: scale(1.02);
            transition: all 0.3s ease-in-out;
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
                    <a class="nav-link active" href="#"
                        style="display: flex; flex-direction: column; align-items: center; color: #F44708;">
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

    <div class="container">
        <div class="text-center">
            <h1 class="my-4" style="font-weight: bold;">
                <img alt="Logo" class="me-2" height="50" src="{{ url('frontend/images/logo.png') }}"
                    width="50" />
                Recipe <span style="color: #FF4500;">Ripple</span>
            </h1>
        </div>
        {{-- <div class="search-bar" style="position: relative;">
            <form action="{{ route('resep.search') }}" method="get">
                <input type="text" name="query" class="form-control btn-danger" placeholder="Search.." style="border-radius: 25px; padding-left: 30px; color: white; background-color: #FF4500; border: none; width: 100%; max-width: 1000px;">
                <i class="bi bi-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%); color: white; pointer-events: none;"></i>
            </form>
        </div> --}}


        <div class="container">
            <div class="row">
                @foreach ($recipes as $recipe)
                    <div class="col-md-4 mb-4">
                        <!-- Mengatur lebar kolom dan margin antar card -->
                        <div class="card">
                            <img alt="Nasi Goreng Kampung" class="card-img-top" height="200"
                                src="{{ url('frontend/images/nasi_goreng_kampug.png') }}" width="300" />
                            <div class="card-body">
                                <h5 class="card-title">{{ $recipe->name }}</h5>
                                <p class="card-text">
                                    <span><i class="fas fa-star"></i> 3.8</span>
                                    <span><i class="fas fa-user"></i> {{ $recipe->author ?? 'Anonymous' }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="load-more">
            <button id="loadMoreButton">Tampilkan lebih banyak</button>
        </div>

        <script>
            const moreRecipes = [{
                    href: "/resep/nasi-goreng-seafood",
                    imgSrc: "{{ url('frontend/images/Nasi_Goreng_Seafood.png') }}",
                    imgAlt: "Nasi Goreng Seafood",
                    title: "Resep Nasi Goreng Seafood, Lezat Segar",
                    rating: 4.7,
                },
                {
                    href: "/resep/nasi-goreng-vegetarian",
                    imgSrc: "{{ url('frontend/images/Nasi_Goreng_Vegetarian.png') }}",
                    imgAlt: "Nasi Goreng Vegetarian",
                    title: "Resep Nasi Goreng Vegetarian, Sehat dan Enak",
                    rating: 4.5,
                },

                {
                    href: "/resep/nasi-goreng-ayam",
                    imgSrc: "{{ url('frontend/images/Nasi_Goreng_Ayam.png') }}",
                    imgAlt: "Nasi Goreng Ayam",
                    title: "Resep Nasi Goreng Ayam, Gurih dan Lezat",
                    rating: 4.6,
                },

                {
                    href: "/resep/nasi-goreng-teri",
                    imgSrc: "{{ url('frontend/images/Nasi_Goreng_Teri.png') }}",
                    imgAlt: "Nasi Goreng Teri",
                    title: "Resep Nasi Goreng Teri, Gurih dan Renyah",
                    rating: 4.3,
                },
            ];

            let recipesDisplayed = false;
            document.getElementById("loadMoreButton").addEventListener("click", function() {
                if (!recipesDisplayed) {
                    const container = document.querySelector(".row");
                    moreRecipes.forEach(recipe => {
                        const col = document.createElement("div");
                        col.className = "col-md-6 col-lg-3 mb-4";
                        col.innerHTML = `
                    <a href="${recipe.href}" class="text-decoration-none">
                        <div class="card">
                            <img src="${recipe.imgSrc}" alt="${recipe.imgAlt}" class="card-img-top" height="200" width="300"/>
                            <div class="card-body">
                                <h5 class="card-title">${recipe.title}</h5>
                                <p class="card-text">
                                    <span><i class="fas fa-star"></i> ${recipe.rating}</span>
                                    <span><i class="fas fa-user"></i></span>
                                </p>
                            </div>
                        </div>
                    </a>
                `;
                        container.appendChild(col);
                    });
                    recipesDisplayed = true;
                    this.style.display = 'none';
                }
            });
        </script>

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
    {{-- <div class="profile-popup" id="profilePopup">
        <div class="d-flex align-items-center">
            <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle"/>
            <div>
                <a href="/profil">
                    <h5>Desri Dabukke</h5>
                </a>
                <p>desristenatalie@gmail.com</p>
            </div>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="width: 100%; background-color: #f44708; color: white; border: none; border-radius: 5px; padding: 0.5rem; cursor: pointer;">
                Keluar
            </button>
        </form>
    </div> --}}

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
                popup.style.display = 'none'; // Hide popup
            }
        }
    </script>
    <script>
        function logout() {
            alert("Logout clicked!");
        }

        window.onclick = function(event) {
            const popup = document.getElementById('profilePopup');
            if (!event.target.closest('.nav-link') && !event.target.closest('#profilePopup')) {
                popup.style.display = 'none';
            }
        }
    </script>
</body>

</html>
