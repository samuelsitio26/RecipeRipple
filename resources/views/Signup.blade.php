<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Ripple | Sign Up</title>
    <link rel="shortcut icon" type="x-icon" href="{{ url('frontend/images/Logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ url('frontend/style.css') }}">
</head>

<body>
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100 bg-image">
        <div class="signup-box p-4 shadow-lg rounded">
            <div class="text-center mb-4">
                <img src="{{ url('frontend/images/logo.png') }}" alt="Logo" class="logo mb-3">
                <h5 class="card-title">
                    LET'S GET YOU STARTED
                </h5>
                <h2 class="card-subtitle mb-2 text-muted">
                    Complete your account details
                </h2>
            </div>
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <!-- Hidden Fields for Google Login Data -->
                @if (isset($googleUser))
                    <input type="hidden" name="google_id" value="{{ $googleUser->getId() }}">
                    <input type="hidden" name="email" value="{{ $googleUser->getEmail() }}">
                    <input type="hidden" name="name" value="{{ $googleUser->getName() }}">
                @endif

                <!-- Nama -->
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control"
                        value="{{ old('name', isset($googleUser) ? $googleUser->getName() : '') }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control"
                        value="{{ old('email', isset($googleUser) ? $googleUser->getEmail() : '') }}" required>
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                        required>
                </div>

                <!-- Phone Number -->
                <div class="mb-3">
                    <label for="nomor_telepon" class="form-label">Phone Number</label>
                    <input type="text" id="nomor_telepon" name="nomor_telepon" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary w-100">Complete Registration</button>
            </form>


            <div class="text-center mt-3">
                <a href="login" class="login-link">Already have an account? <strong>Login Here</strong></a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
