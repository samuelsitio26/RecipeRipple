<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <style>
        body {
            background-color: #FFF7E6;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #FFFFFF;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .btn-custom {
            background-color: #FF4500;
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 10px;
        }

        .btn-custom:hover {
            background-color: #FF6347;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2 class="text-center">Tambah Kategori</h2>
        <form action="{{ route('kategori.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="categoryName" class="form-label">Nama Kategori</label>
                <input type="text" class="form-control" id="namakategori" name="nama" placeholder="Masukkan nama kategori" required>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-custom">Simpan</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>
</body>

</html>
