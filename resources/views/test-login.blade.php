<!DOCTYPE html>
<html>

<head>
    <title>Test Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 50px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 5px;
        }

        input {
            width: 300px;
            padding: 8px;
        }

        button {
            padding: 10px 20px;
            background: #007bff;
            color: white;
            border: none;
        }
    </style>
</head>

<body>
    <h2>Test Login - Admin Access</h2>

    @if ($errors->any())
        <div style="color: red; margin-bottom: 20px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('error'))
        <div style="color: red; margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('test.login.submit') }}">
        @csrf
        <div class="form-group">
            <label>Email:</label>
            <input type="email" name="email" value="admin@reciperipple.com" required>
        </div>
        <div class="form-group">
            <label>Password:</label>
            <input type="password" name="password" value="admin123" required>
        </div>
        <button type="submit">Login</button>
    </form>

    <hr style="margin: 30px 0;">

    <h3>Quick Links (After Login):</h3>
    <ul>
        <li><a href="{{ route('admin.ratings.index') }}">Admin Ratings</a></li>
        <li><a href="{{ route('admin.comments.index') }}">Admin Comments</a></li>
        <li><a href="{{ route('logout') }}">Logout</a></li>
    </ul>

    @auth
        <div style="background: #d4edda; padding: 15px; margin-top: 20px;">
            <strong>Currently logged in as:</strong> {{ Auth::user()->name }} ({{ Auth::user()->role ?? 'user' }})
        </div>
    @endauth
</body>

</html>
