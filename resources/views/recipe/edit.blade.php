<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Recipe - Recipe Ripple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        :root {
            --primary-color: #FF4500;
            --primary-hover: #FF6347;
            --background-color: #FFF7E6;
            --text-color: #333;
            --gray-light: #E0E0E0;
            --gray-medium: #A0A0A0;
            --danger-color: #dc3545;
            --success-color: #28a745;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: var(--background-color);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: var(--text-color);
            line-height: 1.6;
        }

        .navbar {
            background-color: #FFFFFF;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .btn-custom {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 40px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            font-size: 0.9rem;
        }

        .btn-custom:hover {
            background-color: var(--primary-hover);
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .btn-custom:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            background-color: var(--background-color);
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 768px) {
            .container {
                margin: 1rem;
                padding: 1rem;
            }

            .navbar {
                flex-direction: column;
                gap: 1rem;
            }

            .btn-custom {
                padding: 0.4rem 1.5rem;
                font-size: 0.8rem;
            }
        }

        .video-placeholder {
            background-color: var(--gray-light);
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-bottom: 1rem;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .video-placeholder:hover {
            background-color: #d0d0d0;
        }

        .video-placeholder i {
            font-size: 3rem;
            color: var(--gray-medium);
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .video-preview {
            width: 100%;
            height: 100%;
            border-radius: 10px;
            cursor: pointer;
        }

        .video-preview:hover {
            opacity: 0.8;
        }

        iframe {
            cursor: pointer;
        }

        iframe:hover {
            opacity: 0.8;
        }

        input[type="file"] {
            display: none;
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 10px;
            border: 2px solid #ddd;
            transition: border-color 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(255, 69, 0, 0.25);
        }

        .section-title {
            font-weight: bold;
            margin-top: 2rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
            font-size: 1.2rem;
        }

        .add-button {
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary-color);
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
            padding: 0.8rem;
            border: 2px dashed var(--primary-color);
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .add-button:hover {
            background-color: rgba(255, 69, 0, 0.1);
            transform: translateY(-1px);
        }

        .add-button i {
            margin-right: 0.5rem;
        }

        textarea {
            overflow: hidden;
            resize: vertical;
            min-height: 80px;
        }

        .remove-button {
            color: var(--danger-color);
            cursor: pointer;
            font-weight: bold;
            margin-left: 1rem;
            padding: 0.3rem 0.6rem;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
        }

        .remove-button:hover {
            background-color: var(--danger-color);
            color: white;
        }

        .step-image-placeholder {
            background-color: var(--gray-light);
            height: 150px;
            width: 100%;
            max-width: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-top: 1rem;
            cursor: pointer;
            position: relative;
            transition: background-color 0.3s ease;
        }

        .step-image-placeholder:hover {
            background-color: #d0d0d0;
        }

        .step-image-placeholder i {
            font-size: 2rem;
            color: var(--gray-medium);
        }

        .step-image {
            max-width: 200px;
            max-height: 150px;
            margin-top: 1rem;
            border-radius: 10px;
            object-fit: cover;
        }

        .form-group {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .form-group .btn-custom {
            margin-bottom: 0.5rem;
        }

        .form-group img {
            display: block;
            max-width: 300px;
            max-height: 200px;
            margin-top: 10px;
            border-radius: 10px;
            object-fit: cover;
            border: 2px solid #ddd;
        }

        .loading-spinner {
            display: none;
            text-align: center;
            margin: 1rem 0;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.85rem;
            margin-top: 0.25rem;
            display: none;
        }

        .success-message {
            color: var(--success-color);
            font-size: 0.85rem;
            margin-top: 0.25rem;
        }

        .bahan-item,
        .langkah-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.5rem;
            flex-wrap: wrap;
        }

        .bahan-item input,
        .langkah-item input {
            flex: 1;
            min-width: 200px;
        }

        .image-controls {
            display: flex;
            gap: 0.5rem;
            margin-top: 0.5rem;
        }

        .image-controls button {
            padding: 0.3rem 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: all 0.3s ease;
        }

        .existing-image-container {
            padding: 1rem;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            background-color: #f8f9fa;
            margin-top: 1rem;
        }

        .existing-image-container img {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .replace-button {
            background-color: #007bff;
            color: white;
        }

        .replace-button:hover {
            background-color: #0056b3;
        }

        .remove-image-button {
            background-color: var(--danger-color);
            color: white;
        }

        .remove-image-button:hover {
            background-color: #c82333;
        }

        /* Accessibility improvements */
        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        /* Focus indicators */
        button:focus,
        .add-button:focus,
        .remove-button:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }
    </style>
    <script>
        // Suppress YouTube iframe warnings
        const originalConsoleWarn = console.warn;
        console.warn = function(...args) {
            if (args[0] && typeof args[0] === 'string' &&
                (args[0].includes('Violation') || args[0].includes('passive'))) {
                return;
            }
            originalConsoleWarn.apply(console, args);
        };
    </script>
</head>

<body>
    <div>
        <form action="{{ route('recipe.update', $data['recipe']['id']) }}" method="POST" enctype="multipart/form-data"
            id="recipeForm">
            @csrf
            @method('PUT')

            <nav class="navbar">
                <a class="navbar-brand" href="{{ route('recipe.index') }}">
                    <img src="{{ url('frontend/images/logo.png') }}" alt="Recipe Ripple Logo" width="30"
                        class="me-2" style="border-radius: 50%;">
                    Recipe <span style="color: orange;">Ripple</span>
                </a>
                <div class="text-end">
                    <button type="submit" class="btn btn-custom" id="submitBtn">
                        <i class="fas fa-save me-1"></i>Perbarui
                    </button>
                    <a href="{{ route('recipe.index') }}" class="btn btn-custom">
                        <i class="fas fa-times me-1"></i>Batal
                    </a>
                </div>
            </nav>

            <div class="container">
                <div class="loading-spinner" id="loadingSpinner">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    <p>Mengupload file...</p>
                </div>

                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-exclamation-triangle me-1"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="video-placeholder" id="videoIconLabel" role="button" tabindex="0"
                    aria-label="Upload video">
                    @if (!empty($data['recipe']['video_url']) && $data['recipe']['video_type'] === 'youtube')
                        @php
                            $videoId = null;
                            if (
                                preg_match(
                                    '/(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/',
                                    $data['recipe']['video_url'],
                                    $matches,
                                )
                            ) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if ($videoId)
                            <iframe width="100%" height="100%"
                                src="https://www.youtube-nocookie.com/embed/{{ $videoId }}?rel=0&modestbranding=1&playsinline=1"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen referrerpolicy="strict-origin-when-cross-origin"
                                style="border-radius: 10px;">
                            </iframe>
                        @else
                            <i class="fas fa-play-circle" aria-hidden="true"></i>
                            <span class="sr-only">Klik untuk upload video</span>
                        @endif
                    @elseif (!empty($data['recipe']['video_path']) && $data['recipe']['video_type'] === 'file')
                        <video class="video-preview" controls>
                            <source src="{{ asset('uploads/recipe/video/' . $data['recipe']['video_path']) }}"
                                type="video/mp4">
                            <p>Browser Anda tidak mendukung pemutar video.</p>
                        </video>
                    @else
                        <i class="fas fa-play-circle" aria-hidden="true"></i>
                        <span class="sr-only">Klik untuk upload video</span>
                    @endif
                </div>
                <input type="file" id="videoInput" name="video" accept="video/*" aria-label="Upload video file">
                <input type="hidden" name="check_video" id="check_video" value="">

                @if (!empty($data['recipe']['video_url']) || !empty($data['recipe']['video_path']))
                    <button type="button" id="removeVideoBtn" class="btn btn-danger btn-sm mt-2">
                        <i class="fas fa-trash me-1"></i>Hapus Video
                    </button>

                    @if (!empty($data['recipe']['video_url']))
                        <input type="hidden" id="youtube_url_input" name="video_url"
                            value="{{ $data['recipe']['video_url'] }}">
                    @endif
                    <input type="hidden" id="video_type_input" name="video_type"
                        value="{{ $data['recipe']['video_type'] ?? 'file' }}">
                @endif

                <div class="error-message" id="videoError"></div>

                <div class="form-group">
                    <label for="name">Judul Resep *</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Masukkan judul resep..." value="{{ old('name', $data['recipe']['name']) }}"
                        required aria-describedby="nameError">
                    <div class="error-message" id="nameError"></div>
                </div>

                <div class="form-group">
                    <label for="description">Deskripsi *</label>
                    <textarea class="form-control" id="description" name="description" rows="4"
                        placeholder="Ceritakan tentang resep Anda..." required aria-describedby="descriptionError">{{ old('description', $data['recipe']['description']) }}</textarea>
                    <div class="error-message" id="descriptionError"></div>
                </div>

                <div class="form-group">
                    <label for="kategori_id">Kategori *</label>
                    <select class="form-control" id="kategori_id" name="kategori_id" required
                        aria-describedby="kategoriError">
                        <option value="">Pilih kategori...</option>
                        @foreach ($data['kategori'] as $kategori)
                            <option value="{{ $kategori['id'] }}"
                                {{ old('kategori_id', $data['recipe']['kategori_id']) == $kategori['id'] ? 'selected' : '' }}>
                                {{ $kategori['nama'] }}
                            </option>
                        @endforeach
                    </select>
                    <div class="error-message" id="kategoriError"></div>
                </div>

                <div class="form-group">
                    <label for="gambar">Gambar Resep <small class="text-muted">(Opsional - jika kosong, akan
                            menggunakan cover dari video)</small></label>
                    <button type="button" class="btn btn-custom"
                        onclick="document.getElementById('gambar').click()">
                        <i class="fas fa-camera me-1"></i>Pilih Gambar
                    </button>
                    <input type="file" id="gambar" name="gambar" accept="image/*"
                        aria-describedby="gambarError">
                    @if (!empty($data['recipe']['gambar']))
                        <div class="existing-image-container">
                            <img id="imagePreview"
                                src="{{ asset('uploads/recipe/gambar/' . $data['recipe']['gambar']) }}"
                                alt="Preview gambar resep"
                                style="max-width: 300px; max-height: 200px; object-fit: cover; border: 2px solid #ddd; border-radius: 10px;">
                            <div class="image-controls mt-2">
                                <button type="button" class="btn btn-sm btn-primary"
                                    onclick="document.getElementById('gambar').click()">
                                    <i class="fas fa-sync-alt me-1"></i>Ganti Gambar
                                </button>
                                <button type="button" class="btn btn-sm btn-danger" onclick="removeCurrentImage()">
                                    <i class="fas fa-trash me-1"></i>Hapus Gambar
                                </button>
                            </div>
                            <p class="text-muted mt-2 mb-0" style="font-size: 0.85rem;">
                                <i class="fas fa-info-circle me-1"></i>Gambar saat ini:
                                {{ $data['recipe']['gambar'] }}
                            </p>
                        </div>
                    @else
                        <img id="imagePreview"
                            style="display: none; max-width: 300px; max-height: 200px; object-fit: cover;"
                            alt="Preview gambar resep">
                        <div id="imageControls" class="image-controls mt-2" style="display: none;">
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="document.getElementById('gambar').click()">
                                <i class="fas fa-sync-alt me-1"></i>Ganti Gambar
                            </button>
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeCurrentImage()">
                                <i class="fas fa-trash me-1"></i>Hapus Gambar
                            </button>
                        </div>
                    @endif
                    <div class="error-message" id="gambarError"></div>
                </div>

                <h3 class="section-title">Bahan-bahan</h3>
                <div id="bahan-container">
                    @php
                        $bahan = is_array($data['recipe']['bahan'])
                            ? $data['recipe']['bahan']
                            : explode(',', $data['recipe']['bahan']);
                    @endphp
                    @foreach ($bahan as $index => $item)
                        <div class="bahan-item">
                            <input type="text" class="form-control" name="bahan[]" value="{{ trim($item) }}"
                                placeholder="Masukkan bahan..." aria-label="Bahan {{ $index + 1 }}">
                            <button type="button" class="remove-button" onclick="removeBahan(this)"
                                aria-label="Hapus bahan">Hapus</button>
                        </div>
                    @endforeach
                </div>
                <div class="add-button" id="add-bahan" role="button" tabindex="0"
                    aria-label="Tambah bahan baru">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah Bahan
                </div>

                <h3 class="section-title">Langkah-langkah</h3>
                <div id="langkah-container">
                    @php
                        $langkah = is_array($data['recipe']['langkah'])
                            ? $data['recipe']['langkah']
                            : explode(',', $data['recipe']['langkah']);
                        $langkah_images = is_array($data['recipe']['langkah_image'])
                            ? $data['recipe']['langkah_image']
                            : [];
                    @endphp
                    @foreach ($langkah as $index => $step)
                        <div class="langkah-item" data-step="{{ $index + 1 }}">
                            <div style="flex: 1;">
                                <input type="text" class="form-control" name="langkah[]"
                                    value="{{ trim($step) }}" placeholder="Masukkan langkah..."
                                    aria-label="Langkah {{ $index + 1 }}">

                                @if (!empty($langkah_images[$index]))
                                    <img src="{{ asset('uploads/recipe/image/' . $langkah_images[$index]) }}"
                                        class="step-image" alt="Gambar langkah {{ $index + 1 }}">
                                @else
                                    <div class="step-image-placeholder"
                                        onclick="document.getElementById('stepImage{{ $index + 1 }}').click()"
                                        role="button" tabindex="0"
                                        aria-label="Upload gambar untuk langkah {{ $index + 1 }}">
                                        <i class="fas fa-camera" aria-hidden="true"></i>
                                    </div>
                                @endif

                                <input type="file" id="stepImage{{ $index + 1 }}" name="langkah_image[]"
                                    accept="image/*" aria-label="Upload gambar langkah {{ $index + 1 }}">
                            </div>
                            <button type="button" class="remove-button" onclick="removeLangkah(this)"
                                aria-label="Hapus langkah">Hapus</button>
                        </div>
                    @endforeach
                </div>
                <div class="add-button" id="add-langkah" role="button" tabindex="0"
                    aria-label="Tambah langkah baru">
                    <i class="fas fa-plus-circle" aria-hidden="true"></i> Tambah Langkah
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Global variables
        let langkahCount = {{ count($langkah) }};
        let isUploading = false;

        // Utility functions
        function showError(elementId, message) {
            const errorElement = document.getElementById(elementId);
            if (errorElement) {
                errorElement.textContent = message;
                errorElement.style.display = 'block';
            }
        }

        function hideError(elementId) {
            const errorElement = document.getElementById(elementId);
            if (errorElement) {
                errorElement.style.display = 'none';
            }
        }

        function validateFile(file, maxSize = 5 * 1024 * 1024, allowedTypes = ['image/jpeg', 'image/png', 'image/jpg',
            'image/gif'
        ]) {
            if (file.size > maxSize) {
                return `File terlalu besar. Maksimal ${maxSize / (1024 * 1024)}MB`;
            }
            if (!allowedTypes.includes(file.type)) {
                return 'Tipe file tidak didukung';
            }
            return null;
        }

        function showLoading() {
            document.getElementById('loadingSpinner').style.display = 'block';
            document.getElementById('submitBtn').disabled = true;
            isUploading = true;
        }

        function hideLoading() {
            document.getElementById('loadingSpinner').style.display = 'none';
            document.getElementById('submitBtn').disabled = false;
            isUploading = false;
        }

        // Image preview function
        function previewImage(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const imageControls = document.getElementById('imageControls');

            if (file) {
                const error = validateFile(file);
                if (error) {
                    showError(input.id + 'Error', error);
                    input.value = '';
                    return;
                }

                hideError(input.id + 'Error');

                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                    if (imageControls) {
                        imageControls.style.display = 'block';
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Remove current image function
        function removeCurrentImage() {
            if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                const preview = document.getElementById('imagePreview');
                const imageInput = document.getElementById('gambar');
                const imageControls = document.getElementById('imageControls');
                const existingImageContainer = document.querySelector('.existing-image-container');

                // Hide existing image container
                if (existingImageContainer) {
                    existingImageContainer.style.display = 'none';
                }

                // Clear preview and input
                preview.src = '';
                preview.style.display = 'none';
                imageInput.value = '';

                if (imageControls) {
                    imageControls.style.display = 'none';
                }

                // Add hidden input to indicate image removal
                let removeImageInput = document.getElementById('remove_image_input');
                if (!removeImageInput) {
                    removeImageInput = document.createElement('input');
                    removeImageInput.type = 'hidden';
                    removeImageInput.id = 'remove_image_input';
                    removeImageInput.name = 'remove_image';
                    removeImageInput.value = '1';
                    imageInput.parentNode.appendChild(removeImageInput);
                } else {
                    removeImageInput.value = '1';
                }

                // Show empty state message
                const emptyMessage = document.createElement('div');
                emptyMessage.id = 'image_removed_message';
                emptyMessage.className = 'alert alert-info mt-2';
                emptyMessage.innerHTML =
                    '<i class="fas fa-info-circle me-1"></i>Gambar akan dihapus saat menyimpan. Pilih gambar baru jika diperlukan.';
                imageInput.parentNode.appendChild(emptyMessage);
            }
        }

        // Main image handler
        document.getElementById('gambar').addEventListener('change', function() {
            previewImage(this, 'imagePreview');

            // Hide existing image container if new image is selected
            const existingImageContainer = document.querySelector('.existing-image-container');
            if (existingImageContainer && this.files[0]) {
                existingImageContainer.style.display = 'none';
            }

            // Remove "image removed" message if exists
            const removedMessage = document.getElementById('image_removed_message');
            if (removedMessage) {
                removedMessage.remove();
            }

            // Remove hidden remove_image input if exists
            const removeImageInput = document.getElementById('remove_image_input');
            if (removeImageInput) {
                removeImageInput.remove();
            }
        });

        // Bahan (ingredients) functions
        function removeBahan(button) {
            if (confirm('Apakah Anda yakin ingin menghapus bahan ini?')) {
                button.parentElement.remove();
            }
        }

        document.getElementById('add-bahan').addEventListener('click', function() {
            const container = document.getElementById('bahan-container');
            const newBahanDiv = document.createElement('div');
            newBahanDiv.className = 'bahan-item';
            newBahanDiv.innerHTML = `
                <input type="text" class="form-control" name="bahan[]"
                       placeholder="Masukkan bahan..." aria-label="Bahan baru">
                <button type="button" class="remove-button" onclick="removeBahan(this)"
                        aria-label="Hapus bahan">Hapus</button>
            `;
            container.appendChild(newBahanDiv);
            newBahanDiv.querySelector('input').focus();
        });

        // Langkah (steps) functions
        function removeLangkah(button) {
            if (confirm('Apakah Anda yakin ingin menghapus langkah ini?')) {
                button.parentElement.remove();
                updateStepNumbers();
            }
        }

        function updateStepNumbers() {
            const langkahItems = document.querySelectorAll('.langkah-item');
            langkahItems.forEach((item, index) => {
                item.setAttribute('data-step', index + 1);
                const input = item.querySelector('input[name="langkah[]"]');
                if (input) {
                    input.setAttribute('aria-label', `Langkah ${index + 1}`);
                }
            });
        }

        document.getElementById('add-langkah').addEventListener('click', function() {
            langkahCount++;
            const container = document.getElementById('langkah-container');
            const newLangkahDiv = document.createElement('div');
            newLangkahDiv.className = 'langkah-item';
            newLangkahDiv.setAttribute('data-step', langkahCount);

            newLangkahDiv.innerHTML = `
                <div style="flex: 1;">
                    <input type="text" class="form-control" name="langkah[]"
                           placeholder="Masukkan langkah..." aria-label="Langkah ${langkahCount}">
                    <div class="step-image-placeholder" role="button" tabindex="0"
                         aria-label="Upload gambar untuk langkah ${langkahCount}">
                        <i class="fas fa-camera" aria-hidden="true"></i>
                    </div>
                    <input type="file" id="stepImage${langkahCount}" name="langkah_image[]"
                           accept="image/*" aria-label="Upload gambar langkah ${langkahCount}">
                    <img id="stepPreview${langkahCount}" class="step-image" style="display: none;"
                         alt="Preview gambar langkah ${langkahCount}">
                    <div class="image-controls" id="imageControls${langkahCount}" style="display: none;">
                        <button type="button" class="replace-button">
                            <i class="fas fa-sync-alt me-1"></i>Ganti
                        </button>
                        <button type="button" class="remove-image-button">
                            <i class="fas fa-trash me-1"></i>Hapus
                        </button>
                    </div>
                </div>
                <button type="button" class="remove-button" onclick="removeLangkah(this)"
                        aria-label="Hapus langkah">Hapus</button>
            `;

            container.appendChild(newLangkahDiv);

            // Add event listeners for new elements
            const placeholder = newLangkahDiv.querySelector('.step-image-placeholder');
            const fileInput = newLangkahDiv.querySelector(`#stepImage${langkahCount}`);
            const preview = newLangkahDiv.querySelector(`#stepPreview${langkahCount}`);
            const controls = newLangkahDiv.querySelector(`#imageControls${langkahCount}`);

            placeholder.addEventListener('click', () => fileInput.click());
            placeholder.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    fileInput.click();
                }
            });

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const error = validateFile(file);
                    if (error) {
                        alert(error);
                        this.value = '';
                        return;
                    }

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.src = e.target.result;
                        preview.style.display = 'block';
                        placeholder.style.display = 'none';
                        controls.style.display = 'flex';
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Replace button
            controls.querySelector('.replace-button').addEventListener('click', () => {
                fileInput.click();
            });

            // Remove image button
            controls.querySelector('.remove-image-button').addEventListener('click', () => {
                if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                    preview.src = '';
                    preview.style.display = 'none';
                    placeholder.style.display = 'flex';
                    controls.style.display = 'none';
                    fileInput.value = '';
                }
            });

            newLangkahDiv.querySelector('input[name="langkah[]"]').focus();
        });

        // Video upload and preview functionality
        const videoInput = document.getElementById('videoInput');
        const videoIconLabel = document.getElementById('videoIconLabel');
        let select = null;
        let currentVideoType = '{{ $data['recipe']['video_type'] ?? 'file' }}';
        let hasExistingVideo =
            {{ !empty($data['recipe']['video_url']) || !empty($data['recipe']['video_path']) ? 'true' : 'false' }};

        // Initialize remove video button if exists
        document.addEventListener('DOMContentLoaded', function() {
            const removeBtn = document.getElementById('removeVideoBtn');
            if (removeBtn) {
                removeBtn.addEventListener('click', removeVideo);
            }

            // If there's existing video, add click event to show replacement options
            if (hasExistingVideo) {
                const existingVideo = videoIconLabel.querySelector('video') || videoIconLabel.querySelector(
                    'iframe');
                if (existingVideo) {
                    existingVideo.addEventListener('click', function(e) {
                        e.stopPropagation();
                        if (confirm('Apakah Anda ingin mengganti video ini?')) {
                            hasExistingVideo = false;
                            videoIconLabel.click();
                        }
                    });
                }
            }
        });

        videoIconLabel.addEventListener('click', () => {
            if (!hasExistingVideo && !select && !videoIconLabel.querySelector('video') && !videoIconLabel
                .querySelector('iframe')) {
                select = document.createElement('select');
                select.className = 'form-select mt-2';
                select.style.position = 'absolute';
                select.style.top = '50%';
                select.style.left = '50%';
                select.style.transform = 'translate(-50%, -50%)';
                select.style.width = '80%';
                select.style.maxWidth = '300px';
                select.style.zIndex = '10';
                select.innerHTML = `
                    <option value="">Pilih sumber video</option>
                    <option value="file">Upload File (MP4)</option>
                    <option value="youtube">Link YouTube</option>
                `;

                videoIconLabel.appendChild(select);

                select.addEventListener('change', (event) => {
                    const videoType = event.target.value;

                    if (videoType === 'file') {
                        videoInput.click();
                        document.getElementById('check_video').value = '';
                        currentVideoType = 'file';
                    } else if (videoType === 'youtube') {
                        const youtubeUrl = prompt(
                            "Masukkan link YouTube:\n(Format: https://www.youtube.com/watch?v=... atau https://youtu.be/...)"
                        );
                        if (youtubeUrl) {
                            if (validateAndEmbedYouTube(youtubeUrl)) {
                                currentVideoType = 'youtube';
                                document.getElementById('check_video').value = '';
                            }
                        }
                    }
                    removeSelect();
                });

                document.addEventListener('click', (event) => {
                    if (!videoIconLabel.contains(event.target) && select) {
                        removeSelect();
                    }
                });
            }
        });

        function removeSelect() {
            if (select && select.parentNode) {
                videoIconLabel.removeChild(select);
                select = null;
            }
        }

        function validateAndEmbedYouTube(url) {
            const videoId = extractYouTubeId(url);
            if (videoId) {
                embedYouTubeVideo(videoId, url);
                return true;
            } else {
                alert(
                    "Link YouTube tidak valid. Gunakan format:\n- https://www.youtube.com/watch?v=VIDEO_ID\n- https://youtu.be/VIDEO_ID"
                );
                return false;
            }
        }

        function extractYouTubeId(url) {
            const patterns = [
                /(?:youtube\.com\/watch\?v=|youtu\.be\/|youtube\.com\/embed\/)([^&\n?#]+)/,
                /^([a-zA-Z0-9_-]{11})$/
            ];

            for (const pattern of patterns) {
                const match = url.match(pattern);
                if (match && match[1]) {
                    return match[1];
                }
            }
            return null;
        }

        function embedYouTubeVideo(videoId, originalUrl) {
            videoIconLabel.innerHTML = `
                <iframe
                    width="100%"
                    height="100%"
                    src="https://www.youtube-nocookie.com/embed/${videoId}?rel=0&modestbranding=1&playsinline=1"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    allowfullscreen
                    referrerpolicy="strict-origin-when-cross-origin"
                    style="border-radius: 10px;">
                </iframe>
            `;

            // Create hidden input untuk menyimpan URL YouTube
            let youtubeUrlInput = document.getElementById('youtube_url_input');
            if (!youtubeUrlInput) {
                youtubeUrlInput = document.createElement('input');
                youtubeUrlInput.type = 'hidden';
                youtubeUrlInput.id = 'youtube_url_input';
                youtubeUrlInput.name = 'video_url';
                videoIconLabel.parentNode.appendChild(youtubeUrlInput);
            }
            youtubeUrlInput.value = originalUrl;

            // Create hidden input untuk video type
            let videoTypeInput = document.getElementById('video_type_input');
            if (!videoTypeInput) {
                videoTypeInput = document.createElement('input');
                videoTypeInput.type = 'hidden';
                videoTypeInput.id = 'video_type_input';
                videoTypeInput.name = 'video_type';
                videoIconLabel.parentNode.appendChild(videoTypeInput);
            }
            videoTypeInput.value = 'youtube';

            showRemoveButton();
        }

        videoInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                // Validate video file
                const maxSize = 50 * 1024 * 1024; // 50MB
                const allowedTypes = ['video/mp4', 'video/mov', 'video/avi', 'video/webm'];

                if (file.size > maxSize) {
                    alert('File video terlalu besar. Maksimal 50MB');
                    this.value = '';
                    return;
                }

                if (!allowedTypes.includes(file.type)) {
                    alert('Format video tidak didukung. Gunakan: MP4, MOV, AVI, atau WEBM');
                    this.value = '';
                    return;
                }

                const videoUrl = URL.createObjectURL(file);
                videoIconLabel.innerHTML = `
                    <video width="100%" height="100%" controls style="border-radius: 10px;">
                        <source src="${videoUrl}" type="${file.type}">
                        Browser Anda tidak mendukung pemutar video.
                    </video>
                `;

                // Set video type
                let videoTypeInput = document.getElementById('video_type_input');
                if (!videoTypeInput) {
                    videoTypeInput = document.createElement('input');
                    videoTypeInput.type = 'hidden';
                    videoTypeInput.id = 'video_type_input';
                    videoTypeInput.name = 'video_type';
                    videoIconLabel.parentNode.appendChild(videoTypeInput);
                }
                videoTypeInput.value = 'file';

                // Remove YouTube URL if exists
                const youtubeUrlInput = document.getElementById('youtube_url_input');
                if (youtubeUrlInput) {
                    youtubeUrlInput.remove();
                }

                showRemoveButton();
            }
        });

        function showRemoveButton() {
            let removeBtn = document.getElementById('removeVideoBtn');
            if (!removeBtn) {
                removeBtn = document.createElement('button');
                removeBtn.id = 'removeVideoBtn';
                removeBtn.type = 'button';
                removeBtn.className = 'btn btn-danger btn-sm mt-2';
                removeBtn.innerHTML = '<i class="fas fa-trash me-1"></i>Hapus Video';
                removeBtn.onclick = removeVideo;
                videoIconLabel.parentNode.insertBefore(removeBtn, videoIconLabel.nextSibling);
            }
            removeBtn.style.display = 'block';
        }

        function removeVideo() {
            if (confirm('Apakah Anda yakin ingin menghapus video?')) {
                videoIconLabel.innerHTML =
                    '<i class="fas fa-play-circle" aria-hidden="true"></i><span class="sr-only">Klik untuk upload video</span>';
                videoInput.value = '';
                document.getElementById('check_video').value = 'remove';

                // Remove hidden inputs
                const youtubeUrlInput = document.getElementById('youtube_url_input');
                const videoTypeInput = document.getElementById('video_type_input');
                if (youtubeUrlInput) youtubeUrlInput.remove();
                if (videoTypeInput) videoTypeInput.remove();

                const removeBtn = document.getElementById('removeVideoBtn');
                if (removeBtn) {
                    removeBtn.style.display = 'none';
                    removeBtn.remove();
                }

                hasExistingVideo = false;
            }
        }

        // Form validation and submission
        document.getElementById('recipeForm').addEventListener('submit', function(e) {
            if (isUploading) {
                e.preventDefault();
                return;
            }

            let isValid = true;

            // Validate required fields
            const name = document.getElementById('name').value.trim();
            if (!name) {
                showError('nameError', 'Judul resep harus diisi');
                isValid = false;
            } else {
                hideError('nameError');
            }

            const description = document.getElementById('description').value.trim();
            if (!description) {
                showError('descriptionError', 'Deskripsi harus diisi');
                isValid = false;
            } else {
                hideError('descriptionError');
            }

            const kategori = document.getElementById('kategori_id').value;
            if (!kategori) {
                showError('kategoriError', 'Kategori harus dipilih');
                isValid = false;
            } else {
                hideError('kategoriError');
            }

            // Gambar is now optional - no validation needed

            // Validate bahan
            const bahanInputs = document.querySelectorAll('input[name="bahan[]"]');
            let validBahan = false;
            bahanInputs.forEach(input => {
                if (input.value.trim()) {
                    validBahan = true;
                }
            });

            if (!validBahan) {
                alert('Minimal satu bahan harus diisi');
                isValid = false;
            }

            // Validate langkah
            const langkahInputs = document.querySelectorAll('input[name="langkah[]"]');
            let validLangkah = false;
            langkahInputs.forEach(input => {
                if (input.value.trim()) {
                    validLangkah = true;
                }
            });

            if (!validLangkah) {
                alert('Minimal satu langkah harus diisi');
                isValid = false;
            }

            if (!isValid) {
                e.preventDefault();
                return;
            }

            showLoading();
        });

        // Initialize existing step image handlers
        document.querySelectorAll('.step-image-placeholder').forEach((placeholder, index) => {
            const fileInput = document.querySelector(`#stepImage${index + 1}`);
            if (fileInput) {
                placeholder.addEventListener('click', () => fileInput.click());
                placeholder.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        fileInput.click();
                    }
                });

                fileInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const error = validateFile(file);
                        if (error) {
                            alert(error);
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            // Create new image element
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'step-image';
                            img.alt = `Preview gambar langkah ${index + 1}`;

                            // Replace placeholder with image
                            placeholder.parentNode.insertBefore(img, placeholder);
                            placeholder.style.display = 'none';

                            // Add controls
                            const controls = document.createElement('div');
                            controls.className = 'image-controls';
                            controls.innerHTML = `
                                <button type="button" class="replace-button">
                                    <i class="fas fa-sync-alt me-1"></i>Ganti
                                </button>
                                <button type="button" class="remove-image-button">
                                    <i class="fas fa-trash me-1"></i>Hapus
                                </button>
                            `;

                            img.parentNode.insertBefore(controls, img.nextSibling);

                            // Add event listeners
                            controls.querySelector('.replace-button').addEventListener('click', () => {
                                fileInput.click();
                            });

                            controls.querySelector('.remove-image-button').addEventListener('click',
                                () => {
                                    if (confirm('Apakah Anda yakin ingin menghapus gambar ini?')) {
                                        img.remove();
                                        controls.remove();
                                        placeholder.style.display = 'flex';
                                        fileInput.value = '';
                                    }
                                });
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }
        });

        // Keyboard navigation for add buttons
        document.getElementById('add-bahan').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        document.getElementById('add-langkah').addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        videoIconLabel.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                this.click();
            }
        });

        // Auto-hide alerts after 5 seconds
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                if (alert.classList.contains('show')) {
                    alert.classList.remove('show');
                    setTimeout(() => alert.remove(), 300);
                }
            });
        }, 5000);

        // Prevent form submission on Enter key in text inputs (except textarea)
        document.querySelectorAll('input[type="text"]').forEach(input => {
            input.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                }
            });
        });
    </script>
</body>

</html>
