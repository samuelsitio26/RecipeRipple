{{-- <!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Profile</title>
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
    .profile-edit-container {
      background-color: white;
      padding: 2rem;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      width: 80%;
      margin: 2rem auto;
      display: flex;
      flex-direction: column;
    }
    .updated-info p {
      font-size: 16px;
      margin: 10px 0;
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
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg">
    <a class="navbar-brand d-flex align-items-center" href="#">
      <img src="{{url('frontend/images/logo.png')}}" alt="Recipe Ripple" width="30" class="me-2" style="border-radius: 50%;">
      Recipe <span style="color: #F44708;">Ripple</span>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="/beranda" style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-home"></i> Beranda
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/resep" style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-book"></i> Resep
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/writeresep" style="display: flex; flex-direction: column; align-items:center;">
            <i class="fas fa-pen"></i> Tulis
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/notifikasi" style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-bell"></i> Resep Saya
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active d-flex align-items-center" style="color: #F44708" href="#" onclick="toggleProfilePopup()">
            <img src="frontend/images/profile1.jpg" alt="User Profile" class="rounded-circle me-2" width="30" height="30"/>
            Profil
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
  <!-- Edit Profile Section -->
  <div class="profile-edit-container">
    <h2>Profil Anda Telah Diperbarui</h2>
    <div class="updated-info">
      <p><strong>Nama:</strong> <span id="updatedName">Desri Dabukke</span></p>
      <p><strong>Email:</strong> <span id="updatedEmail">desristenatalie@gmail.com</span></p>
      <p><strong>No Telepon:</strong> <span id="updatedPhone">085260419037</span></p>
      <p><strong>Tentang Kamu:</strong> <span id="updatedAbout">Deskripsi Tentang Kamu dan Masakanmu</span></p>
    </div>
    <button type="button" class="btn btn-secondary" onclick="window.location.href='/editprofil'">Edit Profil Lagi</button>
  </div>
  <!-- About Us & Social Media Links -->
  <div class="about-container">
    <h2>About Us</h2>
    <p>At RecipeRipple, we believe that cooking connects people. Our platform allows food lovers to discover, share, and enjoy recipes from around the world. Whether youâ€™re a beginner or an experienced cook, we provide an easy way to explore new dishes, upload your own creations, and engage with a vibrant community.</p>
    <p>Join us in spreading the joy of cooking, one recipe at a time!</p>
    <h2>Contact</h2>
    <div class="social-icons-container">
      <a class="social-icon" href="#"><i class="fab fa-facebook"></i></a>
      <a class="social-icon" href="#"><i the "fab fa-instagram"></i></a>
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
    function fetchUpdatedInfo() {
      // Placeholder function to mimic fetching data from a server
      const userData = {
        name: 'Desri Dabukke',
        email: 'desristenatalie@gmail.com',
        phone: '085260419037',
        about: 'Saya suka memasak masakan Italia dan Jepang.'
      };
      document.getElementById('updatedName').textContent = userData.name;
      document.getElementById('updatedEmail').textContent = userData.email;
      document.getElementById('updatedPhone').textContent = userData.phone;
      document.getElementById('updatedAbout').textContent = userData.about;
    }
    window.onload = fetchUpdatedInfo;
  </script>
</body>
</html> --}}
