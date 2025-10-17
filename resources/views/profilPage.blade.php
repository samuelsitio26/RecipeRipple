<!DOCTYPE html>
<html lang="en">
<head>
  <title>Profile</title>
  <link rel="shortcut icon" type="x-icon" href="{{url('frontend/images/Logo.png')}}">
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    body {
      background-color: #fdf6e3;
      font-family: Arial, sans-serif;
      min-height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .navbar {
      background-color: #FFFFFF;
      padding: 1rem;
      width: 100%;
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
      display: none; /* Hidden by default */
      position: absolute; /* Positioning it absolutely */
      top: 60px; /* Adjust this value based on navbar height */
      right: 20px; /* Adjust to fit within the page */
      background-color: white;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      z-index: 1000; /* Ensures it appears above other elements */
      padding: 1rem;
      min-width: 120px; /* Minimum width to prevent it from being too small */
      width: auto; /* Allow the width to adjust based on content */
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

    .profile-container {
      background-color: #550527;
      color: white;
      padding: 2rem;
      border-radius: 10px;
      margin-top: 3rem;
      text-align: left;
      width: 50%;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      display: flex;
      align-items: left;
      justify-content: left;
      margin-left: auto; /* Center horizontally */
      margin-right: auto; /* Center horizontally */
    }

    .profile-container img {
      width: 150px;
      height: 150px;
      border-radius: 50%;
      margin-right: 2rem;
    }

    .profile-details {
      display: flex;
      flex-direction: column;
    }

    .profile-container h2 {
      font-weight: bold;
      margin-bottom: 0.5rem;
    }

    .profile-container p {
      font-size: 1.2rem;
      margin: 0;
    }

    .edit-profile-btn {
      background-color: #f44708;
      border: none;
      color: white;
      padding: 0.75rem 2rem;
      font-size: 1rem;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 1rem;
    }

    .edit-profile-btn:hover {
      background-color: #FF6347;
    }

    .about-container {
      background-color: #550527;
      color: white;
      padding: 1.5rem;
      font-family: 'Montserrat', sans-serif;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      width: 100%;
      margin-top: auto;
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

    .container-wrapper {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
    }

  </style>
</head>

<body>

  <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="{{url('frontend/images/logo.png')}}" alt="Recipe Ripple" width="30" class="me-2" style="border-radius: 50%;">
            Recipe <span style="color: #F44708;">Ripple</span>
        </a>

        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/beranda" style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-home"></i>
                        Beranda
                    </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="/resep" style="display: flex; flex-direction: column; align-items: center;">
                      <i class="fas fa-book"></i>
                      Resep
                  </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/writeresep" style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-pen"></i>
                        Tulis
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/notifikasi" style="display: flex; flex-direction: column; align-items: center;">
                        <i class="fas fa-bell"></i>
                        Notifikasi
                    </a>
                </li>
                <!-- Profile Link -->
                <li class="nav-item">
                    <a class="nav-link active d-flex align-items-center" style="color: #F44708" href="#" onclick="toggleProfilePopup()">
                        <img src="frontend/images/profile1.jpg" alt="User Profile" class="rounded-circle me-2" width="30" height="30"/>
                        <span>Profil</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Profile Popup -->
    <div class="profile-popup" id="profilePopup">
      <div class="d-flex align-items-center">
          <img src="{{ url('frontend/images/profile1.jpg') }}" alt="User Profile" class="rounded-circle"/>
          <div>
            <a href="/profil">
                <strong>{{ Auth::user()->name }}</strong><br>
            </a>
            <small>{{ Auth::user()->email }}</small>
          </div>
      </div>
      <form action="{{ route('logout') }}" method="POST">
          @csrf
          <button type="submit" style="width: 100%; background-color: #f44708; color: white; border: none; border-radius: 5px; padding: 0.5rem; cursor: pointer;">
              Keluar
          </button>
      </form>
    </div>

    <!-- Main Content Wrapper -->
    <div class="container-wrapper">
        <!-- Profile Container -->
        <div class="profile-container">
            <img src="frontend/images/profile1.jpg" alt="User Profile" class="profile-image">
            <div class="profile-details">
                <h2>{{ Auth::user()->name }}</h2>
                <p>{{ Auth::user()->email }}</p>
                <button class="edit-profile-btn" onclick="window.location.href='/editprofil'">Edit Profil</button>
            </div>
        </div>
    </div>

  <!-- About Us & Social Media Links -->
  <div class="about-container">
    <h2>About Us</h2>
    <p>At RecipeRipple, we believe that cooking connects people. Our platform allows food lovers to discover, share, and enjoy recipes from around the world. Whether youâ€™re a beginner or an experienced cook, we provide an easy way to explore new dishes, upload your own creations, and engage with a vibrant community.</p>
    <p>Join us in spreading the joy of cooking, one recipe at a time!</p>
    <h2>Contact</h2>
    <div class="social-icons-container">
        <a class="social-icon" href="#"><i class="fab fa-facebook"></i></a>
        <a class="social-icon" href="#"><i class="fab fa-instagram"></i></a>
        <a class="social-icon" href="#"><i class="fab fa-twitter"></i></a>
        <a class="social-icon" href="#"><i class="fas fa-phone"></i></a>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
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
