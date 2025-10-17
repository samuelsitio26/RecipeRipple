<!DOCTYPE html>
<html>
<head>
    <title>Search Results</title>
</head>
<body>
    <h1>Search Results for "{{ $query }}"</h1>
    <ul>
        @forelse ($recipes as $recipe)
            <li>
                <a href="{{ route('recipes.show', $recipe->id) }}">
                    {{ $recipe->name }}
                </a>
            </li>
        @empty
            <p>No recipes found.</p>
        @endforelse
    </ul>
</body>
</html>
