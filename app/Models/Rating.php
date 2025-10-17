<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipe_id',
        'user_id',
        'guest_identifier',
        'rating',
        'review',
        'guest_name',
        'guest_email'
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isGuest()
    {
        return $this->user_id === null;
    }

    public function getRaterNameAttribute()
    {
        return $this->user ? $this->user->name : ($this->guest_name ?? 'Guest');
    }
}
