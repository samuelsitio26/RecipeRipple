<html>

<head>
    <title>Recipe Ripple</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #FFF7E6;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: #FFFFFF;
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar-brand {
            font-weight: bold;
        }

        .btn-custom {
            background-color: #FF4500;
            color: white;
            border: none;
            padding: 0.5rem 2rem;
            border-radius: 40px;
        }

        .btn-custom:hover {
            background-color: #FF6347;
        }

        .container {
            max-width: 600px;
            margin: 2rem auto;
            background-color: #FFF7E6;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .video-placeholder {
            background-color: #E0E0E0;
            height: 200px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-bottom: 1rem;
            cursor: pointer;
            position: relative;
        }

        .video-placeholder i {
            font-size: 3rem;
            color: #A0A0A0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        #videoPreview {
            display: none;
            width: 100%;
            /* margin-top: 1rem; */
        }

        input[type="file"] {
            display: none;
        }

        .form-control {
            margin-bottom: 1rem;
            border-radius: 10px;
        }

        .section-title {
            font-weight: bold;
            margin-top: 1rem;
            margin-bottom: 0.5rem;
        }

        .add-button {
            display: flex;
            justify-content: center;
            align-items: center;
            color: #FF4500;
            font-weight: bold;
            cursor: pointer;
            margin-top: 1rem;
        }

        .add-button i {
            margin-right: 0.5rem;
        }

        textarea {
            overflow: hidden;
            resize: none;
        }

        .remove-button {
            color: red;
            cursor: pointer;
            font-weight: bold;
            margin-left: 1rem;
        }

        .step-image-placeholder {
            background-color: #E0E0E0;
            height: 150px;
            width: 30%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-top: 1rem;
            cursor: pointer;
            position: relative;
        }

        .step-image-placeholder i {
            font-size: 2rem;
            color: #A0A0A0;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .bton-custom {
            display: inline-block;
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
            background-color: #f8f9fa;
            /* Warna putih keperakan */
            color: #333;
            border: 1px solid #ccc;
            border-radius: 5px;
            text-align: center;
        }

        .bton-custom:hover {
            background-color: #e2e6ea;
            /* Warna saat di-hover */
        }

        .form-group {
            position: relative;
        }

        .form-group input[type="file"] {
            display: none;
        }

        .form-group label[for="gambar"] {
            background-color: #FF4500;
            color: white;
            padding: 0.5rem 2rem;
            border-radius: 40px;
            cursor: pointer;
            display: inline-block;
        }

        .form-group img {
            display: block;
            width: 50%;
            max-height: 150px;
            margin-top: 10px;
            border-radius: 10px;
        }

        .step-image {
            display: none;
            max-width: 50%;
            margin-top: 1rem;
        }

        .step-image-placeholder {
            background-color: #E0E0E0;
            height: 150px;
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            margin-top: 1rem;
            cursor: pointer;
            position: relative;
        }
    </style>
</head>

