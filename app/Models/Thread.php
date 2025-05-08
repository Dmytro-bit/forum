<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Traits\RecordsActivity;

class Thread extends Model
{
    use RecordsActivity;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'user_id',
        'is_locked',
        'is_pinned'
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function replies(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getLastActivityAttribute(): string
    {
        return $this->updated_at->diffForHumans();
    }
    public function scopePopular(Builder $query): Builder
    {
        return $query->withCount('posts')
            ->orderBy('posts_count', 'desc');
    }
}
