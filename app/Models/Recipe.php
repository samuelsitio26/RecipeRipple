<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'kategori_id',
        'bahan',
        'langkah',
        'langkah_image',
        'video_path',
        'video_type',
        'video_url',
        'gambar',
        'average_rating',
        'total_ratings',
        'views_count',
        'is_featured',
        'user_id'
    ];

    protected $casts = [
        'average_rating' => 'decimal:2',
        'total_ratings' => 'integer',
        'views_count' => 'integer',
        'is_featured' => 'boolean',
        'bahan' => 'array',
        'langkah' => 'array',
        'langkah_image' => 'array',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function updateRating()
    {
        $avgRating = $this->ratings()->avg('rating');
        $totalRatings = $this->ratings()->count();

        $this->update([
            'average_rating' => round($avgRating ?? 0, 2),
            'total_ratings' => $totalRatings
        ]);
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }

    public function getVideoEmbedUrlAttribute()
    {
        if ($this->video_type === 'youtube' && $this->video_url) {
            preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/ ]{11})/', $this->video_url, $match);
            return isset($match[1]) ? "https://www.youtube-nocookie.com/embed/{$match[1]}" : null;
        }
        return null;
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->orderBy('average_rating', 'desc')
            ->orderBy('total_ratings', 'desc')
            ->orderBy('views_count', 'desc')
            ->limit($limit);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('kategori_id', $categoryId);
    }
}