<body>
    <div>
        <form action="{{ route('recipe.store') }}" method="POST" id="recipe-form" enctype="multipart/form-data">
            @csrf
            <nav class="navbar">
                <a class="navbar-brand" href="#">
                    <img src="{{ url('frontend/images/logo.png') }}" alt="Recipe Ripple" width="30" class="me-2"
                        style="border-radius: 50%;">
                    Recipe <span style="color: orange;">Ripple</span>
                </a>
                <div class="text-end">
                    <button type="submit" class="btn btn-custom">Unggah</button>
                    <a href="/writeresep" class="btn btn-custom" style="text-decoration: none;">Batal</a>
                </div>
            </nav>
            <div class="container">
                @if (session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>Berhasil!</strong> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session()->has('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Error!</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Validasi Gagal!</strong> Mohon perbaiki error berikut:
                        <ul class="mb-0 mt-2">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="video-placeholder" id="videoIconLabel">
                    <i class="fas fa-play-circle"></i>
                </div>
                <input type="file" id="videoInput" name="video" accept="video/*">
                <video id="videoPreview" controls></video>

                <input type="text" class="form-control" id="name" name="name"
                    placeholder="Judul : Nasi Goreng Telur Mata Sapi" required>
                <textarea class="form-control" id="description" name="description" rows="3"
                    placeholder="Cerita di balik masakan anda. Bagaimana hal tersebut menginspirasimu? Deskripsikanlah masakan Anda"
                    required></textarea>

                <div class="form-group">
                    <label for="kategori_id">Kategori:</label>
                    <select class="form-control" id="kategori_id" name="kategori_id" required>
                        @foreach ($kategori as $kategoriItem)
                            <option value="{{ $kategoriItem->id }}">{{ $kategoriItem->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="gambar" class="btn bton-custom">Choose File (Optional)</label>
                    <input type="file" class="form-control-file" id="gambar" name="gambar" accept="image/*">
                    <img id="imagePreview" style="display: none;">
                </div>

                <p class="section-title">Bahan-bahan</p>
                <div id="bahan-container">
                    <div class="bahan-item">
                        <input type="text" class="form-control" name="bahan[]" placeholder="1 Piring Nasi">
                    </div>
                    <div class="bahan-item">
                        <input type="text" class="form-control" name="bahan[]" placeholder="1 butir telur">
                    </div>
                </div>
                <div class="add-button" id="add-bahan">
                    <i class="fas fa-plus-circle"></i> Tambah Bahan
                </div>

                <p class="section-title">Langkah-langkah</p>
                <div id="langkah-container">
                    <div class="langkah-item">
                        <input type="text" class="form-control" name="langkah[]"
                            placeholder="Iris bawang merah menjadi beberapa bagian">
                        <div class="step-image-placeholder" id="imagePlaceholder1">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" id="stepImage1" name="langkah_image[]" accept="image/*">
                        <img id="stepPreview1" class="step-image">
                    </div><br>
                    <div class="langkah-item">
                        <input type="text" class="form-control" name="langkah[]"
                            placeholder="Panaskan minyak makan terlebih dahulu">
                        <div class="step-image-placeholder" id="imagePlaceholder2">
                            <i class="fas fa-camera"></i>
                        </div>
                        <input type="file" id="stepImage2" name="langkah_image[]" accept="image/*">
                        <img id="stepPreview2" class="step-image">
                    </div><br>
                </div>
                <div class="add-button" id="add-langkah"><br>
                    <i class="fas fa-plus-circle"></i> Tambah Langkah
                </div>


                <script>
                    document.getElementById('add-bahan').addEventListener('click', function() {
                        var newBahanDiv = document.createElement('div');
                        newBahanDiv.className = 'bahan-item';
                        newBahanDiv.innerHTML =
                            '<input type="text" class="form-control" id="bahan[]" name="bahan[]" placeholder="Tambahkan bahan lain">' +
                            '<span class="remove-button">Hapus</span>';
                        document.getElementById('bahan-container').appendChild(newBahanDiv);

                        newBahanDiv.querySelector('.remove-button').addEventListener('click', function() {
                            newBahanDiv.remove();
                        });
                    });

                    document.getElementById('add-langkah').addEventListener('click', function() {
                        langkahCount++;
                        var newLangkahDiv = document.createElement('div');
                        newLangkahDiv.className = 'langkah-item';
                        newLangkahDiv.innerHTML = `
        <input type="text" class="form-control" id="langkah[]" name="langkah[]" placeholder="Langkah Baru">
        <div class="step-image-placeholder" id="imagePlaceholder${langkahCount}">
            <i class="fas fa-camera"></i>
        </div>
        <input type="file" id="stepImage${langkahCount}" name="langkah_image[]" accept="image/*" style="display: none;">
        <img id="stepPreview${langkahCount}" class="step-image" style="display: none; max-width: 50%; max-height: 150px;">
        <span class="remove-button" onclick="removeLangkah(this)">Hapus</span>
        <div id="imageControls${langkahCount}" style="display: none; margin-top: 10px;">
    <button type="button" class="replace-button" style="background-color: blue;color: white; border: white; border-radius: 5px;margin: 1px;">Ganti</button>
    <button type="button" class="remove-image-button" style="background-color: #9f0000; color: white; border: white; border-radius: 5px; margin: 2px;">Hapus</button>
        </div>
    `;
                        document.getElementById('langkah-container').appendChild(newLangkahDiv);

                        // Add event listener to the new image placeholder
                        const newImagePlaceholder = newLangkahDiv.querySelector(`#imagePlaceholder${langkahCount}`);
                        const newImageInput = newLangkahDiv.querySelector(`#stepImage${langkahCount}`);
                        const newImagePreview = newLangkahDiv.querySelector(`#stepPreview${langkahCount}`);
                        const newImageControls = newLangkahDiv.querySelector(`#imageControls${langkahCount}`);

                        newImagePlaceholder.addEventListener('click', () => newImageInput.click());

                        newImageInput.addEventListener('change', function() {
                            const file = this.files[0];
                            if (file) {
                                const imageUrl = URL.createObjectURL(file);
                                newImagePreview.src = imageUrl;
                                newImagePreview.style.display = 'block';
                                newImagePlaceholder.style.display = 'none';
                                newImageControls.style.display = 'block'; // Show controls
                            }
                        });

                        // Add functionality for the replace button
                        newImageControls.querySelector('.replace-button').addEventListener('click', () => {
                            newImageInput.click(); // Trigger file input to select new image
                        });

                        // Add functionality for the remove button
                        newImageControls.querySelector('.remove-image-button').addEventListener('click', () => {
                            newImagePreview.src = ''; // Clear image source
                            newImagePreview.style.display = 'none'; // Hide image preview
                            newImagePlaceholder.style.display = 'block'; // Show the placeholder again
                            newImageControls.style.display = 'none'; // Hide controls
                            newImageInput.value = ''; // Clear file input
                        });
                    });
                </script>
        </form>
    </div>
    </div>

    <script>
        document.getElementById('gambar').addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imagePreview = document.getElementById('imagePreview');
                    imagePreview.src = e.target.result;
                    imagePreview.style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });

        // Video upload and preview functionality
        const videoInput = document.getElementById('videoInput');
        const videoPreview = document.getElementById('videoPreview');
        const videoIconLabel = document.getElementById('videoIconLabel');
        let select = null;

        videoIconLabel.addEventListener('click', () => {
            if (!select && !videoIconLabel.querySelector('video') && !videoIconLabel.querySelector('iframe')) {
                select = document.createElement('select');
                select.className = 'form-select';
                select.style.padding = "0.5rem";
                select.style.borderRadius = "5px";
                select.style.border = "1px solid #ccc";
                select.style.position = "absolute";
                select.style.top = "50%";
                select.style.left = "50%";
                select.style.transform = "translate(-50%, -50%)";
                select.style.width = "80%";
                select.style.maxWidth = "300px";
                select.style.zIndex = "10";
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
                    } else if (videoType === 'youtube') {
                        const youtubeUrl = prompt(
                            "Masukkan link YouTube:\n(Format: https://www.youtube.com/watch?v=... atau https://youtu.be/...)"
                        );
                        if (youtubeUrl && validateAndEmbedYouTube(youtubeUrl)) {
                            // Video embedded successfully
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
            // Patterns untuk berbagai format YouTube URL
            const patterns = [
                /(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i,
                /^([a-zA-Z0-9_-]{11})$/ // Direct video ID
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
                    src="https://www.youtube.com/embed/${videoId}?enablejsapi=1&origin=${window.location.origin}"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    style="border-radius: 10px;">
                </iframe>
            `;

            // Create hidden inputs untuk menyimpan data
            let youtubeUrlInput = document.getElementById('youtube_url_input');
            if (!youtubeUrlInput) {
                youtubeUrlInput = document.createElement('input');
                youtubeUrlInput.type = 'hidden';
                youtubeUrlInput.id = 'youtube_url_input';
                youtubeUrlInput.name = 'video_url';
                videoIconLabel.parentNode.appendChild(youtubeUrlInput);
            }
            youtubeUrlInput.value = originalUrl;

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

                // Set video type to file
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
                // Reset video placeholder
                videoIconLabel.innerHTML = '<i class="fas fa-play-circle"></i>';

                // Clear video input
                videoInput.value = '';

                // Remove hidden inputs
                const youtubeUrlInput = document.getElementById('youtube_url_input');
                const videoTypeInput = document.getElementById('video_type_input');
                if (youtubeUrlInput) youtubeUrlInput.remove();
                if (videoTypeInput) videoTypeInput.remove();

                // Hide remove button
                const removeBtn = document.getElementById('removeVideoBtn');
                if (removeBtn) removeBtn.remove();

                // Reset select variable so user can choose again
                select = null;
            }
        }

        // Adding new ingredients and steps
        let langkahCount = 2;

        // Adding event listener for existing placeholders
        document.querySelectorAll('.step-image-placeholder').forEach((placeholder, index) => {
            const imageInput = document.querySelector(`#stepImage${index + 1}`);
            const imagePreview = document.querySelector(`#stepPreview${index + 1}`);

            // Create and style image controls
            const imageControls = document.createElement('div');
            imageControls.id = `imageControls${index + 1}`;
            imageControls.style.display = 'none';
            imageControls.style.border = 'none';
            imageControls.style.marginTop = '10px';
            imageControls.style.textAlign = 'left'; // Center align the buttons below the preview
            imageControls.innerHTML = `
    <button type="button" class="replace-button" style="background-color: blue;color: white; border: white; border-radius: 5px;margin: 1px;">Ganti</button>
    <button type="button" class="remove-image-button" style="background-color: #9f0000; color: white; border: white; border-radius: 5px; margin: 2px;">Hapus</button>
    `;

            // Insert imageControls after the image preview
            imagePreview.parentNode.insertBefore(imageControls, imagePreview.nextSibling);

            // Placeholder click event
            placeholder.addEventListener('click', () => imageInput.click());

            // Image input change event
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const imageUrl = URL.createObjectURL(file);
                    imagePreview.src = imageUrl;
                    imagePreview.style.display = 'block';
                    placeholder.style.display = 'none';
                    imageControls.style.display = 'block'; // Show controls
                }
            });

            // Replace button functionality
            imageControls.querySelector('.replace-button').addEventListener('click', () => {
                imageInput.click(); // Trigger file input to select new image
            });

            // Remove button functionality
            imageControls.querySelector('.remove-image-button').addEventListener('click', () => {
                imagePreview.src = ''; // Clear image source
                imagePreview.style.display = 'none'; // Hide image preview
                placeholder.style.display = 'block'; // Show the placeholder again
                imageControls.style.display = 'none'; // Hide controls
                imageInput.value = ''; // Clear file input
            });
        });

        // Function to remove a step
        function removeLangkah(element) {
            element.parentElement.remove();
        }

        // Add langkah with image controls
    </script>

</body>

</html>
