<!DOCTYPE html>
<html>
<head>
    <title>{{ $recipe->name }}</title>
</head>
<body>
    <h1>{{ $recipe->name }}</h1>
    <p>{{ $recipe->description }}</p>

    @if ($recipe->video_path)
        <video controls>
            <source src="{{ asset('storage/' . $recipe->video_path) }}" type="video/mp4">
            Your browser does not support the video tag.
        </video>
    @endif

    <h3>Ingredients:</h3>
    <ul>
        @foreach ($recipe->bahan as $bahan)
            <li>{{ $bahan }}</li>
        @endforeach
    </ul>

    <h3>Steps:</h3>
    <ol>
        @foreach ($recipe->langkah as $langkah)
            <li>{{ $langkah }}</li>
        @endforeach
    </ol>
</body>
</html>
