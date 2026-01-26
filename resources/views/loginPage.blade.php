<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Recipe Ripple | Login</title>
  <link rel="stylesheet" href="{{url('frontend/style.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="shortcut icon" type="x-icon" href="{{url('frontend/images/Logo.png')}}">

  <!-- Google Sign-In API -->
  <script src="https://apis.google.com/js/platform.js" async defer></script>

  <!-- Custom Google Button Styles -->
  <style>
    .google-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #ffffff; /* Set background to white */
      border: 2px solid #F44708; /* Add a border with the color F44708 */
      color: rgb(0, 0, 0); /* Keep text color black */
      padding: 10px 16px;
      width: 100%;
      border-radius: 32px;
      cursor: pointer;
      font-size: 14px;
      margin-top: 20px;
      transition: background-color 0.3s, border-color 0.3s; /* Add transition for smooth hover effect */
    }

    .google-btn:hover {
      background-color: #F44708; /* Change background color on hover */
      border-color: #F44708; /* Keep border color the same on hover */
      color: #ffffff; /* Change text color to white on hover */
    }

    .google-btn img {
      margin-right: 10px;
    }

    .google-btn-text {
      display: flex;
      align-items: center;
    }

    /* Back arrow styles */
    .back-arrow {
      position: absolute;
      left: 12px;
      top: 12px;
      text-decoration: none;
      color: #F44708;
      font-size: 20px;
      width: 28px;
      height: 28px;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      box-shadow: none;
      transition: transform 160ms ease, box-shadow 160ms ease, opacity 160ms ease;
      z-index: 10;
      outline: none;
    }

    .back-arrow:hover {
      transform: translateY(-4px);
      box-shadow: 0 8px 20px rgba(244,68,8,0.18);
      opacity: 0.96;
    }

    .back-arrow:active {
      transform: translateY(1px) scale(0.98);
      box-shadow: 0 4px 12px rgba(244,68,8,0.12);
    }

  </style>

</head>
<body>
  <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 bg-image" style="position: relative;">
    <div class="login-box p-4 shadow-lg rounded" style="position: relative;">
      <!-- Back Arrow Button (inside login-box) -->
      <a href="/" class="back-arrow" aria-label="Back to home">&#8592;</a>
      <div class="text-center mb-4">
        <img src="{{url('frontend/images/Logo.png')}}" alt="Logo" width="50" class="mb-3" style="border-radius: 50%;">
        <br>
        <h3>Login to your account</h3>
      </div>

      <!-- Default Login Form -->
      <form action="{{ route('postlogin') }}" method ="post">
        {{ csrf_field() }}
        <br>
        <div class="mb-3">
          <label for="email" class="form-label">Your email</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="USER@gmail.com" required>
        </div>
        <div class="mb-3 position-relative">
          <label for="password" class="form-label">Your password</label>
          <input type="password" class="form-control" id="password" name="password" placeholder="**************" required>
          <i class="toggle-password bi bi-eye"></i>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="checkbox" id="remember" name="remember">
          <label class="form-check-label" for="remember">Remember me</label>
        </div>
        <br>
        <div class="text-center">
          <button type="submit" class="btn btn-primary w-46" style="border-radius: 32px">Log in</button>
        </div>
      </form>
      <!-- Google Login Button -->
      <div class="text-center mt-4">
        <button class="google-btn" onclick="googleSignIn()">
          <img src="{{ url('frontend/images/Google_Icons.png') }}" alt="Google logo" width="20">
          <a href="auth/redirect"><strong><span class="google-btn-text">Login with Google</span></strong></a>
        </button>
      </div>
      <div class="text-center mt-3">
        <p>Don't have an account? <a href="signup">Create account</a></p>
      </div>
    </div>
  </div>

  <!-- Google Sign-In Script -->
  <script>
    // function googleSignIn() {
    //   // You can implement your own Google Sign-In function here
    //   alert('Google Sign-In button clicked!');
    // }
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
